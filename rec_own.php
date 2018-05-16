<?php
require_once 'includes/sql_connect.php';
?>
<h2>Saját receptek</h2>

<div class="CatOwn">
    <button value="1" class="btnCatOwn btn">Előétel</button>
    <button value="2" class="btnCatOwn btn">Leves</button>
    <button value="3" class="btnCatOwn btn">Főétel</button>
    <button value="4" class="btnCatOwn btn">Desszert</button>
    <button value="5" class="btnCatOwn btn">Saláta</button>
</div>

<?php
if(isset($_GET['subId'])) {
    $subId = filter_input(INPUT_GET, "subId");
} else {
    $subId = 0;
}
//IF MENU BTN
if(filter_input(INPUT_GET, 'user')) {
    $user = filter_input(INPUT_GET, 'user');
    $userId = $_SESSION['userId'];
     
    $requestSpajsz = mysqli_query($link, "SELECT * FROM spajsz WHERE UserId= '$userId' ")or die(mysqli_error($link));
    if(mysqli_num_rows($requestSpajsz) > 0) {
        while ($rowSpajsz = mysqli_fetch_assoc($requestSpajsz)) {
            $recId = $rowSpajsz['RecipeId'];
            //$query = "WHERE RecipeAuthor= '$user' OR RecipeId = '$recId'";
            $requestRecSpajsz = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeId = '$recId' ORDER BY RecipeDate DESC ");
            while ($row = mysqli_fetch_assoc($requestRecSpajsz)) {
                $recLink = $row['RecipeLink'];
                if(strlen($recLink) > 1) {
                    $target = urlencode($recLink);
                    $key = "5ad71ccbea16e447462909b1538e79e274678ecb29b99";
                    $ret = file_get_contents("https://api.linkpreview.net?key={$key}&q={$target}");
                    $myJSON = json_decode($ret);
                    $recOrigTitle = $myJSON->title;
                    $pic = $myJSON->image;
                    $origUrl = $myJSON->url;
                } else {
                    $request2 = mysqli_query($link, "SELECT Filename FROM photos WHERE RecipeId=" . $row['RecipeId']. " LIMIT 1;");
                    $row2 = mysqli_fetch_assoc($request2);
                    $pic_upl = $row2['Filename'];
                if(empty($row2)) {
                    $pic = "http://localhost/konderbetyar/includes/css/img/logo.png";
                } else {
                    $pic = "http://localhost/konderbetyar/img/$pic_upl"  ;
                }
                }
            ?> 
    <button class="btnWiev" id="rec_modal_open" value="<?php echo $row['RecipeId']; ?>">
        <div class="panel_rec">
            <div class="panel_heading"><?php echo $row['RecipeTitle']; ?></div>
            <div class="panel_body">
                <div id="recOrigImgHolder">
                <img style="max-height: 150px;" class="panel_img" src="<?php echo $pic ?>" alt="<?php echo $row['RecipeTitle']; ?>">
<?php
if(strlen($recLink) > 1) {
?>
                <div class="origTitle"><?php echo $recOrigTitle ?></div>
<?php
}
?>
                </div>
            </div>
        </div>
    </button>    
<?php
        }
            $requestRec = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeAuthor= '$user' ORDER BY RecipeDate DESC ");
        }
       } else {
           //$query = "WHERE RecipeAuthor= '$user'";
           $requestRec = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeAuthor= '$user' ORDER BY RecipeDate DESC ");
       }
        

}  

