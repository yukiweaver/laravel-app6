<?php

namespace App\Services;

use App\Rank;
use App\Services\QuestionService;

class RankService
{
    /**
     * @var App\Question
     */
    private $rank;

    /**
     * @var App\Services\QuestionService
     */
    private $questionService;

    public function __construct(Rank $rank, QuestionService $questionService)
    {
      $this->rank = $rank;
      $this->questionService = $questionService;
    }

    public function getRank()
    {
      return $this->rank;
    }

    public function getQuestionService()
    {
      return $this->questionService;
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

    /**
     * ランク昇格処理を行うか判定する
     * @param int $rankType
     * @return boolean true: 昇格処理を行う false: 昇格処理を行わない
     */
    public function isPromotion(int $userId, int $rankType)
    {
      if ($rankType === \RankConst::A_RANK_TYPE) {
        // Aランクならランク昇格はなし
        return false;
      }
      $remainingCorrectAnswersCnt = $this->getQuestionService()->getCorrectAnswersRemainingForPromotion($userId, $rankType);
      if ($remainingCorrectAnswersCnt === 0) {
        return true;
      }
      return false;
    }
}