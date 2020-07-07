<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use App\Rank;

class UserController extends Controller
{
    /**
     * ログインページ表示
     */
    public function signin()
    {
      return view('user.signin');
    }

    /**
     * ログイン処理
     */
    public function login(UserRequest $request)
    {
      $email    = $request->input('email');
      $password = $request->input('password');
      if (!Auth::attempt(['email' => $email, 'password' => $password])) {
        // 認証失敗
        return redirect('/user/signin')->with('error_message', 'I failed to login');
      }
      // 認証成功
      return redirect()->route('root');
    }

    /**
     * 新規登録ページ表示
     */
    public function signup()
    {
      return view('user.signup');
    }

    /**
     * 新規登録処理
     */
    public function store(UserRequest $request)
    {
      $user     = app()->make('App\User');
      $name     = $request->input('name');
      $email    = $request->input('email');
      $password = $request->input('password');
      $params   = [
        'name'      => $name,
        'email'     => $email,
        'password'  => Hash::make($password),
      ];
      if (!$user->registUser($params)) {
        return redirect()->route('user.signup')->with('error_message', 'User registration failed');
      }
      if (!Auth::attempt(['email' => $email, 'password' => $password])) {
        return redirect()->route('user.signin')->with('error_message', 'I failed to login');
      }
      return redirect()->route('root');
    }

    /**
     * ログアウト処理
     */
    public function logout()
    {
      Auth::logout();
      return redirect()->route('user.signin');
    }
}
