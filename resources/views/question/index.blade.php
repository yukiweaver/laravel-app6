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
            <h2>お試し問題</h2>　<!-- sectionに見出しになります　-->
            <span>まずはお試し問題に挑戦してみよう！ランク問題にはログインすることで挑戦可能です。</span>
            <br><br>
            @foreach ($trial_questions as $t_question)
            <section class="section">
                <div class="box11">
                  <h3>{{ $t_question->name }}</h3>　<!-- sectionに見出しになります　-->
                </div>
            </section>
            @endforeach
          </section>
       </div>
     {{-- </div> --}}
   </div>
 </div>
</div>
@endsection
