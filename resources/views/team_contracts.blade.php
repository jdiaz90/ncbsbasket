@extends('layout')

@section('title')
{{$team->Franchise}} - {{ config('app.name') }}
@endsection

@section('description')
Toda la información sobre {{$team->Franchise}} en la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
<script>

  @include('js/changeURL')

</script>   
@endsection

@section('section')

<section>

@include('html.team_top')
<h2 id="h2Staff">Team Contracts</h2>
<div class="table-responsive normal">

  <table class="table" id="teamContracts">
    <thead class="thead">
      <tr>
        <th scope="col">POS</th>
        <th scope="col">PLAYER</th>
        <th scope="col">FA YEAR</th>
        <th scope="col">{{$team->CurrentSeason}}</th>
        <th scope="col">{{$team->CurrentSeason + 1}}</th>
        <th scope="col">{{$team->CurrentSeason + 2}}</th>
        <th scope="col">{{$team->CurrentSeason + 3}}</th>
        <th scope="col">{{$team->CurrentSeason + 4}}</th>
        <th scope="col">TOTAL VALUE</th>
        <th scope="col">BIRD YRS</th>
      </tr>
    </thead>
    <tbody>
  @foreach ($players as $player)
      <tr>
        <td>{{$player->AbPosition}}</td>
        <th scope="row"><a href="{{$player->URLPlayer}}">{{$player->Full_Name}}</a></th>
        <td>{{$player->FAYear}}</td>
        <td>
    @if($player->ContractYear1 > 0)
      {{"$" . number_format($player->ContractYear1, "0", ",", ".")}}
    @else
      -      
    @endif
    @if ($player->ContractYear1 > 0 && $player->ContractYear2 == 0 && $player->ContractType <> "")
      <b>({{$player->ContractType}})</b>
    @endif</td>
        <td>
    @if($player->ContractYear2 > 0)
      {{"$" . number_format($player->ContractYear2, "0", ",", ".")}}
    @else
      -      
    @endif
    @if ($player->ContractYear2 > 0 && $player->ContractYear3 == 0 && $player->ContractType <> "")
    <b>({{$player->ContractType}})</b>
    @endif</td>
        <td>
      @if($player->ContractYear3 > 0)
        {{"$" . number_format($player->ContractYear3, "0", ",", ".")}}
      @else
        -      
      @endif
    @if ($player->ContractYear3 > 0 && $player->ContractYear4 == 0 && $player->ContractType <> "")
      <b>({{$player->ContractType}})</b>
    @endif</td>
        <td>
        @if($player->ContractYear4 > 0)
          {{"$" . number_format($player->ContractYear4, "0", ",", ".")}}
        @else
          -      
        @endif
    @if ($player->ContractYear4 > 0 && $player->ContractYear5 == 0 && $player->ContractType <> "")
      <b>({{$player->ContractType}})</b>
    @endif</td>
        <td>
    @if($player->ContractYear5 > 0)
      {{"$" . number_format($player->ContractYear5, "0", ",", ".")}}
    @else
      -
    @endif
    @if ($player->ContractYear5 > 0 && $player->ContractYear6 == 0 && $player->ContractType <> "")
      <b>({{$player->ContractType}})</b>
    @endif</td>
        <td>${{number_format($player->TotalValue, "0", ",", ".")}}</td>
        <td>{{$player->BirdYears}}</td>
      </tr>
  @endforeach
      <tr id="cut">
        <td></td>
        <td>CUT SALARY:</td>
        <td></td>
  @foreach ($team->CutSalary as $cut)
        <td>{{$cut}}</td>
  @endforeach
        <td></td>
        <td></td>
      </tr>
      <tr id="total">
        <td></td>
        <td>TOTAL SALARY:</td>
        <td></td>
  @foreach ($team->TotalSalary as $total)
        <td>{{$total}}</td>
  @endforeach
        <td></td>
        <td></td>
      </tr>
    </tbody>
  </table>
  <div class="card contractsKey">
    <div class="card-body">
      <h5>Contracts Key</h2>
      <b>PO - </b>Player Option - Player can choose to forgot final
    year of contract For free agency<br />
    <b>TO - </b>Team Option - Team can decide to keep player For
    final year of contract or Let go to Free Agency<br />
    <b>ETO - </b>Early Termination Option - Player
    can terminate contract early<br />
    <b>RFA - </b>Restricted Free Agent - Controlling team will have
    opportunity to match final offer<br />
    <b>QO - </b>Qualified Offer - Player is eligible For a
    qualifying offer to make him a RFA<br />
    <b>UFA - </b>Unrestricted Free Agent - Player is free to
    sign With any team of his choosing<br />
    <b>RO - </b>Rookie Option - 1st round draft picks have
    options you can pick up for years 3 And 4<br />
  </div>
</div>

<script>

  $('table.table').stickyTableHeaders();

</script>

</section>

@endsection
