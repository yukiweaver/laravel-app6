<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    /** 
     * 問題一覧ページ表示
     */
    public function index()
    {
      $viewParams = [];
      $questionModel = app()->make('App\Question');
      $questionService = app()->make('App\Services\QuestionService');
      if (Auth::check()) {
        $currentUser = auth()->user();
        $currentRank = $currentUser->getRankType();
        $questions = $questionModel->findRankQuestions($currentUser->id);
        $remainingCorrectAnswersCnt = $questionService->getCorrectAnswersRemainingForPromotion($currentUser->id, $currentRank);
        $viewParams['remaining_correct_answers_cnt'] = $remainingCorrectAnswersCnt;
        $viewParams['current_rank'] = $currentRank;
      } else {
        $questions = $questionModel->findTrialQuestions();
        $viewParams['current_rank'] = null;
      }
      $viewParams['questions'] = $questions;
      return view('question.index', $viewParams);
    }

    /**
     * 問題文を表示
     * @param App\Http\Requests\QuestionRequest $request
     */
    public function problemStatement(QuestionRequest $request)
    {
      $question = Question::find($request->id);
      if (Auth::check()) {
        $currentUser = auth()->user();
        $questionUser = app()->make('App\QuestionUser');
        $userService = app()->makeWith('App\Services\UserService', ['user' => $currentUser]);
        if ($userService->isHigherThanCurrentUserRank($question->rank->rank_type)) {
          // 自身のランクより上の問題は閲覧不可
          return redirect()->route('root');
        }
        if (!$questionUser->existByQuestionIdAndUserId($question->id, $currentUser->id)) {
          // 中間テーブルにデータがなければインサート処理
          $currentUser->insertQuestionUser($question->id);
        }
      } else {
        $questionService = app()->makeWith('App\Services\QuestionService', ['question' => $question]);
        if ($questionService->isRankQuestion()) {
          // 未ログイン状態でランク問題は閲覧不可
          return redirect()->route('user.signin');
        }
      }
      $viewParams = [
        'name'          => $question->name,
        'content'       => $question->content,
        'question_id'   => $question->id,
        'languages' => \QuestionConst::LANGUAGES,
      ];
      return view('question.problem_statement', $viewParams);
    }

    /**
     * 解答処理
     * @param Illuminate\Http\Request $request
     */
    public function answer(Request $request)
    {
      $stdout = $request->stdout;
      $data = [
        'stdout'      => $stdout,
        'is_result'   => '',
        'error'       => '',
      ];
      $rankObj = app()->make('App\Rank');
      $rankService = app()->make('App\Services\RankService');
      $questionObj = app()->make('App\Question');
      $question = $questionObj->findByQuestionId($request->id);
      $questionService = app()->makeWith('App\Services\QuestionService', ['question' => $question]);
      // 正解かどうか判定する
      if ($questionService->isCorrectAnswer($stdout)) {
        $data['is_result'] = true;
        if ($questionService->isRankQuestion()) {
          $currentUser = auth()->user();
          $currentRank = $currentUser->getRankType();
          $userService = app()->makeWith('App\Services\UserService', ['user' => $currentUser]);
          if ($userService->isHigherThanCurrentUserRank($question->rank_type)) {
            // 自身のランクより上の問題は解答不可
            $data['error'] = \MessageConst::ERRMSG_RANK_ABOVE_CURRENT_USER_RANK;
            return putJsonError($data);
          }
          // DB更新
          DB::beginTransaction();
          try {
            $question->updateQuestionUser($currentUser->id);
            if ($rankService->isPromotion($currentUser->id, $currentRank)) {
              // ランク昇格処理
              $nextRankType = $rankService->getRankAfterPromotion($currentRank);
              $nextRank = $rankObj->findByRankType($nextRankType);
              $currentUser->insertRankUser($nextRank->id);
            }
            DB::commit();
            return putJsonSuccess($data);
          } catch (\Exception $e) {
            DB::rollback();
            $data['error'] = \MessageConst::ERRMSG_DB_ERROR;
            return putJsonError($data);
          }
        }
        return putJsonSuccess($data);
      }
      $data['is_result'] = false;
      return putJsonSuccess($data);
    }
}
