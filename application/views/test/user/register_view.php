<html>
<head>
	<title><?=$test?></title>
	<meta charset='utf-8'>
</head>

<body>
	<h1><?=$title?></h1>
	<form action="<?=base_url().'user/register' ?>" method="post">
		User Name: <input type="text" name="name"><br/>
		Phone: <input type="text" name="phone"> <br/>
		Password: <input type="password" name="pwd"> <br/>
		<input type="submit" value="Submit">
	</form>
</body>
</html>