@extends('layout')

@section('title')
Free Agency Guide - {{ config('app.name') }}
@endsection

@section('description')
Próximos agentes libres de la liga {{ config('app.name') }}.
@endsection

@section('javascript')
<script src="/js/sortable/sortable.js"></script>
<script src="https://unpkg.com/sticky-table-headers"></script>
@endsection

@section('section')

<section class="normal">
<h1>Free Agency Guide</h1>
    <div class="table-responsive">
        <table class="table sortable">
            <thead class="thead">
                <tr>
                <th scope="col">Pos</th>
                <th scope="col">Player</th>
                <th scope="col">Current Team</th>
                <th scope="col">PPG</th>
                <th scope="col">APG</th>
                <th scope="col">RPG</th>
                <th scope="col">SPG</th>
                <th scope="col">BPG</th>
                <th scope="col">Type</th>
                <th scope="col">Contract</th>
                <th scope="col">Overall</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($players as $id => $player)
                <tr>
                    <th data-sort="{{$player['Position']}}" scope="row">{{$player['AbPosition']}}</th>
                    <td><b><a href="{{ url('player', [ 'id' => $id ]) }}">{{$player['Name']}}</a></b></td>
                    <td><a href="{{ url('team', [ 'id' => $player['TeamID'] ]) }}">{{$player['Team']}}</td>
                    <td>{{$player['PPG']}}</td>
                    <td>{{$player['APG']}}</td>
                    <td>{{$player['RPG']}}</td>
                    <td>{{$player['SPG']}}</td>
                    <td>{{$player['BPG']}}</td>
                    <td>{{$player['Type']}}</td>
                    <td data-sort="{{$player['Salary']}}">${{number_format($player['Salary'], "0", ",", ".")}}</td>
                    <td data-sort="{{$player["Overall"][0] + $player["Overall"][1] * 0.5}}">
                        @for($i = 0; $i < $player["Overall"][0]; $i++)
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#ffc40c" class="bi bi-star-fill" viewBox="0 0 16 16">
            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/>
            </svg>
                        @endfor
                        @for($i = 0; $i < $player["Overall"][1]; $i++)
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
