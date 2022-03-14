@extends('layout')

@section('title')
Team List - {{ config('app.name') }}
@endsection

@section('description')
Equipos de la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
<script src="/js/sortable/sortable.js"></script>
@endsection


@section('section')

<section class="normal">
<h1>Team List</h1>

<div class="table-responsive">
  <table class="table sortable">
    <thead class="thead">
        <tr>
        <th scope="col">TEAM</th>
        <th scope="col">AGE</th>
        <th scope="col">EXP</th>
        <th scope="col">FGI</th>
        <th scope="col">FGJ</th>
        <th scope="col">SCR</th>
        <th scope="col">PAS</th>
        <th scope="col">HDL</th>
        <th scope="col">ORB</th>
        <th scope="col">DRB</th>
        <th scope="col">DEF</th>
        <th scope="col">BLK</th>
        <th scope="col">STL</th>        
        <th scope="col">DRFL</th>
        <th scope="col">DI</th>
        <th scope="col">IQ</th>
        <th scope="col">EN</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($players as $team)
      <tr>
        <td><img src="{{$team->team->ImgLogo}}" class="teamLogoList"><a href="{{ url('team', [ 'id' => $team->team->TeamID ]) }}">{{$team->team->Franchise}}</a></td>
        <td>{{round($team->Age)}}</td>
        <td>{{round($team->ProExperience)}}</td>
        <td>{{round($team->InsideRating)}}</td>
        <td>{{round($team->OutsideRating)}}</td>
        <td>{{round($team->Scoring)}}</td>
        <td>{{round($team->Passing)}}</td>
        <td>{{round($team->Handling)}}</td>
        <td>{{round($team->OReb)}}</td>
        <td>{{round($team->DReb)}}</td>
        <td>{{round($team->Defender)}}</td>
        <td>{{round($team->Block)}}</td>
        <td>{{round($team->Steal)}}</td>
        <td>{{round($team->DrawingFouls)}}</td>
        <td>{{round($team->Discipline)}}</td>
        <td>{{round($team->BballIQ)}}</td>
        <td>{{round($team->Endurance)}}</td>
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

<script>

  $('table.table.sortable').stickyTableHeaders();

</script>

</section>

@endsection


