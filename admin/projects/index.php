<?php

session_start();

if(!$_SESSION['userName'])
{
	header("location: ../login.php");
}

include('../models/db.php');



$step = 'Add or modify a project';


// These functions are all for displaying the page...not writing...
function projectList() {
    
    $sql = 'SELECT * FROM project_nfo ORDER BY PID DESC';

    $mysqli = getConnection();

    $result = $mysqli->query($sql);
    if ($result) {
    
        $projects = '';
        
        while ($row = $result->fetch_assoc()) {
            
            $ProjName = $row['ProjName'];
            $ProjDescShort = $row['ProjDescShort'];
            $ProjKeyImg = $row['ProjKeyImgUrl'].$row['ProjKeyImg'];
            $PID = $row['PID'];
            $DateTime = date('F j, Y',strtotime($row['DateAdded']));
            $featured = '';
            $featuredBanner = '';
            
            if($row['ProjFeatured'] === '1') {
                $featured = ' featured';
                $featuredBanner = '<p class="projectCard_meta featured">Featured Project</p>';
            }
            
            $project = '
            <li class="projectCard'.$featured.'" data-project="'.$PID.'" style="background: url('.$ProjKeyImg.');">
                <a href="index.php?projectID='.$PID.'" class="projectCard_inner">
                    <h3 class="projectCard_title">'.$ProjName.'</h3>
                    '.$featuredBanner.'
                    <p class="projectCard_meta">Added: '.$DateTime.'</p>
                </a>
                <a href="#" class="projectCard_remove mark-removal" onclick="markRemoveProj(\''.$PID.'\');">
                    <i class="btr bt-trash"></i>
                </a>
                
                <a href="#" class="projectCard_featured" onclick="setProjectFeatured(\''.$PID.'\');">
                    <i class="btr bt-star"></i>
                </a>
            </li>';

            $projects .= $project;
        }
    }
    echo $projects;
}

function projectContent() {
    
    if(isset($_GET['projectID'])) {
        $projectId = $_GET['projectID'];    
    
        $sql = "SELECT * FROM project_nfo WHERE PID = '$projectId'";

        $mysqli = getConnection();

        $result = $mysqli->query($sql);
        if ($result) {

            $projects = '';

            while ($row = $result->fetch_assoc()) {
                $PID = $row['PID'];
                $ProjName = $row['ProjName'];
                $ProjVendors = $row['ProjVendors'];
                $ProjDescShort = $row['ProjDescShort'];
                $ProjDescLong = $row['ProjDescLong'];
            }

            $_SESSION['proj'] = $ProjName;

            $form = '
                <input type="hidden" name="pid" id="PID" value="'.$PID.'" />
                <input type="text" name="title" id="title" value="'.$ProjName.'" />
                <textarea name="vendors" id="vendors" rows="2">'.$ProjVendors.'</textarea>
                <textarea name="shortdesc" id="shortdesc" rows="5">'.$ProjDescShort.'</textarea>
                <textarea name="longdesc" id="longdesc" rows="10">'.$ProjDescLong.'</textarea>
                <input class="project-action-btn save-btn" type="button" id="save" data-id="update" value="Save Project" onClick="submitForm(\'update\');" />
                <input class="project-action-btn" type="button" data-id="update" value="Save &amp; Modify Images"  onClick="submitForm(\'update\', \'images\');" />';

        }
    } else {
        $form = '
            <input type="hidden" name="pid" id="PID" value="" />
            <input type="text" name="title" id="title" value="" placeholder="Project Name" />
            <textarea name="vendors" id="vendors" rows="2" placeholder="Project Vendors"></textarea>
            <textarea name="shortdesc" id="shortdesc" rows="5" placeholder="Short Description"></textarea>
            <textarea name="longdesc" id="longdesc" rows="10" placeholder="Full Description"></textarea>
            <input class="project-action-btn save-btn" type="button" id="save" data-id="add" value="Save Project" onClick="submitForm(\'new\');" />
            <input class="project-action-btn" type="button" data-id="add" value="Save &amp; Add Images" onClick="submitForm(\'update\', \'images\');"/>';
    }
        
    echo $form;

}

