<?php
ini_set("display_errors",1);
header('Access-Control-Allow-Origin: *');
require_once '../include/DbHandler.php';
require_once '../include/PassHash.php';
require '../libs/Slim/Slim.php';

define('ROOT_DIR', dirname(dirname(dirname(__FILE__))));

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();

// User Id from db - Global Variable
//$userId = NULL;

/**
 * For methods that require Auth
 * Adding Middle Layer to authenticate every request
 * Checking if the request has valid token as part of the parameters
 * @param \Slim\Route $route
 * @throws \Slim\Exception\Stop
 */
function authenticate(\Slim\Route $route) {
    // Getting request headers
    //$headers = apache_request_headers();
    $response = array();
    $app = \Slim\Slim::getInstance();
    $token = $app->request->params('token');

    // Verifying Authorization Header
    if (isset($token)) {
        $db = new DbHandler();
        if (!$db->isValidToken($token)) {
            // Token is not present in users table
            $response["error"] = TRUE;
            $response["message"] = "Access Denied. Invalid Token";
            echoResponse(401, $response);
            $app->stop();
        } else {
            global $userId;
            // get user primary key id
            $tox = $db->getUserByToken($token);
            $userId = $tox['user_id'];
        }
    } else {
        // Token is missing in header
        $response["error"] = TRUE;
        $response["message"] = "Token is missing";
        echoResponse(400, $response);
        $app->stop();
    }
}

/**
 * REGISTER AND LOGIN FUNCTIONS
 **/
$app->post('/register', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('fname','lname','email','password'));

    $response = array();
    $req = $app->request(); // Getting parameters
    // reading post params
    $first_name = $req->params('fname');
    $last_name = $req->params('lname');
    $email = $req->params('email');
    $password = $req->params('password');
    $phone = $req->params('phone');
    // validating email address
    validateEmail($email);

    $db = new DbHandler();
    $res = $db->createUser($first_name, $last_name, $email, $password, $phone);

    if ($res == REGISTRATION_SUCCESSFUL) {
        $user = $db->getUserByEmail($email);

        if ($user != NULL) {
            $response["error"] = FALSE;
            $response['email_address'] = $user['email_address'];
            $response['isVerified'] = FALSE;
            $response['created_time'] = $user['created_time'];
            $response["message"] = "Registration Successful";
        } else {
            // unknown error occurred
            $response['error'] = TRUE;
            $response['message'] = "An error occurred. Please try again";
        }
    } else if ($res == REGISTRATION_FAILED) {
        $response["error"] = TRUE;
        $response["message"] = "Oops! An error occurred while registering";
    } else if ($res == EMAIL_ALREADY_EXISTS) {
        $response["error"] = TRUE;
        $response["message"] = "Sorry, this Email Address already exists";
    }
    // echo json response
    echoResponse(200, $response);
});

$app->post('/login', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('email', 'password'));

    // reading post params
    $req = $app->request();

    $email = $req->params('email');
    $password = $req->params('password');
    // validating email address
    validateEmail($email);
    $response = array();

    $db = new DbHandler();
    // check for correct email and password
    $login = $db->checkLogin($email, $password);
    if ($login == LOGIN_SUCCESSFUL) {
        // get the user by email
        $user = $db->getUserByEmail($email);

        if ($user != NULL) {
            $response["error"] = FALSE;
            $response['email'] = $user['email_address'];
            $response['token'] = $user['token'];
            $response['isVerified'] = TRUE;
            $response['created_time'] = $user['created_time'];
            $response['message'] = "Login Successful";
        } else {
            // unknown error occurred
            $response['error'] = TRUE;
            $response['message'] = "An error occurred. Please try again";
        }
    } elseif ($login == USER_NOT_VERIFIED) {
        // user not verified
        $response['error'] = TRUE;
        $response['isVerified'] = FALSE;
        $response['message'] = 'You have not been Verified';
    } else {
        // user credentials are wrong
        $response['error'] = TRUE;
        $response['message'] = 'Incorrect Email Address and/or Password.';
    }

    echoResponse(200, $response);
});


$app->post('/forgotpassword', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('email'));

    // reading post params
    $req = $app->request();

    $email = $req->params('email');
    // validating email address
    validateEmail($email);
    $response = array();

    $db = new DbHandler();
    // check for correct email and password
    $forgot = $db->forgotPassword($email);

    if ($forgot == TRUE) {
        $response["error"] = FALSE;
        $response['message'] = "Link has been sent to your Email Address";
    } else {
        $response['error'] = TRUE;
        $response['message'] = "An error occurred. Please try again";
    }

    echoResponse(200, $response);
});

$app->post('/resendverification', function() use ($app) {
    // check for required params
    verifyRequiredParams(array('email'));

    // reading post params
    $req = $app->request();

    $email = $req->params('email');
    // validating email address
    validateEmail($email);
    $response = array();

    $db = new DbHandler();
    // check for correct email and password
    $forgot = $db->resendVerification($email);

    if ($forgot == TRUE) {
        $response["error"] = FALSE;
        $response['message'] = "Verification Link has been sent to your Email Address";
    } elseif ($forgot == FALSE) {
        $response['error'] = TRUE;
        $response['message'] = "Your account has already been verified";
    } else {
        $response['error'] = TRUE;
        $response['message'] = "An error occurred. Please try again";
    }

    echoResponse(200, $response);
});


$app->post('/changepassword', 'authenticate', 'changePass');
$app->get('/getprofile', 'authenticate', 'getProfile');
$app->post('/editprofile', 'authenticate', 'editProfile');

$app->get('/myproperties', 'authenticate', 'myProperties');
$app->get('/getmyproperty', 'authenticate', 'getMyProperty');
$app->post('/addeditproperty', 'authenticate', 'addEditProperty');
$app->post('/deleteproperty', 'authenticate', 'deleteProperty');
$app->post('/addpropertyimage', 'addPropertyImage');
$app->post('/deletepropertyimage', 'authenticate', 'deletePropertyImage');

$app->post('/addevent', 'authenticate', 'addEvent');
$app->post('/removeevent', 'authenticate', 'removeEvent');

