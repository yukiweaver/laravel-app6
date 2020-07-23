<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    public function users()
    {
      return $this->belongsToMany('App\User')->withTimestamps();
    }

    public function questions()
    {
      return $this->hasMany('App\Question');
    }

    /**
     * ランクタイプをキーにランク情報を取得
     * @param array $rankTypeArray
     * @return collection
     */
    public function findByRankTypeArray(array $rankTypeArray)
    {
      return $this->whereIn('rank_type', $rankTypeArray)->get();
    }

    /**
     * ランクタイプをキーにランク情報を取得
     * @param int $rankType
     * @return App\Rank
     */
    public function findByRankType(int $rankType)
    {
      return $this->where('rank_type', $rankType)->first();
    }
}
