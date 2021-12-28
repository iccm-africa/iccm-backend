<!DOCTYPE html>
<html>
<head>
</head>
<body>
Hi {{ $user->name }},
<p>
Your registration for ICCM-Africa is almost complete.
</p>
<p>
We like to ask you to fill in some additional information, such as your IT skills and how you can help shape the conference. To complete your registration for ICCM-Africa.<br />
If you are paying by Cash on Arrival, please upload the necessary additional documents e.g. flight ticket or VISA. 
</p>
<p>
Please complete the post-registration form via this link: <a href="{{ route('postregistration_mail', $user->mail_id)}}">post-registration</a>
</p>
Thanks,<br>
ICCM-Africa Prep Team
</body>
</html>
