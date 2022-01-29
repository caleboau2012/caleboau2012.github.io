<?php
/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 * Author: Generaleye
 */
class DbHandler
{

    private $conn;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }


    /* ------------- `users` table method ------------------ */

    /**
     * Creating new user
     * @param $first_name
     * @param $last_name
     * @param $email
     * @param $password
     * @param $phone
     * @return int
     */
    public function createUser($first_name, $last_name, $email, $password, $phone) {
        require_once 'PassHash.php';
        require_once '../libs/sendgrid-php/sendgrid-php.php';
        require_once 'SendGridEmail.php';

        // Check if user already exists in db
        if (!$this->isEmailExists($email)) {
            // Generating password hash
            $password_hash = PassHash::hash($password);

            // Generating API key
            $token = $this->generateToken();

            if (!$this->isTokenExists($token)) {

                //Get current datetime
                $datetime = date("Y-m-d H:i:s", time());
                //Set active status to 2 = unverified
                $active_state = 2;

                // insert query
                $sql = "INSERT INTO users (`first_name`,`last_name`,`email_address`,`password`,`phone_number`, `token`, `created_time`, `modified_time`, `active_status`) VALUES
                        (:fname, :lname, :email, :password, :phone, :token, :created_time, :modified_time, :active_state)";
                try {
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam("fname", $first_name);
                    $stmt->bindParam("lname", $last_name);
                    $stmt->bindParam("email", $email);
                    $stmt->bindParam("password", $password_hash);
                    $stmt->bindParam("phone", $phone);
                    $stmt->bindParam("token", $token);
                    $stmt->bindParam("created_time", $datetime);
                    $stmt->bindParam("modified_time", $datetime);
                    $stmt->bindParam("active_state", $active_state);
                    $result = $stmt->execute();
                } catch(PDOException $e) {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
                }

                // Check for successful insertion
                if ($result) {
                    $verifyToken = PassHash::emailHash($email,"register");
                    $sendEmail = new SendGridEmail();
                    $sendEmail->sendRegistrationEmail($email,$first_name,$verifyToken);
//                    $mail = new Mail();
//                    $mail->send($email,"Welcome Message","Welcome to Ariya. Visit ".VERIFY_ACCOUNT_URL."?email=".$email."&token=".$verifyToken);
                    // User successfully inserted
                    return REGISTRATION_SUCCESSFUL;
                } else {
                    // Failed to create user
                    return REGISTRATION_FAILED;
                }
            } else {
                // User with same token already exists in the db
                return REGISTRATION_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return EMAIL_ALREADY_EXISTS;
        }
    }

    /**
     * Checking user login
     * @param String $email User login email id
     * @param String $password User login password
     * @return boolean User login status success/fail
     */
    public function checkLogin($email, $password) {
        // fetching user by email
        $sql = "SELECT `password`, `active_status` FROM `users` WHERE `email_address` = :email";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("email", $email);
            $stmt->execute();
            //$user = $stmt->fetch(PDO::FETCH_ASSOC);
            $num_rows = $stmt->rowCount();
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
        if ($num_rows > 0) {
            // Found user with the email
            // Now verify the password
            $password_hash = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($password_hash['active_status'] == 2) {
                return USER_NOT_VERIFIED;
            }
            if (PassHash::check_password($password_hash['password'], $password)) {
                // User password is correct
                return LOGIN_SUCCESSFUL;
            } else {
                // user password is incorrect
                return UNSUCCESSFUL_LOGIN;
            }
        } else {
            // user doesn't exist with the email
            return UNSUCCESSFUL_LOGIN;
        }
    }


    public function forgotPassword($email) {
        require_once 'PassHash.php';
        require_once '../libs/sendgrid-php/sendgrid-php.php';
        require_once 'SendGridEmail.php';


        $forgotToken = PassHash::emailHash($email,"forgotpassword");
        $sendEmail = new SendGridEmail();
        $sendEmail->forgotPasswordEmail($email,$forgotToken);
//        $mail = new Mail();
//        if ($mail->send($email,"Welcome Message","Welcome to Ariya. Visit ".FORGOT_PASSWORD_URL."?email=".$email."&token=".$forgotToken)) {
        return TRUE;
    }

    public function resendVerification($email) {
        require_once 'PassHash.php';
        require_once '../libs/sendgrid-php/sendgrid-php.php';
        require_once 'SendGridEmail.php';

        $active = $this->getUserByEmail($email);
        if ($active['active_status']==2) {
            $verifyToken = PassHash::emailHash($email,"register");
            $sendEmail = new SendGridEmail();
            $sendEmail->verificationEmail($email,$active['first_name'],$verifyToken);
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function changePassword($userId, $new) {
        require_once 'PassHash.php';

        $datetime = date("Y-m-d H:i:s", time());
        // Generating password hash
        $password_hash = PassHash::hash($new);

        $sql = "UPDATE `users` SET `password` = :new, `modified_time` = :time_posted WHERE `user_id` = :userId";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("userId", $userId);
            $stmt->bindParam("new", $password_hash);
            $stmt->bindParam("time_posted", $datetime);
            $stmt->execute();
            return TRUE;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }


    /**
     * Checking for duplicate user by email address
     * @param String $email email to check in db
     * @return boolean
     */
    private function isEmailExists($email) {
        $sql = "SELECT `user_id` from `users` WHERE `email_address` = :email";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("email", $email);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            return $num_rows > 0;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    /**
     * Checking for duplicate Token
     * @param String $token value to check in db
     * @return boolean
     */
    private function isTokenExists($token) {
        $sql = "SELECT `user_id` from `users` WHERE `token` = :token";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("token", $token);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            return $num_rows > 0;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    /**
     * Fetching user by email
     * @param String $email User email id
     */
    public function getUserByEmail($email) {
        $sql = "SELECT `first_name`, `email_address`, `token`, `created_time`, `active_status` FROM `users` WHERE `email_address` = :email";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("email", $email);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getUserById($userId) {
        $sql = "SELECT `first_name`, `email_address`, `token`, `profile_picture`, `created_time`, `active_status` FROM `users` WHERE `user_id` = :userId";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("userId", $userId);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function verifyUser($email) {
        $sql = "UPDATE `users` SET `active_status` = 1 WHERE `email_address` = :email";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("email", $email);
            $stmt->execute();
            return TRUE;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function resetPassword($password, $email) {
        require_once 'PassHash.php';
        $password_hash = PassHash::hash($password);
        $sql = "UPDATE `users` SET `password` = :password WHERE `email_address` = :email";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("password", $password_hash);
            $stmt->bindParam("email", $email);
            $stmt->execute();
            return TRUE;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    /**
     * Generating random Unique MD5 String for User Token
     */
    private function generateToken() {
        return md5(time().uniqid(rand(), TRUE));
    }

    public function isValidToken($token) {
        $sql = "SELECT `user_id` from `users` WHERE `token` = :token";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("token", $token);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            return $num_rows > 0;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getUserByToken($token) {
        $sql = "SELECT `user_id`, `first_name` AS `fname`, `last_name` AS `lname`, `phone_number` AS `phone`, `email_address` AS `email`, `profile_picture` FROM `users` WHERE `token` = :token";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("token", $token);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getProfileById($id,$dir) {
        $sql = "SELECT `user_id`, `first_name` AS `fname`, `last_name` AS `lname`, `phone_number` AS `phone`, CONCAT(:dir, profile_picture) AS `profile_picture`, `street`, `city`, `state`, `country`, `company_name` AS `cname`, `company_street` AS `cstreet`, `company_city` AS `ccity`, `company_state` AS `cstate`, `company_country` AS `ccountry`, `account_number` AS `accnum`, `bank_code` AS `bankcode`, `created_time` FROM `users` WHERE `user_id` =:id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->bindParam("dir", $dir);
            $stmt->execute();
            $profile = $stmt->fetch(PDO::FETCH_ASSOC);
            return $profile;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function editProfile($userId, $fname, $lname, $profile_pic, $street, $city, $state, $country, $cname, $cstreet, $ccity, $cstate, $ccountry, $account_number, $bank_code) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "UPDATE `users` SET `first_name` = :fname, `last_name` = :lname, `profile_picture` = :profile_pic,
                `street` = :street, `city` = :city, `state` = :state, `country` = :country,
                `company_name` = :cname, `company_street` = :cstreet, `company_city` = :ccity, `company_state` = :cstate, `company_country` = :ccountry,
                `account_number` = :accnum, `bank_code` = :bankcode,
                 `modified_time` = :datetime
                 WHERE `user_id` =:userId";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("userId", $userId);
            $stmt->bindParam("fname", $fname);
            $stmt->bindParam("lname", $lname);
            $stmt->bindParam("profile_pic", $profile_pic);
            $stmt->bindParam("street", $street);
            $stmt->bindParam("city", $city);
            $stmt->bindParam("state", $state);
            $stmt->bindParam("country", $country);
            $stmt->bindParam("cname", $cname);
            $stmt->bindParam("cstreet", $cstreet);
            $stmt->bindParam("ccity", $ccity);
            $stmt->bindParam("cstate", $cstate);
            $stmt->bindParam("ccountry", $ccountry);
            $stmt->bindParam("accnum", $account_number);
            $stmt->bindParam("bankcode", $bank_code);
            $stmt->bindParam("datetime", $datetime);
            $stmt->execute();
            return TRUE;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    /**
     * Properties Call
     */


    public function getPropertyDetails($property_id) {
        $sql = "SELECT `name`, `owner_id`, `booking_price`, `active_status` FROM `properties` WHERE `property_id` = :property_id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();
            $property = $stmt->fetch(PDO::FETCH_ASSOC);
            return $property;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getMyProperties($userId,$dir) {
//        $sql = "SELECT properties.property_id, `name`, `description`,
//                CONCAT(:dir, (CASE WHEN ( property_images.url IS NULL) THEN 'default.png' ELSE property_images.url END)) AS `src` , `street`, `city`, `state`, `country`, properties.created_time FROM properties
//                  LEFT OUTER JOIN property_images
//                  ON properties.property_id=property_images.property_id
//                  WHERE properties.owner_id = :owner_id AND properties.active_status = 1
//                  GROUP BY property_images.property_id";
//        $sql = "SELECT properties.property_id, `name`, `description`,
//
//                 (CASE WHEN (SELECT property_images.url FROM property_images WHERE property_images.property_id=properties.property_id LIMIT 1) THEN 'default.png' ELSE 'hello' END) AS src,
//                 `street`, `city`, `state`, `country`, properties.created_time FROM properties
//
//                  WHERE properties.owner_id = :owner_id AND properties.active_status = 1";
        $sql = "SELECT property_id, `name`, `description`,
                `street`, `city`, `state`, `country`, created_time FROM properties
                  WHERE owner_id = :owner_id AND active_status = 1 ORDER BY `property_id` DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("owner_id", $userId);
            //$stmt->bindParam("dir", $dir);
            $stmt->execute();
            $myProperties = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $leng = count($myProperties);

            for($i=0;$i<$leng;$i++) {
                $srcT = $this->getAPropertyImage($myProperties[$i]['property_id']);
                $src = ($srcT['url'] == NULL ? 'default.png' : $srcT['url']);
                $myProperties[$i]['src'] = $dir.$src;
            }

            $arr = array('count'=>$leng, 'properties'=>$myProperties);
            return $arr;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getMyProperty($userId,$property_id,$dir) {
        $sql = "SELECT properties.property_id, properties.name, properties.category_id AS category, properties.description,
                 properties.street, properties.city, properties.state, properties.country, properties.latitude, properties.longitude,
                 properties.capacity, properties.booking_price, properties.minimum_bid_price AS `min_bid_price`,
                 statistics.security, statistics.power, statistics.water, statistics.accessibility,
                  features.air_condition AS `ac`, features.swim_pool AS `pool`, features.bar AS `bar`, features.internet, features.backup_power AS `bpower`, features.parking, features.rest_rooms AS `restroom`, properties.created_time
                  FROM `properties`, statistics, features
                  WHERE properties.property_id = :property_id AND properties.property_id = statistics.property_id AND properties.property_id = features.property_id AND `owner_id` = :owner_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("owner_id", $userId);
            $stmt->execute();
            $myProperty = $stmt->fetch(PDO::FETCH_ASSOC);
            $myProperty['ac'] = booleanToStringAndViceVersa($myProperty['ac']);
            $myProperty['pool'] = booleanToStringAndViceVersa($myProperty['pool']);
            $myProperty['bar'] = booleanToStringAndViceVersa($myProperty['bar']);
            $myProperty['internet'] = booleanToStringAndViceVersa($myProperty['internet']);
            $myProperty['bpower'] = booleanToStringAndViceVersa($myProperty['bpower']);
            $myProperty['parking'] = booleanToStringAndViceVersa($myProperty['parking']);
            $myProperty['restroom'] = booleanToStringAndViceVersa($myProperty['restroom']);
            $myProperty['images'] = $this->getPropertyImages($property_id,$dir);
            $myProperty['events'] = $this->getPropertyEvents($property_id);
            return $myProperty;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function isPropertyImageExist($property_id,$image_id) {
        $sql = "SELECT `property_image_id` AS `image_id` FROM `property_images` WHERE `property_id` = :property_id AND `property_image_id` = :image_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("image_id", $image_id);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            return $num_rows > 0;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getAPropertyImageWithId($property_id, $image_id) {
        $sql = "SELECT `property_image_id` AS `image_id`, `url` FROM `property_images` WHERE `property_id` = :property_id AND `property_image_id` = :image_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("image_id", $image_id);
            $stmt->execute();
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
            return $image;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getAPropertyImage($property_id) {
        $sql = "SELECT `property_image_id` AS `image_id`, `url` FROM `property_images` WHERE `property_id` = :property_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();
            $image = $stmt->fetch(PDO::FETCH_ASSOC);
            return $image;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getPropertyImages($property_id,$dir) {
        $sql = "SELECT `property_image_id` AS `id`,CONCAT(:dir, (CASE WHEN ( url IS NULL) THEN 'default.png' ELSE url END)) AS `src` FROM `property_images` WHERE `property_id` = :property_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("dir", $dir);
            $stmt->execute();
            $image = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $image;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function deletePropertyImage($property_id,$image_id) {
        $sql = "UPDATE `property_images` SET `active_status` = 2 WHERE `property_id` = :property_id AND `property_image_id` = :image_id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("image_id", $image_id);
            $stmt->execute();
            return TRUE;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getPropertyStatistics($property_id) {
        $sql = "SELECT `security`, `power`, `water`, `accessibility` FROM `statistics` WHERE `property_id` = :property_id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();
            $image = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $image;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getPropertyFeatures($property_id) {
        $sql = "SELECT `air_condition`, `swim_pool`, `bar`, `internet`, `backup_power`, `parking`, `rest_rooms` FROM `features` WHERE `property_id` = :property_id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();
            $image = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $image;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getPropertyEvents($property_id) {
        $sql = "SELECT `bid_book_id` AS `event_id`, `event_name` AS `title`, `event_date` AS `date`, (CASE `bid_book_type_id` WHEN 1 THEN 'bid' WHEN 2 THEN 'book' WHEN 3 THEN 'own' END) AS `type`, (CASE `bid_book_status_id` WHEN 1 THEN 'in_progress' WHEN 2 THEN 'accepted' WHEN 3 THEN 'declined' WHEN 4 THEN 'closed' WHEN 5 THEN 'cancelled' END) AS `status` FROM `bids_books` WHERE `property_id` = :property_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            for ($i=0;$i<count($events);$i++) {
                if ($events[$i]['status']=='declined') {
                    //unset($events[$i]);
                    array_splice($events, $i,1);
                    //$events[$i]['status'] = 'in_progress';
                }
                if ($events[$i]['type']=='book') {
                    if ($events[$i]['status']=='in_progress') {
                        //unset($events[$i]);
                        array_splice($events, $i,1);
                    }
                }
            }
            return $events;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getPropertyOwner($owner_id) {
        $sql = "SELECT `first_name`, `last_name`, `email_address`, `phone_number`, `account_number`, `bank_code` FROM `users` WHERE `user_id` = :owner_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("owner_id", $owner_id);
            $stmt->execute();
            $owner = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $owner;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getPropertyCompany($owner_id) {
        $sql = "SELECT `company_name` AS `name`, `company_street` AS `street`, `company_city` AS `city`, `company_state` AS `state`, `company_country` AS `country` FROM `users` WHERE `user_id` = :owner_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("owner_id", $owner_id);
            $stmt->execute();
            $owner = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $owner;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    /**
     * Add a Property
     * @param int $userId User's Id gotten from Apikey
     * @param $name
     * @param $address
     * @param $category
     * @param $description
     * @param $security
     * @param $power
     * @param $water
     * @param $accessibility
     * @param $ac
     * @param $pool
     * @param $bar
     * @param $internet
     * @param $bpower
     * @return int $property_id
     */
    public function addProperty($userId,$name,$category,$description,$street,$city,$state,$country,$latitude,$longitude,$capacity,$booking_price,$min_bid_price,$security,$power,$water,$accessibility,$ac,$pool,$bar,$internet,$bpower,$parking,$restroom) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "INSERT INTO properties (`owner_id`,`name`, `category_id`, `description`, `street`, `city`, `state`, `country`, `latitude`, `longitude`, `capacity`, `booking_price`, `minimum_bid_price`, `created_time`, `modified_time`)
                VALUES (:owner_id, :name, :category_id, :description, :street, :city, :state, :country, :latitude, :longitude, :capacity, :booking_price, :minimum_bid_price, :created_time, :modified_time)";
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("owner_id", $userId);
            $stmt->bindParam("name", $name);
            $stmt->bindParam("category_id", $category);
            $stmt->bindParam("description", $description);
            $stmt->bindParam("street", $street);
            $stmt->bindParam("city", $city);
            $stmt->bindParam("state", $state);
            $stmt->bindParam("country", $country);
            $stmt->bindParam("latitude", $latitude);
            $stmt->bindParam("longitude", $longitude);
            $stmt->bindParam("capacity", $capacity);
            $stmt->bindParam("booking_price", $booking_price);
            $stmt->bindParam("minimum_bid_price", $min_bid_price);
            $stmt->bindParam("created_time", $datetime);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();
            $property_id = $this->conn->lastInsertId();

            $sqlin = "INSERT INTO statistics (`property_id`,`security`, `power`, `water`, `accessibility`)
                VALUES (:property_id, :security, :power, :water, :accessibility)";
            try {
                $stmt = $this->conn->prepare($sqlin);
                $stmt->bindParam("property_id", $property_id);
                $stmt->bindParam("security", $security);
                $stmt->bindParam("power", $power);
                $stmt->bindParam("water", $water);
                $stmt->bindParam("accessibility", $accessibility);
                $stmt->execute();

                $sqlinner = "INSERT INTO features (`property_id`,`air_condition`, `swim_pool`, `bar`, `internet`, `backup_power`, `parking`, `rest_rooms`)
                VALUES (:property_id, :air, :swim, :bar, :internet, :backup, :parking, :restroom)";
                try {
                    $stmt = $this->conn->prepare($sqlinner);
                    $stmt->bindParam("property_id", $property_id);
                    $stmt->bindParam("air", $ac);
                    $stmt->bindParam("swim", $pool);
                    $stmt->bindParam("bar", $bar);
                    $stmt->bindParam("internet", $internet);
                    $stmt->bindParam("backup", $bpower);
                    $stmt->bindParam("parking", $parking);
                    $stmt->bindParam("restroom", $restroom);
                    $stmt->execute();
                    $this->conn->commit();
                    return $property_id;

                } catch(PDOException $e) {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
                }
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
            }

        } catch(PDOException $e) {
            $this->conn->rollBack();
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function deleteProperty($property_id) {
        $sql = "UPDATE `properties` SET `active_status` = 2 WHERE `property_id` = :property_id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();

            $sqler = "UPDATE `property_images` SET `active_status` = 2 WHERE `property_id` = :property_id";
            try {
                $stmt = $this->conn->prepare($sqler);
                $stmt->bindParam("property_id", $property_id);
                $stmt->execute();
                return TRUE;
            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
            }
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function addPropertyImage($property_id, $url) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "INSERT INTO property_images (`property_id`, `url`, `created_time`)
                VALUES (:property_id, :url, :time_posted)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("url", $url);
            $stmt->bindParam("time_posted", $datetime);
            $stmt->execute();
            return TRUE;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    /**
     * Edit a Property with the Property's Id
     * @param int $userId A User's Apikey
     * @param int $property_id A property's Id
     * @param $name
     * @param $address
     * @param $category
     * @param $description
     * @param $security
     * @param $power
     * @param $water
     * @param $accessibility
     * @param $ac
     * @param $pool
     * @param $bar
     * @param $internet
     * @param $bpower
     * @return int $property_id
     */
    public function editProperty($userId,$property_id,$name,$category,$description,$street,$city,$state,$country,$latitude,$longitude,$capacity,$booking_price,$min_bid_price,$security,$power,$water,$accessibility,$ac,$pool,$bar,$internet,$bpower,$parking,$restroom) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "UPDATE `properties` SET `name` = :name, `category_id` = :category, `description` = :description, `street` = :street, `city` = :city, `state` = :state, `country` = :country, `latitude` = :latitude, `longitude` = :longitude, `capacity` = :capacity, `booking_price` = :booking_price, `minimum_bid_price` = :minimum_bid_price, `modified_time` = :modified_time
                WHERE `property_id` = :property_id AND `owner_id` = :owner_id AND `active_status` = 1";
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("owner_id", $userId);
            $stmt->bindParam("name", $name);
            $stmt->bindParam("category", $category);
            $stmt->bindParam("description", $description);
            $stmt->bindParam("street", $street);
            $stmt->bindParam("city", $city);
            $stmt->bindParam("state", $state);
            $stmt->bindParam("country", $country);
            $stmt->bindParam("latitude", $latitude);
            $stmt->bindParam("longitude", $longitude);
            $stmt->bindParam("capacity", $capacity);
            $stmt->bindParam("booking_price", $booking_price);
            $stmt->bindParam("minimum_bid_price", $min_bid_price);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();

            $sqlin = "UPDATE `statistics` SET `security` = :security, `power` = :power, `water` = :water, `accessibility` = :accessibility
                      WHERE `property_id` = :property_id";
            try {
                $stmt = $this->conn->prepare($sqlin);
                $stmt->bindParam("property_id", $property_id);
                $stmt->bindParam("security", $security);
                $stmt->bindParam("power", $power);
                $stmt->bindParam("water", $water);
                $stmt->bindParam("accessibility", $accessibility);
                $stmt->execute();

                $sqlinner = "UPDATE `features` SET `air_condition` = :air, `swim_pool` = :swim, `bar` = :bar, `internet` = :internet, `backup_power` = :backup, `parking` = :parking, `rest_rooms` = :restroom
                              WHERE `property_id` = :property_id";
                try {
                    $stmt = $this->conn->prepare($sqlinner);
                    $stmt->bindParam("property_id", $property_id);
                    $stmt->bindParam("air", $ac);
                    $stmt->bindParam("swim", $pool);
                    $stmt->bindParam("bar", $bar);
                    $stmt->bindParam("internet", $internet);
                    $stmt->bindParam("backup", $bpower);
                    $stmt->bindParam("parking", $parking);
                    $stmt->bindParam("restroom", $restroom);
                    $stmt->execute();
                    $this->conn->commit();
                    return $property_id;

                } catch(PDOException $e) {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
                }

            } catch(PDOException $e) {
                echo '{"error":{"text":'. $e->getMessage() .'}}';
            }
            return $property_id;
        } catch(PDOException $e) {
            $this->conn->rollBack();
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    //public function bidBook($property_id, $userId, $name, $date, $type, $price) {
    public function addEvent($userId,$property_id,$name,$date,$type_id=3,$price=0,$status_id=4) {
        $datetime = date("Y-m-d H:i:s", time());
//        $type_id = 2;
//        $price = 0;
//        $status_id = 4; closed
        $sql = "INSERT INTO bids_books (`property_id`, `user_id`, `event_name`, `event_date`, `bid_book_type_id`, `price`, `bid_book_status_id`, `created_time`)
                VALUES (:property_id, :user_id, :event_name, :event_date, :bid_book_type_id, :price, :bid_book_status_id, :time_posted)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("user_id", $userId);
            $stmt->bindParam("event_name", $name);
            $stmt->bindParam("event_date", $date);
            $stmt->bindParam("bid_book_type_id", $type_id);
            $stmt->bindParam("price", $price);
            $stmt->bindParam("bid_book_status_id", $status_id);
            $stmt->bindParam("time_posted", $datetime);
            $stmt->execute();
            $event_id = $this->conn->lastInsertId();

            if ($status_id != 4) {
                if ($type_id == 1) {
                    $interval = 172800; //48 hours
                } elseif ($type_id == 2) {
                    $interval = 86400; //24 hours
                }
                $cron_status_id = 1; //not-run (pending)

                $sql = "INSERT INTO crons (`bid_book_id`, `start_datetime`, `interval_time`, `cron_status_id`, `cron_type_id`)
                VALUES (:bid_book_id, :start_datetime, :interval_time, :cron_status_id, :cron_type_id)";
                try {
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam("bid_book_id", $event_id);
                    $stmt->bindParam("start_datetime", $datetime);
                    $stmt->bindParam("interval_time", $interval);
                    $stmt->bindParam("cron_status_id", $cron_status_id);
                    $stmt->bindParam("cron_type_id", $type_id);
                    $stmt->execute();

                } catch(PDOException $e) {
                    echo '{"error":{"text":'. $e->getMessage() .'}}';
                }

            }
            return $event_id;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function removeEvent($userId,$property_id,$event_id) {
        $sql = "UPDATE bids_books SET `active_status`= 0 WHERE `property_id` = :property_id AND `bid_book_id` = :bid_book_id AND `user_id` = :user_id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("user_id", $userId);
            $stmt->bindParam("bid_book_id", $event_id);
            $stmt->execute();
            return TRUE;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function addRace($userId,$bidId,$name,$date,$price=0,$status_id=4) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "INSERT INTO bid_book_races (`bid_book_id`, `user_id`, `event_name`, `event_date`, `price`, `bid_book_status_id`, `created_time`)
                VALUES (:bid_book_id, :user_id, :event_name, :event_date, :price, :bid_book_status_id, :time_posted)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bidId);
            $stmt->bindParam("user_id", $userId);
            $stmt->bindParam("event_name", $name);
            $stmt->bindParam("event_date", $date);
            $stmt->bindParam("price", $price);
            $stmt->bindParam("bid_book_status_id", $status_id);
            $stmt->bindParam("time_posted", $datetime);
            $stmt->execute();
            $race_id = $this->conn->lastInsertId();
            return $race_id;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }


    public function listAll($dir) {
        $sql = "SELECT property_id, `name`, `description`,
                `street`, `city`, `state`, `country`, `booking_price`, `minimum_bid_price`, `rating`, `created_time` FROM properties
              WHERE active_status = 1 ORDER BY `property_id` DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            //$stmt->bindParam("dir", $dir);
            $stmt->execute();
            $myProperties = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $leng = count($myProperties);

            for($i=0;$i<$leng;$i++) {
                $srcT = $this->getAPropertyImage($myProperties[$i]['property_id']);
                $src = ($srcT['url'] == NULL ? 'default.png' : $srcT['url']);
                $myProperties[$i]['src'] = $dir.$src;
            }

            $arr = array('count'=>$leng, 'properties'=>$myProperties);
            return $arr;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function listSingle($property_id,$dir) {
        $sql = "SELECT properties.property_id, properties.name, properties.category_id AS category, properties.description,
                  properties.street, properties.city, properties.state, properties.country, properties.latitude, properties.longitude,
                  properties.capacity, properties.booking_price, properties.minimum_bid_price AS `min_bid_price`, properties.rating,
                  statistics.security, statistics.power, statistics.water, statistics.accessibility,
                  features.air_condition AS `ac`, features.swim_pool AS `pool`, features.bar AS `bar`, features.internet, features.backup_power AS `bpower`, features.parking, features.rest_rooms AS `restroom`, properties.created_time
                  FROM `properties`, statistics, features
                  WHERE properties.property_id = :property_id AND properties.property_id = statistics.property_id AND properties.property_id = features.property_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();
            $myProperty = $stmt->fetch(PDO::FETCH_ASSOC);
            $myProperty['ac'] = booleanToStringAndViceVersa($myProperty['ac']);
            $myProperty['pool'] = booleanToStringAndViceVersa($myProperty['pool']);
            $myProperty['bar'] = booleanToStringAndViceVersa($myProperty['bar']);
            $myProperty['internet'] = booleanToStringAndViceVersa($myProperty['internet']);
            $myProperty['bpower'] = booleanToStringAndViceVersa($myProperty['bpower']);
            $myProperty['parking'] = booleanToStringAndViceVersa($myProperty['parking']);
            $myProperty['restroom'] = booleanToStringAndViceVersa($myProperty['restroom']);
            $myProperty['images'] = $this->getPropertyImages($property_id,$dir);
            $myProperty['events'] = $this->getPropertyEvents($property_id);
            $owner = $this->getPropertyDetails($property_id);
            $myProperty['owner'] = $this->getPropertyOwner($owner['owner_id']);
            $myProperty['company'] = $this->getPropertyCompany($owner['owner_id']);
            return $myProperty;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }


    public function latestSix($dir) {
        $sql = "SELECT property_id, `name`, `description`,
                `street`, `city`, `state`, `country`, created_time FROM properties
                  WHERE active_status = 1 ORDER BY `property_id` DESC LIMIT 6";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $latest = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $leng = count($latest);

            for($i=0;$i<$leng;$i++) {
                $srcT = $this->getAPropertyImage($latest[$i]['property_id']);
                $src = ($srcT['url'] == NULL ? 'default.png' : $srcT['url']);
                $latest[$i]['src'] = $dir.$src;
            }

            $arr = $latest;
            return $arr;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }


    /*
     * BID and BOOK functions
     */
    public function getDatesBidorBook($property_id,$date,$type_id) {
        $sql = "SELECT `bid_book_id` AS `event_id`, `user_id`, `event_name` AS `title`, `event_date` AS `date`, price, `bid_book_status_id` AS `status_id`, `created_time` FROM `bids_books` WHERE `property_id` = :property_id AND `event_date` = :event_date AND `bid_book_type_id` = :type_id AND `active_status` = 1 ORDER BY `bid_book_id` DESC LIMIT 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("event_date", $date);
            $stmt->bindParam("type_id", $type_id);
            $stmt->execute();
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            return $event;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getDatesStatuses($property_id,$date,$type_id) {
        $sql = "SELECT DISTINCT bid_book_statuses.bid_book_status_id AS `status_id`, bid_book_statuses.name FROM `bids_books`, `bid_book_statuses` WHERE `property_id` = :property_id AND `event_date` = :event_date AND `bid_book_type_id` = :type_id AND bid_book_statuses.bid_book_status_id = bids_books.bid_book_status_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("event_date", $date);
            $stmt->bindParam("type_id", $type_id);
            $stmt->execute();
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            return $event;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getNoOfBidders($bid_id,$date) {
        $sql = "SELECT DISTINCT `user_id` FROM `bid_book_races` WHERE `bid_book_id` = :bid_id AND `event_date` = :event_date AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_id", $bid_id);
            $stmt->bindParam("event_date", $date);
            $stmt->execute();
            $event = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $event;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getCurrentBidPrice($bid_id,$date) {
        $sql = "SELECT `bid_book_id` AS `event_id`, `user_id`, `event_name` AS `title`, `event_date` AS `date`, price, `bid_book_status_id` AS `status_id`, `created_time` FROM `bid_book_races` WHERE `bid_book_id` = :bid_id AND `event_date` = :event_date AND `active_status` = 1 ORDER BY `bid_book_race_id` DESC LIMIT 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_id", $bid_id);
            $stmt->bindParam("event_date", $date);
            $stmt->execute();
            $event = $stmt->fetch(PDO::FETCH_ASSOC);
            return $event;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getRacesforBidDate($bid_id,$date) {
        $sql = "SELECT users.first_name, bid_book_races.price, bid_book_races.created_time
                FROM `bid_book_races`,users
                WHERE `bid_book_id` = :bid_id AND `event_date` = :event_date AND bid_book_races.user_id = users.user_id AND bid_book_races.active_status = 1
                ORDER BY `bid_book_race_id` DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_id", $bid_id);
            $stmt->bindParam("event_date", $date);
            $stmt->execute();
            $event = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $event;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

//date details
    public function dateDetails($property_id,$date) {
        $sql = "SELECT properties.property_id, properties.name, properties.category_id AS category,
                  properties.street, properties.city, properties.state, properties.country,
                  properties.capacity, properties.booking_price, properties.minimum_bid_price AS `min_bid_price`
                  FROM `properties`
                  WHERE properties.property_id = :property_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();
            $datedetails = $stmt->fetch(PDO::FETCH_ASSOC);
            //$owner = $this->getPropertyDetails($property_id);
            $bid = $this->getDatesBidorBook($property_id,$date,1);
            $bid_state = $this->getDatesStatuses($property_id,$date,1);
            $book_state = $this->getDatesStatuses($property_id,$date,2);
//            if ($bid_state['status_id'] == NULL || $bid_state['status_id'] == '2' || $bid_state['status_id'] == '3') {
//                $datedetails['bid_status'] = "";
//            } else {
//                $datedetails['bid_status'] = $bid_state['name'];
//            }
            $datedetails['bid_status'] = ($bid_state['status_id'] == NULL || $bid_state['status_id'] == '2' || $bid_state['status_id'] == '3' ? '' : $bid_state['name']);
            //$datedetails['bid_status'] = ($bid_state['status_id'] == (NULL || '2' || '3') ? '' : $bid_state['name']);
            $datedetails['book_status'] = ($book_state['status_id'] == NULL || $book_state['status_id'] == 1 || $book_state['status_id'] == 3 ? '' : $book_state['name']);
            $bid_id = $bid['event_id'];
            if ($bid_id != NULL && $bid['status_id'] == 1) {
                $latest_bid = $this->getCurrentBidPrice($bid_id,$date);
                $bid_array = array(
                    'no_of_bidders'=>count($this->getNoOfBidders($bid_id,$date)),
                    'bid_start_time'=>$bid['created_time'],
                    'current_bid_price'=>$latest_bid['price'],
                    'races'=>$this->getRacesforBidDate($bid_id,$date)
                );
                $datedetails['bid'] = $bid_array;
            } else {
                $datedetails['bid'] = array();
            }

            return $datedetails;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getBidders($race_id) {
        $sql = "SELECT DISTINCT `user_id` FROM `bid_book_races` WHERE `bid_book_id` = (SELECT `bid_book_id` FROM `bid_book_races` WHERE `bid_book_race_id` = :race_id) AND `bid_book_status_id` IN (1,2,4) AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("race_id", $race_id);
            $stmt->execute();
            $bidders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $bidders;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getBookers($race_id) {
        $sql = "SELECT DISTINCT `user_id` FROM `bid_book_races` WHERE `bid_book_id` = :race_id AND `bid_book_status_id` IN (1,2,4) AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("race_id", $race_id);
            $stmt->execute();
            $bidders = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $bidders;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function insertNotification($userId,$subjectId,$typeId,$statusId = 1) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "INSERT INTO notifications (`owner_id`, `subject_id`, `notification_type_id`, `notification_status_id`, `created_time`,`modified_time`)
                VALUES (:owner_id, :subject_id, :type_id, :status_id, :created_time, :modified_time)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("owner_id", $userId);
            $stmt->bindParam("subject_id", $subjectId);
            $stmt->bindParam("type_id", $typeId);
            $stmt->bindParam("status_id", $statusId);
            $stmt->bindParam("created_time", $datetime);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();
            $notification_id = $this->conn->lastInsertId();
            return $notification_id;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function insertBidBookNotification($pOwner,$userId,$race_id,$type_id) {
        if ($type_id == 1) {
            //bid
            $this->insertNotification($pOwner,$race_id,$type_id);

            $bidders = $this->getBidders($race_id);
            $leng = count($bidders);

            for($i=0;$i<$leng;$i++) {
                $this->insertNotification($bidders[$i]['user_id'],$race_id,$type_id);
            }
        } elseif ($type_id == 2) {
            //book
            //$bookers = $this->getBookers($race_id);
            $this->insertNotification($pOwner,$race_id,$type_id);
            $this->insertNotification($userId,$race_id,$type_id);
        }
        return TRUE;
    }

    public function getBidBookDetails($race_id) {
        $sql = "SELECT bid_book_races.bid_book_id, bid_book_races.user_id, users.first_name AS user_name, users.email_address, users.phone_number, bid_book_races.event_name, bid_book_races.event_date,
                  bid_book_races.price, bid_book_statuses.name AS `status`
                FROM bid_book_races, bids_books, bid_book_statuses, properties, users
                WHERE `bid_book_race_id` =  :race_id AND bid_book_races.bid_book_id = bids_books.bid_book_id AND bid_book_races.bid_book_status_id = bid_book_statuses.bid_book_status_id
                AND bids_books.property_id = properties.property_id AND bid_book_races.user_id = users.user_id AND bid_book_races.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("race_id", $race_id);
            $stmt->execute();
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
            return $details;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getBidBookProperty($race_id) {
        $sql = "SELECT bids_books.property_id, properties.owner_id, properties.name, properties.street, properties.city, properties.state, properties.country
                FROM bid_book_races, bids_books, bid_book_statuses, properties, users
                WHERE `bid_book_race_id` =  :race_id AND bid_book_races.bid_book_id = bids_books.bid_book_id AND bid_book_races.bid_book_status_id = bid_book_statuses.bid_book_status_id
                AND bids_books.property_id = properties.property_id AND bid_book_races.user_id = users.user_id AND bid_book_races.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("race_id", $race_id);
            $stmt->execute();
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
            return $details;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getReviewProperty($review_id) {
        $sql = "SELECT reviews.property_id, properties.owner_id, properties.name, properties.street, properties.city, properties.state, properties.country
                FROM reviews, properties, users
                WHERE `review_id` = :review_id
                AND reviews.property_id = properties.property_id AND reviews.user_id = users.user_id AND reviews.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("review_id", $review_id);
            $stmt->execute();
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
            return $details;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getReviewDetails($review_id) {
        $sql = "SELECT reviews.review_id, reviews.user_id, users.first_name AS user_name, users.email_address, users.phone_number, reviews.rating, reviews.review
                FROM reviews, properties, users
                WHERE `review_id` =  :review_id AND reviews.property_id = properties.property_id AND reviews.user_id = users.user_id AND reviews.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("review_id", $review_id);
            $stmt->execute();
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
            return $details;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getPaymentDetails($bid_book_id) {
        $sql = "SELECT bids_books.bid_book_id, bids_books.user_id, users.first_name AS user_name, users.email_address, users.phone_number, bids_books.event_name, bids_books.event_date,
                  bids_books.price, bid_book_statuses.name AS `status`
                FROM bids_books, bid_book_statuses, properties, users
                WHERE bids_books.bid_book_id = :bid_book_id AND bids_books.bid_book_status_id = bid_book_statuses.bid_book_status_id
                AND bids_books.property_id = properties.property_id AND bids_books.user_id = users.user_id AND bids_books.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bid_book_id);
            $stmt->execute();
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
            return $details;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getPaymentProperty($bid_book_id) {
        $sql = "SELECT bids_books.property_id, properties.owner_id, properties.name, properties.street, properties.city, properties.state, properties.country
                FROM bids_books, bid_book_statuses, properties, users
                WHERE bids_books.bid_book_id =  :bid_book_id AND bids_books.bid_book_status_id = bid_book_statuses.bid_book_status_id
                AND bids_books.property_id = properties.property_id AND bids_books.user_id = users.user_id AND bids_books.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bid_book_id);
            $stmt->execute();
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
            return $details;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

//    public function getBidBookDetails($race_id) {
//        $sql = "SELECT bid_book_races.bid_book_id, bids_books.property_id, properties.owner_id, properties.name, bid_book_races.user_id, users.first_name AS user_name, bid_book_races.event_name, bid_book_races.event_date,
//                  bid_book_races.price, bid_book_statuses.name AS `status`
//                FROM bid_book_races, bids_books, bid_book_statuses, properties, users
//                WHERE `bid_book_race_id` =  :race_id AND bid_book_races.bid_book_id = bids_books.bid_book_id AND bid_book_races.bid_book_status_id = bid_book_statuses.bid_book_status_id
//                AND bids_books.property_id = properties.property_id AND bid_book_races.user_id = users.user_id AND bid_book_races.active_status = 1";
//        try {
//            $stmt = $this->conn->prepare($sql);
//            $stmt->bindParam("race_id", $race_id);
//            $stmt->execute();
//            $details = $stmt->fetch(PDO::FETCH_ASSOC);
//            return $details;
//        } catch(PDOException $e) {
//            echo '{"error":{"text":'. $e->getMessage() .'}}';
//        }
//    }

    public function getNotification($notification_id) {
        $sql = "SELECT notification_id, subject_id, owner_id,
                notification_types.name AS type, notification_statuses.name AS status
                FROM `notifications`, `notification_types`,`notification_statuses`
                WHERE `notification_id` = :notification_id
                AND notifications.notification_type_id = notification_types.notification_type_id
                AND notifications.notification_status_id = notification_statuses.notification_status_id
                AND notifications.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("notification_id", $notification_id);
            $stmt->execute();
            $notification = $stmt->fetch(PDO::FETCH_ASSOC);
            return $notification;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function updateNotificationStatus($owner_id, $notification_id, $status_id) {
        $sql = "UPDATE notifications SET `notification_status_id` = :status_id WHERE `notification_id` = :notification_id AND `owner_id` = :owner_id AND notifications.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("owner_id", $owner_id);
            $stmt->bindParam("notification_id", $notification_id);
            $stmt->bindParam("status_id", $status_id);
            $stmt->execute();
            return TRUE;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function updateNotificationActiveStatus($owner_id, $notification_id) {
        $status_id = 2;
        $sql = "UPDATE notifications SET `active_status` = :status_id WHERE `notification_id` = :notification_id AND `owner_id` = :owner_id AND notifications.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("owner_id", $owner_id);
            $stmt->bindParam("notification_id", $notification_id);
            $stmt->bindParam("status_id", $status_id);
            $stmt->execute();
            return TRUE;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function updateRaceStatus($race_id, $status_id) {
        $sql = "UPDATE bid_book_races SET `bid_book_status_id` = :status_id WHERE `bid_book_race_id` = :race_id AND bid_book_races.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("race_id", $race_id);
            $stmt->bindParam("status_id", $status_id);
            $stmt->execute();
            return TRUE;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function updateBidBook($bidbook_id, $user_id, $event_name, $event_date, $price, $status_id) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "UPDATE `bids_books` SET `user_id` = :user_id, `event_name` = :event_name, `event_date` = :event_date, `price` = :price, `bid_book_status_id` = :bid_book_status_id, `modified_time` = :modified_time WHERE `bid_book_id` = :bidbook_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bidbook_id", $bidbook_id);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("event_name", $event_name);
            $stmt->bindParam("event_date", $event_date);
            $stmt->bindParam("price", $price);
            $stmt->bindParam("bid_book_status_id", $status_id);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();
            return TRUE;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getRaceDetails($notification_subject_id) {
        $sql = "SELECT `bid_book_id`, `user_id`, `event_name`, `event_date`, `price`, `bid_book_status_id`  FROM `bid_book_races` WHERE `bid_book_race_id` = :notification_subject_id AND bid_book_races.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("notification_subject_id", $notification_subject_id);
            $stmt->execute();
            $race = $stmt->fetch(PDO::FETCH_ASSOC);
            return $race;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function bidTimeElapsed($bid_book_id) {
        $sql = "SELECT `created_time`  FROM `bids_books` WHERE `bid_book_id` = :bid_book_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bid_book_id);
            $stmt->execute();
            $time = $stmt->fetch(PDO::FETCH_ASSOC);

            $bid_date = strtotime($time['created_time']);
            $end_date = $bid_date + 172800; //48 hours
            $now_date = time();
            if ($now_date>=$end_date) {
                return TRUE;
            }
            return FALSE;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getNotifications($user_id,$marker=NULL,$type=NULL) {
        if (($marker==NULL) && ($type==NULL)) {
            $cond = "";
        } elseif ($type == 'older') {
            $cond = "`notification_id` < ".$marker."  AND";
        } elseif ($type == 'newer') {
            $cond = "`notification_id` > ".$marker." AND ";
        }

        $sql = "SELECT notification_id, subject_id,
                notification_types.name AS type, notification_statuses.name AS status, notifications.created_time, notifications.modified_time
                FROM `notifications`, `notification_types`,`notification_statuses`
                WHERE ".$cond." `owner_id` = :owner_id
                AND notifications.notification_type_id = notification_types.notification_type_id
                AND notifications.notification_status_id = notification_statuses.notification_status_id
                AND notifications.active_status = 1
                ORDER BY `notification_id` DESC LIMIT 10";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("owner_id", $user_id);
            $stmt->execute();
            $notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $leng = count($notifications);

            for($i=0;$i<$leng;$i++) {
//                $this->insertNotification($bidders[$i]['user_id'],$race_id,$type_id);
                if ($notifications[$i]['type'] == 'bid' || $notifications[$i]['type'] == 'book' || $notifications[$i]['type'] == 'bid_accepted' || $notifications[$i]['type'] == 'book_accepted' || $notifications[$i]['type'] == 'bid_declined' || $notifications[$i]['type'] == 'book_declined' || $notifications[$i]['type'] == 'bid_closed') {
                    $property = $this->getBidBookProperty($notifications[$i]['subject_id']);
                    $image = $this->getAPropertyImage($property['property_id']);
                    $property['image'] = IMAGE_URL_PROPERTIES.$image['url'];
                    $details = $this->getBidBookDetails($notifications[$i]['subject_id']);
                    if ($notifications[$i]['type'] == 'bid') {
                        if ($property['owner_id']==$user_id) {
                            $property['owner'] = TRUE;
                            if ($this->bidTimeElapsed($details['bid_book_id'])) {
                                if ($notifications[$i]['status']=='closed') {
                                    $notifications[$i]['options'] = TRUE;
                                } else {
                                    $notifications[$i]['options'] = FALSE;
                                }
                            }
                        } else {
                            $property['owner'] = FALSE;
                            $notifications[$i]['options'] = FALSE;
                            if ($details['user_id'] == $user_id) {
                                $details['user_name'] = 'You';
                            } else {
                                $details['user_name'] = 'User'.rand(1,9);
                            }
                        }

                    }
                    else {
                        if ($property['owner_id']==$user_id) {
                            $property['owner'] = TRUE;
                            if ($notifications[$i]['status']=='pending') {
                                $notifications[$i]['options'] = TRUE;
                            } else {
                                $notifications[$i]['options'] = FALSE;
                            }
                        } else {
                            $property['owner'] = FALSE;
                            $notifications[$i]['options'] = FALSE;
                            if ($details['user_id'] == $user_id) {
                                $details['user_name'] = 'You';
                            } else {
                                $details['user_name'] = 'User'.rand(1,9);
                            }
                        }
                    }

                    $notifications[$i]['property'] = $property;
                    $notifications[$i]['details'] = $details;
                }
                elseif ($notifications[$i]['type'] == 'review') {
                    $property = $this->getReviewProperty($notifications[$i]['subject_id']);
                    $image = $this->getAPropertyImage($property['property_id']);
                    $property['image'] = IMAGE_URL_PROPERTIES.$image['url'];
                    $details = $this->getReviewDetails($notifications[$i]['subject_id']);

                    $notifications[$i]['property'] = $property;
                    $notifications[$i]['details'] = $details;
                }
                elseif ($notifications[$i]['type'] == 'payment_accepted') {
                    $property = $this->getPaymentProperty($notifications[$i]['subject_id']);
                    $image = $this->getAPropertyImage($property['property_id']);
                    $property['image'] = IMAGE_URL_PROPERTIES.$image['url'];
                    $details = $this->getPaymentDetails($notifications[$i]['subject_id']);

                    if ($property['owner_id']==$user_id) {
                        $property['owner'] = TRUE;
                        $notifications[$i]['options'] = FALSE;
                    } else {
                        $property['owner'] = FALSE;
                        $notifications[$i]['options'] = FALSE;
                    }

                    $notifications[$i]['property'] = $property;
                    $notifications[$i]['details'] = $details;
                }
                elseif ($notifications[$i]['type'] == 'bid_accepted_owner' || $notifications[$i]['type'] == 'book_accepted_owner' || $notifications[$i]['type'] == 'bid_declined_owner' || $notifications[$i]['type'] == 'book_declined_owner' || $notifications[$i]['type'] == 'payment_cancelled_owner' || $notifications[$i]['type'] == 'payment_cancelled') {
                    $property = $this->getBidBookProperty($notifications[$i]['subject_id']);
                    $image = $this->getAPropertyImage($property['property_id']);
                    $property['image'] = IMAGE_URL_PROPERTIES.$image['url'];
                    $details = $this->getBidBookDetails($notifications[$i]['subject_id']);
                    if ($property['owner_id']==$user_id) {
                        $property['owner'] = TRUE;

                    }
                    $notifications[$i]['options'] = FALSE;
                    $notifications[$i]['property'] = $property;
                    $notifications[$i]['details'] = $details;
                }
            }

            return $notifications;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }

    }

    public function calculateRating($property_id) {
        $sql = "SELECT SUM(rating) AS `ratingTotal`, (CASE WHEN (COUNT(DISTINCT user_id) IS NULL) THEN 0 ELSE COUNT(DISTINCT user_id) END) AS `noTotal` FROM `reviews` WHERE `property_id` = :property_id AND `active_status` = 1";
        try {
            $this->conn->beginTransaction();
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();
            $values = $stmt->fetch(PDO::FETCH_ASSOC);
            //return $values;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }

        $newValue = intval($values['ratingTotal']/$values['noTotal']);

        $sql = "UPDATE `properties` SET `rating` = :rating WHERE `property_id` = :property_id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("rating", $newValue);
            $stmt->execute();
            $this->conn->commit();
            return TRUE;

        } catch(PDOException $e) {
            $this->conn->rollBack();
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function hasUserReviewed($user_id,$property_id) {
        $sql = "SELECT `rating` FROM `reviews` WHERE `user_id` = :user_id AND `property_id` = :property_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("user_id", $user_id);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            return $num_rows > 0;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function addReview($userId,$property_id,$review,$rating) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "INSERT INTO reviews (`user_id`, `property_id`, `rating`, `review`, `created_time`, `modified_time`)
                VALUES (:user_id, :property_id, :rating, :review, :created_time, :modified_time)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("user_id", $userId);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("rating", $rating);
            $stmt->bindParam("review", $review);
            $stmt->bindParam("created_time", $datetime);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();
            $review_id = $this->conn->lastInsertId();
            return $review_id;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function updateReview($userId,$property_id,$review,$rating) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "UPDATE `reviews` SET `rating` = :rating, `review` = :review, `modified_time` = :modified_time WHERE `user_id` = :user_id AND `property_id` = :property_id";
        $sqle = "INSERT INTO reviews (`user_id`, `property_id`, `rating`, `review`, `created_time`, `modified_time`)
                VALUES (:user_id, :property_id, :rating, :review, :created_time, :modified_time)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("user_id", $userId);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("rating", $rating);
            $stmt->bindParam("review", $review);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();
            return TRUE;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getReview($property_id,$marker=NULL,$type=NULL) {
        if (($marker==NULL) && ($type==NULL)) {
            $cond = "";
        } elseif ($type == 'older') {
            $cond = "`review_id` < ".$marker."  AND";
        } elseif ($type == 'newer') {
            $cond = "`review_id` > ".$marker." AND ";
        }

        $sql = "SELECT `review_id`, `rating`, `review`, reviews.created_time, reviews.modified_time, users.first_name, users.last_name
                FROM reviews, users
                WHERE reviews.property_id = :property_id AND ".$cond." users.user_id = reviews.user_id AND reviews.active_status = 1
                ORDER BY `review_id` DESC LIMIT 10";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->execute();
            $review = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $review;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getAReviewItem($property_id,$user_id) {
        $sql = "SELECT `review_id`, `rating`, `review`, reviews.created_time, reviews.modified_time, users.first_name, users.last_name
                FROM reviews, users
                WHERE reviews.property_id = :property_id AND reviews.user_id = :user_id AND users.user_id = reviews.user_id AND reviews.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("property_id", $property_id);
            $stmt->bindParam("user_id", $user_id);
            $stmt->execute();
            $review = $stmt->fetch(PDO::FETCH_ASSOC);
            return $review;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function search($query,$typeString,$price_filter,$ratingString,$featureString,$offset,$dir) {
        $newQuery = "%".$query."%";
        $sql = "SELECT SQL_CALC_FOUND_ROWS properties.property_id, `name`, `category_id`, `description`,
                `capacity`, `booking_price`, `minimum_bid_price`, `rating`,
                `street`, `city`, `state`, `country`, `created_time`,
                 air_condition, swim_pool, bar, internet, backup_power, parking, rest_rooms FROM properties, features
                WHERE (`name` LIKE '".$newQuery."' OR `city` LIKE '".$newQuery."' OR `state` LIKE '".$newQuery."' OR `country` LIKE '".$newQuery."')
                AND `category_id` IN (".$typeString.")
                AND ".$price_filter."
                AND `rating` IN (".$ratingString.")
                AND ".$featureString."
                properties.property_id = features.property_id
                AND properties.active_status = 1 ORDER BY `property_id` DESC LIMIT 10 OFFSET ".$offset;
        try {
            $stmt = $this->conn->prepare($sql);
            //$stmt->bindParam("dir", $dir);
            $stmt->execute();
            $myProperties = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $st = $this->conn->prepare('SELECT FOUND_ROWS()');
            $st->execute();
            $rows=$st->fetch();
            $leng = count($myProperties);
            $max_price = 0;

            for($i=0;$i<$leng;$i++) {
                $srcT = $this->getAPropertyImage($myProperties[$i]['property_id']);
                $src = ($srcT['url'] == NULL ? 'default.png' : $srcT['url']);
                $myProperties[$i]['src'] = $dir.$src;


                if ($myProperties[$i]['booking_price']>$max_price) {
                    $max_price = $myProperties[$i]['booking_price'];
                }

                $myProperties[$i]['ac'] = booleanToStringAndViceVersa($myProperties[$i]['air_condition']);
                $myProperties[$i]['pool'] = booleanToStringAndViceVersa($myProperties[$i]['swim_pool']);
                $myProperties[$i]['bar'] = booleanToStringAndViceVersa($myProperties[$i]['bar']);
                $myProperties[$i]['internet'] = booleanToStringAndViceVersa($myProperties[$i]['internet']);
                $myProperties[$i]['bpower'] = booleanToStringAndViceVersa($myProperties[$i]['backup_power']);
                $myProperties[$i]['parking'] = booleanToStringAndViceVersa($myProperties[$i]['parking']);
                $myProperties[$i]['restroom'] = booleanToStringAndViceVersa($myProperties[$i]['rest_rooms']);

                unset($myProperties[$i]['air_condition']);
                unset($myProperties[$i]['swim_pool']);
                unset($myProperties[$i]['backup_power']);
                unset($myProperties[$i]['rest_rooms']);

            }

            $arr = array('result_num'=>intval($rows[0]), 'count'=>$leng, 'max_price' => $max_price, 'properties'=>$myProperties);
            return $arr;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }


    static function booleanToStringAndViceVersa($value) {
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



    //CRON FUNCTIONS

    public function getAcceptedUser($bid_book_id) {
        $sql = "SELECT bid_book_races.bid_book_race_id, bid_book_races.bid_book_id, bid_book_races.user_id, bid_book_races.event_name, bid_book_races.event_date, bid_book_races.price, bid_book_races.bid_book_status_id, users.first_name, users.email_address
                FROM bid_book_races, users WHERE bid_book_races.bid_book_id = :bid_book_id AND bid_book_races.bid_book_status_id = 2 AND bid_book_races.user_id = users.user_id AND bid_book_races.active_status = 1 ORDER BY bid_book_races.bid_book_race_id DESC LIMIT 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bid_book_id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            return $user;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getHighestBidder($bid_book_id) {
        $sql = "SELECT bid_book_races.bid_book_race_id, bid_book_races.bid_book_id, bid_book_races.user_id, bid_book_races.event_name, bid_book_races.event_date, bid_book_races.price, bid_book_races.bid_book_status_id, users.first_name, users.email_address
                FROM bid_book_races, users WHERE bid_book_races.bid_book_id = :bid_book_id AND bid_book_races.user_id = users.user_id AND bid_book_races.active_status = 1 ORDER BY bid_book_races.bid_book_race_id DESC LIMIT 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bid_book_id);
            $stmt->execute();
            $high = $stmt->fetch(PDO::FETCH_ASSOC);
            return $high;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getDeclinedBidders($bid_book_id, $winId) {
        $sql = "SELECT DISTINCT bid_book_races.bid_book_race_id, bid_book_races.bid_book_id, bid_book_races.user_id, bid_book_races.event_name, bid_book_races.event_date, bid_book_races.price, bid_book_races.bid_book_status_id, users.first_name, users.email_address
                FROM bid_book_races, users WHERE bid_book_races.bid_book_id = :bid_book_id AND bid_book_races.user_id != :high AND bid_book_races.user_id = users.user_id AND bid_book_races.active_status = 1 ORDER BY bid_book_races.bid_book_race_id DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bid_book_id);
            $stmt->bindParam("high", $winId);
            $stmt->execute();
            $others = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $others;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getAllBidders($bid_book_id) {
        $sql = "SELECT bid_book_races.bid_book_race_id, bid_book_races.bid_book_id, bid_book_races.user_id, bid_book_races.event_name, bid_book_races.event_date, bid_book_races.price, bid_book_races.bid_book_status_id, users.first_name, users.email_address
                FROM bid_book_races, users WHERE bid_book_races.bid_book_id = :bid_book_id AND bid_book_races.user_id = users.user_id AND bid_book_races.active_status = 1 ORDER BY bid_book_races.bid_book_race_id DESC";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bid_book_id);
            $stmt->execute();
            $others = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $others;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getPropertyOwnerWithBidBookId($bid_book_id) {
        $sql = "SELECT properties.owner_id, users.email_address, users.first_name
                FROM properties, bids_books, users WHERE bids_books.bid_book_id = :bid_book_id AND bids_books.property_id = properties.property_id AND users.user_id = properties.owner_id AND bids_books.active_status = 1
";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bid_book_id);
            $stmt->execute();
            $owner = $stmt->fetch(PDO::FETCH_ASSOC);
            return $owner;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function closeBid($bid_book_id, $status_id) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "UPDATE `bids_books` SET `bid_book_status_id` = :status_id, `modified_time` = :modified WHERE `bid_book_id` = :bid_book_id AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("status_id", $status_id);
            $stmt->bindParam("modified", $datetime);
            $stmt->bindParam("bid_book_id", $bid_book_id);
            $stmt->execute();
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function elapsedDatetime() {
        require_once '../libs/sendgrid-php/sendgrid-php.php';
        require_once 'SendGridEmail.php';
        echo "Arrived"."<br/>";
        $sql = "SELECT `cron_id`, `bid_book_id`, `start_datetime`, `interval_time`, `cron_status_id`, `cron_type_id` FROM crons
              WHERE `cron_status_id` = 1 AND `cron_type_id` = 1 AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $crons = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $leng = count($crons);
            //var_dump($crons);

            for($i=0;$i<$leng;$i++) {
                echo "In 1"." length: ".$leng."<br/>";
                $cron_start_date = strtotime($crons[$i]['start_datetime']);
                $end_date = $cron_start_date + $crons[$i]['interval_time'];
                $now_date = time();
                if ($crons[$i]['cron_type_id'] == 1) { //bid
                    $status_id = 2; //accepted
                    if ($now_date>=$end_date) {
                        //echo "In 2"."<br/>";

                        $bid_closed_id = 4; //closed
                        $this->closeBid($crons[$i]['bid_book_id'], $bid_closed_id);

                        $sendEmail = new SendGridEmail();

                        $highest = $this->getHighestBidder($crons[$i]['bid_book_id']);

                        $pOwner = $this->getPropertyOwnerWithBidBookId($crons[$i]['bid_book_id']);
                        $this->insertNotification($pOwner['owner_id'],$highest['bid_book_race_id'],$bid_closed_id);
                        $sendEmail->bidPropertyOwner($pOwner['email_address'],$pOwner['first_name']);

                        $datetime = date("Y-m-d H:i:s", time());

                        $cron_status_id = 2; //completed
                        $sql = "UPDATE `crons` SET `cron_status_id` = :cron_status_id, `modified_time` = :modified_time WHERE `cron_id` = :cron_id";
                        try {
                            $stmt = $this->conn->prepare($sql);
                            $stmt->bindParam("cron_status_id", $cron_status_id);
                            $stmt->bindParam("modified_time", $datetime);
                            $stmt->bindParam("cron_id", $crons[$i]['cron_id']);
                            $stmt->execute();
                        } catch(PDOException $e) {
                            echo '{"error":{"text":'. $e->getMessage() .'}}';
                        }
                    }
                }

            }

            $arr = array('count'=>$leng, 'crons'=>$crons);
            return $arr;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function sendTwentyFourHourReminders() {
        require_once '../libs/sendgrid-php/sendgrid-php.php';
        require_once 'SendGridEmail.php';
        $sql = "SELECT `payment_id`, `bid_book_id`, `payment_status_id`, `twenty_four_hour_status_id`, `created_time` FROM payments
              WHERE `payment_status_id` = 1 AND `twenty_four_hour_status_id` = 1 AND `active_status` = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $crons = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $leng = count($crons);
            //var_dump($crons);

            for($i=0;$i<$leng;$i++) {
                $created_time = strtotime($crons[$i]['created_time']);
                $end_date = $created_time + 86400;
                $now_date = time();

                if ($now_date>=$end_date) {

                    $sendEmail = new SendGridEmail();

                    $user = $this->getAcceptedUser($crons[$i]['bid_book_id']);
                    $pOwner = $this->getPropertyOwnerWithBidBookId($crons[$i]['bid_book_id']);

                    $this->insertNotification($user['user_id'],$user['bid_book_race_id'],16);
                    $sendEmail->twentyFour($user['email_address'],$user['first_name']);

                    $this->insertNotification($pOwner['owner_id'],$user['bid_book_race_id'],17);
                    $sendEmail->twentyFourOnwer($pOwner['email_address'],$pOwner['first_name']);

                    //$datetime = date("Y-m-d H:i:s", time());

                    $status_id = 2; //Reminder has been sent
                    $sql = "UPDATE `payments` SET `twenty_four_hour_status_id` = :status_id WHERE `payment_id` = :payment_id";
                    try {
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam("status_id", $status_id);
                        $stmt->bindParam("payment_id", $crons[$i]['payment_id']);
                        $stmt->execute();
                    } catch(PDOException $e) {
                        echo '{"error":{"text":'. $e->getMessage() .'}}';
                    }
                }


            }

            $arr = array('count'=>$leng, 'crons'=>$crons);
            return $arr;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }


    public function generateAriyaTicketNo() {
        $characters = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $tic = array();
        while(count($tic)==0) {
            $ticket = "A".$characters[rand(0,25)].rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
            if (!$this->doesTicketNoExist($ticket)) {
                array_push($tic,$ticket);
            }
        }
        return $tic[0];
    }

    private function doesTicketNoExist($ticket) {
        $sql = "SELECT `payment_id` FROM `payments` WHERE `ticket_id` = :ticket";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("ticket", $ticket);
            $stmt->execute();
            $num_rows = $stmt->rowCount();
            return $num_rows > 0;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function openTicket($bidbook_id,$price) {
        $datetime = date("Y-m-d H:i:s", time());
        $ticket_id = $this->generateAriyaTicketNo();

        $ariya_amount = $price*0.05;
        $gateway_amount = $price*0.02;
        $total_amount = $price + $gateway_amount;

        $sql = "INSERT INTO payments (`bid_book_id`, `ticket_id`, `property_amount`, `ariya_amount`, `gateway_amount`, `total_amount`, `created_time`)
                VALUES (:bid_book_id, :ticket_id, :property_amount, :ariya_amount, :gateway_amount, :total_amount, :created_time)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bidbook_id);
            $stmt->bindParam("ticket_id", $ticket_id);
            $stmt->bindParam("property_amount", $price);
            $stmt->bindParam("ariya_amount", $ariya_amount);
            $stmt->bindParam("gateway_amount", $gateway_amount);
            $stmt->bindParam("total_amount", $total_amount);
            $stmt->bindParam("created_time", $datetime);
            $stmt->execute();
            $payment_id = $this->conn->lastInsertId();

            $this->insertPaymentReport($bidbook_id,$ticket_id,$price,$ariya_amount,$gateway_amount,$total_amount);

            return $payment_id;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function insertPaymentReport($bidbook_id,$ticket_id,$property_amt="",$ariya_amt="",$gateway_amt="",$total_amt="",$pay_status=1,$res_status="",$res_msg="",$res_trans_time="",$rrr=NULL,$order_id=NULL) {
        $datetime = date("Y-m-d H:i:s", time());

        $sql = "INSERT INTO payment_reports (`bid_book_id`, `ticket_id`, `rrr`, `order_id`, `property_amount`, `ariya_amount`, `gateway_amount`, `total_amount`, `payment_status_id`, `response_status`, `response_message`, `response_transaction_time`, `created_time`, `modified_time`)
                VALUES (:bid_book_id, :ticket_id, :rrr, :order_id, :property_amount, :ariya_amount, :gateway_amount, :total_amount, :payment_status_id, :response_status, :response_message, :response_transaction_time, :created_time, :modified_time)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bidbook_id);
            $stmt->bindParam("ticket_id", $ticket_id);
            $stmt->bindParam("rrr", $rrr);
            $stmt->bindParam("order_id", $order_id);
            $stmt->bindParam("property_amount", $property_amt);
            $stmt->bindParam("ariya_amount", $ariya_amt);
            $stmt->bindParam("gateway_amount", $gateway_amt);
            $stmt->bindParam("total_amount", $total_amt);
            $stmt->bindParam("payment_status_id", $pay_status);
            $stmt->bindParam("response_status", $res_status);
            $stmt->bindParam("response_message", $res_msg);
            $stmt->bindParam("response_transaction_time", $res_trans_time);
            $stmt->bindParam("created_time", $datetime);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();
//            $payment_id = $this->conn->lastInsertId();
//            return $payment_id;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function getBidBookAndPaymentDetails($bid_book_id) {
        $sql = "SELECT bids_books.bid_book_id,  bids_books.property_id, bids_books.user_id, bids_books.event_name, bids_books.event_date, bids_books.bid_book_type_id, bids_books.bid_book_status_id,
                  bid_book_statuses.name AS `status`, properties.owner_id, users.first_name,
                  payments.ticket_id, payments.order_id, payments.property_amount, payments.ariya_amount, payments.gateway_amount,payments.total_amount, payment_statuses.name AS `payment_status`
                FROM bids_books, bid_book_statuses, properties, users, payments, payment_statuses
                WHERE bids_books.bid_book_id =  :bid_book_id AND bids_books.bid_book_id = payments.bid_book_id AND bids_books.bid_book_status_id = bid_book_statuses.bid_book_status_id
                AND bids_books.property_id = properties.property_id AND properties.owner_id = users.user_id AND payments.payment_status_id = payment_statuses.payment_status_id AND bids_books.active_status = 1";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("bid_book_id", $bid_book_id);
            $stmt->execute();
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
            return $details;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function connectToRemita($totalAmount,$ariyaAmount,$payerName,$payerEmail,$payerPhone,$beneficiaryName2,$beneficiaryAccount2,$bankCode2) {
        //include 'remita_constants.php';
        //$totalAmount = "10000";
        $timesammp=DATE("dmyHis");
        $orderID = $timesammp;
//        $payerName = "VCN Test";
//        $payerEmail = "test@test.com";
//        $payerPhone = "08035267678";
        $responseurl = PATH . "/pay.php";
        $hash_string = MERCHANTID . SERVICETYPEID . $orderID . $totalAmount . $responseurl . APIKEY;
        $hash = hash('sha512', $hash_string);
        $itemtimestamp = $timesammp;
        $itemid1="itemid1";
        $itemid2="34444".$itemtimestamp;
        $beneficiaryName=ARIYA_ACCOUNT_NAME;
        //$beneficiaryName2="Mujib Ishola";
        $beneficiaryAccount=ARIYA_ACCOUNT_NUMBER;
        //$beneficiaryAccount2="123665434";
        $bankCode=ARIYA_BANK_CODE;
        //$bankCode2="050";
        $beneficiaryAmount = $ariyaAmount;
        $beneficiaryAmount2 = $totalAmount-$ariyaAmount;
        $deductFeeFrom=0;
        $deductFeeFrom2=1;
//The JSON data.
        $content = '{"merchantId":"'. MERCHANTID
            .'"'.',"serviceTypeId":"'.SERVICETYPEID
            .'"'.",".'"totalAmount":"'.$totalAmount
            .'","hash":"'. $hash
            .'"'.',"orderId":"'.$orderID
            .'"'.",".'"responseurl":"'.$responseurl
            .'","payerName":"'. $payerName
            .'"'.',"payerEmail":"'.$payerEmail
            .'"'.",".'"payerPhone":"'.$payerPhone
            .'","lineItems":[
{"lineItemsId":"'.$itemid1.'","beneficiaryName":"'.$beneficiaryName.'","beneficiaryAccount":"'.$beneficiaryAccount.'","bankCode":"'.$bankCode.'","beneficiaryAmount":"'.$beneficiaryAmount.'","deductFeeFrom":"'.$deductFeeFrom.'"},
{"lineItemsId":"'.$itemid2.'","beneficiaryName":"'.$beneficiaryName2.'","beneficiaryAccount":"'.$beneficiaryAccount2.'","bankCode":"'.$bankCode2.'","beneficiaryAmount":"'.$beneficiaryAmount2.'","deductFeeFrom":"'.$deductFeeFrom2.'"}
]}';
//        file_put_contents('postjson.json', $content);
        $curl = curl_init(GATEWAYURL);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        $json_response = curl_exec($curl);
        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        $jsonData = substr($json_response, 6, -1);
        $response = json_decode($jsonData, true);
        $statuscode = $response['statuscode'];
        $statusMsg = $response['status'];
        if($statuscode=='025') {
            $rrr = trim($response['RRR']);
            $new_hash_string = MERCHANTID . $rrr . APIKEY;
            $new_hash = hash('sha512', $new_hash_string);
            return array('error'=>FALSE, 'order_id'=>$orderID, 'gatewayurl'=>GATEWAYRRRPAYMENTURL, 'merchantId'=>MERCHANTID, 'rrr'=>$rrr, 'responseurl'=>$responseurl, 'hash'=>$new_hash, 'statuscode'=>$statuscode, 'statusmsg'=>$statusMsg);
        } else {
            return array('error'=>TRUE, 'message'=>'Error Generating RRR - ' .$statusMsg);
        }
    }

    public function updatePayment($ticket_id,$rrr,$order_id,$statuscode="",$statusmsg="") {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "UPDATE `payments` SET `rrr` = :rrr, `order_id` = :order_id, `response_status` = :response_status, `response_message` = :response_message, `modified_time` = :modified_time WHERE `ticket_id` = :ticket_id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("rrr", $rrr);
            $stmt->bindParam("order_id", $order_id);
            $stmt->bindParam("ticket_id", $ticket_id);
            $stmt->bindParam("response_status", $statuscode);
            $stmt->bindParam("response_message", $statusmsg);
            $stmt->bindParam("ticket_id", $ticket_id);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();
            return TRUE;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function updatePaymentAndReport($rrr,$order_id,$status) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "UPDATE `payments` SET  `payment_status_id` = :payment_status_id, `modified_time` = :modified_time WHERE `rrr` = :rrr AND `order_id` = :order_id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("rrr", $rrr);
            $stmt->bindParam("order_id", $order_id);
            $stmt->bindParam("payment_status_id", $status);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();
            //return TRUE;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }

        $sql = "UPDATE `payment_reports` SET  `payment_status_id` = :payment_status_id, `modified_time` = :modified_time WHERE `rrr` = :rrr AND `order_id` = :order_id";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("rrr", $rrr);
            $stmt->bindParam("order_id", $order_id);
            $stmt->bindParam("payment_status_id", $status);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();
            return TRUE;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    /**
     * @param $order_id
     * @return array $details
     */
    public function getBidBookIdFromPayment($order_id) {
        $sql = "SELECT `bid_book_id` FROM `payments` WHERE `order_id` =  :order_id";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("order_id", $order_id);
            $stmt->execute();
            $details = $stmt->fetch(PDO::FETCH_ASSOC);
            return $details;
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function contact($name,$email,$message) {
        $datetime = date("Y-m-d H:i:s", time());
        $sql = "INSERT INTO contacts (`name`, `email_address`, `message`, `created_time`, `modified_time`)
                VALUES (:namer, :email, :message, :created_time, :modified_time)";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam("namer", $name);
            $stmt->bindParam("email", $email);
            $stmt->bindParam("message", $message);
            $stmt->bindParam("created_time", $datetime);
            $stmt->bindParam("modified_time", $datetime);
            $stmt->execute();
            $contact_id = $this->conn->lastInsertId();
            return $contact_id;

        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    public function elapse() {
        require_once '../libs/sendgrid-php/sendgrid-php.php';
        require_once 'SendGridEmail.php';
        $sendEmail = new SendGridEmail();
        $sendEmail->elapse('odumuyiwaleye@yahoo.com','846784');
    }
}

?>