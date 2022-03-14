@extends('layout')

@section('title')
{{$team->Franchise}} - {{ config('app.name') }}
@endsection

@section('description')
Toda la información sobre {{$team->Franchise}} en la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="/js/sortable/sortable.js"></script>
<script src="/js/teamRoster.js"></script>
<script src="https://unpkg.com/sticky-table-headers"></script>
<script>

  function changeTeam(){
      @if ($team->TeamID < 32)
      window.location.href = "{{ url('teamroster', [ 'id' => $team->affiliate()->TeamID ]) }}";
      @else
      window.location.href = "{{ url('teamroster', [ 'id' => $team->parentTeam()->TeamID ]) }}";
      @endif
    }

  function changeTable(value){
    
    if(value == 2)
      showRatings();
    else
      showBio()
  }

  @include('js/changeURL')

</script>

@endsection

@section('section')

<section>
@include('html.team_top')
<h2 id="h2Staff">Team Roster</h2>
<div class="container">
  <div class="row">
    <div class="col">
      <select onchange="changeTeam();" class="form-select" aria-label="Team Options">
        <option selected disabled hidden>Team Options</option>
        @if ($team->TeamID < 32)
        <option>View {{$team->affiliate()->TeamName}} Roster (G-LG Affiliate)</option>
        @else
        <option>View {{$team->parentTeam()->TeamName}} Roster (Parent Team)</option>
        @endif
      </select>
    </div>
    <div class="col">
      <select onchange="changeTable(this.value)" class="form-select" aria-label="Ratings Bio Select">
        <option selected value="2">View Ratings</option>
        <option value="1">View Bio</option>
      </select>
    </div>
  </div>
</div>

