<?php

namespace App\Services;

use App\Rank;

class RankService
{
    /**
     * @var App\Question
     */
    private $rank;

    public function __construct(Rank $rank)
    {
      $this->rank = $rank;
    }

    public function getRank()
    {
      return $this->rank;
    }

    /**
     * 昇格後のランクタイプを取得
     * 現在DランクならCランクを取得
     * @param int $rankType
     * @return int
     */
    public function getRankAfterPromotion(int $rankType)
    {
      if ($rankType === \RankConst::A_RANK_TYPE) {
        // Aランクならエラーとする
        throw new \Exception(\MessageConst::ERRMSG_PROMOTED_HIGHEST_RANK);
      }
      if ($rankType === \RankConst::D_RANK_TYPE) {
        return \RankConst::C_RANK_TYPE;
      }
      if ($rankType === \RankConst::C_RANK_TYPE) {
        return \RankConst::B_RANK_TYPE;
      }
      if ($rankType === \RankConst::B_RANK_TYPE) {
        return \RankConst::A_RANK_TYPE;
      }
    }
}