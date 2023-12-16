<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use stdClass;

use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Arr;
use App\Models\TemporarySignUpUser;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;
use App\Mail\ResetPasswordEmail;
use Exception;
use App\Models\PasswordReset;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function signIn(Request $request)
    {
        $validated = $request->validate([
            "username" => "required",
            "password" => "required",
        ], [
            "username.required" => "Enter your username",
            "password.required" => "Enter your password",
        ]);
        $credentials = $request->json()->all();
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response('Wrong username or password', 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
            // return $e;
        }
        $geoserverAccount = User::join('geoserver_account', 'users.geoserver_account_id', '=', 'geoserver_account.id')
            ->select(
                'geoserver_account.account as username',
                'geoserver_account.key as userkey'
            )->where('users.username', '=', $credentials['username'])
            ->first();
        // $user = User::join('departments', 'users.department_id', '=', 'departments.id')
        //     ->join('user_status', 'users.status_id', '=', 'user_status.id')
        //     ->select(
        //         'users.id as id',
        //         'users.name as name',
        //         'departments.name as department',
        //         'user_status.name as status'
        //     )->where('users.username', '=', $credentials['username'])->first();

        $user = User::select(
            'id',
            'name',
            'username',
            'department_id',
            'status_id',
            'email',
            'geoserver_account_id',
            'birthday'
        )->where('users.username', '=', $credentials['username'])->first();
        return response()->json(compact('token', 'user'));
        // return response()->json(compact('token'));
    }

    public function index(Request $request)
    {
        $data = $request->json()->all();
        $user = auth()->user();
        // $data = User::join('departments', 'users.department_id', '=', 'departments.id')
        //     ->join('user_status', 'users.status_id', '=', 'user_status.id')
        //     ->select(
        //         'users.id',
        //         'users.name',
        //         'users.username',
        //         'users.email',
        //         'users.geoserver_account_id',
        //         'users.birthday',
        //         'departments.name as department',
        //         'user_status.name as status'
        //     )->where('users.id', 'not like', $user['id'])->get();
        $data = User::join('departments', 'users.department_id', '=', 'departments.id')
            ->join('user_status', 'users.status_id', '=', 'user_status.id')
            ->select(
                'users.id',
                'users.name',
                'users.username',
                'users.email',
                'users.geoserver_account_id',
                'users.birthday',
                'departments.name as department',
                'user_status.name as status'
            )->where('users.id', 'not like', $user['id'])->paginate(20);
        // return response($data);
        return response()->json($data);
    }

    public function getUsersManager(Request $request)
    {
        $data = $request->json()->all();
        $user = auth()->user();
        $users = User::join('departments', 'users.department_id', '=', 'departments.id')
            ->join('user_status', 'users.status_id', '=', 'user_status.id')
            ->select(
                'users.id',
                'users.name',
                'users.username',
                'users.email',
                'users.geoserver_account_id',
                'users.birthday',
                'departments.name as department',
                'user_status.name as status'
            )->where(function ($query) use ($data) {
                $index = 0;
                foreach ($data['searchList'] as  $value) {
                    if (!empty($value)) {
                        if (is_array($value)) {
                            // $query->where('users.' . $data['searchColumns'][$index], 'like',  implode(',', $value));
                            $query->whereIn('users.' . $data['searchColumns'][$index], $value);
                        } else {
                            $query->where('users.' . $data['searchColumns'][$index], 'ilike', '%' . $value . '%');
                        }
                        // echo $data['searchColumns'][$index];
                        // $test = $test . ', ' . $data['searchColumns'][$index];
                    }
                    $index++;
                }
            })->where('users.id', 'not like', $user['id'])->paginate($data['pageSize']);

        // return response($data);
        return response()->json($users);
    }

    public function getAuthenticatedUser(Request $request)
    {
        $data = $request->json()->all();
        $user = auth()->user();
        // kiểm tra auth ro
        $geoserverAccount = User::join('geoserver_account', 'users.geoserver_account_id', '=', 'geoserver_account.id')
            ->select(
                'geoserver_account.account as username',
                'geoserver_account.key as userkey'
            )->where('users.username', '=', $user['username'])
            ->get();
        // return response()->json(Arr::except(
        //     $user,
        //     [
        //         'avatar', 'id', 'email_verified_at', 'login_at',
        //         'change_password_at', 'delete_at', 'created_at', 'updated_at',
        //     ]
        // ), $geoserverAccount);
        $userData = Arr::except(
            $user,
            [
                'avatar', 'email_verified_at', 'login_at',
                'change_password_at', 'delete_at', 'created_at', 'updated_at',
            ]
        );
        if ($data['accountId']) {
            if ($data['accountId'] == $user['id']) {
                return response()->json(compact('user'));
            } else {
                return response()->json([
                    'error' => 'Url not found.'
                ], 404);
            }
        }
        return response()->json(compact('user'));

        // return $data['accountId'];
        // return $user['id'];
    }

    public function userUpdateInfo(Request $request)
    {
        $data = $request->json()->all();
        $user = auth()->user();
        // nếu dùng cái này thì không cần thêm cột updated_at
        // Eloquent nó sẽ tự động cập nhật cột đấy
        // $user = User::find(auth()->user()['id']);


        $validated = $request->validate([
            "username" => "required|unique:users,username," . $user['id'],
            "name" => "required",
            "email" => "required|email",
        ], [
            "username.required" => "Enter username",
            "username.unique" => "Username has existed",
            "name.required" => "Enter name",
            "email.required" => "Enter email",
            "email.email" => "Invalid email",
            // "department_id.required" => "Nhập phòng ban",

        ]);


        $affected = DB::table('users')
            ->where('id', $data['id'])
            ->update([
                "username" => $request['username'],
                "name" => $request['name'],
                "email" => $request['email'],
                "updated_at" => date('Y-m-d H:i:s'),
            ]);
        return response()->json(['success' => 'Update successfully!']);

        // return '1';
        // return $data['id'];
        // return $data;
        // return $affected;
    }

    public function userUpdatePassword(Request $request)
    {
        $data = $request->json()->all();
        $user = User::find(auth()->user()['id']);
        // $user = auth()->user();

        // return $user['password'];
        // $request->validate([
        //     'current_password' => 'required',
        //     'password' => 'required|string|min:8|confirmed',
        // ]);
        try {
            if (Hash::check($data['currentPass'], $user['password'])) {
                $user['password'] = Hash::make($data['checkPass']);
                $user['change_password_at'] = date('Y-m-d H:i:s');
                // $user->update(['password' => Hash::make($data['checkPass'])]);
                $user->save();

                return response()->json(['success' => 'Change password successfully!']);
            }
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 400);
        }

        return response()->json(['error' => 'Wrong password!',], 400);

        // ]);
        // $affected = DB::table('users')
        //     ->where('id', $data['id'])
        //     ->update($data);

        // return $data['id'];
        // return $data;
        // return $affected;
        // return $user['password'];
        // return 'oke';
    }


    public function checkUsername(Request $request)
    {
        $validated = $request->validate([
            "username" => "required|unique:users,username",
        ], [
            "username.required" => "Enter username",
            "username.unique" => "Username has existed",
        ]);
    }

    public function signUp(Request $request)
    {
        $data = $request->json()->all();
        // $birthday = $data['yearOfBirth'] . '-' . $data['monthOfBirth'] . '-' . $data['dayOfBirth'];
        $validated = $request->validate([
            "username" => "required|unique:users,username",
            "email" => "required",
            "password" => "required",
            "yearOfBirth" => 'required',
            "monthOfBirth" => 'required',
            "dayOfBirth" => 'required',
        ], [
            "username.required" => "Enter username",
            "username.unique" => "Username has existed",
            "email.required" => "Enter email",
            "yearOfBirth.required" => "Enter year of birth",
            "monthOfBirth.required" => "Enter month of birth",
            "dayOfBirth.required" => "Enter day of birth",
        ]);

        $signUpCode = random_int(100000, 999999);
        try {
            $temp = TemporarySignUpUser::firstOrCreate(
                ['username' => $data['username']],
                [
                    'name' => $data['name'],
                    'username' => $data['username'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'birthday' => $data['yearOfBirth'] . '-' . $data['monthOfBirth'] . '-' . $data['dayOfBirth'],
                    'verify_code' => $signUpCode,
                ]
            )->update(['verify_code' => $signUpCode]);
        } catch (Exception $e) {
            return response()->json(['error' => 'Invalid user, please try again!'], 422);
        }

        // sendVerificationEmail();
        // create email and send it
        Mail::to($data['email'])->send(new VerificationEmail($data['email'], $signUpCode));

        // return response()->json(['message' => 'Sign up user successfully!']);


        // // return $data;
        // return $temp;
    }

    public function insertSignUpUser(Request $request)
    {
        $data = $request->json()->all();
        $emailCode = (int)implode('', $data['code']);
        try {
            $user = TemporarySignUpUser::where('username', $data['username'])
                ->select('verify_code', 'username', 'name', 'birthday', 'password', 'email')
                ->first();
            if ($emailCode === $user['verify_code'])
                $create = User::create([
                    'name' => $user['name'],
                    'email' => $user['email'],
                    'password' => $user['password'],
                    'username' => $user['username'],
                    'birthday' => $user['birthday'],
                    // 'department_id' => $data[1],
                    // 'status_id' => $data[1],
                ]);
            else {
                return response()->json(['error' => 'Verify code does not match, please try again!'], 422);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Can not create user, please try again!', $e->getMessage()], 423);
            // return response()->json($e->getMessage(), 422);
            // return $e;
        }

        // return $data;
        // return [$emailCode, $user['verify_code']];
        return response()->json(['success' => 'Sign up user successfully!']);
    }

    public function sendEmailResetPassword(Request $request)
    {

        $data = $request->json()->all();
        $request->validate(['emailOrNumber' => 'required|email']);
        $token = Str::random(60);
        try {
            if ($data['type'] === 'Email') {
                $user = User::where('username', $data['username'])->where('email', $data['emailOrNumber'])
                    ->select('name', 'email', 'id')
                    ->first();
                if (!$user) {
                    return response()->json(['doNotMatch' => true, 'error' => 'That username and email don\'t match, please try again!'], 500);
                }
                PasswordReset::updateOrCreate(
                    ['user_id' => $user['id']],
                    ['email' => $user['email'], 'token' => $token, 'user_id' => $user['id']]
                );

                // $status = ResetPassword::createUrlUsing(function (User $user, string $token) {
                //     return 'http://localhost:5173/account-recovery/reset-password/' . $token;
                // });
                // return response()->json(['message' => __($status)]);
                // return response()->json(['message' => Str::random(60)]);
                // return response()->json(['message' => encrypt('$2y$10$q2pvZPSQWKIhY5jDYz/joO.brJwwkJaJi6CC7snN8gKI592YNcZ7y')]);
                $url = 'http://localhost:5173/reset-password/' . encrypt($token);
                Mail::to($user['email'])->send(new ResetPasswordEmail(
                    $user['name'],
                    $url
                ));
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage(), $e->getMessage()], 500);
        }

        return response()->json(['success' => 'Reset password link was sent to your email!']);
    }

    public function checkResetPasswordLink(Request $request)
    {
        // Carbon::setTimezone('Asia/Ho_Chi_Minh');
        $data = $request->json()->all();
        try {
            $request->validate(['token' => 'required']);
            $passwordReset = PasswordReset::where('token', decrypt($data['token']))
                ->firstOrFail();
            // $carBonTime = Carbon::now();
            // return Carbon::now()->timezoneName;
            // return config('app.timezone');

            // return Carbon::parse('2023-11-09 18:25:31')->addMinutes(5)->isPast();
            // 2023-11-09T09:41:31.000000Z
            // return  $carBonTime;
            // 2023-11-09T11:08:15.874596Z
            // + thêm 7h để bằng với giờ Ha Noi
            if (Carbon::parse($passwordReset->updated_at)->addMinutes(6000)->isPast()) {
                $passwordReset->delete();

                return response()->json([
                    'error' => 'The password reset token is timeout.'
                ], 422);
            }
        } catch (Exception $e) {
            return response()->json([
                'error' => 'The password reset token is invalid.', $e->getMessage()
            ], 422);
        }

        return response()->json([
            'success' => 'This password reset token is valid.!',
            'id' => $passwordReset['user_id'], 'email' => $passwordReset['email']
        ]);
    }

    public function resetPassword(Request $request)
    {
        // if ($this->checkValidResetPasswordLink()) {
        //     return 'anhquyendeptrai';
        // } else {
        //     return 'anhquyendeptrai vo dich vu tru';
        // }
        $data = $request->json()->all();
        $response = $this->checkResetPasswordLink($request);
        $token = json_decode($response->getContent(), true);
        if (isset($token['error'])) {
            return response()->json(['error' => $token['error']], 422);
        }
        // return $token['id'];
        try {
            $request->validate(['password' => 'required']);
            $user = User::find($token['id']);
            $updatePassword = $user->update(
                ['password' => Hash::make($data['password'])]
            );
            $passwordReset = PasswordReset::where('token', decrypt($data['token']))
                ->firstOrFail();
            $passwordReset->delete();
        } catch (Exception $e) {
            return response()->json(['error' => 'Can not reset password, please try again later!', $e->getMessage()], 422);
        }


        return response()->json([
            'success' => 'Reset password successfully, please sign in!',
        ]);
        // return $message;
    }

    public function searchUsers(Request $request)
    {
        $data = $request->json()->all();
        // $values = $data['searchList'];
        $test = 'a';
        $users = User::join('departments', 'users.department_id', '=', 'departments.id')
            ->join('user_status', 'users.status_id', '=', 'user_status.id')
            ->select(
                'users.id',
                'users.name',
                'users.username',
                'users.email',
                'users.geoserver_account_id',
                'users.birthday',
                'departments.name as department',
                'user_status.name as status'
            )->where(function ($query) use ($data, $test) {
                $index = 0;
                foreach ($data['searchList'] as  $value) {
                    if (!empty($value)) {
                        $query->where('users.' . $data['searchColumns'][$index], 'ilike', '%' . $value . '%');
                        // echo $data['searchColumns'][$index];
                        // $test = $test . ', ' . $data['searchColumns'][$index];
                    }
                    $index++;
                }
                // echo $test;
                // return $index;
            })->where('users.id', 'not like', '20')->get();

        return response()->json($users);
        // return response()->json($test);
        // return response()->json($data);
    }

    public function testRoute()
    {
        // return Auth::check() . "dasds";
        echo 'anhquyen';
    }
}
