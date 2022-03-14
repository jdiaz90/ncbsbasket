@extends('layout')

@section('title')
Rookie Guide - {{ config('app.name') }}
@endsection

@section('description')
Rookie Guide de la liga {{ config('app.name') }}.
@endsection

@section('section')

<section class="normal">
<h1>Rookie Guide</h1>
  <div class="rookieGuideButtons">
    <form role="form" method="POST">
      @csrf


      <div class="container">
        <div class="row align-items-center">

          <div class="col-lg"> 
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="1" id="btn-check" autocomplete="off" />
            <label class="btn btn-primary rookieguide" for="btn-check">Point Guards</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="2" id="btn-check2" autocomplete="off" />
            <label class="btn btn-primary rookieguide" for="btn-check2">Shooting Guards</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="3" id="btn-check3" autocomplete="off" />
            <label class="btn btn-primary rookieguide" for="btn-check3">Small Forwards</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="4" id="btn-check4" autocomplete="off" />
            <label class="btn btn-primary rookieguide" for="btn-check4">Power Forwards</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="5" id="btn-check5" autocomplete="off" />
            <label class="btn btn-primary rookieguide" for="btn-check5">Centers</label>
          </div>

          <div class="col-lg">
            <input onclick="this.form.submit();" type="radio" class="btn-check" name="position" value="6" id="btn-check6" autocomplete="off" />
            <label class="btn btn-primary rookieguide" for="btn-check6">Mock Draft</label>
          </div>

        </div>
      </div>

    </form>
  </div>

  <div class="table-responsive">
    <table class="table">
      <tbody>
        @foreach ($rookieguide as $rookie)
        <tr class="rookieInfo">
          <td class="playerPortrait"><img src="{{$rookie->player->PlayerPhoto}}"
                onerror="this.onerror=null; this.src='/images/players/default.png';"></td>
          <td>
            <h2><u><a href="{{$rookie->player->URLPlayer}}">{{$rookie->player->Full_Name}}</a></u></h2>
            <div>
              {{$rookie->player->Age}} years old<br/>
              {{$rookie->player->Height}} / {{$rookie->player->Weight}}<br/>
              {{$rookie->player->Full_Position}}<br/>
              {{$rookie->player->College}}<br/>
            </div>
          </td>
          @if ($position <= 5)
          <td class="teamPortrait"><img height="190" src="{{$rookie->player->CollegeLogo}}"
            onerror="this.onerror=null; this.src='/images/logos/DDSPB.png'"></td>
          @else
          <td><img height="190" src="{{$rookie->team->ImgLogo}}"></td>  
          @endif
          <td>
            <p>{{$rookie->otherInfo->Strengths}}</p>
            <p>{{$rookie->otherInfo->Weaknesses}}</p>
          </td>
        </tr> 
        @endforeach
      </tbody>
    </table>
  </div>

</section>

@endsection
