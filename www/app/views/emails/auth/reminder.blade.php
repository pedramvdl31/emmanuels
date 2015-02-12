<!DOCTYPE html>
<html lang="en-US">
	<head>
		<meta charset="utf-8">
	</head>
	<body>
		<h2>Password Reset</h2>

		<div>
			To reset your password, complete this form: <a href="{{ action('RemindersController@getReset',$token) }}"> Reset Form</a>
		</div>
	</body>
</html>
