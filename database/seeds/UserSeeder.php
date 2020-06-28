<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Log::info('UserSeeder start!');
      $users = [
        [
          'name'      => 'test0001',
          'email'     => 'test0001@gmail.com',
          'password'  => Hash::make('password'),
        ],
        [
          'name'      => 'test0002',
          'email'     => 'test0002@gmail.com',
          'password'  => Hash::make('password'),
        ],
      ];
    
      // 登録
      foreach ($users as $user) {
        User::create($user);
        Log::info('Userを作成しました。');
      }
      Log::info('UserSeeder end!');
    }
}
