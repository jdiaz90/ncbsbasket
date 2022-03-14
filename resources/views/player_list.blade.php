@extends('layout')

@section('title')
Player List - {{ config('app.name') }}
@endsection

@section('description')
Todos los jugadores de la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
<script src="/js/sortable/sortable.js"></script>
@endsection

@section('section')

<section class="normal">
  <h1>Player List</h1>
    <form role="form" method="POST">
        @csrf
    <div class="container">
        <div class="row align-items-center">

          <div class="col-md playerList">
            <select onchange="this.form.submit();" name="league" class="form-select Stat" aria-label="Default select league">
                <option value="F" {{$selectedLeague[2]}}>Free Agents Only</option>
                <option value="P" {{$selectedLeague[0]}}>Pro Basketball League</option>
                <option value="D" {{$selectedLeague[1]}}>Developmental Basketball League</option>
              </select>
          </div>

          <div class="col-md">
            <table>
              <tr>
                <td class="marginPlayerList">PG</td>
                <td>
                  <label class="switch">
                    <input onchange="this.form.submit();" type="checkbox" name="position[]" value="1" {{$selectedButtons[1]}}><span class="slider round"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md">
            <table>
              <tr>
                <td class="marginPlayerList">SG</td>
                <td>
                  <label class="switch">
                    <input onchange="this.form.submit();" type="checkbox" name="position[]" value="2" {{$selectedButtons[2]}}><span class="slider round"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md">
            <table>
              <tr>
                <td class="marginPlayerList">SF</td>
                <td>
                  <label class="switch">
                    <input onchange="this.form.submit();" type="checkbox" name="position[]" value="3" {{$selectedButtons[3]}}><span class="slider round"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md">
            <table>
              <tr>
                <td class="marginPlayerList">PF</td>
                <td>
                  <label class="switch">
                    <input onchange="this.form.submit();" type="checkbox" name="position[]" value="4" {{$selectedButtons[4]}}><span class="slider round"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>

          <div class="col-md">
            <table>
              <tr>
                <td class="marginPlayerList">C</td>
                <td>
                  <label class="switch">
                    <input onchange="this.form.submit();" type="checkbox" name="position[]" value="5" {{$selectedButtons[5]}}><span class="slider round"></span>
                  </label>
                </td>
              </tr>
            </table>
          </div>

        </div>

      </div>

    </form>

<div class="table-responsive">
  <table class="table sortable">
    <thead class="thead">
        <tr>
        <th scope="col">POS</th>
        <th scope="col">PLAYER</th>
        <th scope="col">TEAM</th>
        <th scope="col">AGE</th>
        <th scope="col">EXP</th>
        <th scope="col">HT</th>
        <th scope="col">WT</th>
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
        <th scope="col">FAYR</th>
        <th scope="col">TYPE</th>
        <th scope="col">OVR</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($players as $player)
        @switch($player->Position)
        @case(1)
        <tr class="PGPlayer"> 
        @break
        @case(2)
        <tr class="SGPlayer">  
        @break
        @case(3)
        <tr class="SFPlayer">  
        @break
        @case(4)
        <tr class="PFPlayer"> 
        @break
        @case(5)
        <tr class="CPlayer"> 
        @break          
    @endswitch
            <th data-sort="{{$player->Position}}" scope="row">{{$player->AbPosition}}</th>
            <td><b><a href="{{ url('player', [ 'id' => $player->PlayerID ]) }}">{{$player->Full_Name}}</a></b></td>
            @if ($player->TeamID > 0)
            <td><a href="{{ url('team', [ 'id' => $player->team->TeamID ]) }}">{{$player->team->TeamName}}</td>
            @else
            <td>Free Agent</td>
            @endif
            <td>{{$player->Age}}</td>
            <td>{{$player->ProExperience}}</td>
            <td>{{$player->Height}}</td>
            <td>{{$player->Weight}}</td>
            <td>{{$player->InsideRating}}</td>
            <td>{{$player->OutsideRating}}</td>
            <td>{{$player->Scoring}}</td>
            <td>{{$player->Passing}}</td>
            <td>{{$player->Handling}}</td>
            <td>{{$player->OReb}}</td>
            <td>{{$player->DReb}}</td>
            <td>{{$player->Defender}}</td>
            <td>{{$player->Block}}</td>
            <td>{{$player->Steal}}</td>
            <td>{{$player->DrawingFouls}}</td>
            <td>{{$player->Discipline}}</td>
            <td>{{$player->BballIQ}}</td>
            @if ($player->Expiring)
            <td data-sort="1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-currency-dollar" viewBox="0 0 16 16">
                <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
              </svg>
            </td>
            @else
            <td data-sort="0"></td>
            @endif
            <td data-sort="{{count($player->PlayerTypeIcons)}}">{!!implode("", $player->PlayerTypeIcons)!!}</td>
            <td data-sort="{{$player->CurrentRating()[0] + $player->CurrentRating()[1] * 0.5}}">
                @for($i = 0; $i < $player->CurrentRating()[0]; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-star-fill" viewBox="0 0 16 16">
    <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
    </svg>
                @endfor
                @for($i = 0; $i < $player->CurrentRating()[1]; $i++)
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-star-half" viewBox="0 0 16 16">
    <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
    </svg>
                @endfor
            </td>
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
