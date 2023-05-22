<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

function sendmai_Contact($email, $name, $message)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                        
        $mail->Host       = SMTP_HOST;                  
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = SMTP_USER; 
        $mail->Password   = SMTP_PASS;                             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = SMTP_PORT;                          
    
        $mail->setFrom($email, $name);
        
        $mail->addAddress('12a1nguyenthanhlong@gmail.com', 'BaoLongStore');    
    
        
        $mail->isHTML(true);                       
        $mail->Subject = 'Customer: ' . $name . ' (email: ' . $email . ') just contacted ';
        $mail->Body    = $message;
        $mail->AltBody = $message;
    
        $mail->send();
        return "true";
    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}

function sendmail_Feedback($email, $name)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                        
        $mail->Host       = SMTP_HOST;                  
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = SMTP_USER; 
        $mail->Password   = SMTP_PASS;                             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = SMTP_PORT;                                                
        
        $mail->setFrom('12a1nguyenthanhlong@gmail.com', 'BaoLongStore');
        
        $mail->addAddress($email, $name);     
    
        
        $mail->isHTML(true);                                  
        $mail->Subject = 'Thanks for contacting us';
        $mail->Body    = 'Cảm ơn bạn đã liên hệ với chúng tôi. </br>Chúng tôi sẽ cố gắng có phản hồi sớm nhất cho bạn.';
        $mail->AltBody = 'Cảm ơn bạn đã liên hệ với chúng tôi. Chúng tôi sẽ cố gắng có phản hồi sớm nhất cho bạn.';
    
        $mail->send();
        return "true";
    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}

function sendmail_ChangePass($email, $name, $token, $userid)
{
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();                                        
        $mail->Host       = SMTP_HOST;                  
        $mail->SMTPAuth   = true;                                  
        $mail->Username   = SMTP_USER; 
        $mail->Password   = SMTP_PASS;                             
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            
        $mail->Port       = SMTP_PORT;                          
    
        $mail->setFrom('12a1nguyenthanhlong@gmail.com', 'BaoLongStore');
        
        $mail->addAddress($email, $name);  
    
        
        $link = 'http://localhost:8080/ElectricDeviceWeb/change_pass.php?userid=' . $userid . '&token=' . $token;
        $mail->isHTML(true);                                  
        $mail->Subject = 'Recover Password';
        $mail->Body    = 'Vui lòng nhấn vào đường link sau để thay đổi mật khẩu. </br> <a href="' . $link . '">' . $link.'</a>';
        $mail->AltBody = 'Vui lòng nhấn vào đường link sau để thay đổi mật khẩu.' .$link;
    
        $mail->send();
        return "true";
    } catch (Exception $e) {
        return $mail->ErrorInfo;
    }
}
?>