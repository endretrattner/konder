<?php
require_once 'includes/sql_connect.php';
 if (filter_input(INPUT_GET, 'recount')) {
        $recount = filter_input(INPUT_GET, 'recount');   
        } else {
           $recount = 0; 
    }
if (filter_input(INPUT_GET, 'recId')) {
        $recId = filter_input(INPUT_GET, 'recId');   
        } else {
           $recId = 0; 
    }
if (filter_input(INPUT_GET, 'portion')) {
        $portion = filter_input(INPUT_GET, 'portion');   
        } else {
           $portion = 0; 
    }
 ?>
<b><i>Hozzávalók: </i></b>
<?php
$request2 = mysqli_query($link, "SELECT * FROM ingred WHERE RecipeId = '$recId'")or die (mysqli_error($link));
    while ($row2 = mysqli_fetch_assoc($request2)) {
        
        $cant = $row2['IngredCant'];
        if ($recount){
            $ujadag = filter_input(INPUT_GET, 'recount', FILTER_SANITIZE_NUMBER_INT);
            $szaz = $portion;
            $bejovo = $cant;
            $cant = ($ujadag * $bejovo) / $szaz; 
        }
        
        $cantName = $row2['CantName'];
   
        $request3 = mysqli_query($link, "SELECT * FROM canttype WHERE CantTypeId = '$cantName' LIMIT 1")or die (mysqli_error($link));
        $row3 = mysqli_fetch_assoc($request3);
        $cantTypeName = $row3['CantName'];
        
 ?>
                
                <p><span><?php echo $row2['IngredName']; ?></span>&nbsp;<span><?php echo $cant; ?></span>&nbsp;<span><?php echo $cantTypeName; ?></span></p>
                
<?php
 }
 ?>

