<?php

$email = "";
$ret_msg = "";
$ret_val = 1;
$infoText ="";

    if (filter_input(INPUT_POST, 'email_forg')) {
        $email = htmlspecialchars(filter_input(INPUT_POST, 'email_forg', FILTER_SANITIZE_EMAIL));
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            require_once "includes/sql_connect.php"; 
            $lekerdezes = mysqli_query($link, "SELECT * FROM user WHERE UserEmail='$email'") or die(mysqli_error($link));
            $data = mysqli_num_rows($lekerdezes);
            if ($data == 1) {
                    $row = mysqli_fetch_assoc($lekerdezes);
                    $name = $row['UserName'];
                    $karakterek = "abcdefghijklmnopqrstuvwxyz1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZ.!?@&";
                    $password = mb_substr(str_shuffle($karakterek), 0, 7, 'UTF-8');
                    $bizt_token = "TiTkO2_Ku1C2";
                    $password1 = md5($password . $bizt_token);
                    for ($i = 0; $i < 1000; $i++) {
                        $password1 = md5($password1);
                    }
                    $sqlUpdate = mysqli_query($link, "UPDATE user SET UserPass='$password1' WHERE UserEmail='$email'") or die(mysqli_error($link));
                    $to = $email;
                    $subject = "A felhasználó neved es jelszavad !";
                    $message = "Hello. A regisztrációkor megadott felhasználóneved: $name és az új jelszavad: $password. Most már beléphet az adatokkal";
                    $headers =  'MIME-Version: 1.0' . "\r\n"; 
                    $headers .= 'From: Your name <info@address.com>' . "\r\n";
                    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                    if (mail($to, $subject, $message, $headers)) {
                        $ret_msg = 'A jelszavat és felhasználónevet elküldtük a(az) '.$email. ' címre!';
                    }
                
            } else {
                $ret_msg = "Az email címe nem szerepel az adatbázisban!";
                $ret_val = 0;
            }
        } else {
            $ret_msg = "Hibás az email címe!";
            $ret_val = 0;
        }
    } else {
        $ret_msg = "Email cím kötelező!";
        $ret_val = 0;
    }
$b = array('ret' => $ret_msg, "ret_val" => $ret_val);

header('Content-type: application/json');
echo json_encode($b);
//}
