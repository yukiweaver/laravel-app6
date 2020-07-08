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
            <span>あなたは現在Dランクです。あと○問正解でランクが昇格します。</span>
            <br><br>
            @foreach ($rank_questions as $r_question)
            <section class="section">
                <div class="box11">
                  <h3>{{ $r_question->name }}</h3>　<!-- sectionに見出しになります　-->
                </div>
            </section>
            @endforeach
            @else
            <h2>お試し問題</h2>　<!-- sectionに見出しになります　-->
            <span>まずはお試し問題に挑戦してみよう！ランク問題にはログインすることで挑戦可能です。</span>
            @foreach ($trial_questions as $t_question)
            <section class="section">
                <div class="box11">
                  <h3>{{ $t_question->name }}</h3>　<!-- sectionに見出しになります　-->
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
@endsection
