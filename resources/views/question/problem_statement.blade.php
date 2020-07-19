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
         <input type="hidden" value="{{ $question_id }}" id="question_id">
         <section class="questions">
           <h2 class="problem_statement_name">{{ $name }}</h2>　<!-- sectionに見出しになります　-->
            <span>{{ $content }}</span>
            <br><br><br>
            <h3 class="answer_column">解答欄</h3>
            <div id="editor" style="height: 600px"></div>
            <br>
            <div class="output_btn">
              <button class="btn btn-primary" id="output_btn">出力する</button>
            </div>
            <br><br><br>
            <h3 class="judgment">判定</h3>
            <div>◎判定結果</div>
            <div id="judgment" class=""></div>
            <br>
            <div>◎出力結果</div>
            <div id="output_result"></div>
            <br>
            <div>◎実行時エラーメッセージ</div>
            <div id="error_msg" class="incorrect"></div>
            <div class="back_btn">
              <a href="{{ route('root') }}" class="btn btn-primary" id="back_btn">一覧ページへ戻る</a>
            </div>
         </section>
       </div>
     {{-- </div> --}}
   </div>
 </div>
</div>
<script>
  const BASE_URL = 'http://api.paiza.io';
  const CREATE_URL = BASE_URL + '/runners/create';
  const GET_DETAILS_URL = BASE_URL + '/runners/get_details';
  const API_KEY = 'guest';
  const INCORRECT_ANSWER = '不正解';
  const CORRECT_ANSWER = '正解';
  let responseDetail = null;
  var editor = ace.edit("editor");
  editor.$blockScrolling = Infinity;
  editor.setOptions({
    enableBasicAutocompletion: true,
    enableSnippets: true,
    enableLiveAutocompletion: true
  });
  editor.setTheme("ace/theme/monokai");
  editor.getSession().setMode("ace/mode/javascript");

  /**
   * 待機処理
   * @param int msec
   * return void 
   */
  function sleep(msec) {
    return new Promise(function(resolve) {
      setTimeout(function() {resolve()}, msec);
    })
  }

  /** 
   * 追加するクラスを決定する
   * @param boolean addFlg
   * @return boolean
   */
  function DetermineClassToAdd(addFlg)
  {
    if (addFlg) {
      if ($('#judgment').hasClass('incorrect')) {
        $('#judgment').removeClass('incorrect');
      }
      if (!$('#judgment').hasClass('correct')) {
        $('#judgment').addClass('correct');
      }
    } else {
      if ($('#judgment').hasClass('correct')) {
        $('#judgment').removeClass('correct');
      }
      if (!$('#judgment').hasClass('incorrect')) {
        $('#judgment').addClass('incorrect');
      }
    }
    return true;
  }

  async function ajaxGetDetails(data) {
    await sleep(1000);
    let createId = data.id;
    $.ajax({
      url: GET_DETAILS_URL,
      type: 'GET',
      data: {
        id: createId,
        api_key: API_KEY,
      }
    })
    .done((data) => {
      ajaxAnswer(data);
    })
    .fail((data) => {
      alert('APIシステムエラー（Details）');
      return;
    })
  }

  async function ajaxAnswer(data) {
    await sleep(1000);
    if (data.stderr) {
      // 入力したプログラムにエラーがある場合はjs側でエラー処理
      DetermineClassToAdd(false);
      $('#judgment').text(INCORRECT_ANSWER);
      $('#error_msg').text(data.stderr);
      return;
    }
    $.ajax({
      url: '/question/answer',
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      data: {
        stdout: data.stdout,
        stderr: data.stderr,
        id: $('#question_id').val(),
      }
    })
    .done((data) => {
      console.log('answer成功');
      console.log(data);
      if (data.status == 'ng') {
        alert(data.content.error);
        return;
      }
      if (data.content.is_result) {
        DetermineClassToAdd(true);
        $('#judgment').text(CORRECT_ANSWER);
      } else {
        DetermineClassToAdd(false);
        $('#judgment').text(INCORRECT_ANSWER);
      }
      $('#output_result').text(data.content.stdout);
    })
    .fail((data) => {
      alert('解答処理でシステムエラー');
      return;
    })
  }

  $(function() {
    $('#output_btn').click(function() {
      let code = editor.getValue();
      $.ajax({
        url: CREATE_URL,
        type: 'POST',
        data: {
          source_code: code,
          language: 'php',
          input: '',
          longpoll: '',
          longpoll_timeout: '',
          api_key: API_KEY,
        }
      })
      .done((data) => {
        console.log('create成功');
        if (data.error != null) {
          alert(data.error);
          return;
        }
        ajaxGetDetails(data);
      })
      .fail((data) => {
        alert('APIシステムエラー（Create）');
        return;
      })
    })
  })
</script>
@endsection