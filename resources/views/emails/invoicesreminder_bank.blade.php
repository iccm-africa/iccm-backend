<!DOCTYPE html>
<html>
<head>
</head>
<body>
Hi {{ $admin->name }},
<p>
The follow invoice(s) is/are unpaid: 
</p>
<p>
<table cellpadding=10>
<tr>
<td><b>{{ _('Invoice Number') }}</b></td><td><b>{{ _('Payment Type') }}</b></td><td><b>{{ _('Description') }}</b></td>
</tr>
@foreach ($invoices as $invoice)
<tr>
	<td> {{ $invoice->number }}</td><td>{{ $invoice->method->name }}</td><td>{!! nl2br(htmlspecialchars($invoice->method->instructions)) !!}</td>
</tr>
@endforeach
</table>

</p>

<p>
Kindly complete your payment soon as possible
</p>
Thanks,<br>
ICCM-Africa System
</body>
</html>
