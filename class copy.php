<?php

function isInjected($str) {
  $injections = array('(\n+)',
    '(\r+)',
    '(\t+)',
    '(%0A+)',
    '(%0D+)',
    '(%08+)',
    '(%09+)'
  );
  $inject = join('|', $injections);
  $inject = "/$inject/i";
  if(preg_match($inject, $str)) {
    return true;
  } else {
    return false;
  }
}

$log = fopen("phplog.log", 'w');
// fwrite($log, implode(',', $_POST));

if (isset($_POST['submit'])) {

  // fwrite($log, "_POST['submit'] is set");

  $email_to = "jack@apairofartists.com";
  $email_from = "Website@APairOfArtists.com";
  $email_subject = "Website Class Registration";

  $name = $_POST['yourName'];
  $email = $_POST['email'];
  $class = $_POST['class'];
  $textarea = $_POST['textarea'];

  fwrite($log, "email_to = $email_to\r\n");
  fwrite($log, "email_from = $email_from\r\n");
  fwrite($log, "email_subject = $email_subject\r\n");
  fwrite($log, "name = $name\r\n");
  fwrite($log, "email = $email\r\n");
  fwrite($log, "class = $class\r\n");
  fwrite($log, "textarea = $textarea\r\n");

  if (empty($name) || empty($email) || empty($class) || empty($textarea)) {
    echo "Please complete all form fields before submitting";
    header("Location: class.html");
  } elseif (isInjected($email)) {
    echo "This doesn't seem to be a proper email adress";
    header("Location: class.html");
  } else {
    $message_body = "You have received a new class registration:\r\n";
    $message_body .= "Name: $name\r\n";
    $message_body .= "Email Address: $email\r\n";
    $message_body .= "Class: $class\r\n";
    $message_body .= "Textarea $textarea\r\n";

    $headers = "From: $email_from \r\nReply-To: $email \r\n";

    fwrite($log, "message_body = \r\n\r\n$message_body\r\n\r\n");
    fwrite($log, "headers = $headers\r\n");

    mail($email_to,$email_subject,$message_body,$headers);

    header("Location: class.html");
  }
} else {
  header("Location: class.html");
}

fclose($log);

?>
