<?php
if(!isset($_POST['submit']))
{
	echo "error; you need to submit the form!";
}

$name = test_input($_POST['Name']);
$visitor_email = test_input ($_POST['Email']);
$subject = test_input ($_POST['Subject']);
$message = test_input ($_POST['Message']);


if (!filter_var($visitor_email, FILTER_VALIDATE_EMAIL)) {
    echo "Email address is not valid!";
    exit; 
}

if(IsInjected($visitor_email))
{
    echo "Bad email value!";
    exit;
}

$email_from = 'beschtia@gmail.com';
$email_subject = "dlukic.ml: New Form submission";
$email_body = "You have received a new message from the user $name.\n From: $visitor_email\n Subject: $subject\n Message:\n $message";
    
$to = "beschtia@gmail.com";
$headers = "From: $email_from \r\n";
$headers .= "Reply-To: $visitor_email \r\n";

mail($to,$email_subject,$email_body,$headers);

header('Location: ../html/thanks-for-message.html');


function IsInjected($str)
{
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
  if(preg_match($inject,$str))
    {
    return true;
  }
  else
    {
    return false;
  }
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

?>