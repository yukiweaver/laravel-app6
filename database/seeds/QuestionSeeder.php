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
          'rank_id'   => 5,
          'name'      => 'ループ処理の基礎',
          'content'   => 'リンゴ、バナナ、ブドウの入った配列を作成し、ループ処理を行なってください。 \r\nそのループ回数を出力してください。',
          'answer'    => '3',
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
          'rank_id'   => 4,
          'name'      => 'チョコレートの数',
          'content'   => 'あなたはチョコレートの入った箱を3箱購入しました。一つの箱には1ダースのチョコレートが入っています。\r\nチョコレートの合計数を出力してください。\r\n1ダースは12個です。',
          'answer'    => '36',
        ],
        [
          'rank_id'   => 4,
          'name'      => '文字列の逆転',
          'content'   => 'Helloという文字列を定義してください。その文字列を逆順した文字列を出力してください。',
          'answer'    => 'olleH',
        ],
        [
          'rank_id'   => 4,
          'name'      => '小文字を大文字に変換',
          'content'   => 'Helloという文字列を定義してください。その文字列を全て大文字に変換して出力してください。',
          'answer'    => 'HELLO',
        ],
        [
          'rank_id'   => 3,
          'name'      => '小数点の四捨五入',
          'content'   => '13 ÷ 3の計算結果を小数第二位で四捨五入し、出力してください。\r\n出力結果は小数点第二位までとする。',
          'answer'    => '4.33',
        ],
        [
          'rank_id'   => 3,
          'name'      => '分から秒へ変換',
          'content'   => '59分を秒に変換するプログラムを記述し、出力してください。',
          'answer'    => '3540',
        ],
        [
          'rank_id'   => 3,
          'name'      => '文字列の連結',
          'content'   => '文字列でfooとbarを定義し、二つの文字列を連結した文字列foobarを出力してください。',
          'answer'    => 'foobar',
        ],
        [
          'rank_id'   => 3,
          'name'      => '数列の和',
          'content'   => '整数1から5までの数列があります。この数列の合計の和を出力してください。',
          'answer'    => '15',
        ],
        [
          'rank_id'   => 3,
          'name'      => 'イニシャルを出力',
          'content'   => 'Akasaka Ryunosukeという苗字、名前からそれぞれ1文字ずつ取り、半角ドット記号で区切った文字列を出力してください。',
          'answer'    => 'A.R',
        ],
        [
          'rank_id'   => 2,
          'name'      => 'Comming Soon',
          'content'   => '現在準備中です。更新をお待ちください。',
          'answer'    => '現在準備中',
        ],
        [
          'rank_id'   => 1,
          'name'      => 'Comming Soon',
          'content'   => '現在準備中です。更新をお待ちください。',
          'answer'    => '現在準備中',
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
