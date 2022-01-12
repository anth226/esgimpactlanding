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
        $attachment = PostmarkAttachment::fromFile(dirname(__FILE__) ."/esgi_one_pager-2.pdf", "attachment.pdf", "application/pdf", "cid:attachment.pdf");
        /* $attachment = PostmarkAttachment::fromRawData("attachment content", "hello.txt", "text/plain"); */
        
        // Send an email:
        /* $sendResult = $client->sendEmail('no-reply@aslingga.com',
         'aslingga@gmail.com',
         "Hello from the PHP Postmark Client Tests! ($currentTime)",
         '<b>Hi there!</b>',
         'This is a text body for a test email.',
         NULL, true, NULL, NULL, NULL, NULL, [$attachment]); */
        
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
        
        /* $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'https://api.postmarkapp.com/email');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json', 
            'Content-Type: application/json',     
            'X-Postmark-Server-Token: 8280929f-f78a-4692-b6a6-f417e2a09d2b'
        ]);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{
          "From": "no-reply@aslingga.com",
          "To": "aslingga@gmail.com",
          "Subject": "Download ESG Impact document",
          "TextBody": "Hello dear Postmark user.",
          "HtmlBody": "<html><body><p>Thank you for your insterest to our community. Please find out the document by using this <a href=\"http://localhost/esgimpactlanding/resources/documents/ESGi_One_Pager-2.pdf\" target=\"_blank\">link</a>.</p></html>",
          "MessageStream": "outbound"
        }');
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
            
        if ($output != null) {
            $result = json_decode($output);
            if ($result->ErrorCode == 0) {
                echo json_encode(['success' => true, 'message' => 'We have sent the document to your inbox. Please check your inbox!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Something wrong while sending the email to your inbox!']);
                
            }
        } else {        
            echo json_encode(['success' => false, 'message' => 'Something wrong while sending the email to your inbox!']);
        } */
    }

} catch (Exception $e) {
}