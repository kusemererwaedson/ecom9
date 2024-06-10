<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
	<table>
		<tr><td>Dear {{ $name }}</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td>Please click on below link to activate your Stack Developers Account :-:</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><a href="{{ url('/user/confirm/'.$code) }}">Confirm Account</a></td></tr>
		<tr><td>&nbsp;</td></tr>	
		<tr><td>&nbsp;</td></tr>
		<tr><td>Thanks & Regards,</td></tr>
		<tr><td>Stack Developers</td></tr>
	</table>
</body>
</html>