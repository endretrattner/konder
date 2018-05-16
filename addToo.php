<?php
require_once 'includes/sql_connect.php';



if (isset($_REQUEST["spaRemId"])) {
    if($_SESSION['autentikacio'] == true) {
        $spaRemId = htmlspecialchars(filter_input(INPUT_GET,'spaRemId',FILTER_VALIDATE_INT));
        $spaRemId = mysqli_real_escape_string($link,$spaRemId);
        $userId = $_SESSION['userId'];
        $spajszRemove = mysqli_query($link, "DELETE FROM spajsz WHERE RecipeId = '$spaRemId' LIMIT 1");
        $recId = $spaRemId;  
    }
} else {
    $spaId = null;
}


if (isset($_REQUEST["spaId"])) {
    if($_SESSION['autentikacio'] == true) {
        $spaId = htmlspecialchars(filter_input(INPUT_GET,'spaId',FILTER_VALIDATE_INT));
        $spaId = mysqli_real_escape_string($link,$spaId);
        $userId = $_SESSION['userId'];
        $spajsz = mysqli_query($link, "INSERT INTO spajsz(UserId, RecipeId) VALUES ('$userId', '$spaId' )");
        $recId = $spaId;  
    }
} else {
    $spaId = null;
} 
?>


<?php    
if($_SESSION['autentikacio'] == TRUE) {
    $userId = $_SESSION['userId'];
    $spareq = mysqli_query($link, "SELECT * FROM spajsz WHERE RecipeId = '$recId' AND UserId='$userId' LIMIT 1 ");
    $requestRec = mysqli_query($link, "SELECT * FROM recipe WHERE RecipeId = '$recId'")or die (mysqli_error($link));
    $rowRec = mysqli_fetch_assoc($requestRec);
    $recAuthVal = $rowRec['RecipeAuthor'];
   if($recAuthVal == $_SESSION['userName']){
?>
       <button type="button" name="btnEdit" class="btn" onclick="btnEdit(<?php echo $recId; ?>)">Szerkesztés</button>
<?php  
       } elseif(mysqli_num_rows($spareq) < 1) {
?>
    <button type="button" name="spa" class="btn" onclick="spajszba(<?php echo $recId; ?>)">Elrakom a saját receptek közé</button>
 <?php
    } else {
?>
     <button type="button" name="spaRemove" class="btn" onclick="spajszRemove(<?php echo $recId; ?>)">Eltávolítom a saját receptek közül</button>
<?php    
    }
} else {
?>
      <p class="alert-success"> Jelentkezz be és tedd el a receptet a spájszba!</p>
<?php
}
?>
              