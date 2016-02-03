<?php session_start();
    $sessionProject = $_SESSION['proj'];
    $ProjectId = $_GET['projectID'];
    $step = 'Image Upload &amp; Information';
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
     <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
     
     <link rel="stylesheet" type="text/css" href="http://cloudbin.vagtm.com/library/cdn/style/960.css" />
     <link rel="stylesheet" type="text/css" href="http://cloudbin.vagtm.com/library/cdn/style/atomic-2.0.css" />
     
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

<?php
    
    
    // Handling the upload
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/connect.inc.php');
    include($path.'/library/includes/config/simpleimage.inc.php');
    
    include($path.'/admin/project-updater/functions.inc.php');
        
    $database = "ehconstruction";
    mysql_select_db("$database") or die(mysql_error());
    
    $ouptut_date = date('Y').'/'.date('m');
    $output_dir = "../../images/projects/".$ouptut_date."/";
    $output_480 = $output_dir."480/";
    $output_200 = $output_dir."200/";
    
    
    if(isset($_FILES['files'])){
        $errors= array();
        foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
            $file_name = str_replace(" ", "-", $_FILES['files']['name'][$key]);
            $file_tmp =$_FILES['files']['tmp_name'][$key];
            
            if(empty($errors)==true){
                if (!is_dir($output_dir)) {
                    mkdir($output_dir, 0777, true);
                }
                if (!is_dir($output_480)) {
                    mkdir($output_480, 0777, true);
                }
                if (!is_dir($output_200)) {
                    mkdir($output_200, 0777, true);
                }
                
                if(file_exists("$output_dir".$file_name)){
                    // if exists, stop!
                    $errors = $file_name.' has already been uploaded, it was not uploaded again.';
                }else{
                    $addfile = "INSERT INTO project_img (ImageName,ImageLink,ImageTitle,ImageCaption,fk_PID) VALUES ('$file_name','$output_dir','','','$ProjectId');";
                    $msql = mysql_query($addfile) or die(mysql_error()); 
                    
                    if(!$msql){
                    
                    } else {
                        $uploaded_file = "$output_dir".$file_name;
                        move_uploaded_file($file_tmp,"$output_dir".$file_name);
                        chmod($uploaded_file, 0777);
                        
                        $image = new SimpleImage();
                        $image->load($uploaded_file);
                        
                        list($width, $height, $type, $attr) = getimagesize($uploaded_file);
                        
                        if($width > 1000)
                        {
                            $image->resizeToWidth(1000);
                            $image->save("$output_dir".$file_name);
                        } else {
                            //$image->save("$output_dir".$file_name);
                        }
                        
                        // We need to force these two options
                        $image->resizeToHeight(480);
                        $image->save("$output_480".$file_name);
                        
                        //Thumbnail
                        //Your Image
                        $imgSrc = "$output_dir".$file_name;
                         
                        //getting the image dimensions
                        list($width, $height) = getimagesize($imgSrc);
                         
                        //saving the image into memory (for manipulation with GD Library)
                        $myImage = imagecreatefromjpeg($imgSrc);
                        
                        ///--------------------------------------------------------
                        //setting the crop size
                        //--------------------------------------------------------
                        if($width > $height) $biggestSide = $width;
                        else $biggestSide = $height;
                         
                        //The crop size will be half that of the largest side
                        $cropPercent = .5;
                        $cropWidth   = $biggestSide*$cropPercent;
                        $cropHeight  = $biggestSide*$cropPercent;
                         
                        //getting the top left coordinate
                        $c1 = array("x"=>($width-$cropWidth)/2, "y"=>($height-$cropHeight)/2);
                        
                        //--------------------------------------------------------
                        // Creating the thumbnail
                        //--------------------------------------------------------
                        $thumbSize = 200;
                        $thumb = imagecreatetruecolor($thumbSize, $thumbSize);
                        imagecopyresampled($thumb, $myImage, 0, 0, $c1['x'], $c1['y'], $thumbSize, $thumbSize, $cropWidth, $cropHeight);
                        
                        //final output
                        //header('Content-type: image/jpeg');
                        imagejpeg($thumb, $output_200.$file_name);
                        imagedestroy($thumb);                       
                        //$thumb->save("$output_200".$file_name);
                        
                        
                    }
                }
                
            }else{
                print_r($errors);
            }
        }
        if(empty($errors)){
            
            mysql_close();
            header("Location: project-upload.php?projectID=$ProjectId");
                
        } else {
           print_r($errors);
        }
    }
?>

</head>
<body>
<?php include('../includes/updater-head.inc.php'); ?>

<div class="container_12">
    <aside class="grid_12" style="background: #eaeaea;">
        <form action="" method="POST" enctype="multipart/form-data" style="padding: 10px;">
            <input type="file" name="files[]" multiple/>
            <input type="submit"/>
        </form>
        <a href="project.php?projectID=<?php echo $ProjectId; ?>" class="btn">Back</a> | 
        <a href="project.php" class="btn">Finish</a>
    </aside>
    <div class="">
        <ul>
            <?php ShowImages(); ?>
        </ul>

    </div>
</div>    



</body>

<script>
        $(function(){
            // Lets update the org and portal links
            $(".meta-item").on('blur', function(){
                var imageId = $(this).closest('li').attr('id');
                var meta = $(this).attr('name');
                var value = $(this).val();
                
                $.post('functions.inc.php', {a:'upMeta', k:imageId, c:meta, v:value }, function(data){
                    if(data == 0){
                        // change this to a non-blocking notification
                        alert('something went wrong!');
                    } else {
                    }
                });
                
            });
            
            $('.mark-removal').on('click', function(){
                var iid = $(this).closest('li').attr('id');
                var $confirm = '<div class="confirm-box p-10 pos-a ta-c" style="left:0;width:100%;height:100%;background:rgba(255,255,255,0.5);">Are you sure?<br><a href="javascript:void(0);" onClick="removeImage('+iid+');">Yes</a><br><a href="javascript:void(0);" onClick="$(\'.confirm-box\').fadeOut(200);">Nope</a></div>';
                
                $(this).closest('.img-row').append($confirm);
                //$this.fadeTo(250, 0.5);
                
            });
            
            
        });
        
        function removeImage(iid){
                var file = $('#'+iid).data('file');
                var link = $('#'+iid).data('url');
                
                $.post('functions.inc.php', {a:'remImg',  k:iid, f:file, l:link}, function(data){
                    if(data == 0){
                        // change this to a non-blocking notification
                    } else {
                        $('#'+iid).slideUp(250);
                    }
                });
            }
    </script> 
</html>