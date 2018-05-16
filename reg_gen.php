<?php
$root = realpath($_SERVER["DOCUMENT_ROOT"]);
include_once "$root/konderbetyar/includes/sql_connect.php";

if(!defined('SECURE')) {
    die ('Nincs nyulkapiszka!');
}
$name = "";
$email = "";
$pass = "";
$nameError = "";
$emailError = "";
$ret_msg = "";
$ret_val = 1;

if(filter_input(INPUT_POST, 'submit')) {
    //MezĹ‘k ellenĂ¶rzĂ©se
    if(filter_input(INPUT_POST, 'name') != "") {
        $name = htmlspecialchars(trim(filter_input(INPUT_POST, 'name')));
        $lekerdezesName = mysqli_query($link, "SELECT * FROM user WHERE  UserName ='$name'") or die (mysqli_error($link));
        $data2 = mysqli_num_rows($lekerdezesName);
        if($data2 == 0){
            if(filter_input(INPUT_POST, 'email') != "") {
                $email = htmlspecialchars(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
                if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    if(filter_input(INPUT_POST, 'password') != "") {
                    $pass = htmlspecialchars(filter_input(INPUT_POST, 'password'));
                    $secPass = htmlspecialchars(filter_input(INPUT_POST, 'secPassword'));
                    if($pass == $secPass) {
                    $bizt_token = "TiTkO2_Ku1C2";
                    $pass = md5($pass.$bizt_token);
                    for ($i = 0; $i < 1000; $i++) {
                        $pass = md5($pass);
                        }
                    $lekerdezes = mysqli_query($link, "SELECT * FROM user WHERE UserEmail='$email'") or die(mysqli_error($link));
                    
                    $data = mysqli_num_rows($lekerdezes);
                    
                    if($data == 0) {
                        $sqlInsert = mysqli_query($link, "INSERT INTO user(UserName, UserEmail, UserPass) VALUES('$name', '$email', '$pass')") or die(mysqli_error($link));
                        if($sqlInsert) {
                              $ret_msg = "Kedves". " " . $name . "!". " " . "Regisztrációd sikeres volt!";
                            }
                    } else {
                        $ret_msg = "Az email cím  már szerepel az adatbázisban!";
                        $ret_val = 0;
                        }
                    
                        
                    } else {
                        $ret_msg = "A két bevitt jelszó nem azonos. Próbáld újra!";
                        $ret_val = 0;
                    }
                    } else {
                        $ret_msg ="Nem adtal meg jalszót";
                        $ret_val = 0;
                    }
                       
                    } else {
                        $ret_msg = "Hibás az email címe!";
                        $ret_val = 0;
                    }
                } else {
                    $ret_msg = "Nem adtál meg email címet!";
                    $ret_val = 0;
                } 
                } else {
                    $ret_msg = "A felhasználónév már foglalt!";
                    $ret_val = 0;
                }
    } else {
        $ret_msg = "Nem adtál meg felhasználónevet!";
        $ret_val = 0;
    }
}

$b = array('ret' => $ret_msg, "ret_val" => $ret_val);

header('Content-type: application/json');
echo json_encode($b);

