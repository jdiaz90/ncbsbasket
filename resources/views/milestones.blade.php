@extends('layout')

@section('title')
Milestones - {{ config('app.name') }}
@endsection

@section('description')
Hitos de {{ config('app.name') }}.
@endsection


@section('section')
<section>

  <div class="container milestones">

  <div class="row">

    <div class="col-xl">
      <table class="table milestones">
        <thead>
          <tr>
            <th scope="col">POINTS</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($arrayPlayers['Points'] as $player)
            @if ($player['Stat'] > 9500)
              @if (intval(($max['Points'] / 1000)) * 1000 <> 
                intval(($player['Stat'] / 1000) + 1) * 1000)
                @php
                $max['Points'] = intval(($player['Stat'] / 1000) + 1) * 1000
                @endphp
          <tr class="headMil">
            <th colspan="3" scope="row">{{number_format($max['Points'], 0, ',', '.')}} Points</th>
          </tr> 
              @endif
          <tr>
            <th scope="row"><a href="{{ url('player', [ 'id' => $player['Player'] ]) }}">{{$player['Player']->Full_Name}}</a></th>
            <td>{{number_format($player['Stat'], 0, ',', '.')}} points</td>
            <td>{{number_format($max['Points'] - $player['Stat'], 0, ',', '.')}} to go</td>
          </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="col-xl">
      <table class="table milestones">
        <thead class="thead">
          <tr>
            <th scope="col">ASSISTS</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($arrayPlayers['Assists'] as $player)
            @if ($player['Stat'] > 1500)
              @if (intval(($max['Assists'] / 1000)) * 1000 <> 
                intval(($player['Stat'] / 1000) + 1) * 1000)
                @php
                $max['Assists'] = intval(($player['Stat'] / 1000) + 1) * 1000
                @endphp
          <tr class="headMil">
            <th colspan="3" scope="row">{{number_format($max['Assists'], 0, ',', '.')}} Points</th>
          </tr> 
              @endif
          <tr>
            <th scope="row"><a href="{{ url('player', [ 'id' => $player['Player'] ]) }}">{{$player['Player']->Full_Name}}</a></th>
            <td>{{number_format($player['Stat'], 0, ',', '.')}} Assists</td>
            <td>{{number_format($max['Assists'] - $player['Stat'], 0, ',', '.')}} to go</td>
          </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="col-xl">
      <table class="table milestones">
        <thead class="thead">
          <tr>
            <th scope="col">REBOUNDS</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($arrayPlayers['Rebounds'] as $player)
            @if ($player['Stat'] > 2500)
              @if (intval(($max['Rebounds'] / 1000)) * 1000 <> 
                intval(($player['Stat'] / 1000) + 1) * 1000)
                @php
                $max['Rebounds'] = intval(($player['Stat'] / 1000) + 1) * 1000
                @endphp
          <tr class="headMil">
            <th colspan="3" scope="row">{{$max['Rebounds']}} Rebounds</th>
          </tr> 
              @endif
          <tr>
            <th scope="row"><a href="{{ url('player', [ 'id' => $player['Player'] ]) }}">{{$player['Player']->Full_Name}}</a></th>
            <td>{{number_format($player['Stat'], 0, ',', '.')}} Rebounds</td>
            <td>{{number_format($max['Rebounds'] - $player['Stat'], 0, ',', '.')}} to go</td>
          </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="col-xl">
      <table class="table milestones">
        <thead class="thead">
          <tr>
            <th scope="col">STEALS</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($arrayPlayers['Steals'] as $player)
            @if ($player['Stat'] > 450)
              @if (intval(($max['Steals'] / 100)) * 100 <> 
                intval(($player['Stat'] / 100) + 1) * 100)
                @php
                $max['Steals'] = intval(($player['Stat'] / 100) + 1) * 100
                @endphp
          <tr class="headMil">
            <th colspan="3" scope="row">{{$max['Steals']}} Steals</th>
          </tr> 
              @endif
          <tr>
            <th scope="row"><a href="{{ url('player', [ 'id' => $player['Player'] ]) }}">{{$player['Player']->Full_Name}}</a></th>
            <td>{{number_format($player['Stat'], 0, ',', '.')}} Steals</td>
            <td>{{number_format($max['Steals'] - $player['Stat'], 0, ',', '.')}} to go</td>
          </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>

    <div class="col-xl">
      <table class="table milestones">
        <thead class="thead">
          <tr>
            <th scope="col">BLOCKS</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($arrayPlayers['Blocks'] as $player)
            @if ($player['Stat'] > 450)
              @if (intval(($max['Blocks'] / 100)) * 100 <> 
                intval(($player['Stat'] / 100) + 1) * 100)
                @php
                $max['Blocks'] = intval(($player['Stat'] / 100) + 1) * 100
                @endphp
          <tr class="headMil">
            <th colspan="3" scope="row">{{$max['Blocks']}} Blocks</th>
          </tr> 
              @endif
          <tr>
            <th scope="row"><a href="{{ url('player', [ 'id' => $player['Player'] ]) }}">{{$player['Player']->Full_Name}}</a></th>
            <td>{{number_format($player['Stat'], 0, ',', '.')}} Blocks</td>
            <td>{{number_format($max['Blocks'] - $player['Stat'], 0, ',', '.')}} to go</td>
          </tr>
            @endif
          @endforeach
        </tbody>
      </table>
    </div>

  </div>
</div>

</section>

@endsection