@extends('layout')

@section('title')
Champions - Hall Of Fame
@endsection

@section('description')
Los campeones que hubo en la NBA y en {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="https://unpkg.com/sticky-table-headers"></script>
@endsection

@section('section')

<section class="normal">
  <h1>Champions</h1>

<form role="form" method="POST">
  @csrf
  <select onchange="this.form.submit();" name="league" class="form-select Stat" aria-label="Default select league">
    <option value="P" {{$selectedLeague[0]}}>Pro Basketball League</option>
    <option value="D" {{$selectedLeague[1]}}>Developmental Basketball League</option>
  </select>
</form>

  <div class="table-responsive">
    <table class="table">
      <thead class="thead">
        <tr>
          <th scope="col">SEASON</th>
          <th scope="col">CHAMPION</th>
          <th scope="col">RUNNER-UP</th>
          <th scope="col">RESULT</th>
        </tr>
      </thead>
      <tbody>
    @foreach($champions as $champion)
        <tr>
          <th scope="row">{{$champion->SeasonID}}</th>
          <td>{{$champion->Champs}}</td>
          <td>{{$champion->Loser}}</td>
          <td>{{$champion->Champs}} won {{$champion->ChampWins}} - {{$champion->LoserWins}}</td>
        </tr>
    @endforeach
      </tbody>
    </table>
  </div>

  <script>

    $('table.table').stickyTableHeaders();

  </script>

</section>

@endsection