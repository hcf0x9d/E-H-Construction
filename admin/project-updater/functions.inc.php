<?php session_start(); ?>

<?php

$ProjectId = $_GET['projectID'];

// Add or update a listing    
if(isset($_POST['a']) && !empty($_POST['a'])) {
    $action = $_POST['a'];
    switch($action) {
        case 'add' : addProject(); break;
        case 'update' : updateProject(); break;
        case 'remImg' : removeImage(); break;
        case 'upMeta' : updateMeta(); break;
        case 'remProj' : removeProject(); break;
    }
}
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

// Listing the projects on the project details page        
function projectList()
{
    
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $sql = 'SELECT * FROM project_nfo ORDER BY PID DESC';
    $data = mysql_query($sql) or die(mysql_error());
    
    $projects = '';
    
    while ($row = mysql_fetch_array($data)) {
        $DateTime = date('F j, Y',strtotime($row['DateAdded']));
        $ProjName = $row['ProjName'];
        $ProjDescShort = $row['ProjDescShort'];
        $PID = $row['PID'];
        
        $project = '
        <li class="list-n d-t proj-row pos-r" data-project="'.$PID.'">
            <div class="d-tc" style="width:30px;">
                <a class="mark-removal">X</a>
            </div>
            <div class="d-tc">
                <a href="project.php?projectID='.$PID.'"><h3 class="mb-0">'.$ProjName.'</h3></a>
                <p class="mt-0">Added: '.$DateTime.'</p>
            </div>
        </li>';
        
        $projects .= $project;
    }
    echo $projects;
    mysql_close();
}

function ShowImages()
{
    if(isset($_GET['projectID']))
    {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include($path.'/library/includes/config/connect.inc.php');
        
        $ProjectId = $_GET['projectID'];
        $database = "ehconstruction";
        
        mysql_select_db("$database") or die(mysql_error());
        
        $sql = "SELECT * FROM project_img WHERE fk_PID = '$ProjectId';";
            
        $data = mysql_query($sql) or die(mysql_error());
        
        while ($row = mysql_fetch_array($data)) {
            $ImageName = $row['ImageName'];
            $ImageLink = $row['ImageLink'];
            $ImageTitle = $row['ImageTitle'];
            $ImageCaption = $row['ImageCaption'];
            $ImageID = $row['IID'];
            
            $item = '
            <li class="list-n p-20 img-row pos-r grid_4" id="'.$ImageID.'" data-file="'.$ImageName.'" data-url="'.$ImageLink.'">
                <div class="grid_4 alpha omega pos-r" style="height:200px;background:url('.$ImageLink.'200/'.$ImageName.') center center no-repeat;">
                    <div class="pos-a mark-removal" style="bottom:10px;right:10px;z-index:1000;">X</div>
                </div>
                <div class="grid_4 alpha omega">
                    '.$ImageName.'<br>
                    <input class="meta-item" type="text" name="ImageTitle" placeholder="Image Title" value="'.$ImageTitle.'" />
                    <textarea class="meta-item" name="ImageCaption" id="" cols="30" rows="4" placeholder="Caption">'.$ImageCaption.'</textarea>
                </div>
            </li>';
            
            echo $item;
            
        }
        
        //mysql_close();
        //header("Location: index.php");   
    }
}

