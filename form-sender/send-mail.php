<?php
  require_once($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');
  
  require($_SERVER['DOCUMENT_ROOT'].'/wp-includes/PHPMailer/PHPMailer.php');
  require($_SERVER['DOCUMENT_ROOT'].'/wp-includes/PHPMailer/SMTP.php');
  require($_SERVER['DOCUMENT_ROOT'].'/wp-includes/PHPMailer/Exception.php');
  $MAIL = new PHPMailer\PHPMailer\PHPMailer();
  
  function sendMail($mailto, $subject, $text){
    if (get_option('formsender_method')=='phpmail'){
      $headers  = "Content-type: text/html; charset=utf-8\r\n";
      $headers .= "From: ".get_option('formsender_from_name')." <".get_option('formsender_from_mail').">\n";
      $headers .= "Return-Path: ".get_option('formsender_from_mail')."";
      $subj = "=?utf-8?B?". base64_encode($subject). "?=";
      if (mail($mailto, $subj, $text, $headers)){
        return "true";
      }
      else{
        return "false";
      }
    }
    if (get_option('formsender_method')=='smtp'){
      global $MAIL, $config;
      $MAIL->ClearAllRecipients();
      $MAIL->isSMTP();
      $MAIL->SMTPDebug = 0;
      $MAIL->SMTPAuth = true;
      if (!empty(get_option('formsender_smtp_secure'))){
        $MAIL->SMTPSecure = get_option('formsender_smtp_secure');
      }
      $MAIL->Host = get_option('formsender_smtp_host');
      $MAIL->Port = get_option('formsender_smtp_port');
      $MAIL->Username = get_option('formsender_smtp_username');
      $MAIL->Password = get_option('formsender_smtp_password');
      $MAIL->CharSet = "utf-8";
      $MAIL->setFrom(get_option('formsender_from_mail'), get_option('formsender_from_name'));
      $mailto = str_replace(' ', '', $mailto);
      $mailto = str_replace(';', ',', $mailto);
      $mail_arr = explode(',', $mailto);
      foreach ($mail_arr as $m){
        $MAIL->addAddress($m);
      }
      //$MAIL->addBCC("anweb@bk.ru");
      $MAIL->Subject = $subject;
      $MAIL->msgHTML($text);
      if ($MAIL->send()){
        return "true";
      }
      else{
        return $MAIL->ErrorInfo;
      }
      return "false";
    }
  }
?>