<?php

// send email
				$to      = "virgarb@yahoo.com";
				$subject = 'SIKOPIS MAIL TEST';
				$message = "IGNORE THIS MESSAGE";
				$headers = 'From: nathani.primasejahtera@nathaniprimasejahtera.com' . "\r\n" .
                           'Reply-To: nathani.primasejahtera@nathaniprimasejahtera.com' . "\r\n" .
                           'X-Mailer: PHP/' . phpversion();

				mail($to, $subject, $message, $headers);

?>
