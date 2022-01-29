<?php
/**
 * Created by PhpStorm.
 * User: Kay Lee
 * Date: 28/06/14
 * Time: 10:39
 */

class update{

    var $dp;
    var $alias;
    var $status;
    var $exts = array(".jpg", ".jpeg", ".gif", ".png");

    function __construct(){
        require_once $_SERVER['DOCUMENT_ROOT'] . '/kopawee/root/databaseHandler.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/kopawee/root/config.php';

        if(isset($_POST['call_no']) && isset ($_POST['password'])){
            $file = explode(".", $_FILES["dp"]["name"]);
            $ext = end($file);

            $this->dp = time() . "." . $ext;
            $this->alias = $_POST['alias'];
            $this->status = $_POST['status'];
            $this->store();
        }
        else{
            $json = array("response"=>"-1", "error"=>"access denied");
            echo json_encode($json);
        }
    }

    public function store(){
        if (!$this->checkExt()) {
            $json = array("response"=>"-1", "error"=>'You cannot upload this file type!');
            echo json_encode($json);
        } else if (move_uploaded_file($_FILES['dp']['tmp_name'], "dps/" . $this->dp)) {
            $db = new databaseHandler(config::HOST, config::USERNAME, config::PASSWORD);
            $db->selectDatabase(config::DB_NAME);
            $call_no = $_POST['call_no'];

            $db->query("SELECT dp FROM otondo WHERE call_no = $call_no;");
            $result = $db->getResult();
            //var_dump($result);
            unlink("dps/" . $result['dp']);
            //echo $this->dp;

            $query = "UPDATE otondo
                SET dp = '$this->dp', alias = '$this->alias', status = '$this->status'
                WHERE call_no = $call_no;";

            $db->query($query);
            //$result = $db->getResult();
            $db->closeDb();

            if ($db->getQueryStatus()){
                $json = array("response"=>"1", "data"=>"Success, update successful");
                echo json_encode($json);
            }
            else{
                $json = array("response"=>"-1", "error"=>$db->getQueryStatus());
                echo json_encode($json);
            }
        } else {
            $json = array("response"=>"-1", "error"=>'There was an error uploading the file, please try again!');
            echo json_encode($json);
        }
    }

    public function checkExt(){
        return (in_array($this->getExt(), $this->exts) ? true : false);
    }

    public function getExt(){
        return strtolower(substr($this->dp, strpos($this->dp, "."), strlen($this->dp) - 1));
    }

}
    $update = new update();
?>
