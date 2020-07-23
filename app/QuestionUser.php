<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class QuestionUser extends Pivot
{
    protected $table = 'question_user';

    /**
     * questionIdとuserIdをキーにしてレコードが存在するか判定する
     * @param int $questionId
     * @param int $userId
     * @return boolean
     */
    public function existByQuestionIdAndUserId(int $questionId, int $userId)
    {
      return $this->where('question_id', $questionId)->where('user_id', $userId)->exists();
    }

    /**
     * questionIdとuserIdをキーにして一件レコード取得
     * @param int $questionId
     * @param int $userId
     * @return 
     */
    public function findByQuestionIdAndUserId(int $questionId, int $userId)
    {
      return $this->where('question_id', $questionId)->where('user_id', $userId)->first();
    }

    /**
     * questionIdsとuserIdをキーにしてレコード取得
     * @param array $questionIds
     * @param int $userId
     * @return collection
     */
    public function findByQuestionIdsAndUserId(array $questionIds, int $userId)
    {
      return $this->whereIn('question_id', $questionIds)
                  ->where('user_id', $userId)
                  ->get();
    }
}