<div class="table-responsive normal">

  <table class="table sortable" id="teamRatings">
    <thead class="thead">
      <tr>
        <th scope="col">NUM</th>
        <th scope="col">POS</th>
        <th scope="col">PLAYER</th>
        <th scope="col">FGI</th>
        <th scope="col">FGJ</th>
        <th scope="col">FT</th>
        <th scope="col">SCR</th>
        <th scope="col">PAS</th>
        <th scope="col">HDL</th>
        <th scope="col">ORB</th>
        <th scope="col">DREB</th>
        <th scope="col">DEF</th>
        <th scope="col">BLK</th>
        <th scope="col">STL</th>
        <th scope="col">DRFL</th>
        <th scope="col">DI</th>
        <th scope="col">IQ</th>
        <th scope="col">EN</th>
        <th scole="col">TYPE</th>
        <th scope="col">OVERALL</th>
        <th scope="col">POTENTIAL</th>
      </tr>
    </thead>
    <tbody>
      @foreach($players as $player)
      <tr>
        <th scope="row">{{$player->JerseyNum}}</th>
        <td data-sort="{{$player->Position}}">{{$player->AbPosition}}</td>
        <th scope="row"><a href="{{$player->URLPlayer}}" >{{$player->Full_Name}}</a></th>
        <td>{{$player->InsideRating}}</td>
        <td>{{$player->OutsideRating}}</td>
        <td>{{$player->FT}}</td>
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
        <td>{{$player->Endurance}}</td>
        <td data-sort="{{count($player->PlayerTypeIcons)}}">{!!implode("", $player->PlayerTypeIcons)!!}</td>
        <td data-sort="{{$player->currentRating()[0] + $player->currentRating()[1]*0.5}}">
          @for($i = 0; $i < $player->currentRating()[0]; $i++)
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-star-fill" viewBox="0 0 16 16">
                  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
              </svg>
          @endfor
          @for($i = 0; $i < $player->currentRating()[1]; $i++)
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-star-half" viewBox="0 0 16 16">
                  <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
              </svg>
          @endfor
        </td>
        <td data-sort="{{$player->potentialRating()[0] + $player->potentialRating()[1]*0.5}}">
          @for($i = 0; $i < $player->potentialRating()[0]; $i++)
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-star-fill" viewBox="0 0 16 16">
                  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
              </svg>
          @endfor
          @for($i = 0; $i < $player->potentialRating()[1]; $i++)
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-star-half" viewBox="0 0 16 16">
                  <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
              </svg>
          @endfor
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <table class="table sortable" id="teamBio">
      <thead class="thead">
        <tr>
          <th scope="col">NUM</th>
          <th scope="col">POS</th>
          <th scope="col">PLAYER</th>
          <th scope="col">HT</th>
          <th scope="col">WT</th>
          <th scope="col">AGE</th>
          <th scope="col">EXP</th>
          <th scope="col">FROM</th>
          <th scope="col">COLLEGE</th>
          <th scope="col">SALARY</th>
          <th scope="col">FAYR</th>
          <th scope="col">MOOD</th>
          <th scope="col">OVERALL</th>
          <th scope="col">POTENTIAL</th>
          <th scope="col">TYPE</th>
        </tr>
      </thead>
      <tbody>
      @foreach($players as $player)
        <tr>
          <th scope="row">{{$player->JerseyNum}}</th>
          <td data-sort="{{$player->Position}}">{{$player->AbPosition}}</td>
          <th scope="row"><a href="{{$player->URLPlayer}}" >{{$player->Full_Name}}</a></th>
          <td data-sort="{{$player->CM}}">{{$player->Height}}</td>
          <td>{{$player->Weight}} lbs</td>
          <td>{{$player->Age}}</td>
          <td>{{$player->ProExperience}}</td>
          <td data-sort="{{$player->Country}}">
              <img width="16px" src="{{$player->CountryFlag}}" /></td>
          <td>{{$player->College}}</td>
          <td data-sort="{{$player->ContractYear1}}"> {{"$" . number_format($player->ContractYear1, "0", ",", ".")}}</td>
          @if ($player->Expiring)
          <td data-sort="1"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-currency-dollar" viewBox="0 0 16 16">
              <path d="M4 10.781c.148 1.667 1.513 2.85 3.591 3.003V15h1.043v-1.216c2.27-.179 3.678-1.438 3.678-3.3 0-1.59-.947-2.51-2.956-3.028l-.722-.187V3.467c1.122.11 1.879.714 2.07 1.616h1.47c-.166-1.6-1.54-2.748-3.54-2.875V1H7.591v1.233c-1.939.23-3.27 1.472-3.27 3.156 0 1.454.966 2.483 2.661 2.917l.61.162v4.031c-1.149-.17-1.94-.8-2.131-1.718H4zm3.391-3.836c-1.043-.263-1.6-.825-1.6-1.616 0-.944.704-1.641 1.8-1.828v3.495l-.2-.05zm1.591 1.872c1.287.323 1.852.859 1.852 1.769 0 1.097-.826 1.828-2.2 1.939V8.73l.348.086z"/>
            </svg>
          </td>
          @else
          <td data-sort="0"></td>
          @endif
          @switch($player->Mood)
              @case(1)
              <td data-sort="1">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-emoji-frown-fill" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm-2.715 5.933a.5.5 0 0 1-.183-.683A4.498 4.498 0 0 1 8 9.5a4.5 4.5 0 0 1 3.898 2.25.5.5 0 0 1-.866.5A3.498 3.498 0 0 0 8 10.5a3.498 3.498 0 0 0-3.032 1.75.5.5 0 0 1-.683.183zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z"/>
                  </svg>    
              </td>     
                  @break
              @case(2)
              <td data-sort="2">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-emoji-neutral-fill" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm-3 4a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 0 1h-7a.5.5 0 0 1-.5-.5zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z"/>
                  </svg>    
              </td>    
                  @break
              @default
              <td data-sort="3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-emoji-smile-fill" viewBox="0 0 16 16">
                      <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zM4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM10 8c-.552 0-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5S10.552 8 10 8z"/>
                  </svg>    
              </td>      
          @endswitch
          <td data-sort="{{$player->currentRating()[0] + $player->currentRating()[1]*0.5}}">
          @for($i = 0; $i < $player->currentRating()[0]; $i++)
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-star-fill" viewBox="0 0 16 16">
                  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
              </svg>
          @endfor
          @for($i = 0; $i < $player->currentRating()[1]; $i++)
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-star-half" viewBox="0 0 16 16">
                  <path d="M5.354 5.119 7.538.792A.516.516 0 0 1 8 .5c.183 0 .366.097.465.292l2.184 4.327 4.898.696A.537.537 0 0 1 16 6.32a.548.548 0 0 1-.17.445l-3.523 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256a.52.52 0 0 1-.146.05c-.342.06-.668-.254-.6-.642l.83-4.73L.173 6.765a.55.55 0 0 1-.172-.403.58.58 0 0 1 .085-.302.513.513 0 0 1 .37-.245l4.898-.696zM8 12.027a.5.5 0 0 1 .232.056l3.686 1.894-.694-3.957a.565.565 0 0 1 .162-.505l2.907-2.77-4.052-.576a.525.525 0 0 1-.393-.288L8.001 2.223 8 2.226v9.8z"/>
              </svg>
          @endfor
            </td>
            <td data-sort="{{$player->potentialRating()[0] + $player->potentialRating()[1]*0.5}}">
          @for($i = 0; $i < $player->potentialRating()[0]; $i++)
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-star-fill" viewBox="0 0 16 16">
                  <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
              </svg>
          @endfor
          @for($i = 0; $i < $player->potentialRating()[1]; $i++)
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