@extends('layout')

@section('title')
Mock Draft - {{ config('app.name') }} 
@endsection

@section('description')
Mock Draft de {{ config('app.name') }}.
@endsection

@section('section')

<section class="normal"> 
  <h1>Mock Draft</h1>
<div class="table-responsive">
  <table class="table">
    <thead class="thead">
          <tr>
            <th scope="col">Player Name</th>
            <th scope="col">Rank</th>
            <th scope="col">Team</th>
          </tr>
        </thead>
        <tbody>
      @foreach($mockDraft as $pick)
          <tr>
            <th scope="row"><a href="{{ url('player' ,
            [ 'id' => $pick->player->UniqueID ]) }}">
              {{$pick->Player->FirstName}} {{$pick->Player->LastName}}</a></th>
            <td>{{$pick->Rank}}</td>
            <td><a href="{{route('team.show',
              $pick->team->TeamID)}}">
              {{$pick->team->CityName}} {{$pick->team->TeamName}}</a></td>
          </tr>
      @endforeach
        </tbody>
    </table>
</div>

</section>

@endsection