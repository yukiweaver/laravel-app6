<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rank;

class Question extends Model
{
    private $rank;

    public function __construct(array $attributes = [], Rank $rank = null) {
      parent::__construct($attributes);
      //以降に個別の設定処理
      if (isset($rank)) {
        $this->setRank($rank);
      }
    }

    /**
     * ランク情報をセットする
     * @param App\Rank $rank
     * @return void
     */
    public function setRank(Rank $rank)
    {
      $this->rank = $rank;
    }

    /**
     * ランク情報を取得する
     * @return App\Rank
     */
    public function getRank()
    {
      return $this->rank;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'rank_id',
      'name',
      'content',
      'answer',
    ];

    public function users()
    {
      return $this->belongsToMany('App\User')->withTimestamps()->withPivot(['is_correct', 'is_challenge']);
    }

    public function rank()
    {
      return $this->belongsTo('App\Rank');
    }

    /**
     * ランク問題を取得
     * @return collection
     */
    public function findRankQuestions($userId)
    {
      $rankQuestions = $this->whereIn('rank_id', function($query) {
        $query->select('id')
              ->from('ranks')
              ->whereNotIn('rank_type', [\RankConst::TRIAL_RANK_TYPE]);
      })->join('ranks', 'questions.rank_id', '=', 'ranks.id')
        ->select('questions.*', 'ranks.rank_type')
        ->get();
        
        $questionUserObj = app()->make('App\QuestionUser');
        foreach ($rankQuestions as $question) {
          $questionId = $question->id;
          $questionUser = $questionUserObj->findByQuestionIdAndUserId($questionId, $userId);
          if ($questionUser) {
            $question->is_correct = $questionUser->is_correct;
            $question->is_challenge = $questionUser->is_challenge;
          } else {
            $question->is_correct = null;
            $question->is_challenge = null;
          }
        }
      return $rankQuestions;
    }

    /**
     * お試し問題を取得
     * @return collection
     */
    public function findTrialQuestions()
    {
      $trialQuestions = $this->whereIn('rank_id', function($query) {
        $query->select('id')
              ->from('ranks')
              ->whereIn('rank_type', [\RankConst::TRIAL_RANK_TYPE]);
      })->join('ranks', 'questions.rank_id', '=', 'ranks.id')
        ->select('questions.*', 'ranks.rank_type')
        ->get();
      return $trialQuestions;
    }

    /**
     * question_userテーブルの正解フラグを一件更新
     * @param int $userId
     * @return boolean
     */
    public function updateQuestionUser(int $userId)
    {
      $dbParams = [
        'is_correct' => true,
      ];
      if ($this->users()->updateExistingPivot($userId, $dbParams)) {
        return true;
      }
      return false;
    }

    /**
     * 指定ユーザーのランクの問題の正解数を取得する
     * @param int $userId
     * @param int $rankType
     * @return int
     */
    public function getCorrectAnswersCnt(int $userId, int $rankType)
    {
      $questionUserObj = app()->make('App\QuestionUser');
      $rank = $this->getRank()->findByRankType($rankType);
      $questionIds = [];
      foreach ($rank->questions as $question) {
        $questionIds[] = $question->id;
      }
      $questionUsers = $questionUserObj->findByQuestionIdsAndUserId($questionIds, $userId);
      if ($questionUsers->isEmpty()) {
        return 0;
      }
      $answerCnt = 0;
      foreach ($questionUsers as $questionUser) {
        if ($questionUser->is_correct) {
          $answerCnt ++;
        }
      }
      return $answerCnt;
    }
}
