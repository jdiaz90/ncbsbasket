  function changeURL(){

      var option = document.getElementById("optionSelected").value;
    
      switch(option){
        case "Index":
          window.location.href = "{{ url('team', [ 'id' => $team->TeamID ]) }}";
          break;
        case "Staff":
          window.location.href = "{{ url('teamstaff', [ 'id' => $team->TeamID ]) }}";
          break;
        case "Roster":
          window.location.href = "{{ url('teamroster', [ 'id' => $team->TeamID ]) }}";
          break;
        case "Stats":
          window.location.href = "{{ url('teamstats', [ 'id' => $team->TeamID ]) }}";
          break;
        case "Contracts":
          window.location.href = "{{ url('teamcontracts', [ 'id' => $team->TeamID ]) }}";
          break;
        case "Insights":
          window.location.href = "{{ url('teaminsights', [ 'id' => $team->TeamID ]) }}";
          break;
        case "Schedule":
          window.location.href = "{{ url('teamschedule', [ 'id' => $team->TeamID ]) }}";
          break;
        case "Team Info":
          window.location.href = "{{ url('teaminfo', [ 'id' => $team->TeamID ]) }}";
          break;
        case "History":
          window.location.href = "{{ url('teamhistory', [ 'id' => $team->TeamID ]) }}";
          break;
      }
  }