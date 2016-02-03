<?php
    
$ProjectId = $_GET['pid'];


function projectList()
{
    
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstr_ehconstruction";
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
            <div class="d-tc">
                <a href="index.php?projectID='.$PID.'"><h3 class="mb-0">'.$ProjName.'</h3></a>
                <p class="mt-0 mb-5">Added: '.$DateTime.'</p>
                <input type="checkbox" class="" value="Set as Featured" >
            </div>
            <div class="d-tc" style="width:30px;">
                <a class="mark-removal"><i class="btr bt-trash"></i></a>
            </div>
        </li>';
        
        $projects .= $project;
    }
    echo $projects;
    mysql_close();
}


// Add or update a listing    
if(isset($_POST['a']) && !empty($_POST['a'])) {
    $action = $_POST['a'];
    switch($action) {
        case 'add' : addProject(); break;
        case 'update' : updateProject(); break;
        case 'remImg' : removeImage(); break;
        case 'upMeta' : updateMeta(); break;
        case 'remProj' : removeProject(); break;
        case 'setCover' : setCover(); break;
    }
}
function clean($string)
{
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
 
function addProject()
{
    if(!empty($_POST['t']))
        {
        $path = $_SERVER['DOCUMENT_ROOT'];
        include($path.'/library/includes/config/connect.inc.php');
        $database = "ehconstr_ehconstruction";
        mysql_select_db("$database") or die(mysql_error());
        
        $ProjName = mysql_real_escape_string($_POST['t']);
        $ProjLink = clean($ProjName);
        $ProjVendors = mysql_real_escape_string($_POST['v']);
        $ProjDescShort = mysql_real_escape_string($_POST['s']);
        $ProjDescLong = mysql_real_escape_string($_POST['l']);
           
        $sql = "INSERT INTO project_nfo (ProjFeatured, ProjLink, ProjName,ProjKeyImg,ProjKeyImgUrl,ProjVendors,ProjDescShort,ProjDescLong,DateAdded) VALUES ('0','$ProjLink','$ProjName','','','$ProjVendors','$ProjDescShort','$ProjDescLong',NULL);";
        
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

function updateProject()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstr_ehconstruction";
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

function removeImage()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstr_ehconstruction";
    
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
//
//function removeProject()
//{
//    $ProjectId = $_POST['k'];
//    
//    $path = $_SERVER['DOCUMENT_ROOT'];
//    include($path.'/library/includes/config/connect.inc.php');
//    
//    $database = "ehconstr_ehconstruction";
//    
//    ////////////////////////////////////////////////////////////////////////
//    // Step 1, find the images associated with the project and remove them
//    ////////////////////////////////////////////////////////////////////////
//    
//    //mysql_connect("$server", "$username", "$password") or die(mysql_error()); 
//    mysql_select_db("$database") or die(mysql_error());
//    
//    $sql = "SELECT ImageLink, ImageName FROM project_img WHERE fk_PID = '$ProjectId';";
//    // get the file names and remove each one...
//    $data = mysql_query($sql) or die(mysql_error());
//    while ($row = mysql_fetch_array($data)) {
//        $link = $row['ImageLink'];
//        $file = $row['ImageName'];
//        
//        unlink($link.$file);
//        unlink($link.'200/'.$file);
//        unlink($link.'480/'.$file);
//    }
//    
//    // delete by image records in the database fk_PID
//    $sql = "DELETE FROM project_img WHERE fk_PID = '$ProjectId';";
//        
//    $data = mysql_query($sql) or die(mysql_error());
//    
//    // check if the query was executed
//    if($data == true){
//       // everything ok
//       print(1);
//    } else {
//       // error happened
//       print(0);
//    }
//    
//    ////////////////////////////////////////////////////////////////////////
//    // Step 2, remove the project from the database
//    ////////////////////////////////////////////////////////////////////////
//    
//    //mysql_connect("$server", "$username", "$password") or die(mysql_error()); 
//    mysql_select_db("$database") or die(mysql_error());
//                
//                    
//    $sql = "DELETE FROM project_nfo WHERE PID = '$ProjectId';";
//        
//    $data = mysql_query($sql) or die(mysql_error());
//    
//    // check if the query was executed
//    if($data == true){
//       // everything ok
//       print(1);
//       if($_GET['projectID'] == $ProjectId){
//           // if we were looking at this project, refresh the page
//           header("Location: index.php");
//       }
//       
//    } else {
//       // error happened
//       print(0);
//    }
//    
//    mysql_close();
//}

function updateMeta()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstr_ehconstruction";
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

function setCover()
{
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    
    $database = "ehconstr_ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $PID = $_POST['p'];
    $ImgLink = $_POST['l'];
    $ImgName = $_POST['f'];
       
    $sql = "UPDATE project_nfo SET ProjKeyImg='$ImgName', ProjKeyImgUrl='/$ImgLink' WHERE PID='$PID';";
    
    $data = mysql_query($sql) or die(mysql_error());
    
    if($data == true){
       
       print(1);
    } else {
       // error happened
       print(0);
    }
    // add some stuff to the session for temporary retrieval
    //$_SESSION['proj']=$_POST['t'];
    mysql_close();
}

?>