<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{$subject}}</title>
    </head>
    <body>
       <h4>{{$subject}}</h4>
       <p>{{$mailMessage}}</p>
    </body>
</html>
