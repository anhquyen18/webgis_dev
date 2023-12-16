<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationEmail;

class EmailVerificationController extends Controller
{
    public function sendVerificationEmail()
    {
        // $user = auth()->user();
        // Mail::to('anhquyendeptraivcl@gmail.com')->send(new VerificationEmail('Anh Quyền đẹp trai vcl213'));
        return 'Email được gửi đi thành công';
    }
}
