<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
use Illuminate\Support\Str;
use DB;
use Mail;
use Carbon\Carbon;

class PasswordController extends Controller
{
    public function showLinkRequestForm() {
        return View('auth/passwords/email');
    }

    public function sendResetLinkEmail(Request $request) {

        $request->validate(['email' => 'required|email'], [], ['email' => 'メールアドレス']);
        $email = $request->email;

        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            session()->flash('danger', 'メールアドレス not found.');
            return redirect()->back()->withInput();
        }

        $token = hash_hmac('sha256', Str::random(40), config('app.key'));
        DB::table('password_resets')->updateOrInsert(['email' => $email], [
            'email' => $email,
            'token' => Hash::make($token),
            'created_at' => new Carbon,
        ]);

        Mail::send('emails.reset_link', \compact('token'), function($message) use ($email) {
            $message->to($email)->subject('password reset');
        });

        \session()->flash('success', '重置邮件发送成功，请查收');
        return \redirect()->back();
    }
}
