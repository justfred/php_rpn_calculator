<?php
 /** index.php
 * index/view for paylease code challenge
 *
 */

//load the controller
require_once('./rpn.php'); 
$rpn = new rpn();

$rpn->process();

?>

<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title>RPN Calculator</title>

	<!-- Styles -->
    <link rel='stylesheet' href='rpn.css' type='text/css'>

</head>
<body>
	<h1>RPN Calculator</h1>

	<form id='calc' action='' method='post'>
		<div class='calcdisplay'><?php $rpn->outDisplay() ?></div>
		<table>
			<tr>
				<td><button name='action' class='calcbutton' type='submit' value='7'>7</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='8'>8</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='9'>9</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='/'>/</button></td>
			</tr>
			<tr>
				<td><button name='action' class='calcbutton' type='submit' value='4'>4</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='5'>5</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='6'>6</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='x'>x</button></td>
			</tr>
			<tr>
				<td><button name='action' class='calcbutton' type='submit' value='1'>1</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='2'>2</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='3'>3</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='-'>-</button></td>
			</tr>
			<tr>
				<td><button name='action' class='calcbutton' type='submit' value='0'>0</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='.'>.</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='Clx'>Clx</button></td>
				<td><button name='action' class='calcbutton' type='submit' value='+'>+</button></td>
			</tr>
			<tr>
				<td colspan=2><button name='action' class='calcbutton buttonEnter' type='submit' value='Enter'>Enter</button></td>
			</tr>
		</table>

		<?php $rpn->outStack() ?>
		d : <?php $rpn->outDisplay() ?><br/>

	</form>

	<!-- javascript -->
<!--
	<script src="//code.jquery.com/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="rpn.js"></script>
-->

</body>
</html>

