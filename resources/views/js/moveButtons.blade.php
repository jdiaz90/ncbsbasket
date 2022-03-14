function moveButtons(){

    var avg = document.getElementById("avg");
    var sum = document.getElementById("sum");
    var rs = document.getElementById("rs");
    var po = document.getElementById("po");

    if(avg.checked == true){
        sum.checked = false;
    }else{
        sum.checked = true;
    }
    
}

function moveButtons2(){

    var avg = document.getElementById("avg");
    var sum = document.getElementById("sum");
    var rs = document.getElementById("rs");
    var po = document.getElementById("po");

    if(sum.checked == true){
        avg.checked = false;
    }else{
        avg.checked = true;
    }
    
}

function fillSelect(){

    var newOptions = {
    "Games": "count(PlayerID)",
    "Minutes": "sum(Minutes)",
    "Points": "sum(Points)"
    "Assists": "sum(Assists)",
    "Rebounds": "sum(Rebounds)",
    "Blocks": "sum(Blocks)"
    "Steals": "sum(Steals)",
    "Field Goal Atempts": "sum(FGA)",
    "Field Goal Made": "sum(FGM)"
    "Field Goal %": "cast(sum(FGM) as float)/sum(FGA) * 1000",
    "3 Point Attempts": "sum(FG3PM)",
    "3 Pointers Made": "sum(FG3PA)"
    "3 Point %": "cast(sum(FG3PM) as float)/sum(FG3PA) * 1000",
    "Free Throw Attempts": "sum(FTA)",
    "Free Throws Made": "sum(FTM)"
    "Free Throw %": "cast(sum(FTM) as float)/sum(FTA) * 1000",
    "Turnovers": "sum(Turnovers)",
    "Player Efficiency": "value3"
    "Double Doubles": "value1",
    "Triple Doubles": "value2",
  };
  
  var $el = $("#record");
  $el.empty(); // remove old options
  $.each(newOptions, function(key,value) {
    $el.append($("<option></option>")
       .attr("value", value).text(key));
  });

}