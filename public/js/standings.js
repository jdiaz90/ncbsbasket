function changeLeague(value){
    
    if(value == "D")
        document.getElementById("form").action = "/dstandings/";
    else
        document.getElementById("form").action = "/standings/";

    document.getElementById("form").submit();
}