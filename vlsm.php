<html>
	<head>
		<title>VLSM</title>
	</head>
	<body>
		<div align="right" style="background-color:gray">
		rajekulislambadsha@gmail.com&nbsp&nbsp<br/>
		<hr/>
		</div>
		<br/>
		<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
			<b>VLSM (Variable Length Subnet Masking)</b>
			<hr/>
			Total Host No.<br/>
			<input type="text" name="hostno"/><br/>
			<hr/>
			<input type="submit" value="Next">
		</form>
	</body>
</html>
<?php
if($_SERVER['REQUEST_METHOD']=="POST"){
	$host=$_POST['hostno'];
	if($host==null){
		echo "<br/><br/>Please enter Host no!!";
	}
	else{
		$digit=false;
		for($i=0;$i<strlen($host);$i++){
			if($host[$i]>='0' && $host[$i]<='9'){
				$digit=true;
			}
			else{
				$digit=false;
				break;
			}
		}
		if($digit==true){
			$str='<form action="result.php" method="post"><hr/>Enter ip address(without prefix):<br/><input type="text" name="ip"/><br/><br/>Enter the Hosts:<br/>';
			
			for($i=0;$i<$host;$i++){
				$str.='Host'.$i.':<br/><input type="text" name="host'.$i.'"/><br/>';
			}
			$str.='<hr/><input type="submit" value="Get Result"/></form>';
			echo $str;
			
		}
		else{
			echo "<br/><br/>Please enter Integer number!!";
		}
	}
}

?>