@extends('layout')

@section('title')
Finances - {{ config('app.name') }} 
@endsection

@section('description')
Finanzas de {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="/js/sortable/sortable.js"></script>
<script src="https://unpkg.com/sticky-table-headers"></script>
@endsection

@section('section')

<section class="normal">
<h1>Finances</h1>
<div class="table-responsive">
  <table class="table sortable">
    <thead class="thead">
      <tr>
        <th scope="col">TEAM</th>
        <th scope="col">PAYROLL</th>
        <th scope="col">CAP SPACE</th>
        <th scope="col">LUXURY TAX</th>
        <th scope="col">NEXT YR PAYROLL</th>
        <th scope="col">NEXT YEAR CAP SPACE</th>
        <th scope="col">TOTAL ATTEND</th>
        <th scope="col">AVG. ATTEND</th>
        <th scope="col">CAPACITY %</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($finances as $players)
      <tr>
        <th scope="row"><img width="16" src="{{$players->team->ImgLogo}}"> 
          <a href="{{url('team', [ 'id' => $players->TeamID ])}}">{{$players->team->Franchise}}</a></th>
        <td>${{number_format($players->team->TeamSalary, "0", ",", ".")}}</td>
        @if ($players->team->CapStatus > 0)
        <td data-sort="{{$players->team->CapStatus}}">{{number_format($players->team->CapStatus, "0", ",", ".")}}</td>
        @else
        <td class="negative" data-sort="{{$players->team->CapStatus}}">{{number_format($players->team->CapStatus, "0", ",", ".")}}</td>  
        @endif
        @if ($players->team->LuxuryTax)
        <td data-sort="{{$players->team->LuxuryTax}}">{{number_format($players->team->LuxuryTax, "0", ",", ".")}}</td>
        @else
        <td data-sort="0"></td>  
        @endif
        <td data-sort="{{$players->PayRoll_2}}">${{number_format($players->PayRoll_2, "0", ",", ".")}}</td>
        @if ($players->Next_PayRoll_2 > 0)
        <td data-sort="{{$players->Next_PayRoll_2}}">{{number_format($players->Next_PayRoll_2, "0", ",", ".")}}</td>
        @else
        <td class="negative" data-sort="{{$players->Next_PayRoll_2}}">{{number_format($players->Next_PayRoll_2, "0", ",", ".")}}</td>  
        @endif
        <td>{{number_format($players->team->TotalAttendance, "0", ",", ".")}}</td>
        <td>{{number_format($players->team->AverageAttendance, "0", ",", ".")}}</td>
        <td data-sort="{{$players->team->CapacityPct}}">{{round($players->team->CapacityPct, 1)}}</td>
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