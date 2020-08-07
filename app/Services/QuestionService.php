<?php

namespace App\Services;

use App\Question;
use Illuminate\Database\Eloquent\Collection;

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
     * @param string|null $stdout
     * @return boolean true:正解 false:不正解
     */
    public function isCorrectAnswer(?string $stdout)
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

    /**
     * 指定のcollectionからランクタイプがキーの多次元連想配列に変換し、問題数、挑戦数、クリア数、正答率をランクごとに算出する
     * @param Illuminate\Database\Eloquent\Collection $questions
     * @return array
     */
    public function getUserStatusInfo(Collection $questions)
    {
      $userStatusInfo = [];
      
      $aRankQuestionsCnt = 0;
      $bRankQuestionsCnt = 0;
      $cRankQuestionsCnt = 0;
      $dRankQuestionsCnt = 0;

      $aRankChallengeCnt = 0;
      $bRankChallengeCnt = 0;
      $cRankChallengeCnt = 0;
      $dRankChallengeCnt = 0;

      $aRankAnsweredCnt = 0;
      $bRankAnsweredCnt = 0;
      $cRankAnsweredCnt = 0;
      $dRankAnsweredCnt = 0;
      foreach ($questions as $question) {
        if (empty($userStatusInfo[$question->rank_type])) {
          $userStatusInfo[$question->rank_type] = [];
        }

        if ($question->rank_type === \RankConst::A_RANK_TYPE) {
          $this->countUp($aRankQuestionsCnt, true);
          $this->countUp($aRankChallengeCnt, $question->is_challenge);
          $this->countUp($aRankAnsweredCnt, $question->is_correct);
        }

        if ($question->rank_type === \RankConst::B_RANK_TYPE) {
          $this->countUp($bRankQuestionsCnt, true);
          $this->countUp($bRankChallengeCnt, $question->is_challenge);
          $this->countUp($bRankAnsweredCnt, $question->is_correct);
        }

        if ($question->rank_type === \RankConst::C_RANK_TYPE) {
          $this->countUp($cRankQuestionsCnt, true);
          $this->countUp($cRankChallengeCnt, $question->is_challenge);
          $this->countUp($cRankAnsweredCnt, $question->is_correct);
        }

        if ($question->rank_type === \RankConst::D_RANK_TYPE) {
          $this->countUp($dRankQuestionsCnt, true);
          $this->countUp($dRankChallengeCnt, $question->is_challenge);
          $this->countUp($dRankAnsweredCnt, $question->is_correct);
        }
      }

      foreach ($userStatusInfo as $rankType => $array) {
        if ($rankType === \RankConst::A_RANK_TYPE) {
          $userStatusInfo[$rankType] = [
            'questions_cnt' => $aRankQuestionsCnt,
            'challenge_cnt' => $aRankChallengeCnt,
            'correct_cnt'   => $aRankAnsweredCnt,
            'answer_rate'   => $this->getCorrectAnswerRate($aRankAnsweredCnt, $aRankChallengeCnt),
          ];
          continue;
        }

        if ($rankType === \RankConst::B_RANK_TYPE) {
          $userStatusInfo[$rankType] = [
            'questions_cnt' => $bRankQuestionsCnt,
            'challenge_cnt' => $bRankChallengeCnt,
            'correct_cnt'   => $bRankAnsweredCnt,
            'answer_rate'   => $this->getCorrectAnswerRate($bRankAnsweredCnt, $bRankChallengeCnt),
          ];
          continue;
        }

        if ($rankType === \RankConst::C_RANK_TYPE) {
          $userStatusInfo[$rankType] = [
            'questions_cnt' => $cRankQuestionsCnt,
            'challenge_cnt' => $cRankChallengeCnt,
            'correct_cnt'   => $cRankAnsweredCnt,
            'answer_rate'   => $this->getCorrectAnswerRate($cRankAnsweredCnt, $cRankChallengeCnt),
          ];
          continue;
        }

        if ($rankType === \RankConst::D_RANK_TYPE) {
          $userStatusInfo[$rankType] = [
            'questions_cnt' => $dRankQuestionsCnt,
            'challenge_cnt' => $dRankChallengeCnt,
            'correct_cnt'   => $dRankAnsweredCnt,
            'answer_rate'   => $this->getCorrectAnswerRate($dRankAnsweredCnt, $dRankChallengeCnt),
          ];
          continue;
        }
      }
      return $userStatusInfo;
    }

    /**
     * 指定の条件がtrueならカウントアップする
     * @param int $cnt
     * @param boolean|null $countUpFlg
     * @return boolean
     */
    public function countUp(int &$cnt, ?bool $countUpFlg)
    {
      if ($countUpFlg) {
        $cnt ++;
      }
      return true;
    }

    /**
     * 正答率を算出する
     * @param int $answerCnt
     * @param int $challengeCnt
     */
    public function getCorrectAnswerRate(int $answerCnt, int $challengeCnt)
    {
      if ($answerCnt === 0 || $challengeCnt === 0) {
        return 0;
      }
      $division = $answerCnt / $challengeCnt;
      return (round($division, 3)) * 100;
    }
}