@extends('layout')

@section('title')
Top Rookies - {{ config('app.name') }} 
@endsection

@section('description')
Top Rookies de {{ config('app.name') }}.
@endsection

@section('section')

<section class="normal"> 
  <h1>Top Rookies</h1>
<div class="table-responsive">
<table class="table">
  <thead class="thead">
        <tr>
          <th scope="col">Player Name</th>
          <th scope="col">Rank</th>
          <th scope="col">Position</th>
          <th scope="col">Player Match</th>
        </tr>
      </thead>
      <tbody>
      @php
        $count = 0;
      @endphp
    @foreach($toprookies as $pick)
        <tr>
          <th scope="row"><a href="{{ url('player' ,
           [ 'id' => $pick->player->UniqueID ]) }}">
            {{$pick->Player->FirstName}} {{$pick->Player->LastName}}</a></th>
          <td>{{$pick->Rank}}</td>
          @switch($pick->Position)
            @case(1)
                <td>PG</td>
                @break
            @case(2)
                <td>SG</td>
                @break
            @case(3)
                <td>SF</td>
                @break
            @case(4)
                <td>PF</td>
                @break
            @case(5)
                <td>C</td>
                @break
          @endswitch
          @if($pick->PlayerMatch == "n/a")
          <td>{{$pick->PlayerMatch}}</td>
          @else
          <td><a href="{{ url('player' ,
           [ 'id' => $comparations[$count] ]) }}">{{$pick->PlayerMatch}}</a></td>
          @endif
        </tr>
        
        @php
          $count++;
        @endphp
        
    @endforeach
      </tbody>
  </table>
</div>

</section>

@endsection