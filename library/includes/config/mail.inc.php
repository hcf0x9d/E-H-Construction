<?php

// Do not edit this if you are not familiar with php
error_reporting (E_ALL ^ E_NOTICE);
$post = (!empty($_POST)) ? true : false;

if($post){
	
    function ValidateEmail($e)
    {
        $test = filter_var($e, FILTER_VALIDATE_EMAIL);

        return empty($test) ? true : false;
    }

    
    $n = stripslashes($_POST['n']);
    $e = trim($_POST['e']);
    //$u = stripslashes($_POST['u']);
    $m = stripslashes($_POST['m']);
    $subject =$n.' submitted a contact form';
    //$to = 'jason@jasonfukura.com';
    $to = 'ehconstruction1987@gmail.com';
    
    $error = '';

    // Checks Name Field
    if(!$n){$error .= 'Please enter a contact name.<br />';}

    // Checks Email Field
    if(!$e){$error .= 'Please enter a contact e-mail address.<br />';}
    if(ValidateEmail($e) == true){$error .= 'Please enter a valid e-mail address.<br />';} // this doesn't seem to work
    //if(!$p){$error .= 'Please select a project type.<br/>';}
    if(!$error) //&& !$u)
    {
        $message .= "Here are the details of the submission. \n\n";
        $message .= "Name: ".$n."\n";
        $message .= "Email: ".$e."\n";
        $message .= "Message: ".$m."\n";
        
        $headers = 'From: '.$e."\r\n".
        'Reply-To: '.$e."\r\n" .
        'X-Mailer: PHP/' . phpversion();
        
        $mail = mail( $to, $subject, $message, $headers ); 

        if($mail){
            $msg ="Your request has been submitted.  We will be in touch soon!";
           
            // write the information to a CSV
            // Write to the file
            $csv = '../../contact.csv';

            $date = date('Y-m-d H:i:s');
            $list = array("$date,$n,$e,$m");

            $fp = fopen($csv, "a");

            foreach ($list as $line)
            {
                fputcsv($fp,explode(',',$line));
            }


            fclose($fp);
            
        } else {
            $msg = 'Uh-oh!  Something went wrong!  <a href="mailto:'.$to.'?subject='.stripslashes($subject).'&body='.$m.'" style="text-decoration: underline;color: #fff;">Click to send the same message as an email</a>.';
        }
        echo '<div class="" style="line-height: 120%;margin-bottom: 10px;">'.$msg.'</div>';
        echo '<script>$(function(){$("form").slideUp(250);});</script>';
    } else { // else for !$error
        echo '<div class="error" style="line-height: 120%;margin-bottom: 10px;">'.$error.'</div>';
    }
}
?>