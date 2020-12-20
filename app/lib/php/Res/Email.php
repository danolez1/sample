<?php

namespace danolez\lib\Res\Email;

// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
// use PHPMailer\PHPMailer\OAuth;
// use Tx\Mailer;

// class Email extends PHPMailer
// {

//     public function __construct()
//     {
//         parent::__construct();
//     }


//     // public function uploadAndSendFile()
//     // {
//     //     $msg = '';
//     //     if (array_key_exists('userfile', $_FILES)) {
//     //         // First handle the upload
//     //         // Don't trust provided filename - same goes for MIME types
//     //         // See http://php.net/manual/en/features.file-upload.php#114004 for more thorough upload validation
//     //         $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['userfile']['name']));
//     //         if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
//     //             // Upload handled successfully
//     //             // Now create a message
//     //             $mail = new PHPMailer;
//     //             $mail->setFrom('from@example.com', 'First Last');
//     //             $mail->addAddress('whoto@example.com', 'John Doe');
//     //             $mail->Subject = 'PHPMailer file sender';
//     //             $mail->Body = 'My message body';
//     //             // Attach the uploaded file
//     //             $mail->addAttachment($uploadfile, 'My uploaded file');
//     //             if (!$mail->send()) {
//     //                 $msg .= 'Mailer Error: ' . $mail->ErrorInfo;
//     //             } else {
//     //                 $msg .= 'Message sent!';
//     //             }
//     //         } else {
//     //             $msg .= 'Failed to move file to ' . $uploadfile;
//     //         }
//     //     }

//     //     //     <form method="post" enctype="multipart/form-data">
//     //     //     <input type="hidden" name="MAX_FILE_SIZE" value="100000"> Send this file: <input name="userfile" type="file">
//     //     //     <input type="submit" value="Send File">
//     //     // </form>

//     //     $mail->From = "from@yourdomain.com";
//     //     $mail->FromName = "Full Name";

//     //     $mail->addAddress("recipient1@example.com", "Recipient Name");

//     //     //Provide file path and name of the attachments
//     //     $mail->addAttachment("file.txt", "File.txt");
//     //     $mail->addAttachment("images/profile.png"); //Filename is optional

//     //     $mail->isHTML(true);

//     //     $mail->Subject = "Subject Text";
//     //     $mail->Body = "<i>Mail body in HTML</i>";
//     //     $mail->AltBody = "This is the plain text version of the email content";

//     //     try {
//     //         $mail->send();
//     //         echo "Message has been sent successfully";
//     //     } catch (Exception $e) {
//     //         echo "Mailer Error: " . $mail->ErrorInfo;
//     //     }
//     // }
//     // public function uploadAndSendMFiles()
//     // {
//     //     $msg = '';
//     //     if (array_key_exists('userfile', $_FILES)) {
//     //         // Create a message
//     //         $mail = new PHPMailer;
//     //         $mail->setFrom('from@example.com', 'First Last');
//     //         $mail->addAddress('whoto@example.com', 'John Doe');
//     //         $mail->Subject = 'PHPMailer file sender';
//     //         $mail->Body = 'My message body';
//     //         //Attach multiple files one by one
//     //         for ($ct = 0; $ct < count($_FILES['userfile']['tmp_name']); $ct++) {
//     //             $uploadfile = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['userfile']['name'][$ct]));
//     //             $filename = $_FILES['userfile']['name'][$ct];
//     //             if (move_uploaded_file($_FILES['userfile']['tmp_name'][$ct], $uploadfile)) {
//     //                 $mail->addAttachment($uploadfile, $filename);
//     //             } else {
//     //                 $msg .= 'Failed to move file to ' . $uploadfile;
//     //             }
//     //         }
//     //         if (!$mail->send()) {
//     //             $msg .= 'Mailer Error: ' . $mail->ErrorInfo;
//     //         } else {
//     //             $msg .= 'Message sent!';
//     //         }
//     //     }

//     //     //     <form method="post" enctype="multipart/form-data">
//     //     //     <input type="hidden" name="MAX_FILE_SIZE" value="100000">
//     //     //     Select one or more files:
//     //     //     <input name="userfile[]" type="file" multiple="multiple">
//     //     //     <input type="submit" value="Send Files">
//     //     // </form>
//     // }

//     // public function test()
//     // {
//     //     $mail = new Email(true);

//     //     //From email address and name
//     //     $mail->From = "from@yourdomain.com";
//     //     $mail->FromName = "Full Name";

//     //     //To address and name
//     //     $mail->addAddress("recepient1@example.com", "Recepient Name");
//     //     $mail->addAddress("recepient1@example.com"); //Recipient name is optional

//     //     //Address to which recipient will reply
//     //     $mail->addReplyTo("reply@yourdomain.com", "Reply");

//     //     //CC and BCC
//     //     $mail->addCC("cc@example.com");
//     //     $mail->addBCC("bcc@example.com");

//     //     //Send HTML or Plain Text email
//     //     $mail->isHTML(true);

