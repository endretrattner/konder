<?php
require_once 'includes/sql_connect.php';

if(isset($_GET['subId'])) {
    $subId = filter_input(INPUT_GET, "subId");
} else {
    $subId = 0;
}

if(isset($_GET['CatId'])) {

    $cat = filter_input(INPUT_GET, 'CatId');
    $subreq = mysqli_query($link, "SELECT * FROM subcategory WHERE CatId = $cat");
    $query = "WHERE CatId = '$cat'";
    ?>

        <div class="subcat_holder">
<?php
            while ($row = mysqli_fetch_assoc($subreq)){
?>
                <div class="check_cont">
                    <input id="check<?php echo $row['SubcatId']; ?>" type="checkbox" class="catcheck" <?php if ($subId == $row['SubcatId']) echo "checked='checked' "; ?>value="<?php echo $row['SubcatId']; ?>"><label for="check<?php echo $row['SubcatId']; ?>" id="checkname"><?php echo $row ['SubcatName']; ?></label>
                </div>
<?php
            }
?>
        </div>

<?php  
}

    if(isset($_GET['subId'])) {
        $subId = filter_input(INPUT_GET, "subId");
        $query = "WHERE SubcatId = '$subId'";
        if(isset($_GET['submeat'])) {
            $submeat = filter_input(INPUT_GET, "submeat");
            $query = "WHERE SubcatId = '$subId' AND MeatId = '$submeat'";
        } else {
            $submeat = null;
        }
        if ($subId == 1 || $subId == 5 || $subId == 9 || $subId == 21) {
            $subreq = mysqli_query($link, "SELECT * FROM meat ");
?>
            <div class="subcat_holder">
    


<?php
            while ($row = mysqli_fetch_assoc($subreq)){
?>
                <div class="check_cont">
                    <input id="subcheck<?php echo $row ['MeatId']; ?>" type="checkbox" class="submeat" value="<?php echo $row ['MeatId']; ?>"<?php if($submeat == $row['MeatId']){echo "checked";}?>><label for="subcheck<?php echo $row ['MeatId']; ?>" id="subcheckname"><?php echo $row ['MeatName']; ?></label>
                </div>
<?php
            }
?>
    
            </div>

<?php
        
        }
    }   

?>
<div id="rec_holder">
<?php
        if(isset($_SESSION['userId'])) {
        $user = $_SESSION['userId'];
        } else {
            $user ="";
        }
        
        
        $publicQuery = "(public = 1 OR UserId = '$user')";
        $request1 = mysqli_query($link, "SELECT * FROM recipe ".$query."AND".$publicQuery." ORDER BY RecipeDate DESC");
        
        while ($row = mysqli_fetch_assoc($request1)) {
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