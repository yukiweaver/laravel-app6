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
            あなたは現在Cランクです。
            あと○問正解でランクが昇格します。
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
          labels: ["英語", "数学", "国語", "理科"],
          datasets: [{
              label: 'Aさん',
              data: [92, 72, 86, 74],
              backgroundColor: 'RGBA(225,95,150, 0.5)',
              borderColor: 'RGBA(225,95,150, 1)',
              borderWidth: 1,
              pointBackgroundColor: 'RGB(46,106,177)'
          }, {
              label: 'Bさん',
              data: [73, 95, 80, 87],
              backgroundColor: 'RGBA(115,255,25, 0.5)',
              borderColor: 'RGBA(115,255,25, 1)',
              borderWidth: 1,
              pointBackgroundColor: 'RGB(46,106,177)'
          }]
      },
      options: {
          title: {
              display: true,
              text: '試験成績'
          },
          scale:{
              ticks:{
                  suggestedMin: 0,
                  suggestedMax: 100,
                  stepSize: 10,
                  callback: function(value, index, values){
                      return  value +  '点'
                  }
              }
          }
      }
  });
</script>
@endsection