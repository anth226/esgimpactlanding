<?php 
require_once('./vendor/autoload.php');

use Postmark\PostmarkClient;

$currentTime = date("c");
$client = new PostmarkClient("8280929f-f78a-4692-b6a6-f417e2a09d2b");

$name = isset($_POST['cf-name']) ? $_POST['cf-name'] : '';
$email = isset($_POST['cf-email']) ? $_POST['cf-email'] : '';
$company = isset($_POST['cf-subject']) ? $_POST['cf-subject'] : '';
$message = isset($_POST['cf-message']) ? $_POST['cf-message'] : '';
$botCheck = isset($_POST['cf-botcheck']) ? true : false;

if ($botCheck) {
    // Send an email
    $sendResult = $client->sendEmailWithTemplate(
        "no-reply@aslingga.com",
        "aslingga@gmail.com",
        "esgi-contact-page",
        [
            "product_url" => "http://localhost",
            "product_name" => "ESG Impact",
            "user_name" => $name,
            "user_email" => $email,
            "user_company_name" => $company,
            "user_message" => $message,
            "company_name" => "Company Name",
            "company_address" => "Company Address",        
        ],
    );
    
    if ($sendResult->errorcode == 0) {
        echo json_encode(['success' => true, 'message' => 'Thank you for contacting us.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Email <strong>could not</strong> be sent due to some Unexpected Error. Please try again later.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Bot <strong>detected</strong>.! Clean yourself botster.']);
}
?>