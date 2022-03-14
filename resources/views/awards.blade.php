@extends('layout')

@section('title')
{{$season}} Awards - {{ config('app.name') }} 
@endsection

@section('description')
Premios de la temporada en la NBA y {{ config('app.name') }} en la temporada {{$season}}.
@endsection

@section('section')

<section class="normal"> 
  <h1>{{$season}} Awards</h1>
<form role="form" method="POST">
  @csrf
  <select onchange="this.form.submit();" name="league" class="form-select Stat" aria-label="Default select league">
    <option value="P" {{$selectedLeague[0]}}>Pro Basketball League</option>
    <option value="D" {{$selectedLeague[1]}}>Developmental Basketball League</option>
  </select>
  <select class="form-select" name="season" onchange="this.form.submit();">

@foreach($seasons as $option)
  @if($season == $option->Season)
    <option selected value="{{$option->Season}}">{{$option->Season}}</option>
  @else
    <option value="{{$option->Season}}">{{$option->Season}}</option>
  @endif
@endforeach
</select>
</form>

<div class="table-responsive">
  <table class="table">
    <thead>
      <tr>
        <th scope="col">AWARD</th>
        <th scope="col" colspan="5">WINNER</th>
      </tr>
    </thead>
    <tbody>
    @foreach($awards as $award => $winners)
      <tr>
        <th scope="row"><img class="trophyPhoto" width="24" src="{{printAward($award)}}">{{str_replace(["PBL ", "DBL "], "", $award)}}</th>
      @foreach ($winners as $winner)
      @if (str_contains($award, "Valuable Player") || str_contains($award, "Defensive Player") ||
          str_contains($award, "Rookie of the Year") || str_contains($award, "Coach of the Year") ||
          str_contains($award, "Sixth Man of the Year"))
        <td colspan="5">
      @else
        <td>
      @endif
          <img width="24" src="{{$winner['TeamIMG']}}">
          @if ($winner['TeamID'] > 0)
          <a href="{{$winner['PlayerURL']}}">{{$winner['PlayerName']}}</a>
          @else
          {{$winner['PlayerName']}}
          @endif
          ({{$winner['TeamName']}})
        </td>
      @endforeach
      </tr>
    @endforeach
    </tbody>
  </table>
</div>

</section>

@endsection