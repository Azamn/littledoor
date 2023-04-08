<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="{{asset('Assets/Admin/css/vendors/bootstrap.css')}}">
    <style>
        body {
            padding: 0;
            margin: 0;
        }
    </style>
</head>
<body>
<div class="text-center" style="width: 100vw; height: 100vh; background-color: #1a202c">
    <div style="padding-top: 40vh; margin-bottom: 15px">
        <span style="color: #aaa; font-size: 22px;">YOUR ACCOUNT HAS BEEN DEACTIVATED</span>
    </div>
    <a href="{{ Route('logout') }}" class="btn btn-danger" onclick="event.preventDefault(); document.getElementById('logout-form').submit()">LOGOUT</a>
    <form action="{{ Route('logout') }}" method="POST" id="logout-form">
        @csrf
    </form>
</div>
</body>
</html>
