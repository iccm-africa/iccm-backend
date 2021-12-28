<!DOCTYPE html>
<html>
<head>
</head>
<body>
Hi {{ $admin->name }},
<p>
The follow user(s) is/are not checked out: 
</p>
<p>
@foreach ($users as $user)
	- {{ $user->name }} <br />
@endforeach
</p>

<p>
Kindly <a href="{{ route('group') }}">log in to the website</a> and press checkout.
</p>
Thanks,<br>
ICCM-Africa System
</body>
</html>
