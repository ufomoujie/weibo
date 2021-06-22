<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class SessionsController extends Controller
{
    //

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
            session()->flash('success', 'welcome you have logined');
            return redirect()->route('users.show', [Auth::user()]);
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
