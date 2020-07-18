<?php

namespace App\Services;

use App\User;

class UserService
{
  /**
   * @var App\User
   */
  private $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function getUser()
  {
    return $this->user;
  }

  /**
   * ユーザーの現在のランクより上のランクか確認
   * @param int $rankType
   * @return boolean true:上のランク false:上のランクではない
   */
  public function isHigherThanCurrentUserRank(int $rankType)
  {
    $currentRank = $this->getUser()->getRankType();
    if ($rankType < $currentRank) {
      return true;
    }
    return false;
  }
}