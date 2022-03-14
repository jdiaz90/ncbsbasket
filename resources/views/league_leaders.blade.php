@extends('layout')

@section('title')
League Leaders - {{ config('app.name') }}
@endsection

@section('description')
Líderes de {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="/js/leagueLeaders.js"></script>
@endsection

@section('section')
<section class="normal">
  <h1>League Leaders</h1>
  <div class="topLeaders">

    <form id="form" role="form" method="POST">
      @csrf

    <div class="container">
      <div class="row align-items-center">

        <div class="col-lg">
          <select onchange="changeLeague(this.value)" name="league" class="form-select Stat" aria-label="Default select league">
            <option value="P" {{$selectedLeague[0]}}>Pro Basketball League</option>
            <option value="D" {{$selectedLeague[1]}}>Developmental Basketball League</option>
          </select>
        </div>

        <div class="col-lg">
          <select onchange="this.form.submit();" name="record" id="record" class="form-select Stat" aria-label="Default select league leaders">
            {!! $select !!}
          </select>
        </div>

        <div class="col-lg">
          <select onchange="this.form.submit();"name="position" id="position" class="form-select Stat" aria-label="Default select players">
            <option {{$selectedPosition[0]}}>All positions</option>
            <option {{$selectedPosition[1]}}>Guards</option>
            <option {{$selectedPosition[2]}}>Forwards</option>
            <option {{$selectedPosition[3]}}>Centers</option>
          </select>
        </div>

        <div class="col-lg leagueLeaders">
          <div class="container">
            
            <div class="row">
              <div class="col-sm">
                <label class="switch">
                  <input onchange="moveButtons(); this.form.submit();" type="checkbox" name="avg" id="avg" {{$toggles[0]}}>
                  <span class="slider round"></span>
                </label>Per Game Stats
              </div>

              <div class="col-sm">
                <label class="switch">
                  <input onchange="moveButtons3(); this.form.submit();" type="checkbox" name="rs" id="rs" {{$toggles[2]}}>
                  <span class="slider round"></span>
                </label>Regular Season  
              </div>
            </div>

            <div class="row">
              <div class="col-sm">
                <label class="switch">
                  <input onchange="moveButtons2(); this.form.submit();" type="checkbox" name="sum" id="sum" {{$toggles[1]}}>
                  <span class="slider round"></span>
                </label>Stat Totals
              </div>

              <div class="col-sm">
                <label class="switch">
                  <input onchange="moveButtons4(); this.form.submit();" type="checkbox" name="po" id="po" {{$toggles[3]}}>
                  <span class="slider round"></span>
                </label>Playoffs  
              </div>
            </div>

          </div>

        </div>

      </div>

    </div>

    </form>
  </div>

  <div class="leaderCards">
    @foreach ($leaderCards as $leader)     
    <div class="card mb-3">
      <div class="row g-0">
        <div class="col-md-4">
          <img class="img-fluid rounded-start" src="{{$leader->PlayerPhoto}}"
          onerror="this.onerror=null; this.src='/images/players/default.png';">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            <h5 class="card-title">{{$leader->Full_Name}}</h5>
            <h6 class="card-subtitle mb-2 text-muted">
              #{{$leader->JerseyNum}} - {{strtoupper($leader->Pos)}}<br/>
              <img src="{{$leader->team->ImgLogo}}" width="24" />{{$leader->team->Franchise}}
            </h6>
            <p class="card-text">{{round($leader->Stat, 1)}} {{strtoupper($leader->Title)}}</p>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>

  <div class="leaderStats">
    <table class="table">
      <thead class="thead">
        <tr>
          <th scope="col">Rank</th>
          <th scope="col">Name</th>
          <th scope="col">STAT</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($leaderStats as $stat)
          @switch($position)
            @case("Guards")
              @if ($stat->player->Position <= 2)
        <tr>
          <th scope="row">{{$c++}}.</th>
          <th scope="row"><a href="{{ url('player', [ 'id' => $stat->player->PlayerID ]) }}">
            {{$stat->player->Full_Name}} ({{$stat->player->AbPosition}}, {{$stat->player->Team}})</a></th>
          <td>{{round($stat->Stat, 1)}}</td>
        </tr>
              @endif
                @break
            @case("Forwards")
            @if ($stat->player->Position == 3 || $stat->player->Position == 4)
        <tr>
          <th scope="row">{{$c++}}.</th>
          <th scope="row"><a href="{{ url('player', [ 'id' => $stat->player->PlayerID ]) }}">
            {{$stat->player->Full_Name}} ({{$stat->player->AbPosition}}, {{$stat->player->Team}})</a></th>
          <td>{{round($stat->Stat, 1)}}</td>
        </tr>
            @endif
              @break
            @case("Centers")
            @if ($stat->player->Position == 5)
        <tr>
          <th scope="row">{{$c++}}.</th>
          <th scope="row"><a href="{{ url('player', [ 'id' => $stat->player->PlayerID ]) }}">
            {{$stat->player->Full_Name}} ({{$stat->player->AbPosition}}, {{$stat->player->Team}})</a></th>
          <td>{{round($stat->Stat, 1)}}</td>
        </tr>
            @endif
              @break
            @default
        <tr>
          <th scope="row">{{$c++}}.</th>
          <th scope="row"><a href="{{ url('player', [ 'id' => $stat->player->PlayerID ]) }}">
            {{$stat->player->Full_Name}} ({{$stat->player->AbPosition}}, {{$stat->player->Team}})</a></th>
          <td>{{round($stat->Stat, 1)}}</td>
        </tr>
          @endswitch
        @endforeach
      </tbody>
    </table>
  </div>

</section>

@endsection