// Add a new project
function addProject()
{
    if(!empty($_POST['t']))
        {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include($path.'/library/includes/config/connect.inc.php');
        $database = "ehconstruction";
        mysql_select_db("$database") or die(mysql_error());
        
        $ProjName = mysql_real_escape_string($_POST['t']);
        $ProjLink = clean($ProjName);
        $ProjVendors = mysql_real_escape_string($_POST['v']);
        $ProjDescShort = mysql_real_escape_string($_POST['s']);
        $ProjDescLong = mysql_real_escape_string($_POST['l']);
           
        $sql = "INSERT INTO project_nfo (ProjLink, ProjName,ProjVendors,ProjDescShort,ProjDescLong,DateAdded) VALUES ('$ProjLink','$ProjName','$ProjVendors','$ProjDescShort','$ProjDescLong',NULL);";
        
        $addProj = mysql_query($sql) or die(mysql_error());
        
        if(!$addProj){
            die('Could not enter data: '.mysql_error());
        } else {
            $sql = "SELECT * FROM project_nfo WHERE ProjName = '$ProjName';";
            
            $data = mysql_query($sql) or die(mysql_error());
            
            while ($row = mysql_fetch_array($data)) {
                $PID = $row['PID'];
            }
            
            mysql_close();
    
            echo "$PID";
               
        }
        // add some stuff to the session for temporary retrieval
        $_SESSION['proj']=$_POST['t'];
    } else {
        return 0;
    }
    mysql_close();
}

// Update an existing project
function updateProject()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $PID = $_POST['pid'];
    $ProjName = mysql_real_escape_string($_POST['t']);
    $ProjLink = clean($ProjName);
    $ProjVendors = mysql_real_escape_string($_POST['v']);
    $ProjDescShort = mysql_real_escape_string($_POST['s']);
    $ProjDescLong = mysql_real_escape_string($_POST['l']);
       
    $sql = "UPDATE project_nfo SET ProjName='$ProjName', ProjLink='$ProjLink', ProjVendors='$ProjVendors', ProjDescShort='$ProjDescShort', ProjDescLong='$ProjDescLong' WHERE PID='$PID';";
    
    $addProj = mysql_query($sql) or die(mysql_error());
    
    if(!$addProj){
        die('Could not enter data: '.mysql_error());
    } else {
        $sql = "SELECT * FROM project_nfo WHERE ProjName = '$ProjName';";
        
        $data = mysql_query($sql) or die(mysql_error());
        
        while ($row = mysql_fetch_array($data)) {
            $PID = $row['PID'];
        }
        
        mysql_close();
        
        echo "$PID";
    }
    // add some stuff to the session for temporary retrieval
    $_SESSION['proj']=$_POST['t'];
    
}

// Remove an image that has been uploaded
function removeImage()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstruction";
    
    //mysql_connect("$server", "$username", "$password") or die(mysql_error()); 
    mysql_select_db("$database") or die(mysql_error());
                
    $key = $_POST['k'];
    $file = $_POST['f'];
    $link = $_POST['l'];
                    
    $sql = "DELETE FROM project_img WHERE IID = '$key';";
        
    $data = mysql_query($sql) or die(mysql_error());
    
    // check if the query was executed
    if($data == true){
       // everything ok
       unlink($link.$file);
       unlink($link.'200/'.$file);
       unlink($link.'480/'.$file);
       
       print(1);
    } else {
       // error happened
       print(0);
    }
    
    mysql_close();
}

// Remove an image that has been uploaded
function removeProject()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstruction";
    
    //mysql_connect("$server", "$username", "$password") or die(mysql_error()); 
    mysql_select_db("$database") or die(mysql_error());
                
    $key = $_POST['k'];
                    
    $sql = "DELETE FROM project_nfo WHERE PID = '$key';";
        
    $data = mysql_query($sql) or die(mysql_error());
    
    // check if the query was executed
    if($data == true){
       // everything ok
       unlink($link.$file);
       unlink($link.'200px-'.$file);
       unlink($link.'480px-'.$file);
       
       print(1);
    } else {
       // error happened
       print(0);
    }
    
    mysql_close();
}

// Update the meta information for the image
function updateMeta()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $key = $_POST['k'];
    $meta = $_POST['c'];
    $val = mysql_real_escape_string($_POST['v']);
                    
    $sql = "UPDATE project_img SET $meta='$val' WHERE IID = '$key';";
        
    $data = mysql_query($sql) or die(mysql_error());
    
    // check if the query was executed
    if($data == true){
       // everything is Ok, the data was inserted
       print(1);
    } else {
       // error happened
       print(0);
    }
    
    mysql_close();
}

?>