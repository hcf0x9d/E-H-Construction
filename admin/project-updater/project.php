<?php session_start();
    
    $ProjectId = $_GET['projectID'];
    $step = 'Add or modify a project';
    
    include('functions.inc.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>E&amp;H Construction | Projects</title>
    
    <link rel="stylesheet" type="text/css" href="http://cloudbin.vagtm.com/library/cdn/style/960.css" />
    <link rel="stylesheet" type="text/css" href="http://cloudbin.vagtm.com/library/cdn/style/atomic-2.0.css" />
    
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <style>
    input[type=text],
    input[type="password"],
    textarea    
        {
            width:96%;
            padding:2%;
            border:1px solid #919195;
            border-radius:3px;
            font-size:1em;
            font-family:sans-serif;
        }
    </style>
</head>
<body>
    <?php include('../includes/updater-head.inc.php'); ?>
    <div class="container_12">
        <aside class="grid_4">
            <h2>Active Projects</h2>
            <ul>
                <li class="d-t list-n">
                    <div class="d-tc" style="width:30px;">
                        &nbsp;
                    </div>
                    <div class="d-tc">
                        <a href="project.php"><h3 class="mb-0">Add a New Project</h3></a>
                        <p class="mt-0">Click to add a new project</p>
                    </div>
                </li>
                <?php projectList(); ?>
            </ul>
        </aside>
        <div class="grid_8">
            <!-- This is the form for adding or updating a project -->
            <form action="" method="POST" enctype="multipart/form-data" style="width:500px;">
                <?php
                    $path = $_SERVER['DOCUMENT_ROOT'];
                    include($path.'/library/includes/config/connect.inc.php');
                    
                    $database = "ehconstruction";
                    mysql_select_db("$database") or die(mysql_error());
                        
                    $sql = "SELECT * FROM project_nfo WHERE PID = '$ProjectId'";
                    $data = mysql_query($sql) or die(mysql_error());
                    
                    while ($row = mysql_fetch_array($data)) {
                        $PID = $row['PID'];
                        $ProjName = $row['ProjName'];
                        $ProjVendors = $row['ProjVendors'];
                        $ProjDescShort = $row['ProjDescShort'];
                        $ProjDescLong = $row['ProjDescLong'];
                    }
                    
                    $_SESSION['proj']=$ProjName;
                    
                    $form =
                    '
                    <input type="hidden" id="PID" value="'.$PID.'" />
                    <input type="text" id="title" value="'.$ProjName.'" />
                    <textarea id="vendors" rows="2">'.$ProjVendors.'</textarea>
                    <textarea id="shortdesc" rows="5">'.$ProjDescShort.'</textarea>
                    <textarea id="longdesc" rows="10">'.$ProjDescLong.'</textarea>';
                    
                    if(isset($ProjName)){
                        $form .= '<input class="project-action-btn" type="button" id="update" value="Save & Continue">';
                    } else {
                        $form .= '<input class="project-action-btn" type="button" id="add" value="Save & Continue">';
                    }
                    
                    echo $form;
                ?>
                
            </form>
        </div>
    </div>
    <script>
        $(function(){
            // Lets update the project
            // on button click, start the preloader
            $('.project-action-btn').on('click', function(){
                var action = $(this).attr('id');
                var title = $('#title').val();
                var vendors = $('#vendors').val();
                var shortdesc = $('#shortdesc').val();
                var longdesc = $('#longdesc').val();
                var pid = $('#PID').val();
                
                
                
                // then run the update function    
                $.post('functions.inc.php', {a:action, pid:pid, t:title, v:vendors, s:shortdesc, l:longdesc, /*f:featured*/ }, function(data){
                    if(data == 0){
                        // change this to a non-blocking notification
                        alert('something went wrong!');
                    } else {
                        window.location.href = 'project-upload.php?projectID='+data;
                    }
                });
            });
            // don't forget to stop the preloader
            
            $('.mark-removal').on('click', function(){
                var pid = $(this).closest('li').data('project');
                var $confirm = '<div class="confirm-box p-10 pos-a ta-c" style="left:0;width:100%;height:100%;background:rgba(255,255,255,0.5);">Are you sure?<br><a href="javascript:void(0);" onClick="removeProject('+pid+');">Yes</a><br><a href="javascript:void(0);" onClick="$(\'.confirm-box\').fadeOut(200);">Nope</a></div>';
                
                $(this).closest('.proj-row').append($confirm);
                //$this.fadeTo(250, 0.5);
                
            });
            
            
        });
            
        function removeProject(pid){
            $.post('functions.inc.php', {a:'remProj',  k:pid}, function(data){
                if(data == 0){
                    // change this to a non-blocking notification
                    alert('oops...didn\'t work');
                } else {
                    $('li[data-project="'+pid+'"').slideUp(250);
                }
            });
        }
    </script> 
</body>
</html>