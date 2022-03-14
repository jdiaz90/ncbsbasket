<head>    
    <title>@yield('title')</title>
    <meta charset="UTF-8">
    <meta name="title" content="@yield('title')">
    <meta name="description" content="@yield('description')">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/css/CSS.css">
    <link rel="stylesheet" type="text/css" href="/css/Teams.css"> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/d5173ee537.js" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#key').on('keyup', function() {
                var key = $(this).val();		
                var dataString = 'key='+key;
            $.ajax({
                    type: "POST",
                    url: "/php/NavBarSearch.php",
                    data: dataString,
                    success: function(data) {
                        //Escribimos las sugerencias que nos manda la consulta
                        $('#suggestions').fadeIn(1000).html(data);
                        //Al hacer click en alguna de las sugerencias
                        $('.suggest-element').on('click', function(){
                                var url = $(this).attr('url');
                                $(location).attr('href',url);
                                return false;
                        });
                    }
                });
            });
        }); 
</script>
    @yield('css')
    @yield('javascript')
</head>