$app->get('/listing', 'listAll');
$app->get('/listing/:id', 'listSingle');
$app->get('/latestSix', 'latestSix');

$app->post('/bidbook', 'authenticate', 'bidBook');
$app->get('/datedetails', 'authenticate', 'dateDetails');

$app->get('/notifications', 'authenticate', 'notifications');
$app->post('/notificationaction', 'authenticate', 'notificationAction');

$app->post('/addreview', 'authenticate', 'addReview');
$app->get('/getreview', 'getReview');

$app->get('/search', 'search');
$app->post('/pay', 'authenticate', 'pay');
$app->post('/cancelpayment', 'authenticate', 'cancelPayment');

$app->post('/contact', 'contact');

$app->get('/elapse', 'elapse');
//$app->get('/testpost', 'testPost');

$app->run();


function changePass() {
    $app = \Slim\Slim::getInstance();
    verifyRequiredParams(array('oldpassword', 'newpassword'));

    $req = $app->request(); // Getting parameters
    $old = $req->params('oldpassword');
    $new = $req->params('newpassword');
    $token = $req->params('token');
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];
    $uid = $db->getUserById($userId);
    $email = $uid['email_address'];

    // check for correct email and password
    $login = $db->checkLogin($email, $old);
    if ($login == LOGIN_SUCCESSFUL) {
        if(!($old==$new)) {
            $change = $db->changePassword($userId, $new);
            $response = array();
            if ($change == TRUE) {
                $response["error"] = FALSE;
                $response['message'] = "Password has been Updated";
            } else {
                // unknown error occurred
                $response['error'] = TRUE;
                $response['message'] = "An error occurred. Please try again";
            }
        } else {
            // old and new passwords are the same
            $response['error'] = TRUE;
            $response['message'] = 'Pick a different password';
        }

    } else {
        // user credentials are wrong
        $response['error'] = TRUE;
        $response['message'] = 'Incorrect Old Password';
    }
    echoResponse(200, $response);
}

function getProfile() {
    $app = \Slim\Slim::getInstance();
    //verifyRequiredParams(array('apikey'));
    $req = $app->request(); // Getting parameters
    $token = $req->params('token');

    $db = new DBHandler();
    $tox = $db->getUserByToken($token);
    $id = $tox['user_id'];

    $profile = $db->getProfileById($id,IMAGE_URL_USERS);
    $response = array();
    if ($profile != NULL) {
        $response["error"] = FALSE;
        $response['profile'] = $profile;
        //$response['profile'] = intval($profile['user_id']);
//        foreach ($profile as $key => $value) {
//            $response[$key] = $value;
//        }
    } else {
        // unknown error occurred
        $response['error'] = TRUE;
        $response['message'] = "An error occurred. Please try again";
    }
    echoResponse(200, $response);
}

function editProfile() {
    require_once ('../include/FileUpload.php');
    $app = \Slim\Slim::getInstance();
    $response = array();

    $req = $app->request(); // Getting parameters
    $fname = $req->params('fname');
    $lname = $req->params('lname');
    $street = $req->params('street');
    $city = $req->params('city');
    $state = $req->params('state');
    $country = $req->params('country');
    $cname = $req->params('cname');
    $cstreet = $req->params('cstreet');
    $ccity = $req->params('ccity');
    $cstate = $req->params('cstate');
    $ccountry = $req->params('ccountry');
    $account_number = $req->params('accnum');
    $bank_code = $req->params('bankcode');

    $token = $app->request->params('token');
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];
    $profile_pic = $tox['profile_picture'];

    if (!empty( $_FILES ) && isset($_FILES)) {
        $image = new FileUpload();
        if ($profile_pic=='user_default.png') {
            $new_profile_pic = $userId.'0'.time();
        } else {
            $new_profile_pic = $profile_pic;
            // $filename has the file name you have under the picture
            $temp = explode( '.', $new_profile_pic );
            $extx = array_pop( $temp );
            $new_profile_pic = implode( '.', $temp );
        }
        $status = $image->uploadImage(ROOT_DIR . '/images/users/', 2048000, $_FILES['avatar'], $new_profile_pic);

        if ($status['error'] == FALSE) {
            $filename = $status['filename'];
            $response['error'] = FALSE;
            $update = $db->editProfile($userId, $fname, $lname, $filename, $street, $city, $state, $country, $cname, $cstreet, $ccity, $cstate, $ccountry, $account_number, $bank_code);
            $response['message'] = "Your profile has been Updated";
        } else {
            $response['error'] = TRUE;
            $update = $db->editProfile($userId, $fname, $lname, $profile_pic, $street, $city, $state, $country, $cname, $cstreet, $ccity, $cstate, $ccountry, $account_number, $bank_code);
            $response['message'] = $status['message'];
        }
    } else {
        $response['error'] = FALSE;
        $update = $db->editProfile($userId, $fname, $lname, $profile_pic, $street, $city, $state, $country, $cname, $cstreet, $ccity, $cstate, $ccountry, $account_number, $bank_code);
        $response['message'] = "Error: No file uploaded";
    }


    if ($update == TRUE) {
        //$response["error"] = FALSE;
        //$response['message'] = "Your profile has been Updated";
    } else {
        // unknown error occurred
        $response['error'] = TRUE;
        $response['message'] = "An error occurred. Please try again";
    }
    echoResponse(200, $response);
}


function myProperties() {
    $app = \Slim\Slim::getInstance();

    $token = $app->request->params('token');
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];

    $properties = $db->getMyProperties($userId,IMAGE_URL_PROPERTIES);
    $response = array();
    if ($properties != NULL) {
        $response["error"] = FALSE;
        $response['my_properties'] = $properties;
    } else {
        // unknown error occurred
        $response['error'] = TRUE;
        $response['message'] = "An error occurred. Please try again";
    }
    echoResponse(200, $response);
}