// IF FOKATEGORIA
if(isset($_GET['CatIdOwn'])) {
    $cat = filter_input(INPUT_GET, 'CatIdOwn');
    $subreq = mysqli_query($link, "SELECT * FROM subcategory WHERE CatId = $cat");
    $userId = $_SESSION['userId'];
    $user = $_SESSION['userName'];
?>
    <div class="subcat_holder">
<?php
            while ($row = mysqli_fetch_assoc($subreq)){
?>
                <div class="check_cont">
                    <input id="check<?php echo $row['SubcatId']; ?>" type="checkbox" class="catcheckOwn" <?php if ($subId == $row['SubcatId']) echo "checked='checked' "; ?>value="<?php echo $row['SubcatId']; ?>"><label for="check<?php echo $row['SubcatId']; ?>" id="checkname"><?php echo $row ['SubcatName']; ?></label>
                </div>
<?php
            }
?>
        </div>
<?php
    $requestSpajsz = mysqli_query($link, "SELECT * FROM spajsz WHERE UserId= '$userId'" );
    if(mysqli_num_rows($requestSpajsz) > 0) {
        while ($rowSpajsz = mysqli_fetch_assoc($requestSpajsz)) {
            $recId = $rowSpajsz['RecipeId'];
            $requestRecSpajsz = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeId = '$recId' AND CatId = '$cat' ORDER BY RecipeDate DESC ");
            while ($row = mysqli_fetch_assoc($requestRecSpajsz)) {
                $recLink = $row['RecipeLink'];
                if(strlen($recLink) > 1) {
                    $target = urlencode($recLink);
                    $key = "5ad71ccbea16e447462909b1538e79e274678ecb29b99";
                    $ret = file_get_contents("https://api.linkpreview.net?key={$key}&q={$target}");
                    $myJSON = json_decode($ret);
                    $recOrigTitle = $myJSON->title;
                    $pic = $myJSON->image;
                    $origUrl = $myJSON->url;
                } else {
                    $request2 = mysqli_query($link, "SELECT Filename FROM photos WHERE RecipeId=" . $row['RecipeId']. " LIMIT 1;");
                    $row2 = mysqli_fetch_assoc($request2);
                    $pic_upl = $row2['Filename'];
                if(empty($row2)) {
                    $pic = "http://localhost/konderbetyar/includes/css/img/logo.png";
                } else {
                    $pic = "http://localhost/konderbetyar/img/$pic_upl"  ;
                }
                }
            ?> 
    <button class="btnWiev" id="rec_modal_open" value="<?php echo $row['RecipeId']; ?>">
        <div class="panel_rec">
            <div class="panel_heading"><?php echo $row['RecipeTitle']; ?></div>
            <div class="panel_body">
                <div id="recOrigImgHolder">
                <img style="max-height: 150px;" class="panel_img" src="<?php echo $pic ?>" alt="<?php echo $row['RecipeTitle']; ?>">
<?php
if(strlen($recLink) > 1) {
?>
                <div class="origTitle"><?php echo $recOrigTitle ?></div>
<?php
}
?>
                </div>
            </div>
        </div>
    </button>    
<?php
        }
            //$query = "WHERE RecipeAuthor= '$user' OR RecipeId = '$recId' AND CatId = '$cat'";
       
            $requestRec = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeAuthor= '$user' AND CatId = '$cat' ORDER BY RecipeDate DESC ");
        }
       } else {
           //$query = "WHERE RecipeAuthor= '$user'";
           $requestRec = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeAuthor= '$user' AND CatId = '$cat' ORDER BY RecipeDate DESC ");
       }
    ?>

        

<?php  
}
if(isset($_GET['subId'])) {
    $subId = filter_input(INPUT_GET, "subId");
    $subreq = mysqli_query($link, "SELECT * FROM meat WHERE MeatId = '$subId'");
    $userId = $_SESSION['userId'];
    $user = $_SESSION['userName'];
    
    $requestSpajsz = mysqli_query($link, "SELECT * FROM spajsz WHERE UserId= '$userId'" );
    if(mysqli_num_rows($requestSpajsz) > 0) {
        while ($rowSpajsz = mysqli_fetch_assoc($requestSpajsz)) {
            $recId = $rowSpajsz['RecipeId'];
            $requestRecSpajsz = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeId = '$recId' AND SubcatId = '$subId' ORDER BY RecipeDate DESC ");
            while ($row = mysqli_fetch_assoc($requestRecSpajsz)) {
                $recLink = $row['RecipeLink'];
                if(strlen($recLink) > 1) {
                    $target = urlencode($recLink);
                    $key = "5ad71ccbea16e447462909b1538e79e274678ecb29b99";
                    $ret = file_get_contents("https://api.linkpreview.net?key={$key}&q={$target}");
                    $myJSON = json_decode($ret);
                    $recOrigTitle = $myJSON->title;
                    $pic = $myJSON->image;
                    $origUrl = $myJSON->url;
                } else {
                    $request2 = mysqli_query($link, "SELECT Filename FROM photos WHERE RecipeId=" . $row['RecipeId']. " LIMIT 1;");
                    $row2 = mysqli_fetch_assoc($request2);
                    $pic_upl = $row2['Filename'];
                if(empty($row2)) {
                    $pic = "http://localhost/konderbetyar/includes/css/img/logo.png";
                } else {
                    $pic = "http://localhost/konderbetyar/img/$pic_upl"  ;
                }
                }
            ?> 
    <button class="btnWiev" id="rec_modal_open" value="<?php echo $row['RecipeId']; ?>">
        <div class="panel_rec">
            <div class="panel_heading"><?php echo $row['RecipeTitle']; ?></div>
            <div class="panel_body">
                <div id="recOrigImgHolder">
                <img style="max-height: 150px;" class="panel_img" src="<?php echo $pic ?>" alt="<?php echo $row['RecipeTitle']; ?>">
<?php
if(strlen($recLink) > 1) {
?>
                <div class="origTitle"><?php echo $recOrigTitle ?></div>
<?php
}
?>
                </div>
            </div>
        </div>
    </button>    
<?php
        }
            //$query = "WHERE RecipeAuthor= '$user' OR RecipeId = '$recId' AND CatId = '$cat'";
            $requestRec = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeAuthor= '$user' AND SubcatId = '$subId' ORDER BY RecipeDate DESC ");
        }
       } else {
           //$query = "WHERE RecipeAuthor= '$user'";
           $requestRec = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeAuthor= '$user' AND SubcatId = '$subId' ORDER BY RecipeDate DESC ");
       }
        if(isset($_GET['submeat'])) {
            $submeat = filter_input(INPUT_GET, "submeat");
            if(!isset(G_GET['submeal'])) { 
                $submeat = null;
                
            }
            $userId = $_SESSION['userId'];
            $subId = filter_input(INPUT_GET, "subId");
            if ($subId == 1 || $subId == 5 || $subId == 9 || $subId == 21) {
                $subreq = mysqli_query($link, "SELECT * FROM meat ");
            
            ?>
            <div class="subcat_holder">
    


<?php
            while ($row = mysqli_fetch_assoc($subreq)){
?>
                <div class="check_cont">
                    <input id="subcheck<?php echo $row ['MeatId']; ?>" type="checkbox" class="submeatOwn" value="<?php echo $row ['MeatId']; ?>"<?php if($submeat == $row['MeatId']){echo "checked";}?>><label for="subcheck<?php echo $row ['MeatId']; ?>" id="subcheckname"><?php echo $row ['MeatName']; ?></label>
                </div>
<?php
            }
?>
    
            </div>
<?php
            }
            $requestSpajsz = mysqli_query($link, "SELECT * FROM spajsz WHERE UserId= '$userId'" );
            if(mysqli_num_rows($requestSpajsz) > 0) {
                while ($rowSpajsz = mysqli_fetch_assoc($requestSpajsz)) {
                    $recId = $rowSpajsz['RecipeId'];
                    $requestRecSpajsz = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeId = '$recId' AND SubcatId = '$subId' AND MeatId = '$submeat'ORDER BY RecipeDate DESC ");
            while ($row = mysqli_fetch_assoc($requestRecSpajsz)) {
                $recLink = $row['RecipeLink'];
                if(strlen($recLink) > 1) {
                    $target = urlencode($recLink);
                    $key = "5ad71ccbea16e447462909b1538e79e274678ecb29b99";
                    $ret = file_get_contents("https://api.linkpreview.net?key={$key}&q={$target}");
                    $myJSON = json_decode($ret);
                    $recOrigTitle = $myJSON->title;
                    $pic = $myJSON->image;
                    $origUrl = $myJSON->url;
                } else {
                    $request2 = mysqli_query($link, "SELECT Filename FROM photos WHERE RecipeId=" . $row['RecipeId']. " LIMIT 1;");
                    $row2 = mysqli_fetch_assoc($request2);
                    $pic_upl = $row2['Filename'];
                if(empty($row2)) {
                    $pic = "http://localhost/konderbetyar/includes/css/img/logo.png";
                } else {
                    $pic = "http://localhost/konderbetyar/img/$pic_upl"  ;
                }
                }
            ?> 
    <button class="btnWiev" id="rec_modal_open" value="<?php echo $row['RecipeId']; ?>">
        <div class="panel_rec">
            <div class="panel_heading"><?php echo $row['RecipeTitle']; ?></div>
            <div class="panel_body">
                <div id="recOrigImgHolder">
                <img style="max-height: 150px;" class="panel_img" src="<?php echo $pic ?>" alt="<?php echo $row['RecipeTitle']; ?>">
<?php
if(strlen($recLink) > 1) {
?>
                <div class="origTitle"><?php echo $recOrigTitle ?></div>
<?php
}
?>
                </div>
            </div>
        </div>
    </button>    
<?php
        }
                    //$query = "WHERE RecipeAuthor= '$user' OR RecipeId = '$recId' AND CatId = '$cat'";
                    $requestRec = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeAuthor= '$user'  AND SubcatId = '$subId' AND MeatId = '$submeat') ORDER BY RecipeDate DESC ");
        }
       } else {
           //$query = "WHERE RecipeAuthor= '$user'";
           $requestRec = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeAuthor= '$user' AND SubcatId = '$subId' AND MeatId = '$submeat' ORDER BY RecipeDate DESC ");
       }
            //$query = "WHERE SubcatId = '$subId' AND MeatId = '$submeat'";
        } else {
        }
        
    }


