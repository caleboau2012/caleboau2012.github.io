<?php
require_once 'api/include/PassHash.php';
require_once 'api/include/DbHandler.php';
$db = new DbHandler();
if (isset($_GET['password']) && isset($_GET['confirm']) && isset($_GET['email'])) {
    $email = $_GET['email'];
    if ($_GET['password']==$_GET['confirm']) {
	$rEmail = $db->getUserByEmail($email);
        $active = $rEmail['active_status'];
        header('Location: http://ariya.ng/login');

        if ($active==1) {
            $db->resetPassword($_GET['confirm'],$_GET['email']);
        } else {
            echo "Your account has not been verified";
        }
    } else {
        echo "Passwords do not match";
    }

} else {
    header('Location: http://ariya.ng/login');
}

?>
