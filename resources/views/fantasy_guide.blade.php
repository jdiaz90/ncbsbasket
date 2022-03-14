@extends('layout')

@section('title')
Fantasy Guide - {{ config('app.name') }}
@endsection

@section('description')
Fantasy Guide de la liga {{ config('app.name') }}.
@endsection

@section('section')

<section class="normal">
<h1>Fantasy Guide</h1>
  <div class="FantasyGuideButtons">
    <form role="form" method="POST">
      @csrf

      <div class="container">
        <div class="row align-items-center">

          <div class="col-lg"> 
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="1" id="btn-check" autocomplete="off" />
            <label class="btn btn-primary fantasyguide" for="btn-check">Point Guards</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="2" id="btn-check2" autocomplete="off" />
            <label class="btn btn-primary fantasyguide" for="btn-check2">Shooting Guards</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="3" id="btn-check3" autocomplete="off" />
            <label class="btn btn-primary fantasyguide" for="btn-check3">Small Forwards</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="4" id="btn-check4" autocomplete="off" />
            <label class="btn btn-primary fantasyguide" for="btn-check4">Power Forwards</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="5" id="btn-check5" autocomplete="off" />
            <label class="btn btn-primary fantasyguide" for="btn-check5">Centers</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="6" id="btn-check6" autocomplete="off" />
            <label class="btn btn-primary fantasyguide" for="btn-check6">Top 50</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="7" id="btn-check7" autocomplete="off" />
            <label class="btn btn-primary fantasyguide" for="btn-check7">Under The Radar</label>
          </div>

      </div>
    </form>
  </div>

  <div class="table-responsive">      
    <table class="table">
      <tbody>
        @foreach ($fantasyguide as $fantasy)
        <tr class="playerInfo">
          <td class="playerPortrait"><img src="{{$fantasy->Player->PlayerPhoto}}"
                onerror="this.onerror=null; this.src='/images/players/default.png';"></td>
          <td>
            <h2><u><a href="{{$fantasy->Player->URLPlayer}}">{{$fantasy->Player->Full_Name}}</a></u></h2>
            <div>
              {{$fantasy->Player->Age}} years old<br/>
              {{$fantasy->Player->Height}} / {{$fantasy->Player->Weight}}<br/>
              {{$fantasy->Player->Full_Position}}<br/>
              {{$fantasy->Player->College}}<br/>
            </div>
          </td>
          <td>
            <p>{{$fantasy->Player->otherInfo->Strengths}}</p>
            <p>{{$fantasy->Player->otherInfo->Weaknesses}}</p>
          </td>
        </tr> 
        @endforeach
      </tbody>
    </table>
  </div>

</section>

@endsection
