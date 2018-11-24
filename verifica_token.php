<?php
	$palavra=$_POST["palavra"];
	$process=$_POST["process"];
	$alfabet="abcdefghijklmnopqrstuvwxyz";
	$posicaolinha=1;
	$palavras=$_POST["palavras"];

	$matrizTable=array(array(1000),array(1000));
	$table=array(1000);

	$token=explode(" ", $palavras);
	$matrizSize=0;

//verifica o tamanho da matriz
	for($i=0; $i<sizeof($token);$i++){
		$trim=trim($token[$i]," ");
		$matrizSize += strlen($trim);
	}
	$matrizSize = $matrizSize + 3;
//monta a matriz colocando por default error em cada posição
	for($i=1; $i<$matrizSize;$i++){
		for($j=0; $j<27;$j++){
			$matrizTable[$i][$j]="error";
		}
	}

//atribui a letra da palavra a uma posição da matriz que ainda não está ocupada
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
			if($matrizTable[$nextLine][$alfabetPos] == "error"){
				$lastLine=$lastLine+1;
				$matrizTable[$nextLine][$alfabetPos]=$lastLine;
				$totalLine=$totalLine+1;
			}
			$nextLine=$matrizTable[$nextLine][$alfabetPos];

			if(intval(strlen($trim)-1)==$j){
				//guarda a próxima posição, que será usada para saber quando está em um estado final
				$table[$cont]=$nextLine;
				$cont=$cont+1;
			}
		}
	}

	$tamMatriz=$totalLine+2;
	$errorPosition=$tamMatriz-1;

	for($i=0; $i<strlen($palavra); $i++){
		$alfabetPos=strripos($alfabet, $palavra[$i])+1;
		if($palavra[$i]!=" "){
			if($alfabetPos!=" " && $process==true){
				if($matrizTable[$posicaolinha][$alfabetPos]!="error" && $process){
					$process=true;
					$posicaolinha=$matrizTable[$posicaolinha][$alfabetPos];
					$class = $posicaolinha;
					$posicaoColuna="p$class";
					$resposta=array("posicaolinha"=>$posicaolinha,"processa"=>$process,"posicaoColuna"=>$posicaoColuna);
				} else {
					$process=false;
					$resposta=array("posicaolinha"=>$alfabetPos,"processa"=>$process);
				}
			}else {
				$process=false;
		    	$resposta=array("posicaolinha"=>$errorPosition,"processa"=>$process,"posicaoColuna"=>$posicaoColuna);
		    }
		} else if ($palavra[$i]==" "){
			 	$final=false;
			 	for($j=0; $j<sizeof($table); $j++){
			 		if($table[$j]==$posicaolinha){
			 			$final=true;
			 		}
			 	}
			$resposta=array("posicaolinha"=>$errorPosition,"processa"=>$process,"final"=>$final,"posicaoColuna"=>$posicaoColuna);
		}
	}

	$jsonresposta=json_encode($resposta);
	echo $jsonresposta;
?>
