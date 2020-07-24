<?php

namespace App\Services;

use App\Question;

class QuestionService
{

  /**
   * @var App\Question
   */
    private $question;

    public function __construct(Question $question)
    {
      $this->question = $question;
    }

    public function getQuestion()
    {
      return $this->question;
    }

    /**
     * 出力結果が正解かどうか判定
     * @param string $stdout
     * @return boolean true:正解 false:不正解
     */
    public function isCorrectAnswer(string $stdout)
    {
      $answer = $this->getQuestion()->answer;
      if ($answer == $stdout) {
        return true;
      }
      return false;
    }

    /**
     * 問題がランク問題であるか判定
     * @return boolean true:ランク問題 false:お試し問題
     */
    public function isRankQuestion()
    {
      $rankType = $this->getQuestion()->rank->rank_type;
      if ($rankType !== \RankConst::TRIAL_RANK_TYPE) {
        return true;
      }
      return false;
    }

    /**
     * ランク昇格に必要な残り問題正解数を取得
     * @param int $userId
     * @param int $rankType
     * @return int
     */
    public function getCorrectAnswersRemainingForPromotion(int $userId, int $rankType)
    {
      $answersCnt = $this->getQuestion()->getCorrectAnswersCnt($userId, $rankType);
      if ($rankType === \RankConst::D_RANK_TYPE) {
        $remainingCorrectAnswersCnt = \RankConst::C_RANK_REQURED_NUMBER_OF_CORRECT_ANSWERS - $answersCnt;
      }
      if ($rankType === \RankConst::C_RANK_TYPE) {
        $remainingCorrectAnswersCnt = \RankConst::B_RANK_REQURED_NUMBER_OF_CORRECT_ANSWERS - $answersCnt;
      }
      if ($rankType === \RankConst::B_RANK_TYPE) {
        $remainingCorrectAnswersCnt = \RankConst::A_RANK_REQURED_NUMBER_OF_CORRECT_ANSWERS - $answersCnt;
      }
      if ($rankType === \RankConst::A_RANK_TYPE) {
        $remainingCorrectAnswersCnt = 0;
        return $remainingCorrectAnswersCnt;
      }

      if ($remainingCorrectAnswersCnt < 0) {
        // 0より下はあり得ない
        throw new \Exception(\MessageConst::ERRMSG_INVALID_REMAINING_CORRECT_ANSWERS_CNT);
      }
      return $remainingCorrectAnswersCnt;
    } 
}