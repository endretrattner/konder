<?php

require_once 'includes/sql_connect.php';
if (filter_input(INPUT_GET, 'recId')) {
    $recId = htmlspecialchars(filter_input(INPUT_GET, 'recId', FILTER_VALIDATE_INT));
    $recId = mysqli_real_escape_string($link, $recId);
    $userId = $_SESSION['userId'];
}

if(isset($_GET['recId'])) {
    $recId = filter_input(INPUT_GET, 'recId');
    if(!$recId) {$recId = filter_input(INPUT_GET, 'spaId'); }
    $request = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeId = '$recId'")or die (mysqli_error($link));
    $request2 = mysqli_query($link, "SELECT * FROM ingred WHERE RecipeId = '$recId'")or die (mysqli_error($link));
    
    $row = mysqli_fetch_assoc($request);
    $recTitle = $row['RecipeTitle'];
    $recProc = $row['RecipeProc'];
    $recDate = $row['RecipeDate'];
    $recAuth = $row['RecipeAuthor'];
    $portion =$row['Portion'];
    $recLink = $row['RecipeLink'];
    
    if(strlen($recLink) > 1) { 
    $recRemarc = $row['RecipeRemarc'];
    $target = urlencode($recLink);
    $key = "5ad71ccbea16e447462909b1538e79e274678ecb29b99";
    $ret = file_get_contents("https://api.linkpreview.net?key={$key}&q={$target}");
    $myJSON = json_decode($ret);
    $recOrigTitle = $myJSON->title;
    $origImg = $myJSON->image;
    $origUrl = $myJSON->url;
    //var_dump($myJSON);
    }
        //print_r(json_decode($ret));
        
        //exit();
    //var_dump($recLink);
    //exit();
    $request4 = mysqli_query($link, "SELECT * FROM photos WHERE RecipeId = '$recId' LIMIT 1")or die (mysqli_error($link));
    $rowImg = mysqli_fetch_assoc($request4);
    
    if (filter_input(INPUT_GET, 'recount')) {
        $recount = filter_input(INPUT_GET, 'recount');   
        } else {
           $recount = 0; 
    }
}

?>
<!--REC_MOD--> 


    

     <!-- Modal content -->
     <div class="modalRecContent" id="modalRecContent"
    <div id="mod_rec">
        <div class="modal-header">
            <span class="closeRec">&times;</span>
            <h2><?php echo "$recTitle";  ?></h2>
        </div>
        <div class="modal-body" id="modalRecBody">
         
            <div id="sapjszHolder">
                <?php include_once 'addToo.php';?>
            </div>

<?php
if(!empty($myJSON)) {

    if(empty($origImg)) {
        $pic = "http://localhost/konderbetyar/includes/css/img/logo.png";
        } else {
            $pic = $origImg;
        }
?>       
    <a type="button" href="<?php echo $origUrl ?>" target="_blank" class="btnLink">        
        <div id="recOrigImgHolder">    
            <img class="recImg" style="float:right; max-width: 350px; " src="<?php echo $pic ?>" alt="<?php echo $row['RecipeTitle']; ?>"/>
            <div class="origTitle"><?php echo $recOrigTitle ?></div>
            <p id="kattints">Kattints a képre a receptért</p>
        </div>
    </a>
    <div class="recRemarc">
        <i><b>Megjegyzés: </b></i>
        <p><?php echo htmlspecialchars_decode(nl2br($recRemarc)); ?></p>
    </div>    
       
<?php    
} else { 
?>
            <div class="panelRecCount">
                <div id="counterInHonlder">    
                    <form method="post">
                        <div>
                            <i><b>Adagolás: </b></i>
                            <input  id="adagbe" class="form-control col-md-2" type="number" name="adag"   style="float: right;" placeholder="Jelenleg <?php echo ($recount > 0) ? $recount : $portion ; ?> személyre/adagra van beállitva a recept!">
                            <button id="adagszamol" data-value="<?php echo "$portion"; ?>" type="button" class="btn btn-secondary" value="<?php echo "$recId"; ?>">Számolás</button>
                        </div>   
                    </form>
                </div>
            </div>
<?php

    $pic_rec = $rowImg['Filename'];
    if(empty($rowImg)) {
        $pic = "http://localhost/konderbetyar/includes/css/img/logo.png";
        } else {
            $pic = "http://localhost/konderbetyar/img/$pic_rec"  ;
        }
?>
            <div id="recImgHolder">    
                <img class="recImg" style="float:right; max-width: 350px; " src="<?php echo $pic ?>" alt="<?php echo $row['RecipeTitle']; ?>"/>
            </div>
            <div class="ingredHolder" id="ingredHolder">
                
<?php
            include_once 'ingred_gen.php';
?>
            </div>
            <div class="processHolder">
                <i><b>Elkészítés: </b></i>
                <p><?php echo htmlspecialchars_decode(nl2br($recProc)); ?></p>
            </div>
<?php
}
?>
            
        </div>
        <div class="panelRecFooter">
            <i>Feltöltő: </i>
            <span style="float: right;"><i>Feltöltés ideje: </i></br><?php echo $recDate; ?></span>
            </br><span><?php echo $recAuth; ?></span>
        </div>
    </div>
</div>