function getMyProperty() {
    $app = \Slim\Slim::getInstance();

    $property_id = $app->request->params('property_id');
    $token = $app->request->params('token');
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];

    $initProperty = $db->getPropertyDetails($property_id);
    $pState = $initProperty['active_status'];
    $pOwner = $initProperty['owner_id'];
    $response = array();

    if ($pState==1) {
        if ($pOwner==$userId) {
            $property = $db->getMyProperty($userId,$property_id,IMAGE_URL_PROPERTIES);

            if ($property != NULL) {
                $response["error"] = FALSE;
                $response['property'] = $property;
            } else {
                // unknown error occurred
                $response['error'] = TRUE;
                $response['message'] = "An error occurred. Please try again";
            }
        } else {
            $response['error'] = TRUE;
            $response['message'] = "Property does not belong to you";
        }
    } elseif ($pState==2) {
        $response['error'] = TRUE;
        $response['message'] = "Property does not exist";
    } else {
        $response['error'] = TRUE;
        $response['message'] = "Invalid Property";
    }

    echoResponse(200, $response);
}

function addEditProperty() {
    $app = \Slim\Slim::getInstance();

    $req = $app->request(); // Getting parameters
    $property_id = $req->params('property_id');

    $name = $req->params('name');
    $category = $req->params('category');
    $description = $req->params('description');

    $street = $req->params('street');
    $city = $req->params('city');
    $state = $req->params('state');
    $country = $req->params('country');

    $latitude = $req->params('latitude');
    $longitude = $req->params('longitude');

    $capacity = $req->params('capacity');
    $booking_price = $req->params('booking_price');
    $min_bid_price = $req->params('min_bid_price');

    $security = $req->params('security');
    $power = $req->params('power');
    $water = $req->params('water');
    $accessibility = $req->params('accessibility');

    $ac = booleanToStringAndViceVersa($req->params('ac'));
    $pool = booleanToStringAndViceVersa($req->params('pool'));
    $bar = booleanToStringAndViceVersa($req->params('bar'));
    $internet = booleanToStringAndViceVersa($req->params('internet'));
    $bpower = booleanToStringAndViceVersa($req->params('bpower'));
    $parking = booleanToStringAndViceVersa($req->params('parking'));
    $restroom = booleanToStringAndViceVersa($req->params('restroom'));

    $token = $app->request->params('token');
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];
    $response = array();

    if ($property_id == (NULL || "")) {
        $property = $db->addProperty($userId,$name,$category,$description,$street,$city,$state,$country,$latitude,$longitude,$capacity,$booking_price,$min_bid_price,$security,$power,$water,$accessibility,$ac,$pool,$bar,$internet,$bpower,$parking,$restroom);
            if ($property != NULL) {
                $response["error"] = FALSE;
                $response['message'] = "Property was Added Successfully";
                $response['property_id'] = $property;
            } else {
                $response["error"] = TRUE;
                $response['message'] = "An error occurred. Please try again";
            }

    } else {
        $initProperty = $db->getPropertyDetails($property_id);
        $pState = $initProperty['active_status'];
        $pOwner = $initProperty['owner_id'];

        if ($pState==1) {
            if ($pOwner==$userId) {
                $property = $db->editProperty($userId,$property_id,$name,$category,$description,$street,$city,$state,$country,$latitude,$longitude,$capacity,$booking_price,$min_bid_price,$security,$power,$water,$accessibility,$ac,$pool,$bar,$internet,$bpower,$parking,$restroom);

                if ($property != NULL) {
                    $response["error"] = FALSE;
                    $response['message'] = "Property was Edited Successfully";
                    $response['property_id'] = $property;
                } else {
                    // unknown error occurred
                    $response["error"] = TRUE;
                    $response['message'] = "An error occurred. Please try again";
                }
            } else {
                $response["error"] = TRUE;
                $response['message'] = "Property does not belong to you";
            }
        } elseif ($pState==2) {
            $response["error"] = TRUE;
            $response['message'] = "Property does not exist";
        } else {
            $response["error"] = TRUE;
            $response['message'] = "Invalid Property";
        }

    }

    echoResponse(200, $response);
}

function deleteProperty() {
    $app = \Slim\Slim::getInstance();

    $req = $app->request(); // Getting parameters
    $property_id = $req->params('property_id');
    $token = $app->request->params('token');
    $db = new DbHandler();
    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];
    $response = array();

    $initProperty = $db->getPropertyDetails($property_id);
    $pState = $initProperty['active_status'];
    $pOwner = $initProperty['owner_id'];

    if ($pState==1) {
        if ($pOwner==$userId) {
            $property = $db->deleteProperty($property_id);

            if ($property == TRUE) {
                $response["error"] = FALSE;
                $response['message'] = "Property has been Deleted Successfully";
            } else {
                // unknown error occurred
                $response["error"] = TRUE;
                $response['message'] = "An error occurred. Please try again";
            }
        } else {
            $response["error"] = TRUE;
            $response['message'] = "Property does not belong to you";
        }
    } elseif ($pState==2) {
        $response["error"] = TRUE;
        $response['message'] = "Property does not exist";
    } else {
        $response["error"] = TRUE;
        $response['message'] = "Invalid Property";
    }

    echoResponse(200, $response);
}

function addPropertyImage() {
    require_once ('../include/FileUpload.php');
    $app = \Slim\Slim::getInstance();

    $req = $app->request(); // Getting parameters
    $property_id = $req->params('property_id');
//    $token = $app->request->params('token');
    $db = new DbHandler();
//    $tox = $db->getUserByToken($token);
//    $userId = $tox['user_id'];
    $response = array();

            if (!empty( $_FILES ) && isset($_FILES)) {
                $image = new FileUpload();
                $status = $image->uploadImage(ROOT_DIR . '/images/properties/', 2048000, $_FILES['file'], $property_id.'_'.rand(1,9).rand(1,9).rand(1,9).rand(1,9).rand(1,9).'_'.time());

                if ($status['error'] == FALSE) {
                    $filename = $status['filename'];
                    $add = $db->addPropertyImage($property_id, $filename);

                } else {
                    $response['error'] = TRUE;
                    $response['message'] = $status['message'];
                }
            } else {
                $response['error'] = TRUE;
                $response['message'] = "Error: No file uploaded";
            }


    echoResponse(200, $response);
}

