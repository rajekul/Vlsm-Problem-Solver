<?php
	echo '<title>VLSM RESULT</title><div align="right" style="background-color:gray">
		rajekulislambadsha@gmail.com&nbsp&nbsp<br/>
		<hr/>
		</div>
		<br/>
		<form action="vlsm.php"><input type="submit" value=" <<< back"/><hr/><br/><br/>';
	$i=0;
	$ef=0;
	$err="";
	$str="";
	foreach($_POST as $key=>$value){
		if($key=="ip"){
			if($value==null){
				$err.="ip is not set !!<br/>";
				$ef++;
			}
			else{
				$ip=explode(".",$value);
				$c=count($ip);
				if($c==4){
					$p=$ip[0].$ip[1].$ip[2].$ip[3];
					for($k=0;$k<strlen($p);$k++){
						if($p[$k]>='0' && $p[$k]<='9'){
					
						}
						else{
							$err.="incorrect ip address !!<br/>";;
							$ef++;
							break;
						}
					}
				}
				else{
					$err.="incorrect ip address !!<br/>";
					$ef++;
				}
			}
		}
		else{
			if($value==null){
				$err.="host$i is null !!<br/>";
				$ef++;
			}
			else{
				for($k=0;$k<strlen($value);$k++){
					if($value[$k]>='0' && $value[$k]<='9'){
					
					}
					else{
						$err.="host$i is not integer !!<br/>";
						$ef++;
						break;
					}
				}
			}
			$i++;
		}
		
	}
	if($ef>0){
		echo '!!! '.$ef.' error found......<br/><br/>'.$err;
	}
	else{
		$h=array();
		foreach($_POST as $key=>$value){
			if($key!="ip"){
				array_push($h,$value);					
			}

		}
		rsort($h);
		$netip=1;
		for($i=0;$i<count($h);$i++){
			$host=$h[$i];
			$h[$i]++;
			for($j=0;$j<23;$j++){
				$x=2;
				for($k=1;$k<$j;$k++){
					$x*=2;
				}
				
				if($x>$h[$i]){
					$blck=$x;
					break;
				}
			}
			$block=$j;
			$prefix=32-$j;
			if($prefix>24){
				$oct=4;
			}
			else if($prefix>16 && $prefix<25){
				$oct=3;
			}
			else{
				$oct=2;
			}
			if($netip==1){
				$nip=$ip[0].'.'.$ip[1].'.'.$ip[2].'.'.$ip[3].'/'.$prefix;
				$netip++;
			}
			else{
				if($oct==4){
					if($ip[3]<255){
						$ip[3]++;
					}
					else{
						$ip[3]=0;
						$ip[2]++;
					}
				}
				else if($oct==3){
					$ip[2]++;
					$ip[3]=0;
				}
				else if($oct==2){
					$ip[1]++;
					$ip[2]=0;
					$ip[3]=0;
				}
				$nip=$ip[0].'.'.$ip[1].'.'.$ip[2].'.'.$ip[3].'/'.$prefix;
			}
			if($ip[3]>=255){
				if($ip[2]>=255){
					$ip[1]++;
				}
				else{
					$ip[2]++;
				}
			}
			else{
				$ip[3]++;
			}
			$fip=$ip[0].'.'.$ip[1].'.'.$ip[2].'.'.$ip[3];
			$remainder = $host % 256;
			$quotient =($host - $remainder)/256;
			if($oct==2){
				
			}
			else if($oct==3){
				$ip[2]+=$quotient;
				$ip[3]=$remainder;
			}
			else{
				$ip[2]+=$quotient;
				$ip[3]+=$remainder-1;
			}
			$lip=$ip[0].'.'.$ip[1].'.'.$ip[2].'.'.$ip[3];
			$y=explode(".",$nip);
			if($oct==2){
				
			}
			else if($oct==3){
				$ip[2]=$y[2];
				if($prefix==17){
					$ip[2]+=127;
					$submask="255.255.128.0";
				}
				else if($prefix==18){
					$ip[2]+=63;
					$submask="255.255.192.0";
				}
				else if($prefix==19){
					$ip[2]+=31;
					$submask="255.255.224.0";
				}
				else if($prefix==20){
					$ip[2]+=15;
					$submask="255.255.240.0";
				}
				else if($prefix==21){
					$ip[2]+=7;
					$submask="255.255.248.0";
				}
				else if($prefix==22){
					$ip[2]+=3;
					$submask="255.255.252.0";
				}
				else if($prefix==23){
					$ip[2]+=1;
					$submask="255.255.254.0";
				}
				else if($prefix==24){
					$ip[2]+=0;
					$submask="255.255.255.0";
				}
				$ip[3]=255;
			}
			
			else if($oct==4){
				$ip[3]=$y[3];
				if($prefix==25){
					$ip[3]+=127;
					$submask="255.255.255.128";
				}
				else if($prefix==26){
					$ip[3]+=63;
					$submask="255.255.255.192";
				}
				else if($prefix==27){
					$ip[3]+=31;
					$submask="255.255.255.224";
				}
				else if($prefix==28){
					$ip[3]+=15;
					$submask="255.255.255.240";
				}
				else if($prefix==29){
					$ip[3]+=7;
					$submask="255.255.255.248";
				}
				else if($prefix==30){
					$ip[3]+=3;
					$submask="255.255.255.252";
				}
				else if($prefix==31){
					$ip[3]+=1;
					$submask="255.255.255.254";
				}
				else if($prefix==32){
					$ip[3]+=0;
					$submask="255.255.255.255";
				}
			}
			$bip=$ip[0].'.'.$ip[1].'.'.$ip[2].'.'.$ip[3];
			$mask=explode(".",$submask);
			$mask1=255-$mask[0];
			$mask2=255-$mask[1];
			$mask3=255-$mask[2];
			$mask4=255-$mask[3];
			$wildmask=$mask1.".".$mask2.".".$mask3.".".$mask4;
			$str.='
			<tr>
				<td>'.$host.'</td>
				<td>'.$blck.'</td>
				<td>'.$nip.'</td>
				<td>'.$fip.'</td>
				<td>'.$lip.'</td>
				<td>'.$bip.'</td>
				<td>'.$submask.'</td>
				<td>'.$wildmask.'</td>
			</tr>';
	
		}
		echo '
		<table align="center" border="1.0" cellpadding="10" cellspacing="0">
			<tr style="background-color:#bfbfbf">
				<td>Host</td>
				<td>Block Size</td>
				<td>Network ip</td>
				<td>1st host ip</td>
				<td>last host ip</td>
				<td>Broadcast ip</td>
				<td>Subnet Mask</td>
				<td>Wildcard Mask</td>
			</tr>'.$str.'
		</table>';
	}

?>