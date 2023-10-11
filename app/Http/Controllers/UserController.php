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
use Tymon\JWTAuth\Facades\JWTFactory;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\JWTManager as JWT;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserController extends Controller
{
    public function signIn(Request $request)
    {
        $validated = $request->validate([
            "username" => "required",
            "password" => "required",
        ], [
            "username.required" => "Nhập tài khoản",
            "password.required" => "Nhập mật khẩu",
        ]);
        $credentials = $request->json()->all();
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response('Sai tài khoản hoặc mật khẩu', 400);
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
            ->get();
        $user = User::join('departments', 'users.department_id', '=', 'departments.id')
            ->join('user_status', 'users.status_id', '=', 'user_status.id')
            ->select(
                'users.id as id',
                'users.name as name',
                'departments.name as department',
                'user_status.name as status'
            )->where('users.username', '=', $credentials['username'])->get();
        return response()->json(compact('token', 'user'));
        // return response()->json(compact('token'));
    }

    public function index()
    {
        $user = User::join('departments', 'users.department_id', '=', 'departments.id')
            ->join('user_status', 'users.status_id', '=', 'user_status.id')
            ->select(
                'users.*',
                'departments.name as department',
                'user_status.name as status'
            )->get();
        return response()->json($user);
    }

    public function getAuthenticatedUser(Request $request)
    {
        $data = $request->json()->all();
        $user = JWTAuth::parseToken()->authenticate();
        try {
            if (!$user) {
                return response()->json(['user_not_found'], 400);
            }
        } catch (TokenExpiredException $e) {
            // return 'token-1';
            return response()->json(['token_expired'], $e);
        } catch (TokenInvalidException $e) {
            // return 'token-2';
            return response()->json(['token_invalid'], $e);
            // return $e;
        } catch (JWTException $e) {
            return response()->json(['token_absent'], $e);
            // return 'token-3';
        }

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
                    'message' => 'Url not found.'
                ], 404);
            }
        }
        return response()->json(compact('user'));

        // return $data['accountId'];
        // return $user['id'];
    }

    public function getDepartments()
    {

        $data = DB::table('departments')->select('id as id', 'name as name')->get();
        return response()->json($data);

        // return response()->json(compact('userData', 'geoserverAccount'));
    }

    public function testRoute()
    {
        // return Auth::check() . "dasds";
        echo 'anhquyen';
    }
}
