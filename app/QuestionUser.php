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
    public function checkByQuestionIdAndUserId(int $questionId, int $userId)
    {
      return $this->where('question_id', $questionId)->where('user_id', $userId)->exists();
    }
}
