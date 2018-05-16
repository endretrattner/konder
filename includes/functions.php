<?php
if(!defined('SECURE')) {
    die ('Nincs nyulkapiszka!');
}


function logged_in() {
    if($_SESSION['autentikacio'] == true) {
        return true;
    } else {
        return false;
    }
}

function autentication() {
    if(!isset($_SESSION['autentikacio'])) {
    $_SESSION['autentikacio'] = false;
    }
}

function logout() {
    unset($_SESSION['autentikacio']);
    header("Location: http://localhost/konderbetyar/index.php");
    
    //exit();
}

function adagolo($szaz, $bejovo, $ujadag) {
    $kimeno = ($ujadag * $bejovo) / $szaz; 
    return $kimeno;
}

function picName($string, $extension = '') {
    $url_old = array("(Ă­|ĂŤ)", "(Ăˇ|Ă�)", "(Ă©|Ă‰)", "(Ĺ±|Ĺ°)", "(Ăş|Ăš)", "(Ĺ‘|Ĺ�)", "(Ăł|Ă“)", "(ĂĽ|Ăś)", "(Ă¶|Ă–)");
    $url_new = array("i", "a", "e", "u", "u","o", "o", "u", "o");
    $url_regex = "([^a-zA-Z0-9]+)";

    $string = preg_quote($string);
    $string = preg_replace($url_old, $url_new, $string);

    $string = strtolower(preg_replace($url_regex, '-', $string));

    if(!empty($extension)) {
        $string .= '.'.$extension;
    }

    return $string;
}

function getBreakText($t) {
    return strtr($t, array('\\r\\n' => '<br>', '\\r' => '<br>', '\\n' => '<br>'));
}

