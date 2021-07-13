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

    public function __construct() {
        // $this->middleware('throttle:2,1', [
        //     'only' => ['showLinkRequestForm']
        // ]);
        // $this->middleware('throttle:3,10', [
        //     'only' => ['sendResetLinkEmail']
        // ]);
    }

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

    public function showResetForm(Request $request) {
        $token = $request->route()->parameter('token');
        return View('auth.passwords.reset', compact('token'));
    }

    public function reset(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        $email = $request->email;
        $token = $request->token;

        $expires = 60 * 10;

        $user = User::where('email', $email)->first();
        if (is_null($user)) {
            session()->flash('danger', 'email not found');
            return redirect()->back()->withInput();
        }

        $record = (array)DB::table('password_resets')->where('email', $email)->first();

        if (!$record) {
            session()->flash('danger', 'record not found');
            return redirect()->back();
        }

        if (Carbon::parse($record['created_at'])->addSeconds($expires)->isPast()) {
            session()->flash('danger', '链接已过期，请重新尝试');
            return redirect()->back();
        }

        if (! Hash::check($token, $record['token'])) {
            session()->flash('danger', '令牌错误');
            return redirect()->back();
        }

        $user->update(['password' => \bcrypt($request->password)]);

        session()->flash('success', '密码重置成功，请使用新密码登录');
        return \redirect()->route('login');

    }
}
