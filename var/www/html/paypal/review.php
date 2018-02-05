<?php
if (isset($_REQUEST['token']))
{
	$token = $_REQUEST['token'];
}else{
	echo "Fail";
	exit();
}
var_dump($token);
	require_once ("paypalfunctions.php");
	$res = GetShippingDetails( $token );
	if($res){
		$res["TOKEN"] = $token;
		$_SESSION["PayPalShippingDetail"] = $res;
		var_dump($_SESSION["PayPalShippingDetail"] );
	}else{
		echo "FAIL.";
		exit();
	}
?>
<h2>最終確認画面</h2>
<table>
	<tbody>
		<tr><td>お名前:<td><?php echo $res["LASTNAME"]." ".$res["FIRSTNAME"] ?></tr>
		<tr><td>Email:<td><?php echo  $res["EMAIL"] ?></tr>
		<tr><td>毎月一円課金を行います。</tr>
	<tbody>
</table>
<?php /*デバック用*/ echo $token; ?>
<form action='confirm.php' METHOD='POST'>
<input type="submit" value="Confirm"/>
</form>
