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
      $rankId = $this->getQuestion()->rank_id;
      if ($rankId !== \RankConst::TRIAL_RANK_TYPE) {
        return true;
      }
      return false;
    }
}