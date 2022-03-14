function moveButtons(){

    var avg = document.getElementById("avg");
    var sum = document.getElementById("sum");

    if(avg.checked == true){
        sum.checked = false;
    }else{
        sum.checked = true;
    }
    
}

function moveButtons2(){

    var avg = document.getElementById("avg");
    var sum = document.getElementById("sum");

    if(sum.checked == true){
        avg.checked = false;
    }else{
        avg.checked = true;
    }
    
}

function moveButtons3(){

    var rs = document.getElementById("rs");
    var po = document.getElementById("po");

    if(rs.checked == true){
        po.checked = false;
    }else{
        po.checked = true;
    }
    
}

function moveButtons4(){

    var rs = document.getElementById("rs");
    var po = document.getElementById("po");

    if(po.checked == true){
        rs.checked = false;
    }else{
        rs.checked = true;
    }
    
}

function changeLeague(value){
    
    if(value == "D")
        document.getElementById("form").action = "/dleagueleaders/";
    else
        document.getElementById("form").action = "/leagueleaders/";

    document.getElementById("form").submit();
}