function getImages() {
    if(isset($_GET['projectID'])) {
        $projectId = $_GET['projectID'];    
    
        $sql = "SELECT ImageName, ImageLink FROM project_img WHERE fk_PID='$projectId'";

        $mysqli = getConnection();

        $result = $mysqli->query($sql);
        if ($result) {
            
            $imgs = '';

            while ($row = $result->fetch_assoc()) {
                $imgs .= '<li style="width: 46%;padding: 2%;"><img src="'.$row['ImageLink'].'200/'.$row['ImageName'].'" /></li>';
            }
        }
        
        echo $imgs;
        
    }
}

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E&amp;H Construction | Projects</title>
    
    <link rel="stylesheet" type="text/css" href="/library/styles/style.css" />
    <link rel="stylesheet" type="text/css" href="/library/webfonts/blacktie/blacktie-fontawesome.css" />

    <script src="/library/scripts/jquery-1.8.0.min.js"></script>    
    
    <link rel="stylesheet" type="text/css" href="/library/scripts/sweetalert/sweetalert.css" />
    <script src="/library/scripts/sweetalert/sweetalert.min.js"></script>

    <style>
        html,body{color:#333;background:#fff;}
        
        input[type=text],
        input[type="password"],
        textarea    
            {
                width:98%;
                padding:1%;
                border:1px solid #919195;
                border-radius:3px;
                font-size:1em;
                font-family:sans-serif;
                color:#919195
            }
            
        .projectCard{
            display: block;
            width: 48%;
            background-size: cover !important;
            background-position: bottom center;
            background-repeat: no-repeat;
            min-height: 200px;
            float: left;
            list-style-type: none;
            position: relative; 
            margin: 1%;
        }
            .projectCard.newProject .projectCard_inner{
                height: 196px;
                border: 2px dashed #ccc;
                background: #efefef !important;
                padding: 0;
            }
                .projectCard.newProject .projectCard_title{
                    padding-top: 3em;
                    text-align: center;
                    color: #ccc;
                    padding-left: 0;
                    padding-right: 0;
                }
            
            .projectCard.featured .projectCard_inner{
                background-color: rgba(97,165,192,0.9);
            }
            .projectCard_inner{
                padding: 5px 2em 5px 10px;
                background: rgba(65,75,78,0.9);

                display: block;
                color: #fff !important;
                text-decoration: none;
                transition: all .2s ease;
            }
                .projectCard_inner:hover{
                    text-decoration: none;
                    background: rgba(65,75,78,1);
                }
            .projectCard_title{
                margin: 10px 0 0 0;
            }
            .projectCard_meta{
                font-size: 0.75em;
                opacity: 0.7;
                line-height: 1;
                margin-top: 0;
            }
                .projectCard_meta.featured{
                    opacity: 1;
                    margin: 0;
                }
            .projectCard_remove{
                position: absolute;
                display: block;
                bottom: 0;
                right: 0;
                width: 2em;
                height: 2em;
                line-height: 2em !important;
                text-align: center;
                color: #fff;
                background: rgba(65,75,78,0.9);
                transition: all .2s ease;
            }
            .projectCard_remove:hover{
                background: red;
            }
            .projectCard_featured{
                position: absolute;
                display: block;
                top: 0;
                right: 0;
                width: 2em;
                height: 2em;
                line-height: 2em !important;
                text-align: center;
                background: rgba(65,75,78,0.9);
                transition: all .2s ease;
                color: rgba(255,255,255,0.5);
            }
                .projectCard_featured:hover,
                .projectCard.featured .projectCard_featured{
                    background: rgba(97,165,192,0.7);
                }
                .projectCard.featured .projectCard_featured:hover{
                    background: rgba(65,75,78,0.9);
                }        
            
            .pb--20{padding-bottom: 20px;}
    </style>
</head>
<body>
    <div class="container_12">
        <aside class="grid_4">
            <h2>logo</h2>
            <ul>                
                <li class="projectCard newProject" data-project="" style="">
                    <a href="index.php" class="projectCard_inner pb--20">
                        <h3 class="projectCard_title">Add a New Project</h3>
                    </a>
                </li>

                <?php projectList(); ?>
            </ul>
        </aside>
        <div class="grid_8">
            <h1>E&amp;H Construction Project Manager</h1>
            <div class="grid_6 alpha">
                <!-- This is the form for adding or updating a project -->
                <form id="projectContent" action="" method="POST" enctype="multipart/form-data" style="width:100%;">
                    <?php projectContent();?>
                    
                </form>
            </div>
            <div class="grid_2 omega">
                <ul class="h-list w-100 m-0">
                    <?php  getImages(); ?>
                </ul>
            </div>
        </div>
        
    </div>
    <script>
    function submitForm(type, next) {
        'use strict';
        event.preventDefault();

        var data = $('#projectContent').serialize();
        
        $.ajax({
            url: '../models/project_functions.php',
            data: 'action=' + type + '&' + data,
            type: 'post',
            success: function (response) {
                if (response) {
                    if (typeof(next) != "undefined" && next !== null) {
                        if(next === 'images') {
                            window.location.href = 'upload.php?pid=' + response;
                        }
                    } else {
                        swal({
                            title: "Project Updated",
                            text: "Your project has been updated, this will close in 2 seconds.",
                            timer: 2000,
                            type: "success",
                            showConfirmButton: false
                        });                        
                    }

                } else {
                    swal({
                        title: "Not Saved",
                        text: "Something went wrong and we were unable to save. This will close in 2 seconds.",
                        timer: 2000,
                        type: "error",
                        showConfirmButton: false
                    });
                    
                }
            }
        });
    }
        
    function markRemoveProj(pid) {
        'use strict';
        event.preventDefault();

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover this project!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: true,
            closeOnCancel: false
        }, function(isConfirm){
            if (isConfirm) {
                removeProject(pid);
            } else {
                swal("Cancelled", "Your project has been saved", "error");
            }
        });
    }
    function removeProject(pid) {
        'use strict';
        $.ajax({
            url: '../models/project_functions.php',
            data: 'action=remProj&pid=' + pid,
            type: 'post',
            success: function (response) {
                if (response) {
                    swal("Deleted!", "Your project has been removed.", "success");
                    $('li[data-project="'+pid+'"').slideUp(250);
                }
            }
        });
        
    }

    function setProjectFeatured(pid) {
        'use strict';
        event.preventDefault();

        var status = '1',
            $proj = $('.projectCard[data-project="' + pid + '"]');

        if($proj.hasClass('featured')) {
            status = '0';
        }

        $.ajax({
            url: '../models/project_functions.php',
            data: 'action=setFeatured&pid=' + pid + '&status=' + status,
            type: 'post',
            success: function (response) {
                if (response && response === '1') {
                    if (status === '1') {
                        $proj.addClass('featured');
                    } else {
                        $proj.removeClass('featured');
                    }
                }
            }
        });

    } 

        $(function(){
            
//            $('.project-action-btn').on('click', function(){
//                var step = $(this).attr('id');
//                var action = $(this).data('id');
//                var title = $('#title').val();
//                var vendors = $('#vendors').val();
//                var shortdesc = $('#shortdesc').val();
//                var longdesc = $('#longdesc').val();
//                var pid = $('#PID').val();
//                
//                
//                
//                // then run the update function    
//                $.post('functions.inc.php', {a:action, pid:pid, t:title, v:vendors, s:shortdesc, l:longdesc, /*f:featured*/ }, function(data){
//                    if(data == 0){
//                        // change this to a non-blocking notification
//                        alert('something went wrong!');
//                    } else {
//                        if(step == 'save'){
//                            location.reload();
//                        } else {
//                            window.location.href = 'upload.php?projectID='+data;
//                        }
//                    }
//                });
//            });
            // don't forget to stop the preloader
            
            
            
        });
            
    </script> 
</body>
</html>