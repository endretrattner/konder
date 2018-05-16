<?php
require_once 'includes/sql_connect.php';
$msgSuccess = "";
$msgError = "";
$title="";
$siker=0;
$option=0;
$public = 0;
$result = FALSE;

 //print_r($_POST);


if (isset($_REQUEST["cat"])){
        $cat = $_REQUEST["cat"]; 
        $subkerdezes = mysqli_query($link, "SELECT * FROM subcategory WHERE CatId = '$cat'");
        $return = "<select  name=\"subcategory\" id=\"subcategory\" class=\"form-control\" onchange=\"husok(this.value)\">";
        $return .= "<option disabled selected value> -- Válassz alkategóriát -- </option>";
        while ($subrow = mysqli_fetch_assoc($subkerdezes)) {
            $return .= "<option value=" .$subrow['SubcatId']. " >" .$subrow['SubcatName']. "</option>";
        }
        $return .= "</select>";
        echo $return;
        exit();
    }
    
if (isset($_REQUEST["subcat"])){
        $subcat = $_REQUEST["subcat"]; 
    } else {
        $subcat = null;
    }
    
if($subcat) {
        $huskerdezes = mysqli_query($link, "SELECT * FROM meat ");
        if($subcat == 1 ||
           $subcat == 5 ||
           $subcat == 9 || 
           $subcat == 11 || 
           $subcat == 3 || 
           $subcat == 13 ||
           $subcat == 21) {
                $return = "<select name=\"husok\" id=\"husok\">";
                $return .= "<option disabled selected value> -- Válassz hús kategóriát -- </option>";                
                while ($husrow = mysqli_fetch_assoc($huskerdezes)) {
                    $return .= "<option  value=".$husrow['MeatId'].">".$husrow['MeatName']."</option>";
                }
                $return .= "</select>";
                echo $return;
                exit();
        }
        else {
            exit();
        }
    }
    
    


?>


<!-- The Modal REC UP -->

     <!-- Modal content -->
<div class="modalRecUpContent">
    <div class="modal-header">
        <span class="closeRecUp">&times;</span>
        <h2>Recept feltöltés</h2>
        <div class="recTipHold">
                    <div class="impField">
                        <button class="recOwn"  name="own">Saját recept szerkesztés</button>
                        <button class="recLink"  name="link">Külső link megadása</button>
                    </div>
        </div>
    </div>
    <div class="modal-body" id="modalRecUpBody">
        <form  method="post" id="recUp" enctype="multipart/form-data" action="index.php">
            <fieldset>
                <div class="impField" id="kulsoLink">
                    <input  id="linkHolder" type="text" name="recLink" placeholder="Ide másold be a külső linket!" >
                </div>
                   
                <div class="pubHold">
                    <label class="impField">Publikus:</label> 
                    <div class="impField">
                        <input class="" type="checkbox" name="publikus" checked="checked">
                    </div>
                </div>
<!--nev mezo -->
                <div class="nameHold">
                    <label class="impField">*Név: </label>
                    <div class="impField">
                        <input type="text" name="recTitle" placeholder="Étel neve" class="">
                    </div>
                </div>

<!--kat mezo -->
                <div class="catHold">
                    <label class="impField">*Kategória:</label>
                    <div class="impField">
                        <select  name="category" id="category"  onchange="get_sub(this.value)">
                            <option> -- Válassz kategóriát -- </option>
<?php
    $lekerdezes = mysqli_query($link, "SELECT CatId, CatName FROM category") or die(mysqli_error($link)); 
    while ($row = mysqli_fetch_assoc($lekerdezes)) {
        //echo "<script>console.log( 'Debug Objects: " . $row['CatId'] . "' );</script>";
        $option = filter_input(INPUT_POST, 'category');
        echo "<option " ; if (isset($option) && $option==$row['CatId']) {echo "selected";}; echo "value=".$row['CatId'].">".$row['CatName']."</option>";
}
?>
                        </select>
                    </div>
                
                    <div class="subHold">
                        <label class=""></label>
                        <div  id="submenu" class="impField"></div>
                    </div>
                    <div class="sub2Hold">
                        <label class=""></label>
                        <div id="submenu2" class="impField"></div>
                    </div>
                </div>
<!-- megjegyzes-->
                <div class="remarcHold">
                    <label class="impField">Megjegyzés:</label>
                    <div class="impField" id="recProcRemarc">
                        <textarea class="remarcText" rows="15" id="recRemarc" name="recProcRemarc"></textarea>
                    </div>
                </div>
            
<!-- hozzavalo-->

                <div class="ingHold">
                    
                    <label class="">*Hozzávalók:</label>
                    
                    <div class="" id="hozzavalo">
                        <div id="repeat">
                            <div  id="ingred" class="impField">
                            <input  type="text" class="ingText" placeholder="Hozzávaló"  name="recIng[]" >
                        </div>
                            <div id="cant" class="impField">
                            <input class="" type="number" name="ingCant[]" min="0,1" step="0.1" placeholder="Mennyiség">
                        </div>
                            <div id="cantType" class="impField">
                            <select  name="cantType[]" id="cantName">
                            <option> -- Válassz mértékegységet -- </option>
<?php
    $lekerdezes2 = mysqli_query($link, "SELECT CantTypeId, CantName FROM canttype") or die(mysqli_error($link)); 
    while ($row2 = mysqli_fetch_assoc($lekerdezes2)) {
        echo "<option  value=".$row2['CantTypeId'].">".$row2['CantName']."</option>";
}
?>
                            </select>
                        </div><br/>
                        </div>
                    </div> 
                    
                        <div class="impField">
                        <a class="" id="addRow" >+ hozzávaló</a>
                        </div><br/>
                </div>
                    
<!-- elkeszites-->
                    
                <div class="procHold">
                    <label class="impField">*Ekészítés:</label>
                    <div class="impField" id="recProcText">
                        <textarea class="procText" rows="15" id="recProc" name="recProc"></textarea>
                    </div>
                </div>
                    

<!-- adag -->
                <div class="portHold">
                    <label class="impField">*Adag:</label> 
                    <div class="impField">
                        <input class="" type="number" name="adag" min="1"  placeholder="Adag">
                    </div>
                </div> 
                    
<!-- kep feltoltes-->
                <div class="imgHold">
                    <label class="impField">Kép:</label>
                    <div class="impField">
                        <input type="file" name="file"  class="">
                    </div>
                </div>
                
                <div class="submitHold">
                    <div class="impField">
                        <!--<input name="mentes" id="mentes" type="submit" value="Mentés"> -->
                        <button id="mentes" value="1" class="btn" name="mentes">Mentés</button>
                    </div>
                </div>
            </fieldset>
        </form>
    </div>
</div>