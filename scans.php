<?php 

function scan($list,$counter,$listcount,$ranstring,$filename){

	$url = "http://localhost/lbemail/lbemail.php?email=".$list."&rr=".$ranstring;
	$curl = curl_init($url);
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	$tt = curl_exec($curl);
	curl_close($curl);


    // check if valid
    if(strpos($tt, "valid")){
    	$file = file($filename);
		$output = $file[0];
		unset($file[0]);
		file_put_contents($filename, $file);
        $result = "[".$counter."/".$listcount."] -> \033[34m".$list." -------> valid\033[0m\n";
        $myfile = fopen("valid-email.txt", "a+");
        fwrite($myfile, "$list\n");
        fclose($myfile);
    } else{
    	$file = file($filename);
		$output = $file[0];
		unset($file[0]);
		file_put_contents($filename, $file);
        $result = "[".$counter."/".$listcount."] -> \033[31m".$list." -------> invalid\033[0m\n";
        $myfile = fopen("invalid-email.txt", "a+");
        fwrite($myfile, "$list\n");
        fclose($myfile); 
    }

    return $result;
}


$emails = array_unique(file($argv[1], FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES));
$counter = 0;
$listcount = count($emails);
$filename = $argv[1];


foreach($emails as $email){
   $ranstring = bin2hex(openssl_random_pseudo_bytes(5));
   $list = trim(preg_replace('/[\t]+/', '', $email));
   $counter++;
   echo scan($list,$counter,$listcount,$ranstring,$filename);
}


?>