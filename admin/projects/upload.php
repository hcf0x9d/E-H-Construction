<?php session_start();
    // not sure what this was
    $sessionProject = $_SESSION['proj'];

    $ProjectId = $_GET['pid'];
    $step = 'Image Upload &amp; Information';

    
    // // Handling the upload
    $path = $_SERVER['DOCUMENT_ROOT'];
    include($path.'/library/includes/config/simpleimage.inc.php');
    
     include($path.'/admin/models/project_functions.php');
     include($path.'/admin/models/db.php');
    
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
                    $sql = "INSERT INTO project_img (ImageName,ImageLink,ImageTitle,ImageCaption,fk_PID) VALUES ('$file_name','$output_dir','','','$ProjectId');";
                    $mysqli = getConnection();

                    $result = $mysqli->query($sql);
                    if ($result) {
                        $uploaded_file = "$output_dir".$file_name;
                        move_uploaded_file($file_tmp,"$output_dir".$file_name);
                        chmod($uploaded_file, 0777);
                        
                        $image = new SimpleImage();
                        $image->load($uploaded_file);
                        
                        list($width, $height, $type, $attr) = getimagesize($uploaded_file);
                        
                        if($width > 1200)
                        {
                            $image->resizeToWidth(1200);
                            $image->save("$output_dir".$file_name);
                            
                        } elseif($height > 1000)
                        {
                            $image -> resizeToHeight(1000);
                            $image->save("$output_dir".$file_name);
                        }
                            //$image->save("$output_dir".$file_name);
                        //}
                        
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
            header("Location: upload.php?pid=$ProjectId");
                
        } else {
           print_r($errors);
        }
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Uploader</title>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    
    <link rel="stylesheet" type="text/css" href="/library/scripts/sweetalert/sweetalert.css" />
    <script src="/library/scripts/sweetalert/sweetalert.min.js"></script>

     <link rel="stylesheet" type="text/css" href="/library/styles/style.css" />
     
<style>
     html,body{color:#333;background:#fff;}
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
    .cover-selected{background:#ccc;}
    .cover-selected input[type="button"]{display: none; }
</style>



</head>
<body>
<?php include('../includes/updater-head.inc.php'); ?>

<div class="container_12">
    <div class="mb-40">
        <h1>E&amp;H Construction Project Manager</h1>
        <ul class="d-ib m-0">
            <li class="list-n img-row pos-r grid_4">
                <form action="" method="POST" enctype="multipart/form-data" style="padding: 10px;">
                    <input type="file" name="files[]" multiple/>
                    <input type="submit"/>
                </form>
            </li>
            <?php ShowImages(); ?>
        </ul>
    </div>
</div>    
<div class="container_12">
    <div class="grid_12">
        <a href="index.php?projectID=<?php echo $ProjectId; ?>" class="btn">Back</a> | 
        <a href="index.php" class="btn">Finish</a>    
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
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this image!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel please!",
                    closeOnConfirm: true,
                    closeOnCancel: false
                }, function(isConfirm){
                    if (isConfirm) {
                        removeImage(iid);
                    } else {
                        swal("Cancelled", "Your image has been saved", "error");
                    }
                });

                
            });
            // Working on this ////
            $('img').on('click', function(){
                var link = $(this).closest('li').data('url');
                var file = $(this).closest('li').data('file');
                
                //open a lightbox with the image url of link+file
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
            function setCover(pid,iid,link,file){
                var link = link.replace(/^.+\.\//,'');
                
                $.post('functions.inc.php', {a:'setCover', p:pid, f:file, l:link}, function(data){
                    if(data == 0){
                        // change this to a non-blocking notification
                    } else {
                        $('#'+iid).addClass('cover-selected').siblings().removeClass('cover-selected');
                    }
                });
            }
        
    </script> 
</html>