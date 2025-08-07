@extends('layout')

@section('title')
Media News - {{ config('app.name') }}
@endsection

@section('description')
Media News de la liga {{ config('app.name') }}.
@endsection

@section('section')

<section class="normal">
<h1>Media News</h1>
<table class="table">
    @foreach ($news as $media)
        <thead>
            <tr>
                @if ($media->MainTeam > 0)
                    @switch($media->MainTeam)
                        @case(4)
                    <th class="media Team Philadelphia ers"><img src="{{$media->mainTeam->ImgLogo}}" width="16"> {{$media->Title}}</th>         
                            @break
                        @case(27)
                    <th class="media Team Angeles Clippers"><img src="{{$media->mainTeam->ImgLogo}}" width="16"> {{$media->Title}}</th>              
                            @break
                        @case(28)
                    <th class="media Team Angeles Lakers"><img src="{{$media->mainTeam->ImgLogo}}" width="16"> {{$media->Title}}</th>          
                            @break
                        @default
                    <th class="media Team {{$media->mainTeam->Franchise}}"><img src="{{$media->mainTeam->ImgLogo}}" width="16"> {{$media->Title}}</th>          
                    @endswitch
                @else
                    <th class="media Team free Agent">{{$media->Title}}</th> 
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$media->Story}}</td>
            </tr>
            <tr>
                <td>{{ $media->days ? $media->days->DayNumber : $media->Day }}</td>
            </tr>
        </tbody>
    @endforeach
    </table>

</section>

@endsection


