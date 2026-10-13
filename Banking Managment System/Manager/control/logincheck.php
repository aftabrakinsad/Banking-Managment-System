<?php
include("../control/managerprocess.php");

?>
<?php
require_once __DIR__ . '/../../config/activity.php';
$temname="";
$tempass = "";
$remember = false;
$accountno = rand(9999999, 1000000);
$status = 1;
if(isset($_POST["remember"]))
{
    $remember = true;
}

session_start();
 $error="";
// store session data
if (isset($_POST['submit'])) {
  
    if (empty($_POST['username']) || empty($_POST['password'])) {
        #$error = "Username or Password is invalid";
        }
        else
        {
        $username=$_POST['username'];
        $password=$_POST['password'];
        
        $connection = new db();
        $conobj=$connection->openConn();
        
        $userQuery=$connection->CheckUser($username,$password,"manager",$conobj);
        
        if ($userQuery->num_rows > 0) {
        $_SESSION["username"] = $username;
        $_SESSION["password"] = $password;
        log_activity('manager', $username, 'login');
        
           }


           $result=$connection->checkassignaccountno($username,"manager",$conobj);
           if ($result->num_rows>0) {
            $results=$connection->assignaccountno($username,$accountno,"manager",$conobj);
           
              }
////////////////////////////
              $statusupdate=$connection->checkactivestatus($username,"manager",$conobj);
           if ($statusupdate->num_rows>0) {
            $statusnew=$connection->assignactivestatus($username,$status,"manager",$conobj);
           
              }

         else {
        $error = "Username or Password is invalid";
        log_activity('manager', isset($_POST['username']) ? $_POST['username'] : '', 'login_failed');
        }
    

    if(!empty($_POST["remember"])){
        setcookie ("username",$_POST["username"],time()+ 86000);
        setcookie ("password",$_POST["password"],time()+ 86000);
        echo "";
    }
    else
    {
        setcookie("username","");
        setcookie("password","");
        echo "";
    }
    header("location: ../view/managerHomePage.php");
    

/*
else
{
    header("location: view/managerRegistration.php");
}
*/
 
}
}



?>