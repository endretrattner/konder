<?php
require_once 'includes/sql_connect.php';


if (filter_input(INPUT_GET, 'logout') == 1) {
    logout();
}

//----------------------------------------------REC UP-------------------------------------//

if(filter_input(INPUT_POST, 'mentes')) {
    $userId = $_SESSION['userId'];
    $userName = $_SESSION['userName'];
    if(isset($_POST['publikus'])) {
        $public = 1;
    } else {
        $public = 0;
    }
    $recLink = filter_input(INPUT_POST, 'recLink');
// if set link
if(strlen($recLink) > 1) {
    $ido = date("Y-m-d h:i:s");
    $recLink = strpos($recLink, 'http') !== 0 ? "http://$recLink" : $recLink;
    if(filter_var($recLink, FILTER_VALIDATE_URL)) {
        if(isset($_POST['recTitle'])) {
            $title = htmlspecialchars(filter_input(INPUT_POST, 'recTitle', FILTER_SANITIZE_STRING));
            if(isset($_POST['category'])) {
                $option = filter_input(INPUT_POST, 'category');
                $subcat = filter_input(INPUT_POST, 'subcategory');
                $husid = filter_input(INPUT_POST, 'husok');
                if(!$husid) {
                    $husid = 0;
                }
                if(isset($_POST['recProcRemarc'])) {
                    $recRemarc = htmlspecialchars(filter_input(INPUT_POST, 'recProcRemarc', FILTER_SANITIZE_STRING));   
                } else {
                    $recRemarc = "";
                }
                $result = mysqli_query($link, "INSERT INTO recipe"
                    . " (RecipeTitle, CatId, SubcatId, MeatId, UserId, `RecipeAuthor`, `RecipeDate`, Public, RecipeRemarc, RecipeLink)"
                    . " VALUES ('$title', '$option', '$subcat', $husid, '$userId', '$userName', '$ido', '$public', '$recRemarc', '$recLink')");
            } else {
                $msgError = "A kategória kiválasztása kötelező";
            }
        } else {
            $msgError = "A név megadása kötelező";
        }  
    } else {
        $msgError = "A megadott link nem érvényes";
    }
} 

// if no link
if(strlen($recLink) < 1) {
    $ido = date("Y-m-d h:i:s");
    if(isset($_POST['recTitle'])) {
        $title = htmlspecialchars(filter_input(INPUT_POST, 'recTitle', FILTER_SANITIZE_STRING));
        echo "<script>console.log( 'Debug Objects/no: " . $title . "' );</script>";
        if(isset($_POST['category'])) {
            $option = filter_input(INPUT_POST, 'category');
            $subcat = filter_input(INPUT_POST, 'subcategory');
            $husid = filter_input(INPUT_POST, 'husok');
            if(!$husid) {
                $husid = 0;
            }
            if(isset($_POST['adag'])){
                $adag = filter_input(INPUT_POST, 'adag');
            } else {
                $adag = 1;
            }
            
            if(isset($_POST['recProc'])) {
                $process = htmlspecialchars(filter_input(INPUT_POST, 'recProc', FILTER_SANITIZE_STRING));
                $process = getBreakText($process);
                if(!empty($_POST ['ingCant']) && !empty($_POST ['recIng']) && !empty($_POST ['cantType'])) {
                    
                
                $result = mysqli_query($link, "INSERT INTO recipe"
                    . " (RecipeTitle,RecipeProc, CatId, SubcatId, MeatId, UserId, `RecipeAuthor`, `RecipeDate`, Public, Portion)"
                    . " VALUES ('$title', '$process', '$option', '$subcat', $husid, '$userId', '$userName', '$ido', '$public', '$adag')"); 
                $id = mysqli_insert_id($link);
                for($i = 0; $i < count ( $_POST ['recIng'] ); $i ++) {
                        $feltoltes = mysqli_query($link, "INSERT INTO ingred"
                        . " (IngredCant, IngredName, CantName, `RecipeId`)"
                        . " VALUES ('" . mysqli_real_escape_string($link, $_POST ['ingCant'][$i]) 
                        ."', '" . mysqli_real_escape_string($link, $_POST ['recIng'][$i])
                        ."', '" . mysqli_real_escape_string($link, $_POST ['cantType'][$i]) ."', '$id')");
                    }
                } else {
                $msgError = "A hozzávalók megadása kötelező";
                } 
            }   
        } else {
            $msgError = "A kategória kiválasztása kötelező";
        }
    } else {
        $msgError = "A név megadása kötelező";
    }  
//kep
    $file_ext = array("jpg", "bmp", "jpeg", "gif", "png");
    $max_mb = 5;
    $talalat = 0;
    $filename = "";
    if(!empty($_FILES['file']['name'])) {
        $temp_tomb = explode('.',$_FILES['file']['name']);
        $feltoltott_kit = end($temp_tomb);
        $keplekerdezes = mysqli_query($link, "SELECT max(PicId) FROM photos");
        $keprow = mysqli_fetch_assoc($keplekerdezes);
        $kepid = $keprow['max(PicId)']+1;
        $picName = picName($title);
        $filename = "kb_" . $picName ."_". $kepid . "." . $feltoltott_kit;
        $imageInfo = getimagesize($_FILES['file']['tmp_name']);
        foreach ($file_ext as $ext) {
            if( ($_FILES['file']['type'] == "image/$ext" ) && ($imageInfo['mime'] == "image/$ext") ) {
                if(move_uploaded_file($_FILES["file"]["tmp_name"], KEPUTVONAL . $filename)) {
                    $talalat = 1;
                }
                if (($talalat == 1) && (in_array($feltoltott_kit, $file_ext)) && ($_FILES['file']['size'] < ($max_mb * 1024 * 1024))) {
                    $kepfeltoltes = mysqli_query($link, "INSERT INTO photos(RecipeId, Filename) VALUES ('$id', '$filename' )");
                } else {
                    if($talalat == 1) {
                        $msgError = "A kép túl nagy!";
                    }
                }
            }
        }
    }
}
if($result){
    $msgSuccess = "A receptet sikeresen feltöltötted!";
    $siker=1;
}
}

