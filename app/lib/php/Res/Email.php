<?php

namespace danolez\lib\Res;

use danolez\lib\DB\Credential;
use danolez\lib\DB\Model;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\OAuth;


class Email
{

    private $body;
    private $html;
    private $subject;
    private $from;
    private $fromName;
    private $to;
    private $toName;
    private $cc;
    private $bcc;
    private $attachment;
    private $attachmentName;
    private $attachments;


    const GOOGLE_SERVER = "smtp.gmail.com";
    const GOOGLE_USERNAME = "f9210abb7d9bdaf63e02ee631e1f3ef60ac5ef6b8e066402d1061f1f94f84b28d2d8f22937c5f263f215c5357037d109e70a154b6b43d9d92af1bbb35d40f9b45d29500a0663151f1e4b06f2155db406642a08f826d9c5020d7080b31726d62a70d82629f8bb2d9bd2f1b3d1a0436c9437c7f16c0622010a29430840f96ccfdabb5d0a3506e51f44c50d0694c7d9f9b3f2356c0ad12ab4fa632a2db4215d09f62a9c280809f29b8ee74401098e432680d1284b509b08c7505d405da02943e7e7f1e5d8269b3eb3f8d280faeec7ef17cfc793632af9f64b0101d9ef0870cff92a7d80ef2ac722e740ee40";
    const GOOGLE_PASSWORD = "f9210abc2dd8d6fa3e02ee931e1f09f6228e5dd270e5f6f1a028bc09d83e50a0bcbc06f6d2b4d63e44bc502a3743d62a3f2129f91e9464d6fa9cb4d90640f901939cb46cd901016480447db402223f1e3f214301088ef8f209eed80601c70a807d1708014464b4d880634c17bc4c173e266c6c0a94f8431515d15d40f9f19c3e44292970fa1501d93ef27d22faf17d7d9417e53f26c5353f357d0280d6a029269c6b43ef63290201d63fd622d8d128b3502d374cf2daeff9f140d8c71efaee40ee40";

    const HOST_SERVER = "pop3.lolipop.jp";
    const HOST_USERNAME = "f99306bb7d93daf68e02eed1c7800d0dd96c37ef1ed8f84b641fd1c5932163b408c52250da3f214b50c71f801563f9702a43efd2f1d8085d635d508e0140f9084470b4bbda440694d63526cf805dbcd1d63e26220ddab444f63eee2ddaa0c7640670d9d621c79394930a6b2dbc2143b40df9c5d8f8e5f880fa44d940f99bd9d2f1223fe5da08700aee2935370d640644cf1ebb21c594ee09fac7d95deed97dd12608c563faf83743013eef3f3537d2941e6c8ef26cf822099b408e63f629faf2f9e78eb48e800935cf28379b17f1151e29f2f98e0a0a15010215f2371e28cf17bbbbe7bbe726ee40ee40";
    const HOST_PASSWORD = "f92106bb7d93d6f63e93027dc7f8638e266ccfee9429fa50b4d835cff6b43580d68e3fd89b4b17f1702ae75d6c3fbcef29d963f8641f5d22d62ad2b37040f994f66b288e22bb648e2d02fa4429c5f2d9440a0ae515d6da809c3e503ef19c6364d14b9315f6bc2609cffa097d221fcff909264bcfc73fa0d2a022da40da1ff2501e010d2d9402f9c7010635630d6c80d926f2d201282870f6f8501ff60a15084c173ff80d6cb39c64e5099c0a269b934c37a0da43d1c78e0aee40ee40";

    const SSL_PORT1 = 587;
    const SSL_PORT2 = 465;

    const DEFAULT_FROM = "Demae System";
    const DEFAULT_FROM_EMAIL = "admin@demae-system.com";
    const ADMIN_MAIL = "admin@demae-system.com";

    public function sendWithHostSTMP()
    {
        $result = "";
        $error = "";
        try {
            $mail = new PHPMailer(TRUE);
            $mail->setFrom($this->from ?? $this::DEFAULT_FROM_EMAIL, $this->fromName ?? $this::DEFAULT_FROM);
            $mail->addAddress($this->to, $this->toName);
            $mail->Subject = $this->subject;
            $mail->isHTML(TRUE);
            // $mail->SMTPDebug = 4;
            $mail->Body = $this->html;
            $mail->AltBody = $this->body;
            //$mail->ReturnPath =FROM_ADDRESS;
            $mail->CharSet = "UTF-8";
            $mail->Encoding = "base64";
            if (!is_null($this->attachment) && $this->attachment != "") {
                // $mail->addStringAttachment(file_get_contents($this->attachment), "filename");
                $mail->AddEmbeddedImage($this->attachment, $this->attachmentName);
            }
            $this->attachments = $this->attachments ?? [];
            foreach ($this->attachments as $name => $file) {
                if (!is_null($name) && $file != "") {
                    $mail->AddEmbeddedImage($file, $name);
                }
            }

            //attachment
            //cc
            //bcc
            $mail->SMTPKeepAlive = true;
            $mail->IsSMTP();
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );
            $mail->Host = ($this::HOST_SERVER);
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = $this::SSL_PORT2;
            $mail->SMTPAuth = true;
            // $mail->SMTPAutoTLS = true;
            $mail->Username = Credential::sDecrypt($this::HOST_USERNAME);
            $mail->Password = Credential::sDecrypt($this::HOST_PASSWORD);
            $result = $mail->send();
        } catch (Exception $e) {
            $error = $e->errorMessage();
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        return json_encode(array(Model::ERROR => $error, Model::RESULT => $result));
    }

