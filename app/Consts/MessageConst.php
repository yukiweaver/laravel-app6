<?php

namespace App\Consts;

class MessageConst
{
  // メッセージエラー系
  const ERRMSG_DB_ERROR = 'DBエラーが発生しました。';
  const ERRMSG_RANK_ABOVE_CURRENT_USER_RANK = 'ユーザーのランクより上のランクの問題です。';
  const ERRMSG_INVALID_REMAINING_CORRECT_ANSWERS_CNT = 'ランク昇格に必要な残り正解数が不正な値です。';
}