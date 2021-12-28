<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
	<table cellpadding="0" cellspacing="0" width="100%">
		<tr class="top">
			<td>
                <img src="data:image/png;charset=utf-8;base64,{{ base64_encode(file_get_contents('img/iccmlogo.png')) }}" >
			</td>
			<td>
				<h1>Receipt</h1> 
			</td>
		</tr>
	</table>
	<br />
	<br />
	<table>
		<tr>
			<td><b>Name:</b></td>
			<td>{{ $groupadmin->name }} {{ $groupadmin->lastname }}</td>
		</tr>
		<tr>
			<td><b>Organisation:</b></td>
			<td>{{ $invoice->group->name }}</td>
		</tr>   
		<tr>
			<td><b>Billing address:</b></td>
			<td>{{ $invoice->group->address }}</td>
		</tr> 
		<tr>
			<td><b>Zipcode:</b></td>
			<td>{{ $invoice->group->zipcode }}</td>
		</tr>
		<tr>
			<td><b>Town/City:</b></td>
			<td>{{ $invoice->group->town }}</td>
		</tr>
		<tr>
			<td><b>Province/County/State:</b></td>
			<td>{{ $invoice->group->state }}</td>
		</tr>
	</table>
	<br/>
	<br/>
	We confirm that we have received payment for the following invoice on {{ $invoice->payment_date->format('j M Y') }}:<br/>
	<br/>
	<table>
		<tr class="heading">
			<td><b>Invoice number</b></td>
			<td><b>Amount</b></td>
		</tr>
		<tr>     
			<td>
				{{ $invoice->number }} 
			</td>
			<td>
				{{ $invoice->currencyString() }}
			</td>
		</tr>
	</table>
</body>
</html>