    public  function sendWithGoogleSTMP()
    {
        $result = "";
        $error = "";
        try {
            $mail = new PHPMailer(TRUE);
            $mail->setFrom($this->from ?? $this::DEFAULT_FROM_EMAIL, $this->fromName ?? $this::DEFAULT_FROM);
            $mail->addAddress($this->to, $this->toName);
            $mail->Subject = $this->subject;
            $mail->isHTML(TRUE);
            $mail->Body = $this->html;
            $mail->AltBody = $this->body;
            $mail->IsSMTP();
            if (!is_null($this->attachment) && $this->attachment != "") {
                // $mail->addStringAttachment(file_get_contents($this->attachment), "filename");
                $mail->AddEmbeddedImage($this->attachment, $this->attachmentName);
            }
            //cc
            //bcc
            $mail->Host = $this::GOOGLE_SERVER;
            $mail->SMTPSecure = "tls";
            $mail->Port = $this::SSL_PORT1;
            $mail->SMTPAuth = true;
            $mail->Username = Credential::sDecrypt($this::GOOGLE_USERNAME);
            $mail->Password = Credential::sDecrypt($this::GOOGLE_PASSWORD);
            $result = $mail->send();
        } catch (Exception $e) {
            $error = $e->errorMessage();
        } catch (\Exception $e) {
            $error = $e->getMessage();
        }
        return json_encode(array(Model::ERROR => $error, Model::RESULT => $result));
    }

    /**
     * Get the value of body
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set the value of body
     *
     * @return  self
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get the value of html
     */
    public function getHtml()
    {
        return $this->html;
    }

    /**
     * Set the value of html
     *
     * @return  self
     */
    public function setHtml($html)
    {
        $this->html = $html;

        return $this;
    }

    /**
     * Get the value of subject
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Set the value of subject
     *
     * @return  self
     */
    public function setSubject($subject)
    {
        $this->subject = purify($subject);

        return $this;
    }

    /**
     * Get the value of from
     */
    public function getFrom()
    {
        return array($this->from, $this->fromName);
    }

    /**
     * Set the value of from
     *
     * @return  self
     */
    public function setFrom($from, $fromName = null)
    {
        $this->from = $from;
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * Get the value of to
     */
    public function getTo()
    {
        return array($this->to, $this->toName);
    }

    /**
     * Set the value of to
     *
     * @return  self
     */
    public function setTo($to, $toName = null)
    {
        $this->to = $to;
        $this->toName = $toName;
        return $this;
    }

    /**
     * Get the value of copy
     * Can see recipient list
     */
    public function getCopy()
    {
        return $this->cc;
    }

    /**
     * Set the value of copy
     *
     * @return  self
     */
    public function setCopy(...$copy)
    {
        $this->cc = $copy;

        return $this;
    }

    /**
     * Get the value of copy
     * Can't see recipient list
     */
    public function getBlindCopy()
    {
        return $this->bcc;
    }

    /**
     * Set the value of copy
     *
     * @return  self
     */
    public function setBlindCopy(...$copy)
    {
        $this->bcc = $copy;

        return $this;
    }

    /**
     * Get the value of attachment
     */
    public function getAttachments()
    {
        return $this->attachments;
    }

    /**
     * Set the value of attachment
     *
     * @return  self
     */
    public function setAttachments($attachment)
    {
        $this->attachments = $attachment;

        return $this;
    }

    /**
     * Get the value of attachmentName
     */
    public function getAttachmentName()
    {
        return $this->attachmentName;
    }

    /**
     * Set the value of attachmentName
     *
     * @return  self
     */
    public function setAttachmentName($attachmentName)
    {
        $this->attachmentName = $attachmentName;

        return $this;
    }

    /**
     * Get the value of attachment
     */
    public function getAttachment()
    {
        return $this->attachment;
    }

    /**
     * Set the value of attachment
     *
     * @return  self
     */
    public function setAttachment($attachment)
    {
        $this->attachment = $attachment;

        return $this;
    }
}


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