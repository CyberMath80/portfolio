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

// variables declaration
  $name    = null;
  $sender  = null;
  $subject = null;
  $message = null;

if(isset($_POST)) {
  $name    = !empty(htmlspecialchars($_POST["name"]));
  $sender  = !empty(htmlspecialchars($_POST["email"]));
  $subject = !empty(htmlspecialchars($_POST["subject"]));
  $message = !empty(htmlspecialchars(wordwrap($_POST["message"], 70, "\r\n")));

  if(checkName($name) && checkSender($sender) && checkSubject($subject) && checkMessage($message)) {
    $messageToSend = "NAME: $name\n\nSUBJECT: $subject\n\nMESSAGE: $message";
    $subjectToSend = "Hey CyberMath you've have a new message";
    $to = "contact@cybermath.dev";
    // create header e-mail.
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-type: text/plain; charset=UTF-8";
    $headers[] = "From: <$sender>";
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
    $subjectResponse = 'CyberMath Message Reception'; // subject response
    
    $messageResponse .= '<div style="background: #030303;">';
    $messageResponse .= '<img src="https://cybermath.dev/assets/img/cybermath-banner.png" alt="CyberMath Banner" style="width: 100%;">';
    $messageResponse .= '<table rules="all" style="border-color: #666; margin: 2rem 0;" cellpadding="10">';
    $messageResponse .= '<tr style="background: #131313; color: #c0c0c0;"><td><strong>NAME:</strong></td><td>'.strip_tags($name).'</td></tr>';
    $messageResponse .= '<tr style="color: #c0c0c0;"><td><strong>EMAIL:</strong></td><td>'.strip_tags($sender).'</td></tr>';
    $messageResponse .= '<tr style="color: #c0c0c0;"><td><strong>SUBJECT:</strong></td><td>'.strip_tags($subject).'</td></tr>';
    $messageResponse .= '<tr style="color: #c0c0c0;"><td><strong>MESSAGE:</strong></td><td>'.strip_tags($message).'</td></tr>';
    $messageResponse .= '<tr style="color: #c0c0c0;"><td><strong>DATE:</strong></td><td>'.date('l d F Y - ', time('H:i:s')).'</td></tr>';
    $messageResponse .= '</table>';
    $messageResponse .= '<p style="color: #c0c0c0;">Votre demande sera traitée dans les plus brefs délais.</p>';
    $messageResponse .= '<p style="color: #c0c0c0;">Ceci est un message automatique, merci de ne pas y répondre.</p>';
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
  }
  //var_dump($_GET);
  $_GET[] = null;
}