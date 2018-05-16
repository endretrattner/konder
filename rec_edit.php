<?php
require_once 'includes/sql_connect.php';
$msgSuccess = "";
$msgError = "";
$updateID = filter_input(INPUT_GET, 'recId', FILTER_VALIDATE_INT);
//echo "<script>console.log( 'Public: " . $updateID . "' );</script>";
//var_dump($updateID);
if ($updateID != NULL){
    $_SESSION['recId'] = $updateID;
}
?>


         

        
        
   
<p class="alert-danger  text-center"><?php echo $msgError; ?></p>
<p class="alert-success text-center"><?php echo $msgSuccess; ?></p> 
        
<?php
    $pageID = filter_input(INPUT_GET, 'recId', FILTER_VALIDATE_INT);
    $pageID = mysqli_real_escape_string($link,$pageID);
    $sqlLekerdezes = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeId ='$pageID' LIMIT 1") or die(mysqli_error($link));
    $receptRow= mysqli_fetch_array($sqlLekerdezes);
    

    $keplekerdezes = mysqli_query($link, "SELECT * FROM photos WHERE RecipeId= '$pageID' LIMIT 1")or die(mysqli_error($link));
    $kepRow = mysqli_fetch_array($keplekerdezes);



?>
<!-- The Modal REC UP -->

     <!-- Modal content -->
<div class="modalRecContent">
    <div class="modal-header">
        <span class="closeRecEdit">&times;</span>
        <h2>Recept szerkesztés</h2>
    </div>
    <div class="modal-body" id="modalRecBody">
        <form  method="post" id="recUp" enctype="multipart/form-data" action="index.php">
            <fieldset>
                <div class="pubHold">
                    <label class="impField">Publikus:</label> 
                    <div class="impField">
                             
<?php
$pub = $receptRow['Public'];
if($pub) {
?>
                        <input class="label-text" type="checkbox" name="publikus" checked="checked">
<?php
} else {
?>    
                        <input class="label-text" type="checkbox" name="publikus">
<?php    
}
?>
                    </div>
                </div>
<!--nev mezo -->
                <div class="nameHold">
                    <label class="col-md-3 control-label">*Név: </label>
                    <div class="impField">
                        <input type="text" name="recTitle"  value="<?php echo $receptRow['RecipeTitle']; ?>">
                    </div>
                </div>


<!--kat mezo -->
                <div class="catHold">
                    <label class="impField">*Kategória:</label>
                    <div class="impField">
                        <select  name="category" id="category"  onchange="get_sub(this.value)">
                            <option
<?php
    $kat = $receptRow['CatId'];
    $lekerdez = mysqli_query($link, "SELECT * FROM category WHERE CatId = '$kat' LIMIT 1") or die(mysqli_error($link));
    $kivalasztott = mysqli_fetch_array($lekerdez);
    echo "value =" .$kivalasztott['CatId'];
?>
                                    > <?php echo $kivalasztott['CatName']; ?>
                            </option>
<?php
    $lekerdezes = mysqli_query($link, "SELECT CatId, CatName FROM category") or die(mysqli_error($link));
    while ($row = mysqli_fetch_assoc($lekerdezes)) {
        $option = filter_input(INPUT_POST, 'category');
    echo "<option value=".$row['CatId']." >".$row['CatName']."</option>";
    
    }
        
?>
                        </select>
                    </div>
                    <div class="subHold">
                            <select  id="submenu" name="submenu" onchange="husok(this.value)">
                                <option
<?php
    $sub_kat = $receptRow['SubcatId'];
    $lekerdez_subcat = mysqli_query($link, "SELECT * FROM subcategory WHERE SubcatId = '$sub_kat' LIMIT 1") or die(mysqli_error($link));
    $kivalasztott_subcat = mysqli_fetch_array($lekerdez_subcat);
    echo "value =" .$kivalasztott_subcat['CatId'];
?>
                                    > <?php echo $kivalasztott_subcat['SubcatName']; ?>
                                </option>
<?php
    $lekerdezes = mysqli_query($link, "SELECT SubcatId, SubcatName FROM subcategory WHERE CatId = '$kat' ") or die(mysqli_error($link));
    while ($rowSubcat = mysqli_fetch_assoc($lekerdezes)) {
        $option = filter_input(INPUT_POST, 'subcategory');
    echo "<option value=".$rowSubcat['SubcatId']." >".$rowSubcat['SubcatName']."</option>";}
        
?>
                            </select>
                    </div>
<?php
    $husok = $receptRow['MeatId'];
?>
                    <div class="sub2Hold">
                        <label></label>
                            <select id="submenu2" name="submenu2" class="form-control">
                                <option
<?php
    
    $lekerdez_husok = mysqli_query($link, "SELECT * FROM meat WHERE MeatId = '$husok' LIMIT 1") or die(mysqli_error($link));
    $kivalasztott_husok = mysqli_fetch_array($lekerdez_husok);
    echo "value =" .$kivalasztott_husok['MeatId'];
