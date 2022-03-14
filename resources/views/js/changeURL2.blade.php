    function changeURL2(value){
        switch (value) {
                case 1:
                    window.location.href = "{{ url('teamhistory/playerrecords', [ 'id' => $team->TeamID ]) }}";
                    break;
                case 2:
                    window.location.href = "{{ url('teamhistory/coachrecords', [ 'id' => $team->TeamID ]) }}";
                    break;
                case 3:
                    window.location.href = "{{ url('teamhistory/playerhistory', [ 'id' => $team->TeamID ]) }}";
                    break;
                case 4:
                    window.location.href = "{{ url('teamhistory/seasonrecaps', [ 'id' => $team->TeamID ]) }}";
                    break;
                case 5:
                    window.location.href = "{{ url('teamhistory/drafthistory', [ 'id' => $team->TeamID ]) }}";
                    break;
                case 6:
                    window.location.href = "{{ url('teamhistory/transactionhistory', [ 'id' => $team->TeamID ]) }}";
                    break;
        }
    }