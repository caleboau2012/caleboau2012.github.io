<?php

/**
 * Class FileUpload
 * Author: Generaleye via odumuyiwaleye@yahoo.com
 */

//$image = new FileUpload('images/profile/',2048000);
//$status = $image->uploadImage($_FILES['image'],'one');
//echo json_encode($status);

class FileUpload {
    private $path;
    private $limit;
    private $file_extension_array = array("jpg","jpeg","png","gif");
    private $file_type_array = array("image/png","image/x-png","image/jpg","image/jpeg","image/pjpeg","image/gif");

    public function __construct() {

    }

    /**
     * @param String $path Path to the file
     * @param Integer $size_limit Maximum size limit in Bytes
     * @param String $file The File to upload
     * @param String $name The name to save the file with
     * @return Array mixed
     */
    public function uploadImage($path,$size_limit,$file,$name) {
        $this->path = $path;
        $this->limit = $size_limit;


        if (isset($file)) {
            //Error Occurred
            $filename = basename($file['name']);
            $ext = strtolower(substr($filename, strrpos($filename, '.') + 1));
        } else {
            $response['error'] = TRUE;
            $response['message'] = "Error: No File uploaded!";
            return $response;
        }

        if (((in_array($ext, $this->file_extension_array)) && ((in_array($file['type'], $this->file_type_array)) || ($file['type'] == "")))) {
            //Determine the path to which we want to save this file
            $newfilename = $name.".".$ext;
            $newname = $this->path.'/'.$newfilename;
        } else {
            $response['error'] = TRUE;
            $response['message'] = "Error: Only jpg, png and gif image files are accepted for upload";
            return $response;
        }

        if ($file["size"] > $this->limit) {
            $response['error'] = TRUE;
            $response['message'] = "Error: File too large";
            return $response;
        }

        //Attempt to move the uploaded file to it's new place
        if ((move_uploaded_file($file['tmp_name'], $newname))) {
            $response['error'] = FALSE;
            $response['filename'] = $newfilename;
            $response['size'] = $file['size'];
            $response['message'] = "Upload was Successful";
            return $response;
            
        } else {
            $response['error'] = TRUE;
            $response['message'] = "An Error Occurred";
            return $response;
        }
    }
}
?>