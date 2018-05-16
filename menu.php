<?php
require 'login_val.php';
require_once 'includes/sql_connect.php';

/*if($_SESSION['autentikacio'] == false) {
    echo "Nem vagy belepve";
} else {
    var_dump($_SESSION['userName']);
}
*/
?>

<!DOCTYPE html>

<html lang="hu">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="stylesheet" type="text/css" href="includes/css/konder.css">
        <link rel="stylesheet" type="text/css" href="includes/fonts/fontface.css">
        <link href='https://fonts.googleapis.com/css?family=Oswald' rel='stylesheet'>
        <script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="http://localhost/konderbetyar/includes/js/konder.js"></script>
        <script src="http://localhost/konderbetyar/includes/js/jquery.preload.js"></script>
        
        <title>Menu</title>
    </head>
    <body>
        <header>
            <div id="wrapper"></div>
            <div class="menuTriggerHolder">
            <div class="logoCont">
                <a href="index.php"> <img src="includes/css/img/logo.png" alt="Konderbetyar logo" class="logo"></a>
            </div>
                <div class="menuCont">
                <ul class="main-nav">
 <?php                   
                    if($_SESSION['autentikacio'] == false) {
                        
?>
                    
                    <li><a id="logIn"><span class="menutext">Belépés</span></a></li>
                    <li><a id="signUp"><span class="menutext">Regisztráció</span></a></li>
<?php
                    } else {
?>                        
                    <li><a href="?logout=1"><span class="menutext">Kilépés</span></a></li>
                    
<?php                    
                    }
?>
                </ul>
            </div>
            </div>
<?php                   
         
                        
?>       
            <div id="menuHolder">              
                <div class="MenuCategory">
                    <button id="apper" value="1" class="btnCat menuBtn">Előétel</button>
                    <button id="soup" value="2" class="btnCat menuBtn">Leves</button>
                    <button id="main" value="3" class="btnCat menuBtn">Főétel</button>
                    <button id="dess" value="4" class="btnCat menuBtn">Desszert</button>
                    <button id="sal" value="5" class="btnCat menuBtn">Saláta</button>
                </div>
<?php
        if($_SESSION['autentikacio'] == true) {
            $user = $_SESSION['userName'];
?>
                <div class="ProfPage">
                    <button id="recUpMod" class="btnProf menuBtn">Recept feltöltés</button>
                    <button id="recOwn" value="<?php echo $user; ?>" class="btnProf menuBtn">Saját receptek</button>
                </div>
            </div>
            
            
<?php
        }   
?>
    <!-- The Modal LOGIN -->
    <div id="myModal" class="modal">

     <!-- Modal content -->
    <div class="modal-content">
        <div id="mod_log">
            <div class="modal-header">
                <span class="close">&times;</span>
                <h2>Belépés</h2>
            </div>
            <div class="modal-body">
                <form class="form-inline text-center" id="login">
                    <div class="form-group">
                        <label for="userName" class="sr-only">Felhasználónév:</label>
                        <div>
                            <input type="text" id="userName" name="userName" placeholder="Felhasználónév"/>
                        </div>
                        <label for="password" class="sr-only">Jelszó:</label>
                        <div>
                            <input type="password" name="password" placeholder="Jelszó" id="password"/>
                        </div>
                    </div>
                    <p id="login-error"></p>
                    <p id="login-success"></p><br/>
                    <div>
                        <div>
                            <input id="loginBtn" type="submit" name="submit"  value="Belépés"/><br/>
                        </div>
                    </div><br/>
                        <span id="forg_pass">Elfelejtett jelszó</span><br/><br/>
                </form>
            </div>
        </div>
        <div id="mod_forg">
                <div class="modal-header">
                    <span class="closeForg">&times;</span>
                <h2>Elfelejtett jelszo</h2>
                </div>
                <div class="modal-body">
                    <form class="form-inline text-center" id="submit_forg">
                        <div class="form-group">
                            <label for="email" class="sr-only">Email cím</label><br/>
                            <div class="form-group">
                                <input type="text"  name="email_forg" id="email_forg" placeholder="Email cím"/>
                            </div><br/>
                        <div class="form-group">
                            <div class="form-group">
                                <input id="btn_kuld" type="submit" name="kuldes" value="Küldés"/><br/>
                            </div>
                            <div class="form-group">
                                <input id="forg_btn_ok" type="button" name="forg_btn_ok" value="OK"/>
                            </div>
                        </div>
                        </div>
                        <div>
                            <br/>
                            <p id="forg_basic_msg">A jelszavát és felhasználónevét elküldjük a megadott email címre!</p>
                            <p id="forg_ok"></p>
                            <p id="forg_nok"></p>
                        </div>
                    </form>
                
                </div>
        </div>
    </div>
    </div>
    
    <!-- The Modal REG -->
    <div id="myModalReg" class="modal">

     <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="closeReg">&times;</span>
                <h2>Regisztráció</h2>
            </div>
            <div class="modal-body">
                <form id="reg">
                    <div>
                        <label for="name" class="sr-only">Felhasználónév:</label>
                        <div>
                            <input type="text" id="name" name="name" placeholder="Felhasználónév"/>
                        </div>
                        <label for="password" class="sr-only">Jelszó:</label>
                        <div>
                            <input type="password" name="password_reg" placeholder="Jelszó" id="password_reg"/>
                        </div>
                        <label for="secPassword" class="sr-only">Jelszó megerősítés: </label>
                        <div>
                            <input type="password" id="secPassword_reg" name="secPassword_reg" placeholder="Jelszó mégegyszer"/>
                        </div>
                        <label for="email" class="sr-only">Email cím: </label>
                        <div>
                            <input type="text" class="form-control" name="email" id="email" placeholder="email cm"/>
                        </div>
                    </div>
                    <p id="reg-error"></p>
                    <p id="reg-success"></p><br/>
                    <div>
                        <div>
                            <input id="btn_reg" type="button" name="submit" value="Regisztrál"/>
                        </div>
                    <div>
                        <input id="btn_ok" type="button" name="btn_ok" value="OK"/>
                    </div>
                    </div>
                </form>
            </div>
        </div> 
    </div>
    
    
    </header>
