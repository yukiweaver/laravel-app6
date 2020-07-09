<?php

/**
 * 自作ヘルパーを記述する
 * @author y-ueno
 */

if (!function_exists('outputRankType')) {
  /**
   * ランクタイプから当てはまる文字列を返す
   * @param int $rankType
   * @return string
   */
  function outputRankType($rankType)
  {
    if ($rankType == \RankConst::A_RANK_TYPE) {
      return 'Aランク';
    }
    if ($rankType == \RankConst::B_RANK_TYPE) {
      return 'Bランク';
    }
    if ($rankType == \RankConst::C_RANK_TYPE) {
      return 'Cランク';
    }
    if ($rankType == \RankConst::D_RANK_TYPE) {
      return 'Dランク';
    }
    if ($rankType == \RankConst::TRIAL_RANK_TYPE) {
      return 'お試し';
    }
  }
}