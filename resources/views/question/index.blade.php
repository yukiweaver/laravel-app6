@extends('layouts.app')

@section('content')
<div class="container">
 <div class="row justify-content-center">
   <div class="col-md-12">
     {{-- <div class="card"> --}}
       {{-- <div class="card-header">{{ __('問題一覧') }}</div> --}}
       <div class="card-body">
         @if (count($errors) > 0)
         <div class="errors">
           <ul>
             @foreach ($errors->all() as $error)
               <li>{{$error}}</li>
             @endforeach
           </ul>
         </div>
         @endif
         <h1>プログラミングスキルチェック</h1>
         <section class="questions">
            @if (Auth::check())
            <h2>ランク問題</h2>　<!-- sectionに見出しになります　-->
            <span>
              あなたは現在{{ outputRankType($current_rank) }}です。
              @if ($current_rank !== \RankConst::A_RANK_TYPE)
              あと{{ $remaining_correct_answers_cnt }}問正解でランクが昇格します。
              @endif
            </span>
            <br><br>
            <div class="tab_wrap">
              <div class="tab_area">
                <label class="tab_label" for="tab1" id="label_rank_d">Dランク</label>
                <label class="tab_label" for="tab2" id="label_rank_c">Cランク</label>
                <label class="tab_label" for="tab3" id="label_rank_b">Bランク</label>
                <label class="tab_label" for="tab4" id="label_rank_a">Aランク</label>
              </div>
              <div class="panel_area">
                <div id="rank_d" class="tab_panel">
                  <p>Dランク</p>
                </div>
                <div id="rank_c" class="tab_panel">
                  <p>Cランク</p>
                </div>
                <div id="rank_b" class="tab_panel">
                  <p>Bランク</p>
                </div>
                <div id="rank_a" class="tab_panel">
                  <p>Aランク</p>
                </div>
              </div>
            </div>
            @else
            <h2>お試し問題</h2>　<!-- sectionに見出しになります　-->
            <span>まずはお試し問題に挑戦してみよう！ランク問題にはログインすることで挑戦可能です。</span>
            @foreach ($questions as $t_question)
            <section class="section">
                <div class="box11">
                  <h3 class="question_name">{{ $t_question->name }}</h3>　<!-- sectionに見出しになります　-->
                  <a href="{{ route('question.problem_statement', ['id' => $t_question->id]) }}" class="btn btn-primary challenge_btn">挑戦する</a>
                </div>
            </section>
            @endforeach
            @endif
          </section>
       </div>
     {{-- </div> --}}
   </div>
 </div>
</div>

<script>
  let questions = @json($questions);
  let currentRank = @json($current_rank);
  const a_rank_type = 1;
  const b_rank_type = 2;
  const c_rank_type = 3;
  const d_rank_type = 4;

  /**
   * appendするためのhtmlを生成する
   */
  function createHtml(question)
  {
    html = '';
    html += '<section class="section">';
    html += '<div class="box11">';
    html += `<h3 class="question_name">${question.name}</h3>`;
    if (question.is_challenge) {
      html += '<span class="btn-sticky is_challenge">挑戦済み</span>';
    }
    if (question.is_correct) {
      html += '<span class="btn-sticky is_correct">クリア済み</span>';
    }
    html += `<a href="/question/problem_statement?id=${question.id}" class="btn btn-primary challenge_btn">挑戦する</a>`;
    html += '</div>';
    html += '</section>';

    return html;
  }

  /**
   * ランクタイプごとにhtmlをappendする
   */
  function appendRankQuestion(question, rankType)
  {
    if (rankType == a_rank_type) {
      $('#rank_a').append(createHtml(question));
    }
    if (rankType == b_rank_type) {
      $('#rank_b').append(createHtml(question));
    }
    if (rankType == c_rank_type) {
      $('#rank_c').append(createHtml(question));
    }
    if (rankType == d_rank_type) {
      $('#rank_d').append(createHtml(question));
    }
  }

  /** 
   * 指定のランクからactiveクラスを初期状態として追加する
   */
  function addActiveClassWithCurrentRank(currentRank)
  {
    if (currentRank == a_rank_type) {
      $('#rank_a').addClass('active');
      $('#label_rank_a').addClass('acrive');
    }
    if (currentRank == b_rank_type) {
      $('#rank_b').addClass('active');
      $('#label_rank_b').addClass('acrive');
    }
    if (currentRank == c_rank_type) {
      $('#rank_c').addClass('active');
      $('#label_rank_c').addClass('acrive');
    }
    if (currentRank == d_rank_type) {
      $('#rank_d').addClass('active');
      $('#label_rank_d').addClass('acrive');
    }
  }

  $(function() {

    /** 
     * キーがランクタイプの配列に変換する
     */
    function convertQuestions(questions)
    {
        let convertQuestions = {};
        $.each(questions, function(ids, question) {
          convertQuestions[ids] = [];
        });
        $.each(questions, function(ids, question) {
          convertQuestions[ids][question.rank_type] = question;
        });
        return convertQuestions;
    }

    addActiveClassWithCurrentRank(currentRank)

    $(".tab_label").on("click",function(){
      var $th = $(this).index();
      $(".tab_label").removeClass("active");
      $(".tab_panel").removeClass("active");
      $(this).addClass("active");
      $(".tab_panel").eq($th).addClass("active");
    });

    convertQuestions = convertQuestions(questions);

    $.each(convertQuestions, function(ids, c_questions) {
      $.each(c_questions, function(rankType, question) {
        if (!question) {
          return true;
        }
        appendRankQuestion(question, rankType);
      });
    });
  });
</script>
@endsection