//     //     $mail->Subject = "Subject Text";
//     //     $mail->Body = "<i>Mail body in HTML</i>";
//     //     $mail->AltBody = "This is the plain text version of the email content";

//     //     try {
//     //         $mail->send();
//     //         echo "Message has been sent successfully";
//     //     } catch (Exception $e) {
//     //         echo "Mailer Error: " . $mail->ErrorInfo;
//     //     }
//     // }


//     // public function gmail()
//     // {
//     //     //Create a new PHPMailer instance
//     //     $mail = new PHPMailer;

//     //     //Tell PHPMailer to use SMTP
//     //     $mail->isSMTP();

//     //     //Enable SMTP debugging
//     //     // SMTP::DEBUG_OFF = off (for production use)
//     //     // SMTP::DEBUG_CLIENT = client messages
//     //     // SMTP::DEBUG_SERVER = client and server messages
//     //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;

//     //     //Set the hostname of the mail server
//     //     $mail->Host = 'smtp.gmail.com';
//     //     // use
//     //     // $mail->Host = gethostbyname('smtp.gmail.com');
//     //     // if your network does not support SMTP over IPv6

//     //     //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
//     //     $mail->Port = 587;

//     //     //Set the encryption mechanism to use - STARTTLS or SMTPS
//     //     $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

//     //     //Whether to use SMTP authentication
//     //     $mail->SMTPAuth = true;

//     //     //Username to use for SMTP authentication - use full email address for gmail
//     //     $mail->Username = 'username@gmail.com';

//     //     //Password to use for SMTP authentication
//     //     $mail->Password = 'yourpassword';

//     //     //Set who the message is to be sent from
//     //     $mail->setFrom('from@example.com', 'First Last');

//     //     //Set an alternative reply-to address
//     //     $mail->addReplyTo('replyto@example.com', 'First Last');

//     //     //Set who the message is to be sent to
//     //     $mail->addAddress('whoto@example.com', 'John Doe');

//     //     //Set the subject line
//     //     $mail->Subject = 'PHPMailer GMail SMTP test';

//     //     //Read an HTML message body from an external file, convert referenced images to embedded,
//     //     //convert HTML into a basic plain-text alternative body
//     //     $mail->msgHTML(file_get_contents('contents.html'), __DIR__);

//     //     //Replace the plain text body with one created manually
//     //     $mail->AltBody = 'This is a plain-text message body';

//     //     //Attach an image file
//     //     $mail->addAttachment('images/phpmailer_mini.png');

//     //     //send the message, check for errors
//     //     if (!$mail->send()) {
//     //         echo 'Mailer Error: ' . $mail->ErrorInfo;
//     //     } else {
//     //         echo 'Message sent!';
//     //         //Section 2: IMAP
//     //         //Uncomment these to save your message in the 'Sent Mail' folder.
//     //         #if (save_mail($mail)) {
//     //         #    echo "Message saved!";
//     //         #}
//     //     }
//     // }

//     // public function stmp()
//     // {
//     //     //Create a new PHPMailer instance
//     //     $mail = new PHPMailer;
//     //     //Tell PHPMailer to use SMTP
//     //     $mail->isSMTP();
//     //     //Enable SMTP debugging
//     //     // SMTP::DEBUG_OFF = off (for production use)
//     //     // SMTP::DEBUG_CLIENT = client messages
//     //     // SMTP::DEBUG_SERVER = client and server messages
//     //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;
//     //     //Set the hostname of the mail server
//     //     $mail->Host = 'mail.example.com';
//     //     //Set the SMTP port number - likely to be 25, 465 or 587
//     //     $mail->Port = 25;
//     //     //Whether to use SMTP authentication
//     //     $mail->SMTPAuth = true;
//     //     //Username to use for SMTP authentication
//     //     $mail->Username = 'yourname@example.com';
//     //     //Password to use for SMTP authentication
//     //     $mail->Password = 'yourpassword';
//     //     //Set who the message is to be sent from
//     //     $mail->setFrom('from@example.com', 'First Last');
//     //     //Set an alternative reply-to address
//     //     $mail->addReplyTo('replyto@example.com', 'First Last');
//     //     //Set who the message is to be sent to
//     //     $mail->addAddress('whoto@example.com', 'John Doe');
//     //     //Set the subject line
//     //     $mail->Subject = 'PHPMailer SMTP test';
//     //     //Read an HTML message body from an external file, convert referenced images to embedded,
//     //     //convert HTML into a basic plain-text alternative body
//     //     $mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//     //     //Replace the plain text body with one created manually
//     //     $mail->AltBody = 'This is a plain-text message body';
//     //     //Attach an image file
//     //     $mail->addAttachment('images/phpmailer_mini.png');

//     //     //send the message, check for errors
//     //     if (!$mail->send()) {
//     //         echo 'Mailer Error: ' . $mail->ErrorInfo;
//     //     } else {
//     //         echo 'Message sent!';
//     //     }
//     // }

