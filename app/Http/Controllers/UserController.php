<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function login()
    {
      //
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
    public function create()
    {
      //
    }

    /**
     * ログアウト処理
     */
    public function logout()
    {
      //
    }
}
