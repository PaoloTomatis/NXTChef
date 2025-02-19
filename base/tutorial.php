<?php 
function card($tit, $desc, $num, $img="img-def.png"){ 
    ?>
    <div class="card grid" id="card-<?php echo htmlspecialchars($num); ?>">
        <div class="col-40">
            <img src="/assets/<?php echo htmlspecialchars($img); ?>" alt="Card-IMG" class="card-img">
        </div>
        <div class="col-60">
            <h2 class="card-tit"><?php echo htmlspecialchars($tit); ?></h2>
            <p class="card-desc"><?php echo $desc; ?></p> <!-- No need to escape HTML here, as it's content -->
        </div>
    </div>
    <?php
}