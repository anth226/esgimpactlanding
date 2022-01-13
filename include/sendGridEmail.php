<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

$pass = $_ENV['API_KEY'];

$url = 'https://api.sendgrid.com/';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if( $_POST['email'] != '' && $_POST['type'] != '') {
        $type  = $_POST['type']; 
        $client_email = $_POST['email'];
        $client_name  = isset( $_POST['name'] ) ? $_POST['name'] : '';
        $client_message  = isset( $_POST['message'] ) ? $_POST['message'] : '';
        $from    = 'adamjace@esgi.io';
        $to      = $client_email;
        $support      = 'contact@esgi.io';
        if ($type == "subscribe") {
            $file    = 'ESGi_One_Pager.pdf';
            $subject = 'ESG Impact : You\'re on the list';
            $message = '<div style="text-align: center;" title="Page 1">&nbsp;</div>
            <h2 style="text-align: center;">Thank you for subscribing.</h2>
            <p style="text-align: center;">Soon you\'ll get a chance to try all the new features we\'ve<br />been building for ESG Impact.</p>
            <p style="text-align: center;">Please check our one pager for more information.</p>';

        } else {

            $file    = '';
            $subject = 'ESG Impact : Thank you for contacting us';
            $message = "<p>Hello $client_name,</p>
            <p>Thank you for contracting us, we will get back to you shortly.</p>
            <p>Below is the message that you have sent to us for reference.</p>
            <p>&nbsp;</p>
            <blockquote>
            <p style=\"text-align: center;\">Name: \"$client_name\"</p>
            <p style=\"text-align: center;\">Email: \"$client_email\"</p>
            <p style=\"text-align: center;\">Message: \"$client_message\"</p>
            </blockquote>
            <p>&nbsp;</p>
            <p>Thank you,</p>
            <p>ESGi Team</p>";
        }

        $params = array(
            'to'        => $to,   
            'subject'   => $subject,
            'fromname'  => "ESGi Team",
            'bccname'   => "Support",
            'html'      => $message,
            'from'      => $from,
            'bcc'       => $support
        );
        if($file != '') {
            $filePath = dirname(__DIR__, 1) . "/assets";
            $params['files['.$file.']'] = file_get_contents($filePath.'/'.$file);
        }
        
        $request =  $url.'api/mail.send.json';
        $headr = array();
        // set authorization header
        $headr[] = 'Authorization: Bearer '.$pass;
        
        $session = curl_init($request);
        curl_setopt ($session, CURLOPT_POST, true);
        curl_setopt ($session, CURLOPT_POSTFIELDS, $params);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        
        // add authorization header
        curl_setopt($session, CURLOPT_HTTPHEADER,$headr);
        
        $response = curl_exec($session);
        curl_close($session);
        echo json_encode($response);


	} else {
		echo '{ "alert": "error", "message": "Please <strong>Fill up</strong> all the Fields and Try Again." }';
    }
}
?>
