<?php 
function recipe(array $recipes, array $saved, int $index) { 
?>
    <div class="col-33 recipes-cont">
        <?php 
        if (isset($recipes[$index])) {
            foreach ($recipes[$index] as $recipe) { 
                $sign = "+";
                foreach ($saved as $save) {
                    if ($save["idRep"] == $recipe["id"]) {
                        $sign = "-";
                        break;
                    }
                }
        ?>
            <div class="recipe">
                <a href="/recipe/<?php echo htmlspecialchars($recipe["id"]); ?>">
                    <img src="assets/NxtChefLOGO.png" alt="Immagine della Ricetta" class="recipe-img">
                </a>
                <div class="recipe-bar">
                    <h3 class="recipe-tit"><?php echo htmlspecialchars($recipe["name"]); ?></h3>
                    <a href="/recipeSave/<?php echo htmlspecialchars($recipe["id"]); ?>" class="recipe-btn">
                        <?php echo $sign; ?>
                    </a>
                </div>
            </div>
        <?php 
            }
        } 
        ?>
    </div>
<?php 
} 
?>
