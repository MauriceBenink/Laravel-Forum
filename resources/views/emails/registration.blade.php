<!DOCTYPE html>
<html lang="en-US">
<head>
    <meta charset="utf-8">
</head>
<body>
<h2>Registration email for Forum</h2>
<hr>
<div>
    Welcome {!! $user->display_name !!} to the Laravel Forum website!
</div>
<hr><br>
<div>
    To complete registration please follow the following link :<br>
    <a href="http://{{$_SERVER['HTTP_HOST']}}/validate/{{$user->hashcode}}">LINK</a><br><br>

    If the link doesnt work please go to the validation page and enter the following code<br>
    {{$user->hashcode}}<br><hr>
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