<head>
<meta charset="utf-8">
<meta name="description" content="Secure way to send an [anonymous] email, using PGP encryption. Created by Cameron Crowley, released under Unlicense." />
<title>PGP Secure Mailer</title>
<!------This is free and unencumbered software released into the public domain.

Anyone is free to copy, modify, publish, use, compile, sell, or
distribute this software, either in source code form or as a compiled
binary, for any purpose, commercial or non-commercial, and by any
means.

In jurisdictions that recognize copyright laws, the author or authors
of this software dedicate any and all copyright interest in the
software to the public domain. We make this dedication for the benefit
of the public at large and to the detriment of our heirs and
successors. We intend this dedication to be an overt act of
relinquishment in perpetuity of all present and future rights to this
software under copyright law.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

For more information, please refer to <http://unlicense.org/> ---->
</head>
<body>
<header id="title">
	<div style="display:inline;min-width:700px">
    <img src="http://s12.postimg.org/fbd9pu5jx/lock.png" style="float:left;" alt="PGP Secure Mailer" title="PGP Secure Mailer" />
		<h1 style="display:inline;min-width:300px">PGP Secure Mailer<span style="font-size:0.6em"></span></h1><br>
		</header>	
	<?php echo $_REQUEST['message'];  ?>
	<section class="block" style="display:inline;min-width:300px">
		<form action="#" method="post" onsubmit="return encrypt();"
			name="submitform" id="submitform">
<ul>
<br>
<style>
	label{font-size:0.8em;font-decoration:bold}
    form#contact{border:0px solid red;width:70%;padding:1em}
    p#msg,p#adr,p#obj{ solid black;margin-right:10%;padding:10px}
    p#msg textarea{border:2px solid black;align:center;height:90px;width:100%}
    p#adr input,p#obj input{border:2px solid black}
    p.bt{text-align:center}
    p.bt input{border:1px red solid;width:50%}
    textarea{border:1px black dotted;width:50%;max-width:480px}
    input{border:1px black dotted;width:50%;max-width:480px}
</style>
	<li><label>To:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
		<input style="max-width:180px" name="recipient" tabindex="5" size="5" type="text" id="recipient" value="<?php echo $_REQUEST['to'];  ?>">
 <li><span id='obj'><label for='purpose'>Subject: 
<input type='text' name='purpose' id='purpose' tabindex='10' size='5' value="<?php echo $_REQUEST['subject'];  ?>" style="max-width:180px"><small>&nbsp;(Cleartext!)</small></label>
    						<li><label>Paste here the recipient public PGP key: </label><br>
							<textarea id="public_key"><?php echo $_REQUEST['public_key'];  ?></textarea>
	<li><label>From: <small>(your email for answer)</small> </label><br /> 
		<input name="mail" tabindex="20" size="30" type="text" id="mail" value="<?php echo $_REQUEST['from'];  ?>">
			<li><label>Message: </label><br /> 
				<textarea tabindex="30" rows="10" cols="40" name="message" id="message"><?php echo $_REQUEST['message'];  ?></textarea>

	</section>
</li>
</ul>
<input name="Sending" tabindex="4" id="send_b" value="Send now" type="submit" style="border:0 30% 0 30%">
</form>
</section>

	<section class="block">
		<p>&nbsp;</p><p>&nbsp;</p>

	<script src="lib/openpgp.min.js"></script>
	<script src="lib/jquery-1.10.1.min.js"></script>
	<script>
		function encrypt() {
			if (window.crypto.getRandomValues) {
				// read public key
				var pub_key = openpgp.key.readArmored($('#public_key').text());
				// encrypt message
				var pgp_message = openpgp.encryptMessage(pub_key.keys, $(
						'#message').val());
				$('#message').val(pgp_message);
				window.alert("Thank you. This message is going to be sent:\n\n"
						+ $('#message').val());
				$("#submitform").attr("action",
						"<?php echo $low_form;?>");
				return true;
			} else {
				$("#submitbutton").val("browser not supported");
				window
						.alert("Error. Use Chrome >= 11, Safari >= 3.1 or Firefox >= 21");
				return false;
			}
		}
	</script>