function deletePropertyImage() {
    $app = \Slim\Slim::getInstance();

    $req = $app->request(); // Getting parameters
    $token = $app->request->params('token');
    $property_id = $req->params('property_id');
    $image_id = $req->params('image_id');
    $db = new DbHandler();

    $response = array();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];

    $initProperty = $db->getPropertyDetails($property_id);
    $pState = $initProperty['active_status'];
    $pOwner = $initProperty['owner_id'];

    if ($pState==1) {
        if ($pOwner==$userId) {
            $image = $db->getAPropertyImageWithId($property_id,$image_id);
            if ($image != NULL) {
                $response['message']=$image['url'];
                //$response["error"] = FALSE;
                //$response['property'] = $delete;
                if(@unlink(ROOT_DIR.'/images/properties/'.$image['url'])) {
                    if ($db->deletePropertyImage($property_id,$image_id) == TRUE) {
                        $response['error'] = FALSE;
                        $response['message'] = "Image has been Deleted";
                    } else {
                        $response['error'] = TRUE;
                        $response['message'] = "An error occurred";
                    }
                } else {
                    $response['error'] = TRUE;
                    $response['message'] = "Image could not be Deleted";
                }
            } else {
                // unknown error occurred
                $response['error'] = TRUE;
                $response['message'] = "Image doesn't Exist";
            }
        } else {
            $response['error'] = TRUE;
            $response['message'] = "You cannot delete this image because the property does not belong to you";
        }
    } elseif ($pState==2) {
        $response['error'] = TRUE;
        $response['message'] = "Property does not exist";
    } else {
        $response['error'] = TRUE;
        $response['message'] = "Invalid Property";
    }

    echoResponse(200, $response);
}

function addEvent() {
    $app = \Slim\Slim::getInstance();

    $property_id = $app->request->params('property_id');

    $title = $app->request->params('title');
    $date = $app->request->params('date');
    $token = $app->request->params('token');
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];

    $initProperty = $db->getPropertyDetails($property_id);
    $pState = $initProperty['active_status'];
    $pOwner = $initProperty['owner_id'];
    $response = array();

    if ($pState==1) {
        if ($pOwner==$userId) {
            $event = $db->addEvent($userId,$property_id,$title,$date);

            if ($event != NULL) {
                $response["error"] = FALSE;
                $response['event_id'] = $event;
            } else {
                // unknown error occurred
                $response['error'] = TRUE;
                $response['message'] = "An error occurred. Please try again";
            }
        } else {
            $response['error'] = TRUE;
            $response['message'] = "Property does not belong to you";
        }
    } elseif ($pState==2) {
        $response['error'] = TRUE;
        $response['message'] = "Property does not exist";
    } else {
        $response['error'] = TRUE;
        $response['message'] = "Invalid Property";
    }

    echoResponse(200, $response);
}

function removeEvent() {
    $app = \Slim\Slim::getInstance();

    $property_id = $app->request->params('property_id');
    $event_id = $app->request->params('event_id');
    $token = $app->request->params('token');
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];

    $initProperty = $db->getPropertyDetails($property_id);
    $pState = $initProperty['active_status'];
    $pOwner = $initProperty['owner_id'];
    $response = array();

    if ($pState==1) {
        if ($pOwner==$userId) {
            $details = $db->getPaymentDetails($event_id);
            if ($details['user_id']==$userId && $details['price']=='0' && $details['status']=='closed') {
                $event = $db->removeEvent($userId,$property_id,$event_id);

                if ($event == TRUE) {
                    $response["error"] = FALSE;
                    $response['message'] = "Delete Successful";
                } else {
                    // unknown error occurred
                    $response['error'] = TRUE;
                    $response['message'] = "An error occurred. Please try again";
                }
            } else {
                $response['error'] = TRUE;
                $response['message'] = "You can't remove this event!!";
            }

        } else {
            $response['error'] = TRUE;
            $response['message'] = "Property does not belong to you";
        }
    } elseif ($pState==2) {
        $response['error'] = TRUE;
        $response['message'] = "Property does not exist";
    } else {
        $response['error'] = TRUE;
        $response['message'] = "Invalid Property";
    }

    echoResponse(200, $response);
}


function listAll() {
    $app = \Slim\Slim::getInstance();

    //$token = $app->request->params('token');
    $db = new DbHandler();

    //$tox = $db->getUserByToken($token);
    //$userId = $tox['user_id'];

    $properties = $db->listAll(IMAGE_URL_PROPERTIES);
    $response = array();
    if ($properties != NULL) {
        $response["error"] = FALSE;
        $response = array_merge($response,$properties);
    } else {
        // unknown error occurred
        $response['error'] = TRUE;
        $response['message'] = "An error occurred. Please try again";
    }
    echoResponse(200, $response);
}

function listSingle($property_id) {
    $app = \Slim\Slim::getInstance();

//    $property_id = $app->request->params('property_id');
    $token = $app->request->params('token');
    $db = new DbHandler();

    $initProperty = $db->getPropertyDetails($property_id);
    $pState = $initProperty['active_status'];
    $pOwner = $initProperty['owner_id'];
    $response = array();

    if ($pState==1) {
        $property = $db->listSingle($property_id,IMAGE_URL_PROPERTIES);

        if ($property != NULL) {
            $response["error"] = FALSE;
            $response['property'] = $property;

            if ($token != NULL) {
                $tox = $db->getUserByToken($token);
                $userId = $tox['user_id'];
                if ($pOwner==$userId) {
                    $response['property']['isOwner'] = TRUE;
                } else {
                    $response['property']['isOwner'] = FALSE;
                }
            } else {
                $response['property']['isOwner'] = FALSE;
            }
//
        } else {
            // unknown error occurred
            $response['error'] = TRUE;
            $response['message'] = "An error occurred. Please try again";
        }

    } elseif ($pState==2) {
        $response['error'] = TRUE;
        $response['message'] = "Property does not exist";
    } else {
        $response['error'] = TRUE;
        $response['message'] = "Invalid Property";
    }

    echoResponse(200, $response);
}


