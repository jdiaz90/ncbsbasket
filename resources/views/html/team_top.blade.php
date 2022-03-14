@section('css')

<style type="text/css">
table.teamTop, .championships span, .teamInformation span, .teamHistoryButton{ 
    width: 100%;
    background-color: {{$team->TeamColor}};
}

span.retired{ 
    background-color: {{$team->TeamColor}};
}

</style>

@endsection

<table class="teamTop">
    <tr>
        <td class="teamLogoTable" rowspan="2"><img src="{{$team->ImgLogo}}" width="70px"/></td>
        <td colspan="9"><h1>{{strtoupper($team->Franchise)}}</h1></td>
    </tr>
    <tr>
        <td class="teamInfoDiv">{{$team->Record}} RECORD</td>
        <td class="teamInfoDiv">{{$team->Streak}} STREAK</td>
        <td class="teamInfoDiv">{{$team->PPG}} PPG</td>
        <td class="teamInfoDiv">{{$team->OPPG}} OPPG</td>
        <td class="teamInfoDiv">{{$team->APG}} APG</td>
        <td class="teamInfoDiv">{{$team->RPG}} RPG</td>
        <td class="teamInfoDiv">${{number_format($team->TeamSalary, 0, ',', '.')}} TEAM SALARY</td>
        <td class="teamInfoDiv">@if ($team->TeamID < 32)
            ${{number_format($team->CapStatus, 0, ',', '.')}} CAP STATUS
            @else
            {{$team->CapStatus}} CAP STATUS   
            @endif</td>
        <td class="teamInfoDiv Important">
            <select id="optionSelected" class="form-select" onchange="changeURL();">
                <option selected disabled hidden>Team Pages</option>
                <option>Index</option>
                <option>Staff</option>
                <option>Roster</option>
                <option>Stats</option>
                <option>Contracts</option>
                <option>Insights</option>
                <option>Schedule</option>
                <option>Team Info</option>
                <option>History</option>
            </select>
        </td>
    </tr>
</table>
