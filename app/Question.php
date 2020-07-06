<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
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
      return $this->belongsToMany('App\User');
    }

    public function rank()
    {
      return $this->belongsTo('App\Rank');
    }

    /**
     * ランク問題を取得
     * @return collection
     */
    public function findRankQuestions()
    {
      $rankQuestions = $this->whereIn('rank_id', function($query) {
        $query->select('id')
              ->from('ranks')
              ->whereNotIn('rank_type', [\RankConst::TRIAL_RANK_TYPE]);
      })->join('ranks', 'questions.rank_id', '=', 'ranks.id')
        ->select('questions.*')
        ->get();
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
        ->select('questions.*')
        ->get();
      return $trialQuestions;
    }
}
