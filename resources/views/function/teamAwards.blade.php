<div>
    <div class="teamAwards">
        <table class="table">
            <thead id="thead" class="thead">
            <tr>
                <th class="ta1" scope="col">Most Valuable Player Winners</th>
                <th class="ta2" scope="col">Defensive Player of the Year Winners</th>
                <th class="ta3" scope="col">Rookie of the Year Winners</th>
                <th class="ta4" scope="col">Sixth Man of the Year Winners</th>
                <th class="ta5" scope="col">Coach of the Year Winners</th>
                <th class="ta6" scope="col">All-League 1st Team Winners</th>
                <th class="ta7" scope="col">All-League 2nd Team Winners</th>
                <th class="ta8" scope="col">All-League 3rd Team Winners</th>
                <th class="ta9" scope="col">All-Defense 1st Team Winners</th>
                <th class="ta10" scope="col">All-Defense 2nd Team Winners</th>
                <th class="ta11" scope="col">All-Rookie 1st Team Winners</th>
                <th class="ta12" scope="col">All-Rookie 2nd Team Winners</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($team->awards as $award)
                @if (str_contains($award->AwardName, 'Valuable'))
                <tr>
                    <td class="ta1">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif
                @if (str_contains($award->AwardName, 'Defensive'))
                <tr>
                    <td class="ta2">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif
                @if (str_contains($award->AwardName, 'Rookie of the Year'))
                <tr>
                    <td class="ta3">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif 
                @if (str_contains($award->AwardName, 'Sixth'))
                <tr>
                <td class="ta4">{{$award->PlayerName}} ({{$award->Season}})</td>      
            </tr>
                @endif
                @if (str_contains($award->AwardName, 'Coach'))
                <tr>
                    <td class="ta5">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif 
                @if (str_contains($award->AwardName, 'All-League 1st'))
                <tr>
                    <td class="ta6">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif  
                @if (str_contains($award->AwardName, 'All-League 2nd'))
                <tr>
                    <td class="ta7">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif  
                @if (str_contains($award->AwardName, 'All-League 3rd'))
                <tr>
                    <td class="ta8">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif  
                @if (str_contains($award->AwardName, 'All-Defense 1st'))
                <tr>
                    <td class="ta9">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif  
                @if (str_contains($award->AwardName, 'All-Defense 2nd'))
                <tr>
                    <td class="ta10">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif
                @if (str_contains($award->AwardName, 'All-Rookie 1st'))
                <tr>
                    <td class="ta11">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif  
                @if (str_contains($award->AwardName, 'All-Rookie 2nd'))
                <tr>
                    <td class="ta12">{{$award->PlayerName}} ({{$award->Season}})</td>      
                </tr>
                @endif  
            @endforeach
            @if($awardsCount['ta1'] == 0)
            <tr>
                <td class="ta1 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta2'] == 0)
            <tr>
                <td class="ta2 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta3'] == 0)
            <tr>
                <td class="ta3 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta4'] == 0)
            <tr>
                <td class="ta4 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta5'] == 0)
            <tr>
                <td class="ta5 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta6'] == 0)
            <tr>
                <td class="ta6 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta7'] == 0)
            <tr>
                <td class="ta7 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta8'] == 0)
            <tr>
                <td class="ta8 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta9'] == 0)
            <tr>
                <td class="ta9 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta10'] == 0)
            <tr>
                <td class="ta10 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta11'] == 0)
            <tr>
                <td class="ta11 nodata">No data available in table</td>      
            </tr>
            @endif
            @if($awardsCount['ta12'] == 0)
            <tr>
                <td class="ta12 nodata">No data available in table</td>      
            </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>