function latestSix() {
//    $app = \Slim\Slim::getInstance();

//    $token = $app->request->params('token');
    $db = new DbHandler();

//    $tox = $db->getUserByToken($token);
//    $userId = $tox['user_id'];

    $latest = $db->latestSix(IMAGE_URL_PROPERTIES);
    $response = array();
    if ($latest != NULL) {
        $response["error"] = FALSE;
        $response['latest'] = $latest;
    } else {
        // unknown error occurred
        $response['error'] = TRUE;
        $response['message'] = "An error occurred. Please try again";
    }
    echoResponse(200, $response);
}

function bidBook() {
    $app = \Slim\Slim::getInstance();
    verifyRequiredParams(array('property_id','date','type', 'price'));

    $req = $app->request(); // Getting parameters
    $token = $req->params('token');
    $property_id = $req->params('property_id');
    $name = $req->params('title');
    $date = $req->params('date');
    $type = $req->params('type');
    $price = $req->params('price');
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];
    $status = 1; //In-progress

    $initProperty = $db->getPropertyDetails($property_id);
    $pState = $initProperty['active_status'];
    $pPrice = $initProperty['booking_price'];
    $pOwner = $initProperty['owner_id'];
    $response = array();

    if ($pState==1) {

        $bid = $db->getDatesBidorBook($property_id,$date,1);
        $book = $db->getDatesBidorBook($property_id,$date,2);

        if ($bid['status_id']==4 || $book['status_id']==4) {
            //Bid or Book has been closed
            $response['error'] = TRUE;
            $response['message'] = "Property is unavailable";
            $response['status'] = "closed";

        } else {

            if ($bid['status_id']==2 || $book['status_id']==2) {
                //Bid or Book has been accepted
                $response['error'] = TRUE;
                $response['message'] = "Property is unavailable";
                $response['status'] = "accepted";

            } else {
                //Bid or Book is In-progress or Declined
                if ($type=='bid') {

                    //$type == 'bid' ? $type_id = 1 : $type_id = 2;
                    $type_id = 1;

                    //$status_id = $bid['status_id'];
                    if ($bid['status_id']==1) {
                        //in-progress
                        $bid_id = $bid['event_id'];
                        $curr_price = $db->getCurrentBidPrice($bid_id,$date);
                        if ($price > $curr_price['price']) {
                            $race_id = $db->addRace($userId,$bid_id,$name,$date,$price,$status);
                            $db->insertBidBookNotification($pOwner,$userId,$race_id,$type_id);
                        } else {
                            $race_id = "none";
                        }
                    } elseif ($bid['status_id']==3 || $bid['status_id']==NULL) {
                        $bid_id = $db->addEvent($userId,$property_id,$name,$date,$type_id,$price,$status);
                        $race_id = $db->addRace($userId,$bid_id,$name,$date,$price,$status);
                        $db->insertBidBookNotification($pOwner,$userId,$race_id,$type_id);

                    }

                    if ($race_id == "none") {
                        $response['error'] = TRUE;
                        $response['message'] = "Bid Price cannot be lower than the Current Bid Price";
                    } elseif ($race_id != NULL) {
                        $response["error"] = FALSE;
                        $response["type"] = $type;
                        $response['race_id'] = $race_id;

                    } else {
                        // unknown error occurred
                        $response['error'] = TRUE;
                        $response['message'] = "An error occurred. Please try again";
                    }
                } elseif ($type=='book') {
                    $type_id = 2;
                    if ($book['status_id']==1) {
                        //in-progress
                        $book_id = $book['event_id'];
                        $race_id = $db->addRace($userId,$book_id,$name,$date,$price,$status);
                        $db->insertBidBookNotification($pOwner,$userId,$race_id,$type_id);
                    } elseif ($book['status_id']==3 || $book['status_id']==NULL) {
                        $book_id = $db->addEvent($userId,$property_id,$name,$date,$type_id,$pPrice,$status);
                        $race_id = $db->addRace($userId,$book_id,$name,$date,$pPrice,$status);
                        $db->insertBidBookNotification($pOwner,$userId,$race_id,$type_id);
                    }

                    //$bidbook_id = $db->addEvent($userId,$property_id,$name,$date,$type_id,$price,$status);

                    if ($race_id != NULL) {
                        $response["error"] = FALSE;
                        $response["type"] = $type;
                        $response['race_id'] = $race_id;

                    } else {
                        // unknown error occurred
                        $response['error'] = TRUE;
                        $response['message'] = "An error occurred. Please try again";
                    }

                } else {
                    $response['error'] = TRUE;
                    $response['message'] = "Unknown Type";
                }
            }
        }

    } elseif ($pState==2) {
        $response['error'] = TRUE;
        $response['message'] = "Property does not exist";
    } else {
        $response['error'] = TRUE;
        $response['message'] = "Invalid Property";
    }

    echoResponse(200, $response);
}

function dateDetails() {
    $app = \Slim\Slim::getInstance();

    $req = $app->request(); // Getting parameters
    $token = $req->params('token');
    $property_id = $req->params('property_id');
    $date = $req->params('date'); //format: YYYY-MM-DD
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];
//    $status = 1; //pending

    $initProperty = $db->getPropertyDetails($property_id);
    $pState = $initProperty['active_status'];
    $pOwner = $initProperty['owner_id'];
    $response = array();

    if ($pState==1) {

        $details = $db->dateDetails($property_id,$date);
        $response = array();
        if ($details != NULL) {
            if ($pOwner==$userId) {
                $details['owner'] = TRUE;
            } else {
                $details['owner'] = FALSE;
            }

            $response["error"] = FALSE;
            $response['details'] = $details;

        } else {
            // unknown error occurred
            $response['error'] = TRUE;
            $response['message'] = "An error occurred. Please try again";
        }

    } elseif ($pState==2) {
        $response['error'] = TRUE;
        $response['message'] = "Property does not exist";
    } else {
        $response['error'] = TRUE;
        $response['message'] = "Invalid Property";
    }




    echoResponse(200, $response);
}


