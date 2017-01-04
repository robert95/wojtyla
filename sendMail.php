<?php
$kom = "";
	function sprawdzEmail($email)
	{
		$wzor = '^([a-zA-Z0-9._\-]+)@([a-zA-Z0-9.\-]+\.[a-zA-Z]{2,4})';
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
			return false;
		else
			return true;
	}
	
	function sendMessage()
    {		
        $name    = addslashes(trim($_POST['name']));
        $email   = addslashes(trim($_POST['mail']));
        $msg     = addslashes(trim($_POST['content']));
        
        if (($name != "" && $email != "" && $msg != "" && sprawdzEmail($email)) == 1)
        {
            $message = "Wiadomość ze strony!<br />Imię i nazwisko: ".$name."<br />E-mail: ".$email."<br />Wiadomość:<br />".$msg;
 
            $to        = getSettingsNameById(6);
            $subject   = 'Wiadomość ze strony!';
            $naglowki  = "From: ".$name." <".$email.">".PHP_EOL;
            $naglowki .= "MIME-Version: 1.0".PHP_EOL;
            $naglowki .= "Content-type: text/html; charset=utf-8".PHP_EOL; 

            if(mail($to, "Wiadomość z formularza na stronie", $message, $naglowki))
            {
				return 1;
            }
        }
        
        return 0;
    }
	if(isset($_POST['mail'])) {
		//if($_SESSION['captcha'] != $_POST['cap'] || $_POST['cap'] == ""){ 
		//	$kom = 'Wpisany kod nie jest poprawny.'; 
		//} else { 
			if(sendMessage()) $kom = "Dziękujemy za Twoją wiadomość.";
			else $kom = "Wiadomość nie została wysłana!"; 
		//}
	} 
?>