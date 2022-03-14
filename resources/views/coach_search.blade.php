@extends('layout')

@section('title')
Coach Search - {{ config('app.name') }}
@endsection

@section('description')
Buscador de la liga {{ config('app.name') }}.
@endsection

@section('section')
<section class="normal">
  <h1>Coach Search</h1>
  <h2 class="search">Showing search results "{{$id}}"</h2>
  <div class="playerSearch">
    @foreach ($coaches as $coach)     
    <div class="card mb-3">
      <div class="row g-0">
        <div class="col-md-4">
          <img class="img-fluid rounded-start" src="{{$coach['PlayerPhoto']}}"
          onerror="this.onerror=null; this.src='/images/nonplayers/default.png';">
        </div>
        <div class="col-md-8">
          <div class="card-body">
            @if ($coach['CoachURL'] <> "N/A")
            <h5 class="card-title"><a href="{{$coach['CoachURL']}}">{{$coach['Full_Name']}}</a></h5>
            @else
            <h5 class="card-title">{{$coach['Full_Name']}}</a></h5>
            @endif
            <h6 class="card-subtitle mb-2 text-muted">
              @if ($coach['TeamID'] > 0)
              <img src="{{$coach['ImgLogo']}}" width="24" />
              @endif
              @if ($coach['Team'] <> "N/A")
              {{$coach['Team']}} 
              @endif
            </h6>
            <ul class="card-text">
              <li>{{$coach['Wins']}} Career wins</li>
              <li>{{$coach['Losses']}} Career losses</li>
              <li>{{$coach['Championships']}} Championships</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    @endforeach
  </div>
</section>

@endsection
