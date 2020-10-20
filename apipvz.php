<?php
// apipvz.php: paima iš lenteles "keliones2" paskutinius n ('kiek') į nurodytą miestą ('kur') įrašus 
// Jei kur nenurodyta =visi miestai, jei kiek nenurodyta=visi įrašai
//
//header("Content-Type: application/json; charset=UTF-8");
//header("Access-Control-Allow-Origin: *");  // atsakinėti bet kam
echo "Labas";die "neina";
$server = "localhost";
$user = "rimas";
$password = "Ohko6ooleeZ3koph";
$database= "rimas";
$lentele="keliones2";
/*	
	//paimti parametrų reikšmes iš užklausos
$miestas=$_GET['kur']; 
$kiek=$_GET['kiek'];
if (($miestas && !preg_match("#^[a-zA-ZĄČĘĖĮŠŲŪŽąčęėįšųūž]+$#", $miestas)) ||    // tik raidės arba tuščia
	($kiek!="" && (!preg_match("#^[0-9]+$#", $kiek) || $kiek ==0 ))){			// tik teigiamas sk arba tuščia
		$outp=array("Nekorektiški parametrai"=>"kur:".$miestas." kiek:".$kiek);
		http_response_code(400);
	goto end;
}
*/
$conn=new mysqli($server,$user,$password,$database);
if ($conn->connect_error){
	echo "Negaliu prisijungti prie MySQL";die;
	$outp=array("Negaliu prisijungti prie MySQL"=>$conn->connect_error);
	http_response_code(500);
	goto end;
}
$sql = ("SET CHARACTER SET utf8"); $conn->query($sql);// del lietuviškų raidžių
$miestas="Roma"; 
$kiek=2;
echo $miestas;die " 0";
// suformuojam sql užklausą pagal parametrus $miestas ir paskutinius $kiek įrašų
if (!empty($kiek))$sql="SELECT * FROM ( ";
else $sql="";
$sql= $sql."SELECT * FROM $lentele ";
if (!empty($miestas))$sql=$sql." WHERE kur='".$miestas."'";
if (!empty($kiek))$sql=$sql." ORDER BY id DESC LIMIT ".$kiek.") sub ORDER BY id ASC";
echo $sql;die " 1";
//$outp=$sql; //goto end;  //testavimui kaip atrodo sql užklausa

if (!$result = $conn->query($sql)){
	//$outp=array("Negaliu nuskaityti ". $lentele => $conn->error);
	echo "Negaliu nuskaityti ". $lentele => $conn->error;die " 3";
	http_response_code(500);
}else
	echo "kazkas rasta";die " 2";
	if (mysqli_num_rows($result)==0 ){
		$outp=array("Nėra kelionių į "=>$miestas);
		http_response_code(400);
	}else{
		$outp = $result->fetch_all(MYSQLI_ASSOC);
		http_response_code(200);
	}
end:
echo "rez<br>";
echo $outp;
//echo json_encode($outp);
?>