<?php

// ini_set('xdebug.var_display_max_depth', 5);
// ini_set('xdebug.var_display_max_children', 256);
// ini_set('xdebug.var_display_max_data', 10240);
// ini_set("allow_url_fopen", true);


print_r($str ='{Попробуйте|Просто|Если сможете,} сделайте так, чтобы это {удивительное|крутое|простое|важное|бесполезное} тестовое предложение {изменялось {быстро| мгновенно|оперативно|правильно} случайным образом|менялось каждый раз}.');





function divString($interString, $semafor = 0)
{

	 $exit_arr =[];
	 $sign_arr =[];
	 $br_count_arr=[];
	 $br = 'breaked';
	 $sl = 'select';
	 $nr = 'normal';
	 $br_count = 0;
	$i = 0;
	while ($i++ < strlen($interString)) {

		$char = mb_substr($interString, $i, 1);


		if ($char!='{' and $char!='}' and $char!='|'){
			 $exitString .= $char;}


		if ($semafor == '{' and $char == '|'){
			$exit_arr[] = $exitString; $exitString = ''; $semafor = '|'; $sign_arr[] = $sl; continue;
		}
		if ($semafor == '}' and $char == '|'){
			$exit_arr[] = $exitString; $exitString = ''; $semafor = '|'; $sign_arr[] = $br;
			$br_count_arr[sizeof($sign_arr)-1]= $br_count--; continue;
		}
		if ($semafor == '|' and $char == '|'){
			$exit_arr[] = $exitString; $exitString = ''; $semafor = '|'; $sign_arr[] = $sl; continue;
		}



		if ($semafor == '{' and $char == '}') {			
			$exit_arr[] = $exitString; $exitString = ''; $semafor = '}'; $sign_arr[] = $nr;continue;
		}
		if ($semafor == '}' and $char == '}') {			
			$exit_arr[] = $exitString; $exitString = ''; $semafor = '}'; $sign_arr[] = $br;
			$br_count_arr[sizeof($sign_arr)-1]=$br_count--;continue;
		}
		if ($semafor == '|' and $char == '}') {			
			$exit_arr[] = $exitString; $exitString = ''; $semafor = '}'; $sign_arr[] = $sl;continue;
		}




		if ($semafor == '{' and $char == '{') {
			$exit_arr[] = $exitString; $exitString = ''; $semafor = '{'; $sign_arr[] = $br;
			$br_count_arr[sizeof($sign_arr)-1]=++$br_count;continue;
		}
		if ($semafor == '}' and $char == '{') {
			$exit_arr[] = $exitString; $exitString = ''; $semafor = '{'; $sign_arr[] = $nr;continue;
		}
		if ($semafor == '|' and $char == '{') {
			$exit_arr[] = $exitString; $exitString = ''; $semafor = '{'; $sign_arr[] = $br;
			$br_count_arr[sizeof($sign_arr)-1]=++$br_count;continue;
		}
		
	}

	$exit[] = $exit_arr;
	$exit[] = $sign_arr;
	$exit[] = $br_count_arr;
	
	return $exit;
}


function select($exitString, $sign_arr, $br_count_arr){

	for ($i = 0; $i<sizeof($sign_arr); $i++){
		if ($sign_arr[$i] == 'select'){
			$temp_arr[] = $i;	
		}else{
			$exitString2[] = $exitString[$i];
			$sign_arr2[] = $sign_arr[$i];
			if ($sign_arr[$i] == 'breaked') {
				$br_count_arr2[sizeof($sign_arr2)-1]= $br_count_arr[$i];
			}

		}


		if ($sign_arr[$i] == 'select' and $sign_arr[$i+1] != 'select'){


			$select_num = rand($temp_arr[0],$temp_arr[sizeof($temp_arr)-1]);
			$temp_arr = [];

			// echo $exitString[$select_num];
			// var_dump($exitString);
			$exitString2[] = $exitString[$select_num];	
			$sign_arr2[] = 'select';	
		}


	}

	$exit[]= $exitString2;
	$exit[]= $sign_arr2;
	$exit[]=$br_count_arr2;



	return $exit;

}


function breaked($exitString, $sign_arr, $br_count_arr){

	for ($i = 0; $i<sizeof($sign_arr); $i++){
		if ($sign_arr[$i] != 'breaked'){

			$exitString3[] = $exitString[$i];
			$sign_arr3[] = $sign_arr[$i];
			continue;
						
		}

		if ($sign_arr[$i] == 'breaked' and $sign_arr[$i+1] == 'select' and $sign_arr[$i+2] == 'breaked' and $br_count_arr[$i] == $br_count_arr[$i+2]){

			$exitString3[] = $exitString[$i].' '.$exitString[$i+1].' '.$exitString[$i+2];	
			$sign_arr3[] = 'select';	
			$i++;
			$i++;
			

			}else{
					if ($sign_arr[$i] == 'breaked') {

						$exitString3[] = $exitString[$i];
						$sign_arr3[] = $sign_arr[$i];
						$br_count_arr2[sizeof($sign_arr3)-1]= $br_count_arr[$i];
						var_dump($br_count_arr[$i]);

					}

				}
	}
	$exit[] = $exitString3;
	$exit[] = $sign_arr3;
	$exit[] = $br_count_arr2;

	return $exit;

}


function build_string($data)
{
	$result = '';
	foreach ($data as  $value) {
		$result.=$value;
	}
	return $result;
}




function string_from_mask($str){

	$exit = divString($str);
	build_string($exit[1]);

	while (strpos(build_string($exit[1]), 'selectselect') != false or strpos(build_string($exit[1]), 'breaked')) {
	  	$exit = select($exit[0], $exit[1], $exit[2]);
		$exit = breaked($exit[0], $exit[1], $exit[2]);
		
	  	} 
	var_dump($exit);
	echo(build_string($exit[0]));  

}

string_from_mask($str);








?>