<?php
  $json = file_get_contents('php://input');
if($json) {
    $data = json_decode($json, true);
    $visitor_name = "";
    $visitor_email = "";
    $visitor_phone = "";
    $visitor_message = "";
    $email_body = "<div>";
    $recipient = "elbadembele@gmail.com";
      
    if(isset($data['visitor_name'])) {
        $visitor_name = filter_var($data['visitor_name'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Visitor Name:</b></label>&nbsp;<span>".$visitor_name."</span>
                        </div>";
    }
 
    if(isset($data['visitor_email'])) {
        $visitor_email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $data['visitor_email']);
        $visitor_email = filter_var($visitor_email, FILTER_VALIDATE_EMAIL);
        $email_body .= "<div>
                           <label><b>Visitor Email:</b></label>&nbsp;<span>".$visitor_email."</span>
                        </div>";
    }
      
    if(isset($data['visitor_phone'])) {
        $visitor_phone = filter_var($data['visitor_phone'], FILTER_SANITIZE_STRING);
        $email_body .= "<div>
                           <label><b>Visitor phone:</b></label>&nbsp;<span>".$visitor_phone."</span>
                        </div>";
    }
      

      
    if(isset($data['visitor_message'])) {
        $visitor_message = htmlspecialchars($data['visitor_message']);
        $email_body .= "<div>
                           <label><b>Visitor Message:</b></label>
                           <div>".$visitor_message."</div>
                        </div>";
    }
      

    $email_body .= "</div>";
 
    $headers  = 'MIME-Version: 1.0' . "\r\n"
    .'Content-type: text/html; charset=utf-8' . "\r\n"
    .'From: ' . $visitor_email . "\r\n";
      
    echo $email_body;
    /* if(mail($recipient, $email_title, $email_body, $headers)) {
        echo "<p>Thank you for contacting us, $visitor_name. You will get a reply within 24 hours.</p>";
    } else {
        echo '<p>We are sorry but the email did not go through.</p>';
    } */
      
} else {
    echo json_encode(array("status" => "400"));
}
?>