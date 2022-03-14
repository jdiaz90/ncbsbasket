@section('title')
{{$coach->Full_Name}} ({{$coach->franchise}}) - 
{{ config('app.name') }}
@endsection

@section('description')
Toda la información sobre {{$coach->Full_Name}},
jugador de {{$coach->franchise}} 
en la liga {{ config('app.name') }}.
@endsection

@section('css')

<style type="text/css">
.coachPhi .container .row span, .container .row .little span{ 
    background-color: {{$coach->TeamColor2}};
}
</style>

@endsection

@section('javascript')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
@endsection

@section('section')

<section id="playerSection">

    <div class="container top">
        <div class="row align-items-center">
          <div class="col">
            <img height="190px" src="{{$coach->PlayerPhoto}}"
            onerror="this.onerror=null; this.src='/images/players/default.png';">
          </div>
          <div class="col name">
            <h1>{{$coach->FirstName}}<br/>
                {{$coach->LastName}}</h1>
    
                <h2>
                    @if($coach->franchise != "Free Agent")
                    <a href="{{$coach->URLTeam}}"><img width="32px" 
                    src="{{$coach->coachTeam->ImgLogo}}"></a>
                    <a href="{{$coach->URLTeam}}">{{$coach->coachTeam->franchise}}</a> -
                    {{$otherInfo['Job']}}
                    @else
                    Free Agent - {{$otherInfo['Job']}}
                    @endif
                </h2>
          </div>
          <div class="col">
            <div class="d-flex flex-column miscellany">
                <div class="p-2"><b>AGE</b></div>
                <div class="p-2">{{$coach->CoachAge}} YEARS OLD</div>
                <div class="p-2"><b>EXPERIENCE</b></div>
                <div class="p-2">{{$otherInfo['Experience']}} YEARS</div>
                @if($otherInfo['Salary'] != 0)
                <div class="p-2"><b>CONTRACT AMOUNT</b></div>
                <div class="p-2">{{$otherInfo['Salary']}} PER YEAR</div>
                @endif
                {{-- <div class="p-2"><b>CONTRACT LENGTH</b></div>
                <div class="p-2">{{$coach->Draft}}</div> --}}
            </div>
          </div>
          <div class="col">
            <div class="d-flex flex-row stats">
                <div class="p-2"><span>{{$otherInfo['Wins']}}</span><br/>CAREER<br/>WINS</div>
                <div class="p-2"><span>{{$otherInfo['Losses']}}</span><br/>CAREER<br/>LOSSES</div>
                <div class="p-2"><span>{{$otherInfo['CareerPO']}}</span><br/>CAREER<br/>PLAYOFFS</div>
                <div class="p-2"><span>{{$otherInfo['CareerTitles']}}</span><br/>CAREER<br/>TITLES</div>
            </div>
          </div>
        </div>
      </div>
