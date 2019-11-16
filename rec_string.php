<?php

ini_set('xdebug.var_display_max_depth', 5);
ini_set('xdebug.var_display_max_children', 256);
ini_set('xdebug.var_display_max_data', 10240);
ini_set("allow_url_fopen", true);




// 	// $str = file_get_contents('http://theory.phphtml.net');
// 	// var_dump($str);

// $str = file_get_contents('index.html');

// 	preg_match_all('#<title>(.+?)</title>#su', $str, $res);
// 	var_dump($res);

// 	preg_match_all('#<head>(.+?)</head>#su', $str, $res);
// 	var_dump($res);

// 	preg_match_all('#<body.*>(.+?)</body>#su', $str, $res);
// 	var_dump($res);

// 	echo '<br>';
// 		//Выведет '! e', а ожидалось '! qw x e':
// 	echo preg_replace('#a.+x#', '!', 'a23e4x qw x e'); 


/*	$html=file_get_contents ('http://itlifemsk.ru');
$url='itlifemsk.ru';
$vnut=[];
$vnech=[];
preg_match_all('~<a [^<>]*href=[\'"]([^\'"]+)[\'"][^<>]*>~si',$html, $matches);*/
// foreach ($matches[1] as $val) {
//     if (!preg_match("~^[^=]+://~", $val) || preg_match("~^[^://]+://(www\.)?".$url."~i", $val)) { $vnut[]=$val; }
//     else $vnech[]=$val;
// }

echo '<br>';
// print_r($str ='{Please,|Просто|Если сможете,} сделайте так, чтобы это{удивительное|крутое|простое|важное|бесполезное} тестовое предложение {изменялось{быстро|мгновенно|оперативно|правильно} случайным образом|менялось каждый раз}.');

print_r($str ='Важное {Попробуйте,|Просто|Если сможете,} сделайте так, чтобы это {удивительное|крутое|простое|важное|бесполезное} тестовое предложение {изменялось {быстро| мгновенно|оперативно|правильно} случайным образом|менялось каждый раз}.');


($str1 = 'Lorem ipsum {helicopter|bisical|{dolor|sit amet,|consectetur}} adipisicing elit. {Molestiae,| distinctio} fugit perferendis maxime quaerat perspiciatis fugiat, quod ea. {Accusantium}, {soluta}tyyu.');

// $arr_str = str_split($str);
// var_dump($arr_str);


// $charset = mb_detect_encoding($str);

// $str = iconv($charset, "UTF-8", $str);





$count = 0;

function divString($interString)
{
			// echo '<br><br>';
			// echo $interString;
			// echo '<br>mark $interString<br>';
	$count = 0;
	$exitString_arr =[];
	
	$i = 0;
	while ($i < strlen($interString)) {

		$char = substr($interString, $i, 1);


		if ($char!='{' and $char!='}' and $char!='|'){
			 $exitString .= $char;
		}

		if ($char == '|' and isset($exitString)){
			$exitString_arr[] = $exitString;
			$exitString = ' ';			
		}



		if ($char == '}') {
			
			// echo '<br><br>';
			// echo $exitString;
			// echo '<br>mark *}* $exitString<br>';
			// echo $i;

			$exitString .= ' ';
			$exitString_arr[] = $exitString;
			return $exitString_arr;
		}

		if ($char == '{') {

			// echo '<br><br>';
			// echo $exitString;
			// echo '<br>mark *{* $exitString<br>';
			$exitString.= ' ';
			$exitString_arr[] = $exitString;
			$exitString = '';
			$subString = substr($interString, $i+1);


			$count++;
			$exitString_arr[] = divString($subString);
			$count++;

			$i = search_size($exitString_arr, $len);
			
			// echo $i;
			// die();



		}
			if ($i == strlen($interString)-1) {
				// echo $exitString;
				$exitString_arr[] = $exitString;
				// var_dump($exitString_arr);
				$exitString = ' ';
				
		}

		$i++;
		// echo '<br>';
		// echo $i;
	}

	return $exitString_arr;
	

}

function search_size($data)
{
	$len = 0;
	foreach ($data as $value) {

		if (is_array($value)) {
			$len += search_size($value);
		}else{
			$len += strlen($value);
		}
	}
	return $len;
}

var_dump(divString($str));

?>