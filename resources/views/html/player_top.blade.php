@section('title')
{{$player->Full_Name}} ({{$player->franchise}}) - 
{{ config('app.name') }}
@endsection

@section('description')
Toda la información sobre {{$player->Full_Name}},
jugador de {{$player->franchise}} 
en la liga {{ config('app.name') }}.
@endsection

@section('css')

<style type="text/css">
.mr-2 .row .col-md button{
    background: {{$teamColor}};
}

</style>

@endsection

@section('javascript')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://unpkg.com/sticky-table-headers"></script>
<script src="/js/playerStats.js"></script>
<script>

    function changeURL(value){
        switch (value) {
                case 1:
                    window.location.href = "{{ url('player', [ 'id' => $player->PlayerID ]) }}";
                    break;
                case 2:
                    window.location.href = "{{ url('playerprofile', [ 'id' => $player->PlayerID ]) }}";
                    break;
                case 3:
                    window.location.href = "{{ url('playerstats', [ 'id' => $player->PlayerID ]) }}";
                    break;
                case 4:
                    window.location.href = "{{ url('playerlog', [ 'id' => $player->PlayerID ]) }}";
                    break;
                case 5:
                    
                    break;
                case 6:
                    
                    break;
        }
    }
    
</script>
@endsection

@section('section')

<section id="playerSection">

    <div class="container top">

        <div class="row align-items-center">

          <div class="col">

            <img src="{{$player->PlayerPhoto}}"
            onerror="this.onerror=null; this.src='/images/players/default.png';">

          </div>

          <div class="col">

            <div class="name">
                <h1>{{$player->FirstName}} {{$player->LastName}}</h1>
    
                <h2>
                    @if($player->franchise != "Free Agent")
                    <a href="{{$player->URLTeam}}"><img width="32px" 
                    src="{{$player->team->ImgLogo}}"></a>
                    @endif
                    {{$player->franchise}}</a> -
    
                    @if($player->JerseyNum <> 0 && $player->TeamID > 0)
                    #{{$player->JerseyNum}} -
                    @endif
                    {{$player->Pos}}
                    <img width="16px" src="{{$player->CountryFlag}}">
                </h2>
                @if ($player->Injury)
                <div class="alert alert-danger" role="alert">{{$player->Injury}}</div>
                @endif
            </div>

          </div>

          <div class="col">
            
            <div class="d-flex flex-column miscellany">
                <div class="p-2"><b>HEIGHT/WEIGHT</b></div>
                <div class="p-2">{{$player->height}} / {{$player->Weight}} LBS</div>
                <div class="p-2"><b>AGE</b></div>
                <div class="p-2">{{$player->Age}} YEARS OLD</div>
                <div class="p-2"><b>FROM</b></div>
                <div class="p-2">{{strtoupper($player->College)}}</div>
                <div class="p-2"><b>DRAFT</b></div>
                <div class="p-2">{{$player->Draft}}</div>
                <div class="p-2"><b>EXPERIENCE</b></div>
                <div class="p-2">{{$player->Experience("YEAR", true)}}</div>
            </div>

          </div>
          
          <div class="col">
            
            <div class="d-flex flex-column rating">
                <div class="p-2"><b>CURRENT RATING</b></div>
                    <div class="p-2">
                        @for($i = 0; $i < $player->currentRating()[0]; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        @endfor
                        @for($i = 0; $i < $player->currentRating()[1]; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                        <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                        </svg>
                        @endfor
                    </div>
                    <div class="p-2"><b>POTENTIAL RATING</b></div>
                        <div class="p-2">
                        @for($i = 0; $i < $player->potentialRating()[0]; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
                        </svg>
                        @endfor
                        @for($i = 0; $i < $player->potentialRating()[1]; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-half" viewBox="0 0 16 16">
                        <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
                        </svg>
                        @endfor
                    </div>
                </div>
            </div>


          <div class="col">

            <div class="d-flex flex-row stats">
                <div class="p-2"><span>{{$player->PPG}}</span><br/>POINTS<br/>PER GAME</div>
                <div class="p-2"><span>{{$player->APG}}</span><br/>ASSISTS<br/>PER GAME</div>
                <div class="p-2"><span>{{$player->RPG}}</span><br/>REBOUNDS<br/>PER GAME</div>
                <div class="p-2"><span>{{$player->BPG}}</span><br/>BLOCKS<br/>PER GAME</div>
                <div class="p-2"><span>{{$player->SPG}}</span><br/>STEALS<br/>PER GAME</div>
            </div>

          </div>

        </div>

      </div>
