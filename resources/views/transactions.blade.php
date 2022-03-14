@extends('layout')

@section('title')
Transactions - {{ config('app.name') }}
@endsection

@section('description')
Todas las transacciones en la liga {{ config('app.name') }}.
@endsection


@section('section')

<section class="normal">
<h1>Transactions</h1>
<form role="form" method="POST">
@csrf
<select onchange="this.form.submit();" class="form-select transactionsSelect" id="league" name="league" aria-label="Default select league">
  <option value="1" {{$selected2[0]}}>Pro Basketball League</option>
  <option value="2" {{$selected2[1]}}>Developmental Basketball League</option>
</select>

<select onchange="this.form.submit();" class="form-select transactionsSelect" id="option" name="option" aria-label="Default select option">
  <option value="1" {{$selected[0]}}>All Transactions</option>
  <option value="2" {{$selected[1]}}>Trades</option>
  <option value="3" {{$selected[2]}}>Signings/Releases</option>
  <option value="4" {{$selected[3]}}>Assignings/Recalls</option>
  <option value="5" {{$selected[4]}}>Contractual</option>
</select>

</form>
  <table class="table">
    <thead>
      <tr>
        <th>Pro Basketball League Transaction Report</th>
      </tr>
    </thead>
    @foreach ($transactions as $year => $y)
      @foreach ($y as $day => $d)
    <thead>
      <tr>
        <th>{{$days[$year][$day]}}, @if ($day > 195) {{$seasons[$year]['Season'] + 1}}</th>@else {{$seasons[$year]['Season']}}</th>@endif
      </tr>
    </thead>
    <tbody>
      @foreach ($d as $transaction)
      <tr>
        @if (str_contains($transaction->Transaction, ' tender ') ||
            str_contains($transaction->Transaction, 'Released ') ||
            str_contains($transaction->Transaction, ' trade ') ||
            str_contains($transaction->Transaction, 'Agreed ') ||
            (
              str_contains($transaction->Transaction, 'Signed') &&
              str_contains($transaction->Transaction, 'deal')
            ))
          <td><img width="16" src="{{$transaction->team->ImgLogo}}"> 
          {!! $transaction->OtherText !!}.</td>
        @else
          <td><img width="16" src="{{$transaction->team->ImgLogo}}"> {{$transaction->team->TeamName}} 
            {!! $transaction->OtherText !!}.</td>
        @endif
      </tr> 
      @endforeach 
    </tbody>  
      @endforeach
    @endforeach
  </table>

</section>

@endsection


