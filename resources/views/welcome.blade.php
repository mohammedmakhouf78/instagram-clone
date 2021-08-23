<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Instgram-clone</title>
    <link rel="stylesheet" href="{{mix('css/app.css')}}">

    <script>
        (function(){
            window.Laravel = {
                csrfToken: '{{ csrf_token() }}'
            }
        })();
    </script>
</head>

<body class="body">


    <div id="app">
        <welcome></welcome>
    </div>


    <script src="{{mix('js/app.js')}}"></script>
</body>

</html>