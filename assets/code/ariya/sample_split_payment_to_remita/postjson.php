<!-- 
@company - SystemSpecs
@product - Remita
@author - Oshadami Mike
-->
<?php
include 'remita_constants.php';
$totalAmount = "3000";
$timesammp=DATE("dmyHis");		
$orderID = $timesammp;
$payerName = $_POST["name"];
$payerEmail = $_POST["email"];
$payerPhone = $_POST["phone"];
$responseurl = PATH . "/sample-receipt-page.php";
$hash_string = MERCHANTID . SERVICETYPEID . $orderID . $totalAmount . $responseurl . APIKEY;
$hash = hash('sha512', $hash_string);
$itemtimestamp = $timesammp;
$itemid1="itemid1";
$itemid2="34444".$itemtimestamp;
$itemid3="8694".$itemtimestamp;
$beneficiaryName="Oshadami Mke";
$beneficiaryName2="Mujib Ishola";
$beneficiaryName3="Ogunseye Olarewanju";
$beneficiaryAccount="3455665434";
$beneficiaryAccount2="123665434";
$beneficiaryAccount3="1264565434";
$bankCode="011";
$bankCode2="050";
$bankCode3="070";
$beneficiaryAmount ="1000";
$beneficiaryAmount2 ="1000";
$beneficiaryAmount3 ="1000";
$deductFeeFrom=1;
$deductFeeFrom2=0;
$deductFeeFrom3=0;
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
{"lineItemsId":"'.$itemid2.'","beneficiaryName":"'.$beneficiaryName2.'","beneficiaryAccount":"'.$beneficiaryAccount2.'","bankCode":"'.$bankCode2.'","beneficiaryAmount":"'.$beneficiaryAmount2.'","deductFeeFrom":"'.$deductFeeFrom2.'"},
{"lineItemsId":"'.$itemid3.'","beneficiaryName":"'.$beneficiaryName3.'","beneficiaryAccount":"'.$beneficiaryAccount3.'","bankCode":"'.$bankCode3.'","beneficiaryAmount":"'.$beneficiaryAmount3.'","deductFeeFrom":"'.$deductFeeFrom3.'"}
]}';
file_put_contents('postjson.json', $content);
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
if($statuscode=='025'){
$rrr = trim($response['RRR']);
$new_hash_string = MERCHANTID . $rrr . APIKEY;
$new_hash = hash('sha512', $new_hash_string);
echo '<html>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-dark.min.css">
</head>
<body>
  <div class="container">
	<div class="row">
    <div class="col-xs-12 col-md-9 col-lg-7">

<form action="'.GATEWAYRRRPAYMENTURL.'" method="POST">
<input id="merchantId" name="merchantId" value="'.MERCHANTID.'" type="hidden"/>
<input id="rrr" name="rrr" value="'.$rrr.'" type="hidden"/>
<input id="responseurl" name="responseurl" value="'.$responseurl.'" type="hidden"/>
<input id="hash" name="hash" value="'.$new_hash.'" type="hidden"/>
<div class="form-group">
	<label class="col-sm-4 control-label">Payment Type</label>
	<div class="col-sm-8">
		<select name="paymenttype" class="form-control">
			<option value=""> -- Select --</option>
			<option value="REMITA_PAY"> Remita Account Transfer</option>
			<option value="Interswitch"> Verve Card</option>
			<option value="UPL"> Visa</option>
			<option value="UPL"> MasterCard</option>
			<option value="PocketMoni"> PocketMoni</option>
			<option value="RRRGEN"> POS</option>
			<option value="ATM"> ATM</option>
			<option value="BANK_BRANCH">BANK BRANCH</option>
			<option value="BANK_INTERNET">BANK INTERNET</option>
		</select>
	</div>
</div>
 <div class="form-group">
	<div class="col-sm-8 col-sm-offset-4">
		<input type="submit" class="btn btn-sm btn-primary" name="submit" value="Submit" />
	</div>
</div>
	</form>
</div>
</div>
</div>
</body>
</html>';
}
else{
echo "Error Generating RRR - " .$statusMsg;
}
?>