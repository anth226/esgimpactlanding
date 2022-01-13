<?php

require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

$pass = $_ENV['API_KEY'];

$url = 'https://api.sendgrid.com/';

if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
    if( $_POST['email'] != '' && $_POST['type'] != '') {
        $type  = $_POST['type']; 
        $email = $_POST['email'];
        $name  = isset( $_POST['name'] ) ? $_POST['name'] : '';
        if ($type == "subscribe") {
            $file    = 'ESGi_One_Pager.pdf';
            $name    = substr($email, 0, strrpos($email, '@'));
            $subject = 'ESG Impact : You\'re on the list';
            $message = '<div style="text-align: center;" title="Page 1">&nbsp;</div>
            <h2 style="text-align: center;">Thank you for subscribing.</h2>
            <p style="text-align: center;">Soon you\'ll get a chance to try all the new features we\'ve<br />been building for ESG Impact.</p>
            <p style="text-align: center;">Please check our one pager for more information.</p>';
            $from    = 'adamjace@esgi.io';
            $to      = $email;

        } else {

            $file    = '';
            $subject = 'Thank you for contacting us';
            $message = "<p>Thank you $name,</p><p>We have received your message and will get back to you soon!</p><p>Thank you!</p>";
            $from    = $email;
            $to      = 'contact@esgi.io';
        }
		


        $params = array(
            'to'        => $to,     
            'subject'   => $subject,
            'html'      => $message,
            'from'      => $from,
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
        echo $response;


	} else {
		echo '{ "alert": "error", "message": "Please <strong>Fill up</strong> all the Fields and Try Again." }';
    }
}
?>