<!-- Hidden form after encrption --> 
<form style="display:none" id='contact' method="post" align="center" action="<?php echo $_SERVER['PHP_SELF'];?>" enctype="multipart/form-data">
  <p id='obj'><label for='purpose'>purpose of the message :<br>
  <input type='text' name='purpose' id='purpose' tabindex='10' size='30' value="<?php $_REQUEST['purpose'];  ?>"></label></p> 

  <p id="adr"><label for="mail">E-mail<br>
  <input name="mail" tabindex="20" size="30" type="text" id="mail" value="<?php $_REQUEST['mail'];  ?>"></label></p>
  
  <p id="msg"><label for="message">Your message<br>
  <textarea tabindex="30" rows="10" cols="40" name="message" id="message" value=""><?php echo $_REQUEST['message'];  ?></textarea>
  </label>

</form>

</div>	
</div>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<center>Created by <a href="https://securitybycameron.com/"/>Cameron Crowley</a>.</center>
<?php

if (!empty($_REQUEST['send_now']) && $_REQUEST['send_now'] == yes ){
echo '<script>document.getElementById("send_b").click();</script>';
echo '<script>alert "Message sent";</script>';
}
$Preview='<p class="bt">
<input type="submit" name="Preview" tabindex="3" value="Pre;View"></p>';
$Sending="\n".'<p class="bt">
<input name="Sending" tabindex="4" value="Send" id="mailsend" type="submit"></p>';
if (isset($_POST['message']))
  {
    // Check
    $verif='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,5}$#';
    // Replace
    $autosendmail='<script></script>document.contact.Sending.click()</script>';
    $message=preg_replace('#(<|>)#', '-', $_POST['message']);
    $message=str_replace('"', "'",$message);
    $message=str_replace('&', 'et',$message);
    $purpose=preg_replace('#(<|>)#', '-', $_POST['purpose']);
    $purpose=str_replace('"', "'",$purpose);
    $purpose=str_replace('&', 'et',$purpose);
    // Assign
    $recipient=stripslashes(htmlentities($_POST['recipient']));
    $mail=stripslashes(htmlentities($_POST['mail']));
    $message=stripslashes(htmlspecialchars($message));
    $purpose=stripslashes(htmlspecialchars($purpose));
    // Input send
    $Sending=htmlentities($_POST['Sending']);
    $Preview=htmlentities($_POST['Preview']);
    $mail=trim($mail);
    $message=trim($message);
    $purpose=trim($purpose);
    $preview_result='<p></p>';
    /*Check input*/
    if((empty($message))or(empty($purpose))or(!preg_match($verif,$mail)))
      {
        // if all empty
        if(empty($mail)and(empty($message))and(empty($purpose)))
          {
            echo '<p>All is empty..no way to encrypt the air.</p>';
            $message='';$mail='';$purpose='';$preview_result='';
          }
        // if 1 empty
        else
          {
            if(!preg_match($verif,$mail))
              echo'<p>Invalid mail.</p>';
            else
            {
              echo'<p>Something is missing!</p>';
              if(empty($message))
                $preview_result='';
            }
          }
      }
    // If all fine, send directly
    else
      {
        $domain=preg_replace('#[^@]+@(.+)#','$1',$mail);
        $domainMailExist=checkdnsrr($domain,'MX');
        if(!$domainMailExist)
          echo'<p>This mail domain does not exist.</p>';
        elseif(!empty($Preview))
            {
              $preview_result='';
              $Preview='';
            }
        elseif(!empty($Sending))  
            {
              $purpose='[PGP] : '.$purpose;
              $headers='From:'.$mail."\r\n".'To:'.$mail."\r\n".'Subject:'.$purpose."\r\n".'Content-type:text/plain;charset=is-8859-1'."\r\n".'Sent:'.date('l, F d, Y H:i');
              if(mail($recipient,$purpose,$message,$headers))
              {
                echo '<p style="position:fixed;top:255px;left:360px;display:inline"><span style="color:green;font-size:210px;text-decoration:bold">&#x2713;</span></p>';
                $Sending='';
                $Preview='';
              }
              else
                echo'ERROR';
            }
        else
          $autosendmail='';
      }
echo $preview_result;
  }
else
  {
  echo '<p></p>';'<p></p>';
  $mail='';$message='';
  }
$low_form=$Sending;
?>
