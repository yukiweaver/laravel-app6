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
         <h1>ステータス確認</h1>
         <section class="questions">
          <span>
            あなたは現在{{ outputRankType($current_rank) }}です。
            @if ($current_rank !== \RankConst::A_RANK_TYPE)
            あと{{ $remaining_correct_answers_cnt }}問正解でランクが昇格します。
            @endif
          </span>
          <br>
          <canvas id="myRaderChart"></canvas>
          <br>
          <table class="table">
            <thead>
              <tr>
                <th></th>
                <th>Aランク</th>
                <th>Bランク</th>
                <th>Cランク</th>
                <th>Dランク</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th>挑戦数</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <th>クリア数</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
              <tr>
                <th>正答率</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
              </tr>
            </tbody>
          </table>
         </section>
       </div>
     {{-- </div> --}}
   </div>
 </div>
</div>
<script>
  var ctx = document.getElementById("myRaderChart");
  var myRadarChart = new Chart(ctx, {
      type: 'radar', 
      data: { 
          labels: ["Aランク", "Bランク", "Cランク", "Dランク"],
          datasets: [{
              label: '挑戦数',
              data: [8, 7, 6, 7],
              backgroundColor: 'RGBA(225,95,150, 0.5)',
              borderColor: 'RGBA(225,95,150, 1)',
              borderWidth: 1,
              pointBackgroundColor: 'RGBA(46,106,177)'
          }, {
              label: 'クリア数',
              data: [3, 5, 5, 5],
              backgroundColor: 'RGBA(115,255,100, 0.5)',
              borderColor: 'RGBA(115,255,100, 1)',
              borderWidth: 1,
              pointBackgroundColor: 'RGB(46,106,177)'
          }]
      },
      options: {
          title: {
              display: true,
              text: 'ステータス'
          },
          scale:{
              ticks:{
                  suggestedMin: 0,
                  suggestedMax: 10,
                  stepSize: 1,
                  callback: function(value, index, values){
                      return  value +  '問'
                  }
              }
          }
      }
  });
</script>
@endsection