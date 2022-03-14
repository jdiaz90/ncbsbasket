@extends('layout')

@section('title')
Draft Picks - {{ config('app.name') }} 
@endsection

@section('description')
Premios semanales y mensuales de la liga {{ config('app.name') }}.
@endsection

@section('section')

<section class="normal"> 

<div class="table-responsive">
  <h1>Draft Picks</h1>
  <table class="table">
    <thead>
      <tr>
        <th scope="col">TEAM</th>
        <th scope="col">2023 1ST RND</th>
        <th scope="col">2023 2ND RND</th>
        <th scope="col">2024 1ST RND</th>
        <th scope="col">2024 2ND RND</th>
        <th scope="col">2025 1ST RND</th>
        <th scope="col">2025 2ND RND</th>
      </tr>
    </thead>
    <tbody>
    @foreach ($teams as $team)
      <tr>
        <th scope="row"><img class="teamDraftLogo" src="{{$team->ImgLogo}}" width="16">
          <a href="{{url('team', [ 'id' => $team->TeamID ])}}">{{$team->Franchise}}</a></th>
        @foreach ($team->getDraftPicks() as $year)
          @foreach ($year as $round)
          <td>
            {{implode(" | ", $round)}}
          </td> 
          @endforeach
        @endforeach
      </tr> 
    @endforeach
    </tbody>
  </table>
</div>

</section>

@endsection