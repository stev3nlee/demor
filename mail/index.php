// <?php
// require 'PHPMailerAutoload.php';
// require 'generate.php';

// $mail = new PHPMailer;

// $mail->isSMTP();
// $mail->Host = 'smtp.gmail.com';
// $mail->SMTPAuth = true;
// $mail->Username = 'demorboutique11@gmail.com';
// $mail->Password = 'D3m0r123';
// $mail->SMTPSecure = 'tls';
// $mail->Port = 587;
// $mail->isHTML(true);

// $mail->setFrom('demorboutique11@gmail.com', 'noreply@demorboutique.com');
// $mail->addReplyTo("demorboutique11@gmail.com", "");
// $mail->addAddress("frankykwek@rocketmail.com"); 
// $mail->addAddress($_REQUEST['emailFrom']); 

// $mailLoader = new Mail;
// $cons = $_REQUEST['cons'];
// $data = $_REQUEST['data'];
// $cons = 'order';
// $data = null;

// $mail->Subject = $mailLoader->getSubject($cons);
// $mail->Body    = $mailLoader->getBody($cons, $data); 

// if(!$mail->send()) {
    // echo '<p>Message could not be sent.</p>';
    // echo '<p>Mailer Error: ' . $mail->ErrorInfo . '</p>';
// } else {
    // echo '<p>Message has been sent</p>';
// }