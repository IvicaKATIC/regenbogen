<?php

for($i = 0; $i < count($percentages); $i++){?>


<p>Frage <?php echo $i ?></p>
<p><?php echo $percentages[$i]->frage->frage?></p>
<p>

    <label><input type="radio" name="q1" value="25">25%</label>
    <label><input type="radio" name="q1" value="50">50%</label>
    <label><input type="radio" name="q1" value="75">75%</label>
    <label><input type="radio" name="q1" value="100">100%</label>
</p>
<br>

<?php }?>

