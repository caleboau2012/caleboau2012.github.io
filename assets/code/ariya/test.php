<?php
//$to      = 'odumuyiwaleye@gmail.com';
//$subject = 'the subject';
//$message = 'hello';
//$headers = 'From: webmaster@ariya.com.ng' . "\r\n" .
//    'Reply-To: webmaster@ariya.com.ng' . "\r\n" .
//    'X-Mailer: PHP/' . phpversion();
//
//mail($to, $subject, $message, $headers);
//echo "TEST";
//?><!-- -->


<?php
//require_once ('api/include/Mail.php');
//require_once ('api/include/Config.php');
//require_once ('api/include/PassHash.php');
//
//$email = "odumuyiwaleye@gmail.com";
//$verifyToken = PassHash::emailHash($email,"register");
//$mail = new Mail();
//$mail->send($email,"Welcome Message","Welcome to Ariya. Visit ".VERIFY_ACCOUNT_URL."?email=".$email."&token=".$verifyToken);

//require_once ('api/include/PassHash.php');
//
//$email = "leye@leye.com";
//$emailhash = PassHash::emailHash($email);
//
//echo $emailhash;
//
//if (PassHash::check_email($emailhash,$email)) {
//    echo "TRUE";
//} else {
//    echo "FALSE";
//}
///**
// * Created by PhpStorm.
// * User: kaylee
// * Date: 5/17/15
// * Time: 3:56 AM
// */
?>

<html>
      <body>
            <form action="http://www.remitademo.net/remita/ecomm/init.reg" name="SubmitRemitaForm" method="POST">
                  <input name="merchantId" value="1509328648353" type="hidden">
                  <input name="serviceTypeId" value="1509328543428" type="hidden">
                  <input name="orderId" value="8792" type="hidden">
                  <input name="hash" value="ABCED12D3E1476DEFA12" type="hidden">
                  <input name="payerName" value="Customer Name" type="hidden">
                  <input name="payerEmail" value="customer_email@email.com" type="hidden">
                  <input name="payerPhone" value="080211111111" type="hidden">
                  <input name="amt" value="7000" type="hidden">
                  <input name="responseurl" value="http://www.yourwebsite.com/response.php" type="hidden">
                  <input type ="submit" name="submit_btn" value="Pay Via Remita">
           </form>
      </body>
</html>