//------------------------END REC UP-----------------------------------//




//----------------------- REC EDIT ---------------------------//

//$feltoltes = "";        
if(filter_input(INPUT_POST, 'felulir')) {
    $updateID = $_SESSION['recId'];
    if(isset($_POST['publikus'])) {
                $public = 1;
            } else {
                $public = 0;
            }
    $category = (int)filter_input(INPUT_POST, 'category');
    $submenu = (int)filter_input(INPUT_POST, 'submenu');
    $submenu2 =(int)filter_input(INPUT_POST, 'submenu2');
    if(!$submenu2) {
        $submenu2 = 0;
    }
    $recTitle = htmlspecialchars(filter_input(INPUT_POST, 'recTitle', FILTER_SANITIZE_STRING));
    $recDesc = htmlspecialchars(filter_input(INPUT_POST, 'recDesc', FILTER_SANITIZE_STRING));
    $recProc = htmlspecialchars(filter_input(INPUT_POST, 'recProc', FILTER_SANITIZE_STRING));
    $recProc = getBreakText($recProc);
    $adag = filter_input(INPUT_POST, 'adag');
    $ido = date("Y-m-d h:i:s");
    
    $result = mysqli_query($link, "UPDATE recipe SET "
            . "RecipeTitle = '$recTitle', RecipeProc = '$recProc', "
            . "CatID = '$category', SubcatID = '$submenu', MeatId = '$submenu2', "
            . "RecipeDate = '$ido', Portion = '$adag', public = '$public' "
            . "WHERE RecipeId = '$updateID'");
    
//hozzavalo
       
    if(!empty($_POST ['ingCant']) && !empty($_POST ['recIng']) && !empty($_POST ['cantType'])) {
        
        $delIng = mysqli_query($link, "DELETE FROM ingred WHERE RecipeId='$updateID'");
                    
        for($i = 0; $i < count ( $_POST ['recIng'] ); $i ++) {
            $feltoltes = mysqli_query($link, "INSERT INTO ingred"
                . " (IngredCant, IngredName, CantName, `RecipeId`)"
                . " VALUES ('" . mysqli_real_escape_string($link, $_POST ['ingCant'][$i]) 
                ."', '" . mysqli_real_escape_string($link, $_POST ['recIng'][$i])
                ."', '" . mysqli_real_escape_string($link, $_POST ['cantType'][$i]) ."', '$updateID')");
        }
    }
//kep
    $file_ext = array("jpg", "bmp", "jpeg", "gif", "png");
    $max_mb = 5;
    $talalat = 0;
    $filename = "";

    if(!empty($_FILES['file']['name'])) {
        $temp_tomb = explode('.',$_FILES['file']['name']);
        $feltoltott_kit = end($temp_tomb);
        $keplekerdezes = mysqli_query($link, "SELECT PicId FROM photos WHERE RecipeId='$updateID'");
        $keprow = mysqli_fetch_assoc($keplekerdezes);
        $kepid = $keprow['PicId'];
        $picName = picName($recTitle);
        $filename = "kb_" . $picName ."_". $kepid . "." . $feltoltott_kit;                     
        $imageInfo = getimagesize($_FILES['file']['tmp_name']);
        foreach ($file_ext as $ext) {
            //dupla ellenorzes
            if( ($_FILES['file']['type'] == "image/$ext" ) && ($imageInfo['mime'] == "image/$ext") ) {
                if(move_uploaded_file($_FILES["file"]["tmp_name"],KEPUTVONAL. $filename)) { 
                    //$path= $_FILES['file']['name'];
                    $talalat = 1;
                }
            }
        }
    }
    if (($talalat == 1) && (in_array($feltoltott_kit, $file_ext)) && ($_FILES['file']['size'] < ($max_mb * 1024 * 1024))) {
        $kepfeltoltes = mysqli_query($link, "UPDATE photos SET Filename='$filename' WHERE RecipeId = '$updateID'");
        
        } else {
            if($talalat == 1) {
                $msgError = "A kép túl nagy!";
            }
        }
    if($result && $feltoltes) {
        $msgSuccess = "A receptet sikeresen elmentetted!";
    }
}
        
//---------------END REC EDIT -------------------------------//


autentication();  
require_once 'menu.php';
?>
<div id="dinamic"></div>

<div id="myModalRec" class="modal"></div>
<div id="myModalRecUp" class="modal"></div>


</body>
</html>
