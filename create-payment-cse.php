<html>
	<head>
		<title>Adyen - CSE 3DS 2.0 example</title>
	 <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	 <script src="./js/threedsSDK.0.9.5.min.js"></script>
	</head>
<?php

if(isset($_POST['adyen-encrypted-data']))
{
		 $request = array(
		 	"merchantAccount" => "AlbertoLSpanish",
		 	"amount.currency" => "EUR",
		 	"amount.value" => "2000",
		 	"reference" => "CSE-TEST-" . time(),
		 	"shopperEmail" => "al@berting.com",
		 	"fraudOffset" => "0",
		 	"additionalData.card.encrypted.json" => $_POST['adyen-encrypted-data'],
		 	"browserInfo.userAgent" => $_SERVER['HTTP_USER_AGENT'],
		 	"browserInfo.acceptHeader" => $_SERVER['HTTP_ACCEPT'],
			"threeDS2RequestData.deviceChannel" => "browser",
			"threeDS2RequestData.notificationURL" => "http://localhost:8080/sale3D20/return-after-challenge.php",
			"shopperIP" => "83.41.111.116",
		 	);

		 $ch = curl_init();
		 curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/servlet/Payment/v40/authorise");
		 curl_setopt($ch, CURLOPT_HEADER, false);
		 curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC  );
		 curl_setopt($ch, CURLOPT_USERPWD, "ws_608162@Company.AdyenTechSupport:HK*+@te9KzA>^^b4u@A^IaSC&");
		 curl_setopt($ch, CURLOPT_POST,1);
		 curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($request));
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

		 $result = curl_exec($ch);

		 if($result === false)
		 	echo "Error: " . curl_error($ch);
		 else{
		 	parse_str($result, $result);
	   	print_r(($result));

			if ($result['resultCode'] == 'ThreeDS2Method') {
				echo "3D Secure 2.0";
			?>

			<?php
	   	} elseif ($result['resultCode'] == 'RedirectShopper') {
				echo "3D Secure";
	   	}
		}
	   	curl_close($ch);
}

?>

	 <body>
		<form method="POST" action="http://localhost:8080/sale3D20/create-payment-cse.php" id="adyen-encrypted-form">
			<fieldset>
				<legend>Card Details</legend>
					<label for="adyen-encrypted-form-number">
						Card Number
						<input type="text" id="adyen-encrypted-form-number" value="4212 3456 7890 1245" size="20" autocomplete="off" data-encrypted-name="number" />
                    </label>
                    <label for="adyen-encrypted-form-holder-name">
						Card Holder Name
						<input type="text" id="adyen-encrypted-form-holder-name" value="Alberto Lopez" size="20" autocomplete="off" data-encrypted-name="holderName" />
					</label>
					<label for="adyen-encrypted-form-cvc">
						CVC
						<input type="text" id="adyen-encrypted-form-cvc" value="737" size="4" autocomplete="off" data-encrypted-name="cvc" />
					</label>
					<label for="adyen-encrypted-form-expiry-month">
						Expiration Month (MM)
						<input type="text" value="10"   id="adyen-encrypted-form-expiry-month" size="2"  autocomplete="off" data-encrypted-name="expiryMonth" /> /
					</label>
					<label for="adyen-encrypted-form-expiry-year">Expiration Year (YYYY)
						<input type="text" value="2020" id="adyen-encrypted-form-expiry-year"  size="4"  autocomplete="off" data-encrypted-name="expiryYear" />
					</label>

					<input type="hidden" id="adyen-encrypted-form-expiry-generationtime" value="<?php date_default_timezone_set('Europe/Amsterdam'); echo date("c")?>" data-encrypted-name="generationtime" />
					<input type="submit" value="Create payment" />
			</fieldset>
		</form>

		<div id="threedsOverlay" class="threeds-overlay">
        <div id="threedsContainer" class="threeds-cont" style="width:600px;height:400px;"></div>
    </div>
		
		<script type="text/javascript" src="../js/adyen.encrypt.min.js"></script>
		<script type="text/javascript">
			var form    = document.getElementById('adyen-encrypted-form');
			/* Put your WS users' CSE key here */
			/* Adyen CA -> Settings -> Users -> Choose the WS user -> Copy CSE key */
			var key = "10001|CDFE557350396C1E135C1C89316EDD21EAB9ED7E193DC2749D78235229BA152643AE9078FED772F8A7F5DCCC94422C3FAF0959B38CC8389269AEB14C4898EA7C289DA18A95DA8C2DF3F25B8A63AD6651721722F1F62901CA0AF4C3B30278E8E67B052588F5ED03E09C196D6F1E809D6952A56A306D3040F6A4069CA8CFF4C387397377AB1ADD0F061910C577855BCD25C70723BC494F9E37626332A6B049BDDFF76E96626865C7F3F321575F91F989F78000A69C560C7640654CB869F1C34AFF533C3B88957CE4990E23E758C8640F7AF6BA3A38B70ED81017A0A26B00AA99F9B58EB9F08A72C1C8EE8906C578385A9412295F49997CB4C03C11AC4C07A9B977";
			 adyen.encrypt.createEncryptedForm( form, key, {});
		</script>
	 </body>
 </html>
