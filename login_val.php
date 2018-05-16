<?php
//Munkamenet
//require_once "./includes/sql_connect.php";
//A hasznĂˇlt vĂˇltozĂłk fevĂ©tele
$return = "";

//userName=KonderBetyar&password=admin


if(isset($_POST['userName']) && isset($_POST['password'])) {
    require_once "includes/sql_connect.php";    
    $userName = filter_input(INPUT_POST, 'userName');
    $password = filter_input(INPUT_POST, 'password');
    $bizt_token = "TiTkO2_Ku1C2";
    $password = md5($password.$bizt_token);
    for ($i = 0; $i < 1000; $i++) {
        $password = md5($password);
    }
    $sql = mysqli_query($link, "SELECT * "
                             . "FROM user "
                             . "WHERE UserName ='$userName' "
                             . "AND UserPass='$password' "
                             . "LIMIT 1") or die (mysqli_error($link));
    $row = mysqli_fetch_assoc($sql);
    $userID = $row['UserId'];
    $userName = $row['UserName'];
    //szamoljuk meg a lekerdezeseink sorait
    if(mysqli_num_rows($sql) == 1) {
        $_SESSION['autentikacio'] = true;
        $_SESSION['userId'] = $userID;
        $_SESSION['userName'] = $userName;
        
        return "OK";
        
    } else {
        $return = "Email vagy jelszó helytelen!";
    }
    //BiztonsĂˇgi db csatlakozĂˇs bezĂˇrĂˇst
    mysqli_close($link);
        
} else {
    $return = "A mezők nem lehetnek üresek!";
    return $return;
}


