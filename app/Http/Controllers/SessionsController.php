<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //

    public function __construct() {
        $this->middleware('guest', [
            'only' => ['create']
        ]);

        $this->middleware('throttle:10,60', [
            'only' => ['store']
        ]);
    }

    public function create() {
        return view('sessions.create');
    }

    public function store(Request $request ) {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ],
        [],
        [
            'email' => 'メールアドレス',
            'password' => 'パスワード'
        ]
        );
        if (Auth::attempt($credentials, $request->has('remeber'))) {
            if (Auth::user()->activated) {
                session()->flash('success', 'welcome you have logined');
                $fallback = route('users.show', [Auth::user()]);
                return redirect()->intended($fallback);
            } else {
                Auth::logout();
                session()->flash('warning', '你的账号未激活，请检查邮箱中的注册邮件进行激活。');
                return redirect('/');
            }
        } else {
            session()->flash('danger', 'sorry not found user or passwrod wrong');
            return redirect()->back()->withInput();
        }
    }

    public function destroy() {
        Auth::logout();
        session()->flash('success', 'logout success!');
        return redirect()->route('login');
    }
}
