@extends('layout')

@section('title')
{{$team->Franchise}} - {{ config('app.name') }}
@endsection

@section('description')
Toda la información sobre {{$team->Franchise}} en la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
<script src="/js/sortable/sortable.js"></script>

<script>

  @include('js/changeURL')


  @include('js/changeURL2')

</script>   
@endsection

@section('section')

<section>

@include('html.team_top')

<div class="container teamHistory">
  <div class="row">
    <div class="col-md">
      <button type="button" onclick="changeURL2(1);" class="btn btn-secondary teamHistoryButton">Player Records</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(2);" class="btn btn-secondary teamHistoryButton">Coach Records</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(3);" class="btn btn-secondary teamHistoryButton disabled">Player History</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(4);" class="btn btn-secondary teamHistoryButton">Season Recaps</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(5);" class="btn btn-secondary teamHistoryButton">Draft History</button>
    </div>
    <div class="col-md">
      <button type="button" onclick="changeURL2(6);" class="btn btn-secondary teamHistoryButton">Transaction History</button>
    </div>
  </div>
</div>
<h2 id="h2Staff">Player History</h2>
<div class="table-responsive normal">
  <table class="table sortable">
    <thead class="thead">
      <tr>
        <th scope="col">SEASON</th>
        <th scope="col">PLAYER</th>
        <th scope="col">G</th>
        <th scope="col">GS</th>
        <th scope="col">MPG</th>
        <th scope="col">FGM-A</th>
        <th scope="col">FG%</th>
        <th scope="col">FTM-A</th>
        <th scope="col">FT%</th>
        <th scope="col">3PM-A</th>
        <th scope="col">3P%</th>
        <th scope="col">PPG</th>
        <th scope="col">APG</th>
        <th scope="col">RPG</th>
        <th scope="col">SPG</th>
        <th scope="col">BPG</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($team->seasonStats as $season)
      <tr>
        <th scope="row">{{$season->SeasonID}}</th>
        <th scope="row"><a href="{{ url('formerplayer', [ 'id' => $season->PlayerID ]) }}">{{$season->PlayerName}}</a></th>
        <td>{{$season->G}}</td>
        <td>{{$season->GS}}</td>
        <td>{{round($season->MPG, 1)}}</td>
        <td data-sort="{{$season->FGM}}">{{$season->FGM}}-{{$season->FGA}}</td>
        @if (empty($season->FGPct))
        <td>0</td>  
        @else
        <td>{{round($season->FGPct * 100,1)}}</td>  
        @endif      
        <td data-sort="{{$season->FTM}}">{{$season->FTM}}-{{$season->FTA}}</td>
        @if (empty($season->FTPct))
        <td>0</td>  
        @else
        <td>{{round($season->FTPct * 100,1)}}</td>  
        @endif    
        <td data-sort="{{$season->FG3PM}}">{{$season->FG3PM}}-{{$season->FG3PA}}</td>
        @if (empty($season->FG3PPct))
        <td>0</td>  
        @else
        <td>{{round($season->FG3PPct * 100,1)}}</td>  
        @endif    
        <td>{{round($season->PPG, 1)}}</td>
        <td>{{round($season->APG, 1)}}</td>
        <td>{{round($season->RPG, 1)}}</td>
        <td>{{round($season->SPG, 1)}}</td>
        <td>{{round($season->BPG, 1)}}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</div>

<script>

  $('table.table').stickyTableHeaders();

</script>

</section>

@endsection
