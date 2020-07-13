<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\QuestionRequest;
use Illuminate\Support\Facades\Log;

class QuestionController extends Controller
{
    /** 
     * 問題一覧ページ表示
     */
    public function index()
    {
      $viewParams = [];
      if (Auth::check()) {
        $currentUser = auth()->user();
        $currentRank = $currentUser->getRankType();
        $viewParams['current_rank'] = $currentRank;
      }
      $questionModel = app()->make('App\Question');
      $rankQuestions = $questionModel->findRankQuestions();
      $trialQuestions = $questionModel->findTrialQuestions();
      $viewParams['rank_questions'] = $rankQuestions;
      $viewParams['trial_questions'] = $trialQuestions;
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
        if (!$questionUser->checkByQuestionIdAndUserId($question->id, $currentUser->id)) {
          // 中間テーブルにデータがなければインサート処理
          $currentUser->insertQuestionUser($question->id);
        }
      }
      $viewParams = [
        'name'      => $question->name,
        'content'   => $question->content,
      ];
      return view('question.problem_statement', $viewParams);
    }

    /**
     * 解答処理
     * DBに正解フラグを立てるのはランク問題のみ
     * @param Illuminate\Http\Request $request
     */
    public function answer(Request $request)
    {
      Log::debug($request->stdout);
      Log::debug($request->stderr);
      return response()->json();
    }
}
