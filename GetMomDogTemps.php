<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'authenticate.php';
include 'dbconnect.php';

$input = json_decode(authenticate(urldecode($_GET['session'])), true);
if ($input['error'] == 'auth error') {
    $error = array('error' => 'auth error');
    echo json_encode($error);
}
else{


$theMasterArray = array();

if ($db->connect_error)
{
    die("Can't connect");
}
else {
    $i = 0;
    $theMasterArray = array();
    $dogID = mysqli_real_escape_string($db,urldecode($_GET['dogID']));
    $dogData = $db->query(
    "SELECT *
    FROM Temperature 
    WHERE $dogID = DogID"
    );
    while ($result = $dogData->fetch_assoc()){
        if(strtotime($result["Time"]) = time()-5184000){
		$theMasterArray[$i] = $result;
		$theMasterArray[$i]["Time"] = strtotime($theMasterArray[$i]["Time"]);
		i++;
	}
    }
    echo json_encode($theMasterArray);
        $db->close();
}
}
?>