function notifications() {
    $app = \Slim\Slim::getInstance();

//    $req = $app->request(); // Getting parameters
    $token = $app->request->params('token');
    $marker = $app->request->params('marker');
    $type = $app->request->params('type');
    $db = new DbHandler();
    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];
    $response = array();

    if (isset($marker) && isset($type)) {
        $notifications = $db->getNotifications($userId,$marker,$type);
    } else {
        $notifications = $db->getNotifications($userId);
    }

    $response["error"] = FALSE;
    $response['notifications'] = $notifications;


    echoResponse(200, $response);
}


function notificationAction() {
    require_once '../libs/sendgrid-php/sendgrid-php.php';
    require_once '../include/SendGridEmail.php';
    $app = \Slim\Slim::getInstance();
    $sendEmail = new SendGridEmail();

//    $req = $app->request(); // Getting parameters
    $token = $app->request->params('token');
    $notification_id = $app->request->params('notification_id');
    $status = $app->request->params('status');
    $db = new DbHandler();
    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];
    $response = array();

    if ($status=='accepted' || $status=='declined') {
        if ($status == 'accepted') {
            $status_id = 2;
        } elseif ($status == 'declined') {
            $status_id = 3;
        }
        $notification = $db->getNotification($notification_id);
        $notification_type = $notification['type'];
        $notification_subject_id = $notification['subject_id'];
        if ($notification_type != NULL) {
            if ($notification_type == 'bid_closed') {
                $bid_accepted_id = 5;
                $bid_declined_id = 6;


                $db->updateNotificationStatus($userId,$notification_id,$status_id);
                $db->updateRaceStatus($notification_subject_id, $status_id);
                $race = $db->getRaceDetails($notification_subject_id);
                if ($status_id == 2) {

                    $db->insertNotification($userId,$notification_subject_id,10);


                    $highest = $db->getHighestBidder($race['bid_book_id']);
                    $db->updateBidBook($highest['bid_book_id'],$highest['user_id'],$highest['event_name'],$highest['event_date'], $highest['price'],$highest['bid_book_status_id']);
                    $db->insertNotification($highest['user_id'],$highest['bid_book_race_id'],$bid_accepted_id);
                    $db->openTicket($highest['bid_book_id'],$highest['price']);
                    $sendEmail->bidWinner($highest['email_address'],$highest['first_name']);

                    $others = $db->getDeclinedBidders($race['bid_book_id'], $highest['user_id']);
                    $others_length = count($others);
                    for ($j=0;$j<$others_length;$j++) {
                        $db->insertNotification($others[$j]['user_id'],$highest['bid_book_race_id'],$bid_declined_id);
                        $sendEmail->bidLosers($others[$j]['email_address'],$others[$j]['first_name']);
                    }

                } elseif ($status_id == 3) {
                    $db->insertNotification($userId,$notification_subject_id,11);

                    $all_bidders = $db->getAllBidders($race['bid_book_id']);
                    $all_bidders_length = count($all_bidders);
                    for ($k=0;$k<$all_bidders_length;$k++) {
                        $db->insertNotification($all_bidders[$k]['user_id'],$all_bidders[$k]['bid_book_race_id'],$bid_declined_id);
                        $sendEmail->bidLosers($all_bidders[$k]['email_address'],$all_bidders[$k]['first_name']);
                    }
                }


            } elseif ($notification_type == 'book') {
                $book_accepted_id = 7;
                $book_declined_id = 8;

                $db->updateNotificationStatus($userId,$notification_id,$status_id);
                $db->updateRaceStatus($notification_subject_id, $status_id);
                $race = $db->getRaceDetails($notification_subject_id);
                $booker = $db->getUserById($race['user_id']);
                if ($status_id == 2) {

                    //$pOwner = $this->getPropertyOwnerWithBidBookId($race['bid_book_id']);
                    $db->insertNotification($userId,$notification_subject_id,12);

                    $db->updateBidBook($race['bid_book_id'],$race['user_id'],$race['event_name'],$race['event_date'], $race['price'],$race['bid_book_status_id']);
                    $db->insertNotification($race['user_id'],$notification_subject_id,$book_accepted_id,$status_id);
                    $db->openTicket($race['bid_book_id'],$race['price']);
                    $sendEmail->bookingWinner($booker['email_address'],$booker['first_name']);
                } elseif ($status_id == 3) {
                    $db->insertNotification($userId,$notification_subject_id,13);

                    $db->insertNotification($race['user_id'],$notification_subject_id,$book_declined_id,$status_id);
                    $sendEmail->bookingLoser($booker['email_address'],$booker['first_name']);
                }

            }
            $response['error'] = FALSE;
            $response['message'] = $status;
        } else {
            $response['error'] = TRUE;
            $response['message'] = "Invalid Notification";
        }

    } else {
        $response['error'] = TRUE;
        $response['message'] = "Invalid Status";
    }

    echoResponse(200, $response);
}

function addReview() {
    $app = \Slim\Slim::getInstance();

    verifyRequiredParams(array('property_id','review','rating'));
    $property_id = $app->request->params('property_id');

    $review = $app->request->params('review');
    $rating = $app->request->params('rating');
    $token = $app->request->params('token');
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];

    $initProperty = $db->getPropertyDetails($property_id);
    $pState = $initProperty['active_status'];
    $pOwner = $initProperty['owner_id'];
    $response = array();
    $res = array();

    if ($pState==1) {

        if (!$db->hasUserReviewed($userId,$property_id)) {
            $review = $db->addReview($userId,$property_id,$review,$rating);
            $db->insertNotification($pOwner,$review,3,2);
        } else {
            $review = $db->updateReview($userId,$property_id,$review,$rating);
        }

        if ($db->calculateRating($property_id)) {
            $aReview = $db->getAReviewItem($property_id,$userId);
            $res["error"] = FALSE;
            $res['message'] = "success";
            $response = array_merge($res, $aReview);
        } else {
            // unknown error occurred
            $response['error'] = TRUE;
            $response['message'] = "An error occurred. Please try again";
        }

    } elseif ($pState==2) {
        $response['error'] = TRUE;
        $response['message'] = "Property does not exist";
    } else {
        $response['error'] = TRUE;
        $response['message'] = "Invalid Property";
    }

    echoResponse(200, $response);
}