?>
                                    > <?php echo $kivalasztott_husok['MeatName']; ?>
                                </option>
<?php
    $lekerdezes = mysqli_query($link, "SELECT MeatId, MeatName FROM meat") or die(mysqli_error($link));

    while ($row = mysqli_fetch_assoc($lekerdezes)) {
        $option = filter_input(INPUT_POST, 'husok');
        echo "<option value=".$row['MeatId']." >".$row['MeatName']."</option>";
    
    }
       
?>
                            </select>
                    </div>
                </div>
              
<!-- hozzavalo-->
            <label>*Hozzávalók:</label>
            <div id="ingHoldEdit">
                
<?php
    $ing_id = $receptRow['RecipeId'];
    $query = mysqli_query($link, "SELECT * FROM ingred WHERE RecipeId = '$ing_id'") or die(mysqli_error($link));
    $sorok = mysqli_num_rows($query);
    
    //$cantName = $row2['CantName'];
    //$requestCantType = mysqli_query($link, "SELECT * FROM canttype WHERE CantTypeId = '$cantName' LIMIT 1")or die (mysqli_error($link));
    
    for($i=0; $i<$sorok; $i++) {
        $line = mysqli_fetch_assoc($query);
        $delRow = $line['IngredId'];
        $delRowClass = "delId_".$delRow;
 ?>                     
                <div id="hozzavalo" class="<?php echo $delRowClass; ?>">
                    <div id="repeat">
                        <div  id="ingred" class="impField">
                            <input  type="text" class="form-control" value="<?php echo $line['IngredName']; ?>"  name="recIng[]" >
                        </div>
                        <div id="cant" class="impField">
                             <input type="number" name="ingCant[]" min="0,1" step="0.1" value="<?php echo $line['IngredCant']; ?>">
                        </div>
                        <div id="cantType" class="impField">
                            <select name="cantType[]">
                                <option
                                    
<?php
    $cantName = $line['CantName'];
    $requestCantType = mysqli_query($link, "SELECT * FROM canttype WHERE CantTypeId = '$cantName' LIMIT 1")or die (mysqli_error($link));
    $line2 = mysqli_fetch_assoc($requestCantType);
    echo "value =" .$line2['CantTypeId'];
?>                                    
                                    
                                    ><?php echo $line2['CantName']; ?></option>
<?php
    $lekerdezes2 = mysqli_query($link, "SELECT CantTypeId, CantName FROM canttype") or die(mysqli_error($link)); 
    while ($row2 = mysqli_fetch_assoc($lekerdezes2)) {
        echo "<option  value=".$row2['CantTypeId'].">".$row2['CantName']."</option>";
    }
?>
                            </select>
                        </div>
                        <div id="delRow">
                            <button name="delRow" value="<?php echo $delRowClass; ?>" class="delRow">
                                <img id="deleteLogo" src="http://localhost/konderbetyar/includes/css/img/deleteLogo.png">
                            </button>
                        </div>
                    </div>
                </div>
<?php
    }
?>
                <div class="impField">
                    <a class="" id="addRowEdit" >+ hozzávaló</a>
                </div><br/>
            </div>
<!-- elkeszites-->

<?php
$proc = $receptRow['RecipeProc'];
?>

                <div class="procHold">
                    <label class="impField">*Ekészítés:</label>
                    <div class="impField" id="recProcText">
                        <textarea class="procText" rows="15" id="recProc" name="recProc"><?php echo $proc; ?></textarea>
                    </div>
                </div>
 <!-- adag -->
                     
<?php
$adag_query = $receptRow['Portion'];
?>
 
                <div class="portHold">
                    <label class="impField">*Adag:</label> 
                    <div class="impField">
                        <input class="" type="number" name="adag" min="1"  value="<?php echo $adag_query ?>">
                    </div>
                </div>
 
 
<!-- kep feltoltes-->
<?php
$kep_id = $receptRow['RecipeId'];
$kep_query = mysqli_query($link, "SELECT * FROM photos WHERE RecipeId = '$kep_id'") or die(mysqli_error($link));
$rowImg = mysqli_fetch_assoc($kep_query);
?>
                     
                    <div class="imgHold">
                        <label class="impField">Jelenlegi kép:</label>
                        <img style="max-height: 150px;" src="<?php echo "/konderbetyar/img/".$rowImg['Filename'] ?>">
                        <div class="col-md-12">
                            <input type="file" name="file">
                        </div>
                    </div>

<!-- Submit gomb-->
                <div class="submitHold">
                    <div class="impField">
                        <!--<input name="mentes" id="mentes" type="submit" value="Mentés"> -->
                        <button id="mentes" value="<?php echo $updateID; ?>" class="btn" name="felulir">Mentés</button>
                    </div>
                </div>
        </fieldset>
    </form><br/>
            <div class="col-md-12 text-right">
                <button name="torles" class="btn" onclick="torol_rec(<?php echo $updateID; ?>)">Törlés</button><br/>
            </div>
        </div>
</div>
                    
                    
                    
                    



