<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">Home</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            League Media
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li class="dropdown-submenu">
              <a href="/team" data-bs-toggle="dropdown" class="dropdown-item dropdown-toggle" data-bs-display="static">Teams</a>
              <ul class="dropdown-menu">
    
                <li class="dropdown-submenu">
                  <a href="#" data-bs-toggle="dropdown" class="dropdown-item dropdown-toggle">NBA</a>
                  <ul class="dropdown-menu">
                      <li>
                      @foreach ($navBarTeams as  $key => $division)
                        <li class="dropdown-submenu">
                            <a href="#" data-bs-toggle="dropdown" class="dropdown-item dropdown-toggle">{{$key}}</a>
                            <ul class="dropdown-menu">
                              @foreach($division as $team)
                              <li class="dropdown-submenu"><a href="{{ url('team', [ 'id' => $team['TeamID'] ]) }}" data-bs-toggle="dropdown" class="dropdown-item dropdown-toggle"><img width="16" src="{{$team['ImgLogo']}}"> {{$team['Franchise']}}</a>
                                <ul class="dropdown-menu">
                                @foreach ($team['Players'] as  $player)
                                  <li><a href="{{ url('player', [ 'id' => $player['PlayerID'] ]) }}" class="dropdown-item">{{$player->Full_Name}}</a></li>
                                @endforeach
                                </ul>
                                @endforeach
                              </li>
                            </ul>
                        </li>
                      @endforeach
                      </li>
                  </ul>
                </li>
    
                <li class="dropdown-submenu">
                  <a href="#" data-bs-toggle="dropdown" class="dropdown-item dropdown-toggle">D-League</a>
                  <ul class="dropdown-menu">
                      <li>
                      @foreach ($dNavBarTeams as  $key => $division)
                        <li class="dropdown-submenu">
                            <a href="#" data-bs-toggle="dropdown" class="dropdown-item dropdown-toggle">{{$key}}</a>
                            <ul class="dropdown-menu">
                              @foreach($division as $team)
                              <li class="dropdown-submenu"><a href="{{ url('team', [ 'id' => $team['TeamID'] ]) }}" data-bs-toggle="dropdown" class="dropdown-item dropdown-toggle"><img width="16" src="{{$team['ImgLogo']}}"> {{$team['Franchise']}}</a>
                                <ul class="dropdown-menu">
                                @foreach ($team['Players'] as  $player)
                                  <li><a href="{{ url('player', [ 'id' => $player['PlayerID'] ]) }}" class="dropdown-item">{{$player->Full_Name}}</a></li>
                                @endforeach
                                </ul>
                                @endforeach
                              </li>
                            </ul>
                        </li>
                      @endforeach
                      </li>
                  </ul>
                </li>
    
              </ul>
            </li>
            <li><a class="dropdown-item" href="/player">Players</a></li>
            <li><a class="dropdown-item" href="/coach">Coaches</a></li>
            <li><a class="dropdown-item" href="/schedule">Schedule</a></li>
            <li><a class="dropdown-item" href="/medianews">Media News</a></li>
            <li class="dropdown-submenu">
              <a href="#" data-bs-toggle="dropdown" class="dropdown-item dropdown-toggle">Magazines</a>
              <ul class="dropdown-menu">
                  <li>
                      <a href="/rookieguide" class="dropdown-item">Rookie Guide</a>
                  </li>
                  <li>
                      <a href="/freeagencyguide" class="dropdown-item">Free Agency Guide</a>
                  </li>
                  <li>
                    <a href="/fantasyguide" class="dropdown-item">Fantasy Guide</a>
                  </li>
                  <li>
                    <a href="/seasonprev" class="dropdown-item">Season Preview</a>
                  </li>
              </ul>
            </li>
          <li><a class="dropdown-item" href="/awards">Awards</a></li>
          <li><a class="dropdown-item" href="/injuryreport">Injury Report</a></li>
          <li><a class="dropdown-item" href="/draftpicks">Draft Picks</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Standings
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/standings">This Season</a></li>
            <li><a class="dropdown-item" href="/paststandings">Historical Standings</a></li>
            <li><a class="dropdown-item" href="/playoffrounds">Playoff Rounds</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/finances">Finances</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/transactions">Transactions</a>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Leaders
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/leagueleaders">League Leaders</a></li>
            <li><a class="dropdown-item" href="/teamleagueleaders">Team League Leaders</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Almanac
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="/playerrecords">Player Records</a></li>
            <li><a class="dropdown-item" href="/coachrecords">Coach Records</a></li>
            <li><a class="dropdown-item" href="/playerhistory">Player History</a></li>
            <li><a class="dropdown-item" href="/paststandings">Historical Standings</a></li>
            <li><a class="dropdown-item" href="/awardwinners">Award Winners </a></li>
            <li><a class="dropdown-item" href="/champions">Champions</a></li>
            <li><a class="dropdown-item" href="/draft">Draft History</a></li>
            <li><a class="dropdown-item" href="/hof">Hall Of Fame</a></li>
          </ul>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="/milestones">Milestones</a>
        </li>

      </ul>

      <form class="d-flex" method="POST" action="/search">
      @csrf
      <div class="input-group input-group-sm">
          <input class="form-control me-2" type="search" minlength="3" placeholder="Search" name="key" id="key" aria-label="Search" autocomplete="off">
          <button class="btn btn-outline-success" type="submit">Search</button>
          <div id="suggestions"></div>
      </div>
    </form>
    </div>
  </div>
</nav>