function getReview() {
    $app = \Slim\Slim::getInstance();
    $req = $app->request(); // Getting parameters
//    $token = $req->params('token');
    verifyRequiredParams(array('property_id'));
    $property_id = $app->request->params('property_id');
    $marker = $app->request->params('marker');
    $type = $app->request->params('type');

    $db = new DBHandler();

//    $tox = $db->getUserByToken($token);
//    $id = $tox['user_id'];

    if (isset($marker) && isset($type)) {
        $review = $db->getReview($property_id,$marker,$type);
    } else {
        $review = $db->getReview($property_id);
    }
    $response = array();
//    if ($review != NULL) {
        $response["error"] = FALSE;
        $response['review'] = $review;

//    } else {
//        // unknown error occurred
//        $response['error'] = TRUE;
//        $response['message'] = "An error occurred. Please try again";
//    }
    echoResponse(200, $response);
}

function search() {
    $app = \Slim\Slim::getInstance();
    $req = $app->request(); // Getting parameters
//    $token = $req->params('token');
    //verifyRequiredParams(array('query'));
    $query = $app->request->params('query');
    $type = $app->request->params('type');
    $min_price = $app->request->params('min_price');
    $max_price = $app->request->params('max_price');
    $rating = $app->request->params('rating');
    $features = $app->request->params('features');
    $page_num = $app->request->params('page_num');

    $typeString = "'0'";
    $ratingString = "'0'";
    $featureString = "";
    $price_filter = "";

    $db = new DBHandler();
    //$response['query'] = $query;
    $typeArr = explode(",", $type);
    if (!empty($typeArr[0])) {
        foreach ($typeArr as $value) {
            $typeString .= ",'".$value."'";
        }
    } else {
        $typeString = "'1', '2', '3', '4', '5', '6'";
    }

    if (!empty($min_price) && !empty($max_price)) {
        $price_filter = " `booking_price` BETWEEN ".$min_price." AND ".$max_price;
    } elseif ((empty($min_price)||($min_price==0)) && !empty($max_price)) {
        $price_filter = " `booking_price` BETWEEN 1 AND ".$max_price;
    } else {
        $price_filter = "`booking_price` > 0";
    }

    $ratingArr = explode(",", $rating);
    if (!empty($rating[0])) {
        foreach ($ratingArr as $value) {
            $ratingString .= ",'".$value."'";
        }
    } else {
        $ratingString = "'0', '1', '2', '3', '4', '5'";
    }

    $featureArr = explode(",", $features);
    if (!empty($features[0])) {
        foreach ($featureArr as $value) {
            $featureString .= " ".featureNameToDBname($value)." IN (1) AND ";
        }
    } else {
        $featureString = " `air_condition` IN (0,1) AND `swim_pool` IN (0,1) AND `bar` IN (0,1) AND `internet` IN (0,1) AND `backup_power` IN (0,1) AND `parking` IN (0,1) AND `rest_rooms` IN (0,1) AND ";
    }

    if (empty($page_num) || $page_num == 1) {
        $offset = 0;
    } else {
        $offset = ($page_num-1) * 10;
    }

    $results = $db->search($query,$typeString,$price_filter, $ratingString,$featureString,$offset,IMAGE_URL_PROPERTIES);
    if ($results != NULL) {
        $response["error"] = FALSE;
        $response['results'] = $results;

    } else {
        // unknown error occurred
        $response['error'] = TRUE;
        $response['message'] = "An error occurred. Please try again";
    }


//    if (isset($marker) && isset($type)) {
//        $review = $db->getReview($property_id,$marker,$type);
//    } else {
//        $review = $db->getReview($property_id);
//    }
//    $response = array();
//
    echoResponse(200, $response);
}

function pay() {
    $app = \Slim\Slim::getInstance();
    verifyRequiredParams(array('bid_book_id'));
    $bid_book_id = $app->request->params('bid_book_id');
    $token = $app->request->params('token');
    $db = new DbHandler();

    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];
    $fname = $tox['fname'];
    $lname = $tox['lname'];
    $payerEmail = $tox['email'];
    $payerPhone = $tox['phone'];

    $initBidBook = $db->getBidBookAndPaymentDetails($bid_book_id);
//    $pState = $initProperty['active_status'];
//    $pOwner = $initProperty['owner_id'];
    $response = array();
    if ($initBidBook['user_id'] == $userId) {
        if ($initBidBook['bid_book_type_id'] == 2) {
            $response['error'] = FALSE;
            $response['details'] = $initBidBook;
            $response['property'] = $db->listSingle($initBidBook['property_id'],IMAGE_URL_PROPERTIES);
            unset($response['property']['events']);
            unset($response['property']['images']);
            $remita = $db->connectToRemita($initBidBook['total_amount'],$initBidBook['ariya_amount'],$fname." ".$lname,$payerEmail,$payerPhone,$response['property']['owner'][0]['first_name']." ".$response['property']['owner'][0]['last_name'],$response['property']['owner'][0]['account_number'],$response['property']['owner'][0]['bank_code']);
            if ($remita['error']==FALSE) {
                $response['payment'] = $remita;
                $db->updatePayment($initBidBook['ticket_id'],$remita['rrr'],$remita['order_id'],$remita['statuscode'],$remita['statusmsg']);
                $db->insertPaymentReport($bid_book_id,$initBidBook['ticket_id'],$initBidBook['property_amount'],$initBidBook['ariya_amount'],$initBidBook['gateway_amount'],$initBidBook['total_amount'],1,$remita['statuscode'],$remita['statusmsg'],'0',$remita['rrr'],$remita['order_id']);
                unset($response['payment']['error']);
            } else {
                unset($response);
                $response['error'] = TRUE;
                $response['message'] = $remita['message'];
            }
        } else {
            $response['error'] = TRUE;
            $response['message'] = "Your request has not been accepted";
        }

    } else {
        $response['error'] = TRUE;
        $response['message'] = "You cannot pay";
    }

    echoResponse(200, $response);
}

