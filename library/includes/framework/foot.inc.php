<?php
/*include($path.'/library/includes/config/connect.inc.php');

$database = "ehconstruction";
mysql_select_db("$database") or die(mysql_error());

$sql = 'SELECT UpLink, UpDescShort FROM update_nfo LIMIT 1;';
        
$data = mysql_query($sql) or die(mysql_error());

while ($row = mysql_fetch_array($data)) {
    $UpLink = $row['UpLink'];
    $UpDescShort = $row['UpDescShort'];
} */   
?>
    

<footer class="container_12 mt-60 c-natural-gray">
    <!--<div class="grid_3">&nbsp;</div>
    <div class="grid_5">
        <h4 class="m-0">Latest Updates</h4>
        <p class="m-0"><?php //echo $UpDescShort; ?></p>
        <p class="m-0"><a href="update/<?php //echo $UpLink; ?>" class="c-natural-gray link">Read more</a></p>
    </div>
    <div class="grid_2">
        <h4 class="m-0">Something</h4>
        <ul class="list-n m-0">
            <li><a href="#" class="c-natural-gray link">Houzz</a></li>
            <li><a href="#" class="c-natural-gray link">Pinterest</a></li>
            <li><a href="#" class="c-natural-gray link">LinkedIn</a></li>
        </ul>
    </div>
    <div class="grid_2">
        <h4 class="m-0">E&amp;H Construction</h4>
        <ul class="list-n m-0">
            <li><a href="/about" class="c-natural-gray link">About</a></li>
            <li><a href="/updates" class="c-natural-gray link">Updates</a></li>
            <li><a href="/projects" class="c-natural-gray link">Projects</a></li>
        </ul>
    </div>-->
    <div class="grid_12 mt-20" style="border-top:1px solid;">&copy; <?php echo date("Y"); ?> E&amp;H Construction</div>
</footer>