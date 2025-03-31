<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Test Case for Lendflow</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
</head>

<body>
    <h1>NYT API</h1>
    <br>
    <p>Hi,</p>
    <p>I would like to thank for the opportunity to perform test task</p>
    <p>It was inspiring</p>
    <hr>
    <p>You can visit this link to check task <a href="{{ route('v1.books') }}">link</a> or you can utilize Postman</p>
    <br>
    <p>Best Regards,</p>
    <p>Serhii Parovchenko</p>
</body>

</html>