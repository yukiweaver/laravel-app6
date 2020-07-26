<?php

use Illuminate\Database\Seeder;
use App\Question;
use Illuminate\Support\Facades\Log;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Log::info('QuestionSeeder start!');
      $questions = [
        [
          'rank_id'   => 5,
          'name'      => '文字列を出力',
          'content'   => 'Hello World! を出力してください。',
          'answer'    => 'Hello World!',
        ],
        [
          'rank_id'   => 5,
          'name'      => '配列操作の基礎',
          'content'   => 'リンゴ、バナナ、ブドウの入った配列を作成し、バナナを出力してください。',
          'answer'    => 'バナナ',
        ],
        [
          'rank_id'   => 4,
          'name'      => '三角形の面積',
          'content'   => '底辺が3、高さ8の三角形があります。この三角形の面積を出力してください。',
          'answer'    => '12',
        ],
        [
          'rank_id'   => 4,
          'name'      => '日付の計算',
          'content'   => '現在が2020年6月28日だったとします。一週間後の日付をY/m/d形式で出力してください。',
          'answer'    => '2020/07/05',
        ],
        [
          'rank_id'   => 3,
          'name'      => 'Cランクテスト問題1',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 3,
          'name'      => 'Cランクテスト問題2',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 3,
          'name'      => 'Cランクテスト問題3',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 3,
          'name'      => 'Cランクテスト問題4',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 3,
          'name'      => 'Cランクテスト問題5',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 2,
          'name'      => 'Bランクテスト問題1',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 2,
          'name'      => 'Bランクテスト問題2',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 2,
          'name'      => 'Bランクテスト問題3',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 2,
          'name'      => 'Bランクテスト問題4',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 2,
          'name'      => 'Bランクテスト問題5',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 1,
          'name'      => 'Aランクテスト問題1',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 1,
          'name'      => 'Aランクテスト問題2',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 1,
          'name'      => 'Aランクテスト問題3',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 1,
          'name'      => 'Aランクテスト問題4',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
        [
          'rank_id'   => 1,
          'name'      => 'Aランクテスト問題5',
          'content'   => 'これはテスト問題です。これはテスト問題です。',
          'answer'    => 'テスト問題',
        ],
      ];
    
      // 登録
      foreach ($questions as $question) {
        Question::create($question);
        Log::info('Questionを作成しました。');
      }
      Log::info('QuestionSeeder end!');
    }
}
