<?php

require "vendor/autoload.php";

use Mailgun\Mailgun;

$mg   = new Mailgun("<REMOVED>");
$dom  = "<REMOVED>";
$to = array(
	"test@example.com"
);

$errorMSG = "";

// NAME
if (empty($_POST["name"])) {
    $errorMSG = "Name is required ";
} else {
    $name = $_POST["name"];
}

// EMAIL
if (empty($_POST["email"])) {
    $errorMSG .= "Email is required ";
} else {
    $email = $_POST["email"];
}

// GUESTS
if (empty($_POST["guests"])) {
    $guests = "None Submitted";
} else {
    $guests = $_POST["guests"];
}

// SONG
if (empty($_POST["song"])) {
    $song = "None Submitted";
} else {
    $song = $_POST["song"];
}

// COUNTRY
if (empty($_POST["country"])) {
    $errorMSG .= "Country is required ";
} else {
    $country = $_POST["country"];
}

// MESSAGE
if (empty($_POST["message"])) {
    $message = "None Submitted";
} else {
    $message = $_POST["message"];
}


// prepare email body text
$body = "
<html>
<head>
  <title>Wedding RSVP Received</title>
</head>
<body>
  <table>
    <tr>
      <td><em>Name:</em></td>
      <td>$name</td>
    </tr>
    <tr>
      <td><em>Email:</em></td>
      <td>$email</td>
    </tr>
    <tr>
      <td><em>Guests:</em></td>
      <td>$guests</td>
    </tr>
    <tr>
      <td><em>Song:</em></td>
      <td>$song</td>
    </tr>
    <tr>
      <td><em>Country:</em></td>
      <td>$country</td>
    </tr>
    <tr>
      <td><em>Message:</em></td>
      <td>$message</td>
    </tr>
  </table>
</body>
</html>
";


$sendErrMsg = "";

foreach($to as &$addr) {
	$res = $mg->sendMessage(
		$dom,
		array(
			'from'    => 'Wedding RSVP <>',
			'to'      => $addr,
			'subject' => "New Wedding RSVP Received from $name",
			'html'    => $body
		)
	);

	if ($res->http_response_code != 200) {
		$sendErrMsg .= $res->message . "<br>";
	}
}

// redirect to success page
if ($sendErrMsg == "" && $errorMSG == ""){
   echo "success";
} else {
    if($errorMSG == ""){
  	echo "An error occured: " . $sendErrMsg;
    } else {
        echo $errorMSG;
    }
}

?>
