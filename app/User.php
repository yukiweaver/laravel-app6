<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Rank;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

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
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function ranks()
    {
      return $this->belongsToMany('App\Rank')->withTimestamps();
    }

    public function questions()
    {
      return $this->belongsToMany('App\Question')->withTimestamps();
    }

    /**
     * ユーザを登録する
     * 中間テーブルへのインサートも同時に行う
     * @param array $params
     * @return boolean
     */
    public function registUser(array $params)
    {
      DB::beginTransaction();
      try {
        $this->fill($params)->save();
        $user = User::find($this->id);
        $rankObj = $this->getRank();
        $rankTypeArray = [\RankConst::D_RANK_TYPE, \RankConst::TRIAL_RANK_TYPE];
        $ranks = $rankObj->findByRankTypeArray($rankTypeArray);
        $rankIds = [];
        foreach ($ranks as $rank) {
          array_push($rankIds, $rank->id);
        }
        $user->ranks()->attach($rankIds);
        DB::commit();
        return true;
      } catch (\Exception $e) {
        DB::rollback();
        return false;
      }
    }

    /**
     * ユーザのランクタイプを返す
     * @return int
     */
    public function getRankType()
    {
      $ranks = $this->ranks();
      $currentRank = null;
      foreach ($ranks as $rank) {
        if (is_null($currentRank)) {
          $currentRank = $rank->rank_type;
        }
        if ($currentRank > $rank->rank_type) {
          $currentRank = $rank->rank_type;
        }
      }
      return $currentRank;
    }
}
