@include('date.components.head')

@php 
    $dating_survey_m = 'https://docs.google.com/forms/d/e/1FAIpQLSf729TuKGvkpx3rNoN290_mkVAlLN8ltp66oo0Jn2mCF2qf8w/viewform';
    $dating_survey_f = 'https://docs.google.com/forms/d/e/1FAIpQLSeeZNRi_X19m5xG99lSlkNQOdcCVpOMnzGRFxT_gsNVmzrvIQ/viewform';
@endphp

    <style>
        .jumbotron{
            background-color:#c3a367;
            color:#2b2b2b;
            border-radius:0px;
        }
        body{
            background-color:#2b2b2b;
            color:#c3a367;
        }
        a{
            color:#c3a367;
        }
    </style>
</head>
<body>

<div style="padding-top:20px;padding-right:20px;" class="float-right">
    <a href="/date/data" class="btn btn-primary">回上頁</a>
</div>
<div class="jumbotron text-center">
    <h2><strong>配對結果</strong></h2>
</div>

<div class="container">
    @if(empty($data['result']))
        <h2 class="text-center" style="color:red;">目前沒有配對結果</h2>
    @endif
    <div class="row">
    @if(!empty($data['result']))
            @foreach($data['result'] as $value)
                @if($value['appointment_result'] !== 'otherSide')
                    <div class="col-md-4">
                        <h3>{{ $value['appointment_user'] }}</h3>
                        <h5>約會類型 : {{ $value['type'] }}</h5>
                        @if($value['type'] == '餐廳約會')
                            <h5>餐廳地點 : {{ $value['restaurant'] }}</h5>
                        @endif
                        @if($value['type'] == '視訊約會')
                            <h5>視訊方式 : {{ $value['chat_option'] }}</h5>
                        @endif
                        @if($value['appointment_result'] == null || $value['appointment_result'] == 'noSel')
                            <h5>排約結果 : <br><span style="color:red;">未回應</span></h5>
                        @elseif($value['appointment_result'] == 'delete')
                            <h5>排約結果 : <br><span style="color:red;">對方拒絕邀約</span></h5>
                        @elseif($value['appointment_result'] == 'noTime')
                            <h5>排約結果 : <br><span style="color:red;">時間無法配合，要另約時間</span></h5>
                        @else
                            @php 
                                $week = date('w',strtotime($value['datetime'])); 
                                if($week == 0) $week = '日';
                                if($week == 1) $week = '一';
                                if($week == 2) $week = '二';
                                if($week == 3) $week = '三';
                                if($week == 4) $week = '四';
                                if($week == 5) $week = '五';
                                if($week == 6) $week = '六';
                            @endphp
                            <h5>排約結果 : <br>
                                @php
                                    $now = strtotime(date('Y-m-d H:i:s'));
                                    $date_time = strtotime($value['appointment_result']);
                                    $date_start = $date_time + 3*60*60;
                                    $date_over = $date_time + 24*60*60*7;
                                    $date_start2 = $date_time - 3*60*60;
                                    $date_over2 = $date_time + 3*60*60;
                                @endphp  
                                <span style="color:green;">  
                                {{ date('Y/m/d', $date_time) }} ({{$week}}) {{ date('H點i分', $date_time) }}
                                </span>
                                @if($now > $date_start && $now < $date_over)
                                    <br>
                                    <a href="{{ $dating_survey_f }}" target="__blank"><u>約會滿意度調查表(女生用)</u></a>
                                    <br>
                                    <a href="{{ $dating_survey_m }}" target="__blank"><u>約會滿意度調查表(男生用)</u></a>             
                                @endif
                                @if($now > $date_start2 && $now < $date_over2 || true)
                                    <div style="margin-top:10px;">對方傳給你的訊息 :</div>
                                    @if($value['date_msg'] == null || $value['date_msg'] == 'no')
                                        <div style="color:pink;">無</div>
                                    @else
                                        <div style="color:pink;">{{$value['date_msg']}}</div>
                                    @endif
                                    <div style="margin-top:10px;">無法準時到達給對方的訊息 :</div>
                                    <form action="/date/date_msg_post" method="post" id="date_msg_form">
                                        @csrf
                                        <input type="hidden" name="table_id" value="{{ $value['id'] }}">
                                        <div class="form-group">
                                            <div class="form-check">
                                                <label class="form-check-label" for="msg0">
                                                    <input type="radio" class="form-check-input" id="msg0" name="msg" value="no">
                                                    無
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="msg1">
                                                    <input type="radio" class="form-check-input" id="msg1" name="msg" value="會晚到5分鐘左右">
                                                    會晚到5分鐘左右
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="msg2">
                                                    <input type="radio" class="form-check-input" id="msg2" name="msg" value="會晚到10分鐘左右">
                                                    會晚到10分鐘左右
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="msg3">
                                                    <input type="radio" class="form-check-input" id="msg3" name="msg" value="會晚到15分鐘左右">
                                                    會晚到15分鐘左右
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="msg4">
                                                    <input type="radio" class="form-check-input" id="msg4" name="msg" value="會晚到30分鐘左右">
                                                    會晚到30分鐘左右
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label" for="msg5">
                                                    <input type="radio" class="form-check-input" id="msg5" name="msg" value="碰到緊急情況無法到達">
                                                    碰到緊急情況無法到達
                                                </label>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary"
                                        style="background-color:#c3a367;color:#2b2b2b;border:0px;font-weight:900;">
                                            送出
                                        </button>
                                    </form>
                                @endif
                            </h5>
                        @endif
                        <br>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
</div>
<br><br>

<script>  
$(document).ready(function(){
    $("#date_msg_form").on('submit', function(e){
        alert('訊息已送出');
    });
});

</script>
</body>
</html>