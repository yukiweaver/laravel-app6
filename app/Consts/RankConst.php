<?php

namespace App\Consts;

class RankConst
{
  const A_RANK_TYPE = 1;
  const B_RANK_TYPE = 2;
  const C_RANK_TYPE = 3;
  const D_RANK_TYPE = 4;
  const TRIAL_RANK_TYPE = 9;
  const C_RANK_REQURED_NUMBER_OF_CORRECT_ANSWERS = 2; // Cランク昇格に必要なDランク問題の正解数
  const B_RANK_REQURED_NUMBER_OF_CORRECT_ANSWERS = 5; // Bランク昇格に必要なCランク問題の正解数
  const A_RANK_REQURED_NUMBER_OF_CORRECT_ANSWERS = 5; // Aランク昇格に必要なBランク問題の正解数
}