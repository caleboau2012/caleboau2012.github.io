<?php
include_once 'api/include/PassHash.php';
include_once 'api/include/DbHandler.php';
$href = $_SERVER['HTTP_HOST'];
if (isset($_GET['email']) && isset($_GET['token'])) {
    $email = $_GET['email'];
    $token = $_GET['token'];
    if (PassHash::check_email($token,$email,"register")) {
        $db = new DbHandler();
	$userEmail = $db->getUserByEmail($email);
        $active = $userEmail['active_status'];

        if ($active==2) {
            $db->verifyUser($email);
            $label = "Your account has been verified. Login to edit your account details.";
            $labelButton = "Login to your account";
        } else {
            $label = "Your account has already been verified.";
            $labelButton = "Login to your account";
        }


    } else {
        $label = "An error occurred. Resend the verification mail.";
        $labelButton = "Resend Verification Mail";
    }

} else {
    header("location: " . $href);
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
        <br>
        <div class="col-xs-8 col-xs-offset-2">
            <div class="panel panel-primary form-signin">
                <div class="panel-heading">
                    <h1 class="panel-title">Verify Account</h1>
                </div>
                <form>
                    <div class="panel-body">
                        <label><?php echo $label; ?></label>
                    </div>
                    <div class="panel-footer">
                        <div class="checkbox">
                            <a href="<?php echo $href ?>" ><button class="btn btn-primary pull-right" ><?php echo $labelButton; ?></button></a>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
