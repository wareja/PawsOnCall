<?php
authenticate('XamUpyJniQzJntrCLbFB'); //REMOVE
include 'dbconnect.php';
function authenticate($sessionKey){

    if ($db->connect_error)
    {
        die("Can't connect");
    }
    else {
        $session = $db->query("SELECT * FROM SessionKeys WHERE SessionKey = '$sessionKey'");
        $sessionrow = $session->fetch_assoc();
        if($session->num_rows == 1 && strtotime($sessionrow["Time"]) > time() - 3600){ //checks if session key valid and session last use <1hr ago
            $userID = $sessionrow["UserID"];
            $db->query("UPDATE SessionKeys SET SessionKey = '$sessionKey' Time = CURRENT_TIMESTAMP WHERE userID = '$userID'"); //updates session last used time
            $arr = array('userID' => $userID, 'sessionKey' => $sessionKey, 'error' => 'none');
	    return json_encode($arr);
        }
        else{
	    $error = array('error' => 'auth error');
            return json_encode($error);
        }
    }
    $db->close();
}
?>
