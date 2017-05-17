<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>@yield('title')</h2>
<hr>
<div>
    @yield('welcome')
</div>
<hr><br>
<div>
    @yield('content')
</div>
<div>
    See you soon on the forum {{$user->displayname}} !
    <hr><br>
</div>
</body>
<footer>
    <br><br>
    This is a automatically generated email and this account is not monitord.<br>
    Emails to this account will not be responded to.
</footer>
</html>