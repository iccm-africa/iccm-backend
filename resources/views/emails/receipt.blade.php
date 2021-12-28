<!DOCTYPE html>
<html>
<head>
</head>
<body>
Hi {{ $admin->name }},
<p>
The following invoice has been marked as paid:
</p>
<p>
{{ $invoice->number}} ({{ $invoice->currencyString() }})
</p>
<p>
You can now download the receipt when you <a href="{{ route('group') }}">log in to the website</a>.
</p>
Thanks,<br>
ICCM-Africa System
</body>
</html>
