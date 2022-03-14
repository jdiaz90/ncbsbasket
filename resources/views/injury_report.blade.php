@extends('layout')

@section('title')
Injury Report - {{ config('app.name') }} 
@endsection

@section('description')
Parte de lesiones de la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
@endsection

@section('section')

<section class="normal"> 
<h1>Injury Reports</h1>
  <table class="table">
    <thead class="thead">
      <tr>
        <th scope="col">NAME</th>
        <th scope="col">DATE</th>
        <th scope="col">INJURY</th>
        <th scope="col">TIMELINE</th>
      </tr>
    </thead>
    @foreach ($teams as $teamName => $team)
        <thead>
            <tr>
              @switch($team->TeamID)
                  @case(4)
              <th colspan="4" class="media Team Philadelphia ers"><img class="injuryLogo" src="{{$team->ImgLogo}}" width="16">{{$team->Franchise}}</th>         
                      @break
                  @case(27)
              <th  colspan="4" class="media Team Angeles Clippers"><img class="injuryLogo" src="{{$team->ImgLogo}}" width="16">{{$team->Franchise}}</th>             
                      @break
                  @case(28)
              <th  colspan="4" class="media Team Angeles Lakers"><img class="injuryLogo" src="{{$team->ImgLogo}}" width="16">{{$team->Franchise}}</th>          
                      @break
                  @default
              <th  colspan="4" class="media Team {{$team->Franchise}}"><img class="injuryLogo" src="{{$team->ImgLogo}}" width="16">{{$team->Franchise}}</th>          
              @endswitch
            </tr>
        </thead>
    <tbody>
      @if (gettype($team->Injuries) <> "string")
        @foreach ($team->Injuries as $injury)
      <tr>
        <th scope="row"><a href="{{url('player', [ 'id' => $injury['PlayerID'] ])}}">{{$injury['PlayerName']}}</a></th>
        <td>{{$injury['Date']}}</td>
        <td>{{$injury['Injury']}}</td>
        <td>{{$injury['Timeline']}}</td>
      </tr>   
        @endforeach
      @else
      <tr>
        <td colspan="4">NONE</td>
      </tr>    
      @endif

    </tbody>
    @endforeach
  </table>

  <script>

    $('table.table').stickyTableHeaders();

</script>

</section>

@endsection