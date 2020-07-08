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
      if (Auth::check()) {
        $currentUser = auth()->user();
      }
      $questionModel = app()->make('App\Question');
      $rankQuestions = $questionModel->findRankQuestions();
      $trialQuestions = $questionModel->findTrialQuestions();
      $viewParams = [
        'rank_questions'  => $rankQuestions,
        'trial_questions' => $trialQuestions,
      ];
      return view('question.index', $viewParams);
    }
}
