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
            <div>不正解</div>
            <br>
            <div>◎出力結果</div>
            <div>test</div>
            <br>
            <div>◎実行結果ステータス</div>
            <div>Runtime error</div>
            <br>
            <div>◎実行時エラーメッセージ</div>
            <div>PHP Parse error:  syntax error, unexpected ''test'' (T_CONSTANT_ENCAPSED_STRING) in /workspace/Main.php on line 4</div>
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
      alert('システムエラー');
      return;
    })
  }

  async function ajaxAnswer(data) {
    await sleep(1000);
    if (data.stderr) {
      // 入力したプログラムにエラーがある場合はjs側でエラー処理
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
      }
    })
    .done((data) => {
      console.log('answer成功');
    })
    .fail((data) => {
      alert('システムエラー');
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
        console.log(data);
        if (data.error != null) {
          alert(data.error);
          return;
        }
        ajaxGetDetails(data);
      })
      .fail((data) => {
        alert('システムエラー');
        return;
      })
    })
  })
</script>
@endsection