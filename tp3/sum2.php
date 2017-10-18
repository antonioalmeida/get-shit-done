<!DOCTYPE html>
<html>
<head>
<title>Sample PHP Form</title>
</head>

<?php 
$val1 = $_GET['val1'];
$val2 = $_GET['val2'];

$sum2 = $val1+$val2;
?>	

<body>
	<?php echo $sum2; ?>
	<a href="./form.html">Go back!</a>
</body>

</html>