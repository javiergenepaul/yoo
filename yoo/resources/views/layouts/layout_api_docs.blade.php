<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Yoo Documentation @yield('title')</title>
    <script src="https://kit.fontawesome.com/caefad7d7f.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{asset('assets/css/api_docs_style.css')}}">
</head>

<body data-bs-spy="scroll" data-bs-target="#navbar-example">
    @include('include.api_docs_sidebar')
    @yield('content')

    <script src="{{asset('assets/js/api_docs_script.js')}}"></script>
</body>
</html>
