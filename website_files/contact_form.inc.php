<?php
//Create an instance; passing `true` enables exceptions
require_once "functions.inc.php";
//phpmailer import
require "./PHPMailer/src/Exception.php";
require "./PHPMailer/src/PHPMailer.php";
require "./PHPMailer/src/SMTP.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$output_email = "apozin@bu.edu";

$MAX_LENGTHS = 
            [
              "first_name"      => 50,
              "last_name"       => 50,
              "company_name"    => 50,
              "email"           => 70,
              "phone"           => 20,
              "message_subject" => 300,
              "message"         => 5000
            ];

$PATTERNS = 
            [
            "email" => '/^[^0-9][_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/',
            "phone" => '/^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/',
            "name"  => '/^[\w\'\-,.]*[^_!¡?÷?¿\/\\+=@#$%ˆ&*(){}|~<>;:[\]]*$/'
            ];

$required_fields = ["first_name","last_name","email","message_subject","message"];

$location_path_error = "LOCATION: ./contact_us.php?error=";
$location_path_success = "LOCATION: ./form_submitted_success.php";

if($_SERVER['REQUEST_METHOD'] === "POST"){
    /*check if required fields are filled*/
    if (!(checkRequiredFields($_POST,$required_fields))){ 
        header("LOCATION: ./contact_us.php?error=Empty_Required_Fields");
        exit();
    }
    /*delete empty optional keys from _POST array so they won't interfere with validation and sanitization*/
    if($_POST["company_name"] === ""){
        unset($_POST["company_name"]);
        unset($MAX_LENGTHS["company_name"]);
    }

    if($_POST["phone"] === ""){
        unset($_POST["phone"]);
        unset($MAX_LENGTHS["phone"]);
    }

    /*check length of each input*/
    $validateLengthValue = validateLength($_POST, $MAX_LENGTHS);
    if (!empty($validateLengthValue)){
        $location_str = $location_path_error . "invalid_length_of_" . implode(",", $validateLengthValue);
        header($location_str);
        exit();
    }
    /*check format of names, phone, and email*/
    $validateFormatValue = validateFormat($_POST, $PATTERNS);
    if (!empty($validateFormatValue)){
        $location_str = $location_path_error . "invalid_format_of_" . implode(",", $validateFormatValue);
        header($location_str);
        exit;
    }
    /*sanitize data and save it*/
    $user_info = sanitize($_POST);

    /*if we've made it this far, that means we've validated and sanitized everything, setup headers and mail*/
    $headers  = 'Content-Type: text/plain; charset=utf-8' . "\r\n"; 
    $headers .= 'Content-Transfer-Encoding: base64' . "\r\n";
    $headers .= 'MIME-Version: 1.0'."\r\n";


    $message_out = $user_info["last_name"].", ".$user_info["first_name"].":";
    /*if phone or company are set, append to the start of the message*/
    if(isset($user_info["company_name"])){
        $message_out .= ", ".$user_info["company_name"];
    }
    if(isset($user_info["phone"])){
        $message_out .= ", ".$user_info["phone"];
    }
    /*append \n" to the from line to complete message*/
    $message_out .= ", ".$user_info["email"].":\n\n".$user_info["message"];
    //setup phpmailer
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'ssl://smtp.titan.email';               //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'admin@inventbattery.com';              //SMTP username
        $mail->Password   = 'kartina12';                            //SMTP password
//      $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->SMTPSecure = 'ssl';
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        $mail->SMTPAutoTLS = false;
        //Recipients
        $mail->setFrom   ('admin@inventbattery.com');
        $mail->addAddress('admin@inventbattery.com');               //Add a recipient

        //Content
        $mail->Subject = $user_info["message_subject"];
        $mail->Body    = $message_out;

        $mail->send();
        header($location_path_success);
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Please contact inventbattery@gmail.com with error. Mailer Error: {$mail->ErrorInfo}";
    }
}
