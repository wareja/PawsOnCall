<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'authenticate.php';
$input = json_decode(authenticate('XamUpyJniQzJntrCLbFB'), true);
if ($input['error'] == 'auth error') {
    $error = array('error' => 'auth error');
    echo json_encode($error);
}
else{
$host = "localhost";
$username = "pawswhelp";
$password = "Ireallylikepuppies1!";
$db_name = "pawswhelpdb";
$MasterArray = array();
$db = mysqli_connect("$host","$username","$password","$db_name");

if ($db->connect_error)
{
    die("Can't connect");
}
else {
    $i = 0;
    $dog_name = mysqli_real_escape_string($db,urldecode($_GET['dog_name']));
    $userID = $input['userID'];
    $dog_data = $db->query(
    "SELECT d.id AS DogId, d.Name AS DogName, v.Name AS VolunteerName, d.Breed 
    FROM Volunteer AS v, Dogs AS d 
    WHERE d.name LIKE '%$dog_name%' AND d.Sex = 'F' AND d.VolunteerID = '$userID'"
    );
    while ($result = $dog_data->fetch_assoc()){
        $MasterArray[$i] = $result;
        $i++;
    }
    echo json_encode($MasterArray);
        $db->close();
}
}
?>