?>
<div id="rec_holder">

<?php
    

// KIRAS SAJ REC

    while ($row = mysqli_fetch_assoc($requestRec)) {
        $recLink = $row['RecipeLink'];
        if(strlen($recLink) > 1) {
        $target = urlencode($recLink);
        $key = "5ad71ccbea16e447462909b1538e79e274678ecb29b99";
        $ret = file_get_contents("https://api.linkpreview.net?key={$key}&q={$target}");
        $myJSON = json_decode($ret);
        $recOrigTitle = $myJSON->title;
        $pic = $myJSON->image;
        $origUrl = $myJSON->url;
        } else {
            $request2 = mysqli_query($link, "SELECT Filename FROM photos WHERE RecipeId=" . $row['RecipeId']. " LIMIT 1;");
            $row2 = mysqli_fetch_assoc($request2);
            $pic_upl = $row2['Filename'];
            if(empty($row2)) {
                $pic = "http://localhost/konderbetyar/includes/css/img/logo.png";
            } else {
                $pic = "http://localhost/konderbetyar/img/$pic_upl"  ;
            }
         }
            ?> 
    <button class="btnWiev" id="rec_modal_open" value="<?php echo $row['RecipeId']; ?>">
        <div class="panel_rec">
            <div class="panel_heading"><?php echo $row['RecipeTitle']; ?></div>
            <div class="panel_body">
                <div id="recOrigImgHolder">
                <img style="max-height: 150px;" class="panel_img" src="<?php echo $pic ?>" alt="<?php echo $row['RecipeTitle']; ?>">
<?php
if(strlen($recLink) > 1) {
?>
                <div class="origTitle"><?php echo $recOrigTitle ?></div>
<?php
}
?>
                </div>
            </div>
        </div>
    </button>    
<?php
        }

?>
</div>