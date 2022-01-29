<!-- 
@company - SystemSpecs
@product - Remita
@author - Oshadami Mike
-->
<html>
<head>
<link rel="stylesheet" href="css/bootstrap.min.css">
<link rel="stylesheet" href="css/bootstrap-dark.min.css">
</head>
<body>
  <div class="container">
	<div class="row">
		<div class="col-xs-12">
			<form name="form1" id="form1" action="postjson.php" method="post" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-4 control-label">Payer Name</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" placeholder="Enter Name..." name="name">
					</div>
                </div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Payer Email</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" placeholder="Enter Email..." name="email">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">Payer Phone</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" placeholder="Enter Phone..." name="phone">
					</div>
				</div>						
				 <div class="form-group">
					<div class="col-sm-8 col-sm-offset-4">
						<button class="btn btn-sm btn-primary" id="payButton" type="button">Pay Now</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript" src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
        <script type="text/javascript">
            $(function() {
                $("button#payButton").click(function(){
                  $('form[name=form1]').submit();
                });
              
            });
        </script>
</body>
</html>