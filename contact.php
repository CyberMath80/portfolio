<?php 
// functions definition 
function checkName($arg) :bool {
  return $arg != null && strlen($arg) >= 2 && strlen($arg) <= 255;
}

function checkSender($arg) :bool {
  return $arg != null && filter_var($arg, FILTER_VALIDATE_EMAIL);
}

function checkSubject($arg) :bool {
  return $arg != null && strlen($arg) >= 2 && strlen($arg) <= 255;
}

function checkMessage($arg) :bool {
  return $arg != null && strlen($arg) >= 3;
}
//echo json_encode($_POST);
$success = false;
$messageInput = 'Erreur: contact.php';

// variables declaration
$name    = null;
$sender  = null;
$subject = null;
$message = null;

if(isset($_POST)) {
  if(!empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['message'])) {
    $name    = htmlspecialchars(strip_tags($_POST["name"]));
    $sender  = htmlspecialchars(strip_tags($_POST["email"]));
    $subject = htmlspecialchars(strip_tags($_POST["subject"]));
    $message = htmlspecialchars(strip_tags(wordwrap($_POST["message"], 70, "\r\n")));

    if(checkName($name)) {
      if(checkSender($sender)) {
        if(checkSubject($subject)) {
          if(checkMessage($message)) {
            // begin the job
            $messageToSend = "NAME: $name\n\nSUBJECT: $subject\n\nMESSAGE: $message";
            $subjectToSend = $subject;
            $to = "contact@cybermath.dev";
            // create header e-mail.
            $headers[] = "MIME-Version: 1.0";
            $headers[] = "Content-type: text/plain; charset=UTF-8";
            $headers[] = "From: $name <$sender>";
            $headers[] = "Reply-To: <$sender>";
            $headers[] = "X-Sender: <$sender>";
            $headers[] = "X-Mailer: PHP/".phpversion();
            $headers[] = "X-Priority: 1"; // Urgent message!
            $headers[] = "Return-Path: <$sender>";
            // send mail
            mail($to, $subjectToSend, $messageToSend, implode("\r\n", $headers));
            //-------------------------------------------------
            //automatic response from notification mail adress
            $toResponse      = $sender;
            $subjectResponse = "CyberMath get your message!"; // subject response
            
            $messageResponse .= '<div style="background: #030303;">';
            $messageResponse .= '<p style="text-align: center; margin-top: 20px;"><img src="https://cybermath.dev/assets/img/cybermath.png" alt="CyberMath Logo" align="center" width=300 height=300></p>';
            $messageResponse .= '<table rules="all" style="margin: 20px auto; border-color: #666;" cellpadding="10">';
            $messageResponse .= '<tr style="background: #131313; color: #c0c0c0;"><td><strong>NAME:</strong></td><td>'.strip_tags($name).'</td></tr>';
            $messageResponse .= '<tr style="color: #c0c0c0;"><td><strong>EMAIL:</strong></td><td>'.strip_tags($sender).'</td></tr>';
            $messageResponse .= '<tr style="color: #c0c0c0;"><td><strong>SUBJECT:</strong></td><td>'.strip_tags($subject).'</td></tr>';
            $messageResponse .= '<tr style="color: #c0c0c0;"><td><strong>MESSAGE:</strong></td><td>'.strip_tags($message).'</td></tr>';
            $messageResponse .= '<tr style="color: #c0c0c0;"><td><strong>DATE:</strong></td><td>'.date('l d F Y - H:i:s', time()).'</td></tr>';
            $messageResponse .= '</table>';
            $messageResponse .= '<p style="color: #c0c0c0; margin-left: 20px;">The answer for your query will be fast as possible.</p>';
            $messageResponse .= '<p style="color: #c0c0c0; margin-bottom: 20px; margin-left: 20px;">This is an automatic message, you don\'t need to reply.</p>';
            $messageResponse .= '</div>';
            // create header e-mail.
            $hdr[] = "MIME-Version: 1.0";
            $hdr[] = "Content-type: text/html; charset=UTF-8";
            $hdr[] = "From: CyberMath <notification@cybermath.dev>";
            $hdr[] = "Reply-To: no-reply@cybermath.dev";
            $hdr[] = "X-Sender: <notification@cybermath.dev>";
            $hdr[] = "Return-Path: <notification@cybermath.dev>";
            $hdr[] = "X-Mailer: PHP/".phpversion();
            
            mail($toResponse, $subjectResponse, $messageResponse, implode("\r\n", $hdr));
            $_POST[] = null;
            $success = true;
            $messageInput = 'Your message has been sent, thank you.';
            // finish the job
          } else {
            $messageInput = 'Please complete your message';
          }
        } else {
          $messageInput = 'Please complete your subject';
        }
      } else {
        $messageInput = 'Your email is wrong';
      }
    } else {
      $messageInput = 'You must complete your name.';
    }
  }
}

$result = ["success" => $success, "message" => $messageInput];
echo json_encode($result);