function cancelPayment() {
    require_once '../libs/sendgrid-php/sendgrid-php.php';
    require_once '../include/SendGridEmail.php';
    $app = \Slim\Slim::getInstance();
    $sendEmail = new SendGridEmail();

//    $req = $app->request(); // Getting parameters
    $token = $app->request->params('token');
    $notification_id = $app->request->params('notification_id');
    $db = new DbHandler();
    $tox = $db->getUserByToken($token);
    $userId = $tox['user_id'];
    $response = array();


    $notification = $db->getNotification($notification_id);
    $notification_owner = $notification['owner_id'];
    $notification_type = $notification['type'];
    $notification_subject_id = $notification['subject_id'];

    if ($notification_owner == $userId) {
        if ($notification_type != NULL) {

            $status_id = 5; //cancelled
            $db->updateNotificationActiveStatus($userId,$notification_id);

            $race = $db->getRaceDetails($notification_subject_id);

            $initBidBook = $db->getBidBookAndPaymentDetails($race['bid_book_id']);
            $db->updateRaceStatus($notification_subject_id, $status_id);
            $recipient = $db->getUserById($race['user_id']);


//            $pOwner = $this->getPropertyOwnerWithBidBookId($race['bid_book_id']);
            $db->insertNotification($initBidBook['owner_id'],$notification_subject_id,15);

            $db->updateBidBook($race['bid_book_id'],$race['user_id'],$race['event_name'],$race['event_date'], $race['price'],$status_id);
            $db->insertNotification($race['user_id'],$notification_subject_id,14);
            //$db->openTicket($race['bid_book_id'],$race['price']);
            //$sendEmail->bookingWinner($recipient['email_address'],$recipient['first_name']);

            $response['error'] = FALSE;
            $response['message'] = "Payment Cancelled Successfully";

        } else {
            $response['error'] = TRUE;
            $response['message'] = "Invalid Notification";
        }
    } else {
        $response['error'] = TRUE;
        $response['message'] = "User not Authorized";
    }

    echoResponse(200, $response);
}

function contact() {
    require_once '../include/Config.php';
    require_once '../libs/sendgrid-php/sendgrid-php.php';
    require_once '../include/SendGridEmail.php';
    $app = \Slim\Slim::getInstance();
    $sendEmail = new SendGridEmail();
    verifyRequiredParams(array('name', 'email', 'message'));
    $name = $app->request->params('name');
    $email = $app->request->params('email');
    $message = $app->request->params('message');

    // validating email address
    validateEmail($email);

    $db = new DbHandler();
    $contact = $db->contact($name,$email,$message);

    if ($contact != NULL) {
        $sendEmail->contact($name,$email,$message);

        $response["error"] = FALSE;
        $response['contact_id'] = $contact;
        $response['message'] = "Message was posted Successfully";
    } else {
        // unknown error occurred
        $response["error"] = TRUE;
        $response['message'] = "An error occurred. Please try again";
    }

    echoResponse(200, $response);
}

function elapse() {
    $db = new DbHandler();
    $mes = $db->getPropertyOwnerWithBidBookId(7);


//    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
//
//    $tic = array();
//    while(count($tic)==0) {
//        $ticket = "A".$characters[rand(0,25)].rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
//        array_push($tic,$ticket);
//    }
//    echo $tic[0];
    //echo count($tic);
//    $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
//    $ticket = "A".$characters[rand(0,25)].rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
//    echo $ticket;
//    $app = \Slim\Slim::getInstance();
//    $query = $app->request->params('query');
//    echo "value: ".gettype($query);
//    $db = new DBHandler();
    echoResponse(200, $mes);
}

//function testPost() {
//    $app = \Slim\Slim::getInstance();
//    //verifyRequiredParams(array('apikey'));
//    //$req = $app->request(); // Getting parameters
//    //$token = $req->params('token');
//    $response = $app->response();
//    $response->header('Access-Control-Allow-Origin', '*');
//    //$response->header('Access-Control-Allow-Methods', 'GET, POST');
//    //$response->header('Access-Control-Allow-Headers', 'accept, origin, content-type');
//    $response->header('Access-Control-Expose-Headers', 'FooBar');
//
//    $responser["error"] = FALSE;
//    $responser['profile'] = $_SERVER["SERVER_NAME"];
//
//    echoResponse(200, $responser);
//}


function featureNameToDBname($value) {
    if ($value == "ac") {
        return "air_condition";
    } else if ($value == "pool") {
        return "swim_pool";
    } else if ($value == "bar") {
        return "bar";
    } else if ($value == "internet") {
        return "internet";
    } else if ($value == "bpower") {
        return "backup_power";
    } else if ($value == "parking") {
        return "parking";
    } else if ($value == "restroom") {
        return "rest_rooms";
    }
}

function booleanToStringAndViceVersa($value) {
    if ($value == "true") {
        return "1";
    } else if ($value == "false") {
        return "0";
    } else if ($value == "1") {
        return true;
    } else if ($value == "0") {
        return false;
    }
}

/**
 * Verifying required params posted or not
 * @param $required_fields
 * @throws \Slim\Exception\Stop
 */
function verifyRequiredParams($required_fields) {
    $error = FALSE;
    $error_fields = "";
    //$request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = TRUE;
            $error_fields .= $field . ', ';
        }
    }

    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = TRUE;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoResponse(400, $response);
        $app->stop();
    }
}

/**
 * Validating email address
 * @param $email
 * @throws \Slim\Exception\Stop
 */
function validateEmail($email) {
    $app = \Slim\Slim::getInstance();
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $response["error"] = TRUE;
        $response["message"] = 'Email address is not valid';
        echoResponse(400, $response);
        $app->stop();
    }
}

function echoResponse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);

    //$app->header('Access-Control-Allow-Origin', '*');
    //$response->header('Access-Control-Allow-Origin', '*');
    //$app->header('Access-Control-Allow-Origin: *');

    // setting response content type to json
    $app->contentType('application/json');

    echo json_encode($response);
}

?>
