<?php


$request = array(
	"merchantAccount" => "AlbertoLSpanish",
	"browserInfo.userAgent" => $_SERVER['HTTP_USER_AGENT'],
	"browserInfo.acceptHeader" => $_SERVER['HTTP_ACCEPT'],
	"md" => $_POST['MD'],
	"paResponse" => $_POST['PaRes'],
	"shopperIP" => "83.41.111.116",
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://pal-test.adyen.com/pal/servlet/Payment/v18/authorise3d");
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_USERPWD, "ws_608162@Company.AdyenTechSupport:HK*+@te9KzA>^^b4u@A^IaSC&");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);

if ($result === false)
	echo "Error: " . curl_error($ch);
else {
	/**
	 * If the payment passes validation a risk analysis will be done and, depending on the
	 * outcome, an authorisation will be attempted. You receive a
	 * payment response with the following fields:
	 * - pspReference: The reference we assigned to the payment;
	 * - resultCode: The result of the payment. One of Authorised, Refused or Error;
	 * - authCode: An authorisation code if the payment was successful, or blank otherwise;
	 * - refusalReason: If the payment was refused, the refusal reason.
	 */
	parse_str($result, $result);
	print_r($result);
}

curl_close($ch);

?>
