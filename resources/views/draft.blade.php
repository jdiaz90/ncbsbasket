@extends('layout')

@php

  if(isset($season['Year']))
    $year = $season['Year'];
  else
    $year = $seasons[0]->Season;

@endphp

@section('title')
{{$year}} Draft - {{ config('app.name') }} 
@endsection

@section('description')
Draft de la NBA y {{ config('app.name') }} en la temporada {{$year}}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
<script>
  function changeSeason(value){
    window.location.href = "{{route('draft.index')}}" + "/" +value;
  }
</script>
@endsection

@section('section')

<section class="normal"> 
  <h1>{{$year}} Draft</h1>

  <label for="Season">Select season: </label>
  <select name="Season" onchange=
  "changeSeason(this.value)">

@foreach($seasons as $season)
  @if($year == $season->SeasonID)
  <option selected value="{{$season->SeasonID}}">{{$season->SeasonID}}</option>

  @else
  <option value="{{$season->SeasonID}}">{{$season->SeasonID}}</option>
  @endif

@endforeach
</select>

<div class="table-responsive">
  <table class="table">
    <thead class="thead">
      <tr>
        <th scope="col">Player Name</th>
        <th scope="col">Selected By</th>
        <th scope="col">Round</th>
        <th scope="col">Pick</th>
        <th scope="col">Position</th>
        <th scope="col">College</th>
      </tr>
    </thead>
    <tbody>
  @foreach($selections as $selection)
      <tr>
        @if(!empty($selection->PlayerID))
        <th scope="row"><a href="{{ url('formerplayer' ,
           [ 'id' => $selection->PlayerID ]) }}">
           {{$selection->PlayerName}}</a></th>
        @else
        <th scope="row">{{$selection->PlayerName}}</th>
        @endif
        <td>{{$selection->Team}}</td>
        @if($selection->Round <> 0)
        <td>{{$selection->Round}}</td>
        @else
        <td>N/A</td>
        @endif
        @if($selection->Pick <> 0)
        <td>{{$selection->Pick}}</td>
        @else
        <td>N/A</td>
        @endif
        @if(!empty($selection->Position))
        <td>{{$selection->Position}}</td>
        @else
        <td>N/A</td>
        @endif
        @if(strcmp($selection->College, "0"))
        <td>{{$selection->College}}</td>
        @else
        <td>N/A</td>
        @endif
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