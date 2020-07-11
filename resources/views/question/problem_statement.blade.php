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
              <button class="btn btn-primary">出力する</button>
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
  var editor = ace.edit("editor");
  editor.$blockScrolling = Infinity;
  editor.setOptions({
    enableBasicAutocompletion: true,
    enableSnippets: true,
    enableLiveAutocompletion: true
  });
  editor.setTheme("ace/theme/monokai");
  editor.getSession().setMode("ace/mode/javascript");
</script>
@endsection