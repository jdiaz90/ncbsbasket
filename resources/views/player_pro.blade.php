@php
use \App\Http\Controllers\PlayerController;
@endphp

@extends('layout')

@include('html.player_top')

<div class="container mr-2" role="group" aria-label="Player Options">
    <div class="row">
      <div class="col-md">
        <button type="button" onclick="changeURL(1);" class="btn btn-secondary">Player Bio</button>
      </div>
      <div class="col-md">
        <button type="button" class="btn btn-secondary active disabled">Player Profile</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(3);" class="btn btn-secondary">Player Stats</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(4);" class="btn btn-secondary">Game Logs</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(5);" class="btn btn-secondary">Staff Report</button>
      </div>
      <div class="col-md">
        <button type="button" onclick="changeURL(6);" class="btn btn-secondary">Ratings Progression</button>
      </div>
    </div>
</div>

<div class="container">
  <div class="row">
    <div class="col-lg">
      <h2>Personality</h2>
        <hr/>
        <div class="d-flex flex-column">
            <div class="p-2 per">
            {!! progress($player->AttitudeC, $player->AttitudeC . "%") !!}
            <b>Coach Relationship</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->AttitudeT, $player->AttitudeT . "%") !!}
            <b>Team Relationship</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->AttitudeO, $player->AttitudeO . "%") !!}
            <b>Organization Relationship</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->Loyalty, $player->Loyalty . "%") !!}
            <b>Loyalty</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->Motivation, $player->Motivation . "%") !!}
            <b>Motivation</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->Consistency, $player->Consistency . "%") !!}
            <b>Consistency</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->Greed, $player->Greed . "%") !!}
            <b>Greed</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->PlayForWinner, $player->PlayForWinner . "%") !!}
            <b>Play For Winner</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->Durability, $player->Durability . "%") !!}
            <b>Durability</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->WorkEthic, $player->WorkEthic . "%") !!}
            <b>Work Ethic</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->Personality, $player->Personality . "%") !!}
            <b>Personality</b>
            </div>
            <div class="p-2 per">
            {!! progress($player->PlayingTime, $player->PlayingTime . "%") !!}
            <b>Playing Time</b>
            </div>
        </div>
    </div>
    @if(sizeof($player->Transactions) > 0)
    <div class="col-lg">
        <h2>Transaction History</h2>
        <hr/>
        <table class="table">
          <tbody>
            @foreach ($player->Transactions as $move)
            <tr>
              <td>{{$move->Transaction}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
    </div>
    @endif
    <div class="col-lg">
      <h2>Awards Won</h2>
      <hr/>
      <table class="table">
        <tbody>
          @foreach ($player->Awards as $award)
          <tr>
            <td>{{$award->Season}} - {{$award->AwardName}}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>

</section>

@endsection