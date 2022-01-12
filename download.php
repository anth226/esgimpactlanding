<?php
require_once('./vendor/autoload.php');

use Postmark\PostmarkClient;
use Postmark\Models\PostmarkAttachment;

$email = null;

if (!empty($_GET["email"])) {
    $email = $_GET["email"];
}
if (!empty($_GET["EMAIL"])) {
    $email = $_GET["EMAIL"];
}
if (!empty($_POST["email"])) {
    $email = $_POST["email"];
}
if (!empty($_POST["EMAIL"])) {
    $email = $_POST["EMAIL"];
}

try {
    if (true || $email != null) {
        $currentTime = date("c");
        $client = new PostmarkClient("8280929f-f78a-4692-b6a6-f417e2a09d2b");
        $attachment = PostmarkAttachment::fromFile(dirname(__FILE__) ."/resources/documents/esgi_one_pager-2.pdf", "attachment.pdf", "application/pdf", "cid:attachment.pdf");
        
        // Send an email
        $sendResult = $client->sendEmailWithTemplate(
            "no-reply@aslingga.com",
            "aslingga@gmail.com",
            "esgi-download-document",
            [
                "product_url" => "http://localhost",
                "product_name" => "ESG Impact",
                "name" => "Angga Lingga",
                "action_url" => "http://localhost",
                "company_name" => "Company Name",
                "company_address" => "Company Address",
            ],
            true, NULL, NULL, NULL, NULL, NULL, NULL,
            [$attachment]
        );
        
        if ($sendResult->errorcode == 0) {
            echo json_encode(['result' => 'success', 'message' => 'We have sent the document to your email. Please check your inbox!']);
        } else {
            echo json_encode(['result' => 'error', 'message' => 'Something wrong while sending the email to your inbox!']);
        }
    }

} catch (Exception $e) {
    echo json_encode(['result' => 'error', 'message' => 'Something wrong while sending the email to your inbox!']);
}