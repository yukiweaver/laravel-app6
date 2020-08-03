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
          @foreach ($user_status_info as $rankType => $status)
          <h4>{{ outputRankType($rankType) }}</h4>
          <table class="table">
            <thead>
              <tr>
                <th>問題数</th>
                <th>挑戦数</th>
                <th>クリア数</th>
                <th>正答率</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>{{ $status['questions_cnt'] }}問</td>
                <td>{{ $status['challenge_cnt'] }}問</td>
                <td>{{ $status['correct_cnt'] }}問</td>
                <td>{{ $status['answer_rate'] }}%</td>
              </tr>
            </tbody>
          </table>
          <br>
          @endforeach
         </section>
       </div>
     {{-- </div> --}}
   </div>
 </div>
</div>
<script>
  let userStatusInfo = @json($user_status_info);
  let allRanksName = @json($all_ranks_name);
  const a_rank_type = 1;
  const b_rank_type = 2;
  const c_rank_type = 3;
  const d_rank_type = 4;
  let suggestedMax = 0;
  let challengeCntData = [];
  let answeredCntData = [];
  let allRanks = [];
  $(function() {
    $.each(userStatusInfo, function(ids, status) {
      // # userStatusInfoがAランクから順にソートされていることが前提の処理
      challengeCntData.push(status.challenge_cnt);
      answeredCntData.push(status.correct_cnt);

      if (suggestedMax < status.questions_cnt) {
        suggestedMax = status.questions_cnt;
      };
    });

    $.each(allRanksName, function(ids, val) {
      allRanks.push(val);
    });
  
    var ctx = document.getElementById("myRaderChart");
    var myRadarChart = new Chart(ctx, {
        type: 'radar', 
        data: { 
            labels: allRanks,
            datasets: [{
                label: '挑戦数',
                data: challengeCntData,
                backgroundColor: 'RGBA(225,95,150, 0.5)',
                borderColor: 'RGBA(225,95,150, 1)',
                borderWidth: 1,
                pointBackgroundColor: 'RGBA(46,106,177)'
            }, {
                label: 'クリア数',
                data: answeredCntData,
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
                    suggestedMax: suggestedMax,
                    stepSize: 1,
                    callback: function(value, index, values){
                        return  value +  '問'
                    }
                }
            }
        }
    });
  });
</script>
@endsection