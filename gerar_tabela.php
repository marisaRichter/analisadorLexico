<?php
	$palavras=$_POST["palavras"];

	$matrizTable=array(array(1000),array(1000));
	$table=array(1000);

	$token=explode(" ", $palavras);
	$matrizSize=0;

	for($i=0; $i<sizeof($token);$i++){
		$trim=trim($token[$i]," ");
		$matrizSize=$matrizSize+strlen($trim);
	}

	$matrizSize = $matrizSize + 3;

	for($i=1; $i<$matrizSize;$i++){
		for($j=0; $j<27;$j++){
			$matrizTable[$i][$j]=" ";
		}
	}

	$lastLine=1;
	$totalLine=1;
	$nextLine=1;
	$cont=0;
	$alfabet="abcdefghijklmnopqrstuvwxyz";

	for($i=0; $i<sizeof($token);$i++){
		$nextLine=1;
		$trim=trim($token[$i]," ");
		for($j=0; $j<intval(strlen($trim)); $j++){
			$alfabetPos=strripos($alfabet, $trim[$j])+1;

			if($matrizTable[$nextLine][$alfabetPos] == " "){
				$lastLine=$lastLine+1;
				$matrizTable[$nextLine][$alfabetPos]=$lastLine;
				$totalLine=$totalLine+1;
			}

			$nextLine=$matrizTable[$nextLine][$alfabetPos];

			if(intval(strlen($trim)-1)==$j){
				//salva a próxima linha
				$table[$cont]=$nextLine;
				$cont=$cont+1;
			}
		}
	}

	$tamMatriz=$totalLine+1;
	$errorPosition=$tamMatriz-1;
//Monta a Tabela
	echo "<table border=1> ";
	echo "<tr>";

	for($i=96; $i<=122; $i++){
		$albafetConverter = chr($i);
		echo "<td> [$albafetConverter]</td>";
	}
	echo "</tr>";

	for($i=1; $i<$tamMatriz; $i++){
		echo "<tr id='$i'>";
		if($i==1){
		echo "<td>->p$i </td>";
		} else {
			$lineFinal="false";
			for($j=0; $j<sizeof($table); $j++){
				if($table[$j]==$i){
					$lineFinal="true";
				}
			}
			if($lineFinal=="true"){
				echo "<td class='fp$i'>*p$i </td>";
			}else{
				echo "<td> p$i </td>";
			}
		}

		for($j = 1; $j < 27; $j++){
			if($matrizTable[$i][$j] == " "){
					echo "<td></td>";
			} else {
				echo "<td class='p".$matrizTable[$i][$j]."'>p".$matrizTable[$i][$j]."</td>";
			}
		}
		echo "</tr>";
	}
	echo "</table>";
?>
