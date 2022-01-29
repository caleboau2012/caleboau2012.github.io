<?php
include_once 'api/include/DbHandler.php';
$db = new DbHandler();
require_once 'api/libs/sendgrid-php/sendgrid-php.php';
require_once 'api/include/SendGridEmail.php';
$sendEmail = new SendGridEmail();
$href = $_SERVER['HTTP_HOST'];

$orderID = "";
if( isset( $_GET['orderID'] )) {
    $orderID = $_GET["orderID"];
}
$response_code ="";
$rrr = "";
$response_message = "";
//Verify Transaction
function remita_transaction_details($orderId){
    $mert =  MERCHANTID;
    $api_key =  APIKEY;
    $concatString = $orderId . $api_key . $mert;
    $hash = hash('sha512', $concatString);
    $url 	= CHECKSTATUSURL . '/' . $mert  . '/' . $orderId . '/' . $hash . '/' . 'orderstatus.reg';
    //  Initiate curl
    $ch = curl_init();
    // Disable SSL verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    // Will return the response, if false it print the response
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set the url
    curl_setopt($ch, CURLOPT_URL,$url);
    // Execute
    $result=curl_exec($ch);
    // Closing
    curl_close($ch);
    $response = json_decode($result, true);
//    echo "RESPONSE";
//    var_dump($response);
//    echo "GET";
//    var_dump($_GET);
    return $response;
}
if($orderID !=null){
    $response = remita_transaction_details($orderID);
    $response_code = $response['status'];
    if (isset($response['RRR']))
    {
        $rrr = $response['RRR'];
    }
    $response_message = $response['message'];
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Àríyá</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
<div class="wrapper">
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button class="navbar-toggle collapsed" type="button" data-target="#collapseNavbar" data-toggle="collapse">
                <span class="sr-only"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a href='<?php echo $href;?>' class="navbar-brand"><img src="img/logo.png" class="header-logo img-responsive"></a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="row">
        <?php
        if($response_code == '01' || $response_code == '00') {
            $db->updatePaymentAndReport($rrr,$orderID,2);
            $bid_bookId = $db->getBidBookIdFromPayment($orderID);
            $details = $db->getBidBookAndPaymentDetails($bid_bookId);
            $db->insertNotification($details['owner_id'],$bid_bookId['bid_book_id'],9);
            $sendEmail->paymentAcceptedPropertyOwner($recipient, $details['first_name'], $details['event_date']);
            ?>

        <br>
        <div class="panel panel-success form-signin">
            <div class="panel-heading">
                <h1 class="panel-title">ePayment Success</h1>
            </div>
            <form>
                <div class="panel-body">
                    <p><b>Order ID: </b><?php echo $orderID; ?><p>
                    <p><b>Remita Retrieval Reference: </b><?php echo $rrr; ?><p>
                    <label>You have successfully completed this transaction. Please click here to continue</label>
                </div>
                <div class="panel-footer">
                    <div class="checkbox">
                        <a href="<?php echo $href . "/listing" ?>" ><button class="btn btn-primary pull-right" >Continue</button></a>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </form>
        </div>
<!--        <h2>Transaction Successful</h2>-->

            <?php
        }else if($response_code == '021') {
            $db->updatePaymentAndReport($rrr,$orderID,3);
            ?>
            <br>
            <div class="panel panel-success form-signin">
                <div class="panel-heading">
                    <h1 class="panel-title">RRR Generated Successfully</h1>
                </div>
                <form>
                    <div class="panel-body">
                        <p><b>Order ID: </b><?php echo $orderID; ?><p>
                        <p><b>Remita Retrieval Reference: </b><?php echo $rrr; ?></p>
                    </div>
                    <div class="panel-footer">
                        <div class="checkbox">
                            <a href="<?php echo $href . "/listing" ?>" ><button class="btn btn-primary pull-right" >Continue</button></a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
<!--        <h2>RRR Generated Successfully</h2>-->
<!--        <p><b>Remita Retrieval Reference: </b>--><?php //echo $rrr; ?><!--<p>-->
            <?php
        }else{
            $db->updatePaymentAndReport($rrr,$orderID,1);
            ?>
<!--        <h2>Your Transaction was not Successful</h2>-->

            <br>
            <div class="col-xs-8 col-xs-offset-2">
                <div class="panel panel-warning form-signin">
                    <div class="panel-heading">
                        <h1 class="panel-title">ePayment Error</h1>
                    </div>
                    <form>
                        <div class="panel-body">
                            <p><b>Order ID: </b><?php echo $orderID; ?><p>
                            <?php if ($rrr !=null){ ?>
                            <p>Your Remita Retrieval Reference is <span><b><?php echo $rrr; ?></b></span><br />
                            <?php } ?>
                            <p><b>Reason: </b><?php echo $response_message; ?><p>
                                <label>An error occurred while performing the transaction, please try again.</label>
                        </div>
                        <div class="panel-footer">
                            <div class="checkbox">
                                <a href="<?php echo $href . "/listing" ?>" ><button class="btn btn-primary pull-right" >Try Again</button></a>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        <?php }?>

    </div>
    <div class="push"></div>
</div>
</div>

<div class="footer">
    <div class="container">
        <div class="row">
            <div class="col-sm-4 text-left">
                <a title="Home Page" ui-sref="home"><img src="img/logo.png" class="img-responsive"></a>
            </div>
            <div class="col-sm-4 text-center">
                <ul class="list-inline">
                    <li><span class="text-info">Own a venue? <a href="publish" title="Rent My Venue" class="btn btn-xs btn-link">Publish-My-Venue</a></span></li>
                </ul>
                <ul class="list-inline">
                    <!-- Privacy things -->
                    <li><a title="Privacy Things" href ui-sref="privacy"><span class="fa fa-lock"></span></a></li>
                    <!-- Terms and Conditions -->
                    <li><a href title="Terms and Conditions" ui-sref="terms"><span class="fa fa-file-text"></span></a></li>
                    <!-- Wetin You Wan Know -->
                    <li><a href title="Wetin You Wan Know" ui-sref="faq"><span class="fa fa-question"></span></a></li>
                    <!-- How E Dey Work -->
                    <li><a href title="How E Dey Work" ui-sref="info"><span class="fa fa-gears"></span></a></li>
                    <!-- Our Gist -->
                    <li><a href="" title="Our Gist" ui-sref="contact"><span class="fa fa-users"></span></a></li>
                </ul>
            </div>
            <div class="col-sm-4 text-right">
                <ul class="list-inline">
                    <li><a><span class="text-info">Follow Us</span></a></li>
                    <!-- Facebook -->
                    <li><a href="" title="Facebook Page" target="_blank" ui-sref="http://www.facebook.com/AriyaEvents"><span class="fa fa-facebook"></span></a></li>
                    <!-- Google Plus -->
                    <li><a href title="Google+ Page" ui-sref="https://plus.google.com/108213839974386475917/about"><span class="fa fa-google-plus"></span></a></li>
                    <!-- Twitter -->
                    <li><a href title="Twitter Account" ui-sref="https://twitter.com/ariyainfo"><span class="fa fa-twitter"></span></a></li>
                </ul>
                <ul class="list-inline">
                    <li><a title="Home Page" ui-sref="home">Àríyá &copy; 2015</a></li>
                </ul>
            </div>
        </div>
        <!--<div class="footer-logo">-->
        <!--<a title="Home Page" ui-sref="home"><img src="img/logo.png" class="img-responsive"></a>-->
        <!--</div>-->
        <!--<div class="footer-navs">-->
        <!--<div class="footer-nav">-->
        <!--<ul class="list-inline footer-left">-->
        <!--<li><a><span class="text-info">Follow Us</span></a></li>-->
        <!--&lt;!&ndash; Facebook &ndash;&gt;-->
        <!--<li><a href="" title="Facebook Page" target="_blank" ui-sref="http://www.facebook.com/AriyaEvents"><span class="fa fa-facebook"></span></a></li>-->
        <!--&lt;!&ndash; Google Plus &ndash;&gt;-->
        <!--<li><a href title="Google+ Page" ui-sref="https://plus.google.com/108213839974386475917/about"><span class="fa fa-google-plus"></span></a></li>-->
        <!--&lt;!&ndash; Twitter &ndash;&gt;-->
        <!--<li><a href title="Twitter Account" ui-sref="https://twitter.com/ariyainfo"><span class="fa fa-twitter"></span></a></li>-->
        <!--</ul>-->
        <!--<ul class="list-inline footer-right">-->
        <!--<li><span class="text-info">Own a venue? <a href="publish" title="Rent My Venue" class="btn btn-xs btn-link">Publish-My-Venue</a></span></li>-->
        <!--</ul>-->
        <!--</div>-->
        <!--<div class="footer-nav">-->
        <!--<ul class="list-inline footer-left">-->
        <!--<li><a title="Home Page" ui-sref="home">Àríyá &copy; 2015</a></li>-->
        <!--</ul>-->
        <!--<ul class="list-inline footer-right">-->
        <!--&lt;!&ndash; Privacy things &ndash;&gt;-->
        <!--<li><a title="Privacy Things" href ui-sref="privacy"><span class="fa fa-lock"></span></a></li>-->
        <!--&lt;!&ndash; Terms and Conditions &ndash;&gt;-->
        <!--<li><a href title="Terms and Conditions" ui-sref="terms"><span class="fa fa-file-text"></span></a></li>-->
        <!--&lt;!&ndash; Wetin You Wan Know &ndash;&gt;-->
        <!--<li><a href title="Wetin You Wan Know" ui-sref="faq"><span class="fa fa-question"></span></a></li>-->
        <!--&lt;!&ndash; How E Dey Work &ndash;&gt;-->
        <!--<li><a href title="How E Dey Work" ui-sref="info"><span class="fa fa-gears"></span></a></li>-->
        <!--&lt;!&ndash; Our Gist &ndash;&gt;-->
        <!--<li><a href="" title="Our Gist" ui-sref="contact"><span class="fa fa-users"></span></a></li>-->
        <!--</ul>-->
        <!--</div>-->
        <!--</div>-->
    </div>
</div>
<script type="text/javascript" src="js/vendor/jquery.min.js"></script>
<script type="text/javascript" src="js/vendor/bootstrap.js"></script>
</body>
</html>
