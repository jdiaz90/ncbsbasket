<footer class="bg-dark text-center text-white">

      <div class="container p-4">
    
        <section class="mb-4">

          <p>
            <a rel="license" href="http://creativecommons.org/licenses/by-nc/4.0/"><img alt="Creative Commons License" style="border-width:0" src="https://i.creativecommons.org/l/by-nc/4.0/88x31.png" /></a><br />This work is licensed under a <a rel="license" class="text-white" href="http://creativecommons.org/licenses/by-nc/4.0/">Creative Commons Attribution-NonCommercial 4.0 International License</a>.
          </p>

        </section>
    
        <section class="">

          <div class="row">

            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

                  <h5 class="text-uppercase">Historical Players</h5>
        
                  <ul class="list-unstyled mb-0">
                        @foreach ($historicalPlayers as $player)
                        <li>
                            <a href="{{ url('formerplayer', [ 'id' => $player->PlayerID ]) }}" class="text-white">{{$player->PlayerName}}</a>
                          </li>
                        @endforeach
                  </ul>

            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

              <h5 class="text-uppercase">Points Leaders</h5>
    
              <ul class="list-unstyled mb-0">
                    @foreach ($topPoints as $player)
                    <li>
                        <a href="{{ url('player', [ 'id' => $player->PlayerID ]) }}" class="text-white">{{$player->PlayerName}}</a>
                      </li>
                    @endforeach
              </ul>

            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">

                  <h5 class="text-uppercase">Assists Leaders</h5>
        
                  <ul class="list-unstyled mb-0">
                        @foreach ($topAssists as $player)
                        <li>
                            <a href="{{ url('player', [ 'id' => $player->PlayerID ]) }}" class="text-white">{{$player->PlayerName}}</a>
                          </li>
                        @endforeach
                  </ul>

            </div>

            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                  <h5 class="text-uppercase">Rebounds Leaders</h5>
        
                  <ul class="list-unstyled mb-0">
                        @foreach ($topRebounds as $player)
                        <li>
                            <a href="{{ url('player', [ 'id' => $player->PlayerID ]) }}" class="text-white">{{$player->PlayerName}}</a>
                          </li>
                        @endforeach
                  </ul>
            </div>

          </div>

        </section>

      </div>

      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        Author: <a class="text-white" target="_blank" href="https://www.linkedin.com/in/jdiaz90/">@jdiaz90</a>
      </div>

</footer>