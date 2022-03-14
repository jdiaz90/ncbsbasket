@extends('layout')

@section('title')
Hall Of Fame - {{ config('app.name') }} 
@endsection

@section('description')
Jugadores ingresados en el Hall of Fame de la NBA y {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="/js/sortable/sortable.js"></script>
<script src="https://unpkg.com/sticky-table-headers"></script>
@endsection

@section('section')

<section class="normal"> 
  <h1>Hall Of Fame</h1>
    <div class="table-responsive">
      <table class="table sortable">
        <thead class="thead">
          <tr>
            <th scope="col">NAME</th>
            <th scope="col">INDUCTED</th>
            <th scope="col">GAMES</th>
            <th scope="col">POINTS</th>
            <th scope="col">ASSISTS</th>
            <th scope="col">REBOUNDS</th>
            <th scope="col">BLOCKS</th>
            <th scope="col">STEALS</th>
          </tr>
        </thead>
        <tbody>
      @foreach($hofs as $hof)
          <tr>
            <th scope="row"><a href="{{url('formerplayer', [ 'id' => $hof->PlayerID ])}}">{{$hof->PlayerName}}</a></th>
            <th scope="row">{{$hof->SeasonID}}</th>
            <td data-sort="{{$hof->G}}">{{number_format($hof->G, "0", ",", ".")}}</td>
            <td data-sort="{{$hof->Points}}">{{number_format($hof->Points, "0", ",", ".")}}</td>
            <td data-sort="{{$hof->Assists}}">{{number_format($hof->Assists, "0", ",", ".")}}</td>
            <td data-sort="{{$hof->Rebounds}}">{{number_format($hof->Rebounds, "0", ",", ".")}}</td>
            <td data-sort="{{$hof->Blocks}}">{{number_format($hof->Blocks, "0", ",", ".")}}</td>
            <td data-sort="{{$hof->Steals}}">{{number_format($hof->Steals, "0", ",", ".")}}</td>
          </tr>
      @endforeach
        <tbody>
      </table>
    </div>

    <script>

      $('table.table.sortable').stickyTableHeaders();
  
  </script>

</section>

@endsection