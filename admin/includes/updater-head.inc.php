<?php
    $header = $step;
    if (isset($sessionProject))
    {
        $header .= ' // '.$sessionProject;
    }
?>

<div class="container_12">
    <div class="grid_12">
        <?php echo $header; ?>
    </div>
</div>


