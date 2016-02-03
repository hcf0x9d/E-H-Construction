<?php

require 'db.php';

// Add or update a listing    
if(isset($_POST['action']) && !empty($_POST['action'])) {
    $action = $_POST['action'];
    switch($action) {
        case 'new' : addProject(); break;
        case 'update' : updateProject(); break;
        case 'remImg' : removeImage(); break;
        case 'upMeta' : updateMeta(); break;
        case 'remProj' : removeProject($_POST['pid']); break;
        case 'setCover' : setCover(); break;
        case 'setFeatured' : featuredProject(); break;
    }
}

function featuredProject() {
    $sql = "UPDATE project_nfo SET ProjFeatured='".$_POST['status']."' WHERE PID='".$_POST['pid']."'";

    $mysqli = getConnection();

    $result = $mysqli->query($sql);
    if ($result) {
        echo '1';

    } else {
        echo '0';
    }
}

function ShowImages() {
    if(isset($_GET['pid']))
    {
        $ProjectId = $_GET['pid'];

        $sql = "SELECT ProjKeyImg FROM project_nfo WHERE PID = '$ProjectId';";

        $mysqli = getConnection();

        $result = $mysqli->query($sql);
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $cover = $row['ProjKeyImg'];
            }

            $sql = "SELECT * FROM project_img WHERE fk_PID = '$ProjectId';";
        
            $mysqli = getConnection();

            $result = $mysqli->query($sql);
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $ImageName = $row['ImageName'];
                    $ImageLink = $row['ImageLink'];
                    $ImageTitle = $row['ImageTitle'];
                    $ImageCaption = $row['ImageCaption'];
                    $ImageID = $row['IID'];
                    if($ImageName == $cover){
                        $item = '<li class="list-n img-row pos-r grid_4 cover-selected" id="'.$ImageID.'" data-file="'.$ImageName.'" data-url="'.$ImageLink.'">';
                    } else {
                        $item = '<li class="list-n img-row pos-r grid_4" id="'.$ImageID.'" data-file="'.$ImageName.'" data-url="'.$ImageLink.'">';
                    }
                    $item .= '
                        <div class="grid_4 alpha omega pos-r" style="height:200px;background:url('.$ImageLink.'200/'.$ImageName.') center center no-repeat;">
                            <div class="pos-a mark-removal" style="bottom:10px;right:10px;z-index:1000;">X</div>
                            <input type="button" class="set-cover" id="" name="" value="Set as Project Cover" onClick="setCover(\''.$ProjectId.'\',\''.$ImageID.'\',\''.$ImageLink.'\',\''.$ImageName.'\');">
                        </div>
                        <div class="grid_4 alpha omega">
                            '.$ImageName.'<br>
                            <input class="meta-item" type="text" name="ImageTitle" placeholder="Image Title" value="'.$ImageTitle.'" />
                            <textarea class="meta-item" name="ImageCaption" id="" cols="30" rows="4" placeholder="Caption">'.$ImageCaption.'</textarea>
                        </div>
                    </li>';
                    
                    echo $item;
                }
            }
        }
    }
}


function addProject() {
    
    $ProjName = mysql_real_escape_string($_POST['title']);
    $ProjLink = clean($ProjName);
    $ProjVendors = mysql_real_escape_string($_POST['vendors']);
    $ProjDescShort = mysql_real_escape_string($_POST['shortdesc']);
    $ProjDescLong = mysql_real_escape_string($_POST['longdesc']);

    $sql = "INSERT INTO project_nfo 
        (ProjFeatured, ProjLink, ProjName,ProjKeyImg,ProjKeyImgUrl,ProjVendors,ProjDescShort,ProjDescLong,DateAdded) 
        VALUES 
        ('0','$ProjLink','$ProjName','','','$ProjVendors','$ProjDescShort','$ProjDescLong',NULL)";
    
    $mysqli = getConnection();

    $result = $mysqli->query($sql);
    if ($result) {
        getProjectId($ProjName);
    }
}

function updateProject() {
    $PID = $_POST['pid'];
    $ProjName = mysql_real_escape_string($_POST['title']);
    $ProjLink = clean($ProjName);
    $ProjVendors = mysql_real_escape_string($_POST['vendors']);
    $ProjDescShort = mysql_real_escape_string($_POST['shortdesc']);
    $ProjDescLong = mysql_real_escape_string($_POST['longdesc']);

    $sql = "UPDATE project_nfo SET
        ProjName='$ProjName',
        ProjLink='$ProjLink',
        ProjVendors='$ProjVendors',
        ProjDescShort='$ProjDescShort',
        ProjDescLong='$ProjDescLong'
        WHERE PID='$PID'";

    $mysqli = getConnection();

    $result = $mysqli->query($sql);
    if ($result) {
        getProjectId($ProjName);
    }
}

function getProjectId($ProjName) {
    
    $sql = "SELECT * FROM project_nfo WHERE ProjName = '$ProjName'";
    
    $mysqli = getConnection();

    $result = $mysqli->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            echo $row['PID'];
        }
    }
}


function removeProject($ProjectId)
{
    
    ////////////////////////////////////////////////////////////////////////
    // Step 1, find the images associated with the project and remove them
    ////////////////////////////////////////////////////////////////////////
    
    $sql = "SELECT ImageLink, ImageName FROM project_img WHERE fk_PID = '$ProjectId';";
    // get the file names and remove each one...
    $mysqli = getConnection();

    $result = $mysqli->query($sql);
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $link = $row['ImageLink'];
            $file = $row['ImageName'];

            unlink($link.$file);
            unlink($link.'200/'.$file);
            unlink($link.'480/'.$file);
        }
    }
    
    // delete by image records in the database fk_PID
    $sql = "DELETE FROM project_img WHERE fk_PID = '$ProjectId';";
        
    $mysqli = getConnection();

    $result = $mysqli->query($sql);
    if ($result == true) {
       // everything ok
       echo '1';
    } else {
       // error happened
       echo '0';
    }
    
    ////////////////////////////////////////////////////////////////////////
    // Step 2, remove the project from the database
    ////////////////////////////////////////////////////////////////////////
    
    $sql = "DELETE FROM project_nfo WHERE PID = '$ProjectId';";
        
    $mysqli = getConnection();

    $result = $mysqli->query($sql);
    // check if the query was executed
    if($result == true){
       // everything ok
       echo '1';
           // if we were looking at this project, refresh the page
           //header("Location: index.php");
       
    } else {
       // error happened
       echo '0';
    }
    
}


function clean($string)
{
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}

?>
