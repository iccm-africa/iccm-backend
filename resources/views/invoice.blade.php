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
				<h1>Invoice</h1> 
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
		<tr>
			<td><b>Country:</b></td>
			<td>{{ $invoice->group->country }}</td>
		</tr>
		</table>
		<br />
		<br />
		<table>
		<tr>
			<td><b>Invoice number:</b></td>
			<td>{{ $invoice->number }}</td>
		</tr>
		<tr>
			<td><b>Date:</b></td>
			<td>{{ $invoice->created_at->format('j M Y') }}</td>
		</tr>
		</table>
		<br/>
		<br/>
		<table width="100%">
		<tr class="heading">
			<td><b>Participant</b></td>
			<td><b>Accommodation</b></td>
			<td><b>Products</b></td>
			<td><b>Cost</b></td>
		</tr>
		@foreach($invoice->group->users as $u)
		<tr>     
			<td>
				{{ $u->nameString() }}
			</td>
	                <td>
				{{ $u->accommodation->name }}
			</td>
			<td>
				@foreach($u->products as $p)
				{{ $p->name }}<br />
				@endforeach
			</td>
			<td>
				{{ $u->currencyString() }}
			</td>
		</tr>
		@endforeach
		<tr>
			<td colspan="3"><b>Total</b></td>
			<td><b>{{ $def->format($invoice->group->cost()) }}</b></td>
		</tr>
		@if($invoice->amount != $invoice->group->cost())
		<tr>
			<td colspan="4">
			<br />
			</td>
		</tr>
		<tr>
			<td colspan="3">Previous invoices</td>
			<td>{{ $def->format($invoice->group->cost() - $invoice->amount) }}</td>
		</tr>
		<tr>
			<td colspan="3"><b>Outstanding</b></td>
			<td><b>{{ $def->format($invoice->amount) }}</b></td>
		</tr>
		@endif
		@if($invoice->getCurrency() != $def)
		<tr>
			<td colspan="3"></td>
			<td><b>{{ $invoice->currencyString() }}</b></td>
		</tr>
		@endif
        </table>
        <br />
        <br />
        {!! nl2br(htmlspecialchars($invoice->method->instructions)) !!}
</body>
</html>
