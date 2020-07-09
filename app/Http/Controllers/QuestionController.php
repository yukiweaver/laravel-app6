<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Question;
use Illuminate\Support\Facades\Auth;

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
     */
    public function problemStatement(Request $request)
    {
      //
    }
}