//     // public function stmpNoAuth()
//     // {
//     //     //Create a new PHPMailer instance
//     //     $mail = new PHPMailer;
//     //     //Tell PHPMailer to use SMTP
//     //     $mail->isSMTP();
//     //     //Enable SMTP debugging
//     //     // SMTP::DEBUG_OFF = off (for production use)
//     //     // SMTP::DEBUG_CLIENT = client messages
//     //     // SMTP::DEBUG_SERVER = client and server messages
//     //     $mail->SMTPDebug = SMTP::DEBUG_SERVER;
//     //     //Set the hostname of the mail server
//     //     $mail->Host = 'mail.example.com';
//     //     //Set the SMTP port number - likely to be 25, 465 or 587
//     //     $mail->Port = 25;
//     //     //We don't need to set this as it's the default value
//     //     //$mail->SMTPAuth = false;
//     //     //Set who the message is to be sent from
//     //     $mail->setFrom('from@example.com', 'First Last');
//     //     //Set an alternative reply-to address
//     //     $mail->addReplyTo('replyto@example.com', 'First Last');
//     //     //Set who the message is to be sent to
//     //     $mail->addAddress('whoto@example.com', 'John Doe');
//     //     //Set the subject line
//     //     $mail->Subject = 'PHPMailer SMTP without auth test';
//     //     //Read an HTML message body from an external file, convert referenced images to embedded,
//     //     //convert HTML into a basic plain-text alternative body
//     //     $mail->msgHTML(file_get_contents('contents.html'), __DIR__);
//     //     //Replace the plain text body with one created manually
//     //     $mail->AltBody = 'This is a plain-text message body';
//     //     //Attach an image file
//     //     $mail->addAttachment('images/phpmailer_mini.png');

//     //     //send the message, check for errors
//     //     if (!$mail->send()) {
//     //         echo 'Mailer Error: ' . $mail->ErrorInfo;
//     //     } else {
//     //         echo 'Message sent!';
//     //     }
//     // }

//     // public function mailingList()
//     // {
//     //     $mail = new PHPMailer(true);

//     //     $body = file_get_contents('contents.html');

//     //     $mail->isSMTP();
//     //     $mail->Host = 'smtp.example.com';
//     //     $mail->SMTPAuth = true;
//     //     $mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
//     //     $mail->Port = 25;
//     //     $mail->Username = 'yourname@example.com';
//     //     $mail->Password = 'yourpassword';
//     //     $mail->setFrom('list@example.com', 'List manager');
//     //     $mail->addReplyTo('list@example.com', 'List manager');

//     //     $mail->Subject = 'PHPMailer Simple database mailing list test';

//     //     //Same body for all messages, so set this before the sending loop
//     //     //If you generate a different body for each recipient (e.g. you're using a templating system),
//     //     //set it inside the loop
//     //     $mail->msgHTML($body);
//     //     //msgHTML also sets AltBody, but if you want a custom one, set it afterwards
//     //     $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';

//     //     //Connect to the database and select the recipients from your mailing list that have not yet been sent to
//     //     //You'll need to alter this to match your database
//     //     $mysql = mysqli_connect('localhost', 'username', 'password');
//     //     mysqli_select_db($mysql, 'mydb');
//     //     $result = mysqli_query($mysql, 'SELECT full_name, email, photo FROM mailinglist WHERE sent = FALSE');

//     //     foreach ($result as $row) {
//     //         try {
//     //             $mail->addAddress($row['email'], $row['full_name']);
//     //         } catch (Exception $e) {
//     //             echo 'Invalid address skipped: ' . htmlspecialchars($row['email']) . '<br>';
//     //             continue;
//     //         }
//     //         if (!empty($row['photo'])) {
//     //             //Assumes the image data is stored in the DB
//     //             $mail->addStringAttachment($row['photo'], 'YourPhoto.jpg');
//     //         }

//     //         try {
//     //             $mail->send();
//     //             echo 'Message sent to :' . htmlspecialchars($row['full_name']) . ' (' . htmlspecialchars($row['email']) . ')<br>';
//     //             //Mark it as sent in the DB
//     //             mysqli_query(
//     //                 $mysql,
//     //                 "UPDATE mailinglist SET sent = TRUE WHERE email = '" .
//     //                     mysqli_real_escape_string($mysql, $row['email']) . "'"
//     //             );
//     //         } catch (Exception $e) {
//     //             echo 'Mailer Error (' . htmlspecialchars($row['email']) . ') ' . $mail->ErrorInfo . '<br>';
//     //             //Reset the connection to abort sending this message
//     //             //The loop will continue trying to send to the rest of the list
//     //             $mail->getSMTPInstance()->reset();
//     //         }
//     //         //Clear all addresses and attachments for the next iteration
//     //         $mail->clearAddresses();
//     //         $mail->clearAttachments();
//     //     }
//     // }
// }

// class SimpleMailer extends Mailer
// {
// }
