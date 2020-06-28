<?php

use Illuminate\Database\Seeder;
use App\Rank;
use Illuminate\Support\Facades\Log;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Log::info('RankSeeder start!');
      $ranks = [
        [
          'name'      => 'Aランク',
          'rank_type' => 1,
        ],
        [
          'name'      => 'Bランク',
          'rank_type' => 2,
        ],
        [
          'name'      => 'Cランク',
          'rank_type' => 3,
        ],
        [
          'name'      => 'Dランク',
          'rank_type' => 4,
        ],
        [
          'name'      => 'お試し',
          'rank_type' => 9,
        ],
      ];
    
      // 登録
      foreach ($ranks as $rank) {
        Rank::create($rank);
        Log::info('Rankを作成しました。');
      }
      Log::info('RankSeeder end!');
    }
}
