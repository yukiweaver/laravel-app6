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

  /**
   * 指定のIDがログインユーザーのIDと一致するか判定
   * @param string $id
   * @return boolean true: 一致する false: 一致しない
   */
  public function checkCurrentUserId(string $id)
  {
    $currentUser = auth()->user();
    if (!$currentUser) {
      throw new \Exception(\MessageConst::ERRMSG_NOT_CURRENT_USER);
    }
    if (strval($currentUser->id) === $id) {
      return true;
    }
    return false;
  }
}