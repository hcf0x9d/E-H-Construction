<?php

// Redirect?
//userAgent($_SERVER['HTTP_USER_AGENT']);

// function userAgent($ua) {

//     $iphone = strstr(strtolower($ua), 'iphone'); //Search for 'mobile' in user-agent (iPhone have that)
//     $android = strstr(strtolower($ua), 'android'); //Search for 'android' in user-agent
//     $windowsPhone = strstr(strtolower($ua), 'phone'); //Search for 'phone' in user-agent (Windows Phone uses that)
//     $iPad = strstr(strtolower($ua),'ipad');

//     if($iphone || $android || $windowsPhone){ //If it's a phone and NOT a tablet
//         header('Location: http://m.ehconstructionco.com'.$_SERVER[REQUEST_URI]);
//     }
//     if($iPad){
//         // return 'desktop';
//     }
//     else{
//         //return 'desktop';
//     }
// }


// TODO: This could be cleaned up a bit.
function homeRotator () {
    include '/models/rotator.models.php';

    $captions = '';
    $images = '';
    $dots = '';

    // include '/models/db.model.php';

    foreach ($rotatorArray as $row) {

        $ProjName = $row['ProjName'];
        $ProjLink = $row['ProjLink'];
        $ProjDescShort = $row['ProjDescShort'];

        if(strlen($ProjDescShort) > 100) {
            $ProjDescShort=substr($ProjDescShort,0,100) . '...';
        }

        $KeyImage = $row['ProjKeyImgUrl'].$row['ProjKeyImg'];

        $captions .= '<li class="rotator-card-captions-item" data-project="'.$ProjLink.'">
                        <h2 class="rotator-card-title">'.$ProjName.'</h2>
                        <p class="rotator-card-body">'.$ProjDescShort.'</p>
                        <a href="/project/'.$ProjLink.'" class="rotator-captions-target">Go to project</a>
                     </li>';

        // TODO: Update this to use a srcset instead of background image
        $images .= '<li class="rotator-images-item" data-project="'.$ProjLink.'" style="background: url('.$KeyImage.') center center no-repeat;background-size:cover;"></li>';

        $dots .='<li class="rotator-dots-dot" data-project="'.$ProjLink.'"></li>';

    }

    return array('dots' => $dots, 'captions' => $captions, 'images' => $images);
}

function projectList () {
    include BASE_URI.'/models/project.models.php';

    $projectArray = projectListModel();

    $cards = null;

    foreach ($projectArray as $row) {
        $ProjName = $row['ProjName'];
        $ProjLink = $row['ProjLink'];
        $KeyImage = $row['ProjKeyImgUrl'].'480/'.$row['ProjKeyImg'];

        $card = '
        <li class="col-md-4 project-card">
        <a href="/project/'.$ProjLink.'" class="project-card-target" style="background:url('.$KeyImage.')center center no-repeat;background-size:cover;">
            <h2 class="project-card-title">'.$ProjName.'</h2>
            <div class="project-card-cover"></div>
        </a>
        </li>';

        $cards .= $card;

    }

    echo $cards;
}

function projectDetail () {
    include BASE_URI.'/models/project.models.php';

    $projectDetails = projectDetailModel();

    $images = Array();
    foreach ($projectDetails['detail'] as $row => $value) {
        $name = $value['ProjName'];
        $summary = $value['ProjDescShort'];
        $vendors = $value['ProjVendors'];
        $description = $value['ProjDescLong'];
        $hero = $value['ProjKeyImgUrl'].$value['ProjKeyImg'];

        $ImageName = $value['ImageName'];
        $Image = $value['ImageLink'].'200/'.$value['ImageName'];
        $ImageTitle = $value['ImageTitle'];
        $ImageCaption = $value['ImageCaption'];

        $images[$row] = Array('imageName' => $ImageName, 'image' => $Image, 'imageTitle' => $ImageTitle, 'imageCaption' => $ImageCaption);
    }

    $project = Array('name' => $name, 'vendors' => $vendors, 'hero' => $hero, 'summary' => $summary, 'description' => $description);
    // print_r($projectDetails);
    //

    $imageHTML = projectImageBuilder($images);

    return array('details' => $project, 'images' => $imageHTML);
}

function projectImageBuilder($imageArray) {
    $images = '';

    foreach ($imageArray as $key => $value) {

        $images .='<li class="col-md-4">
            <div class="img-cover anim lightbox">
                <i class="fa fa-search-plus c-white"></i>
            </div>
            <img src="'.$value['image'].'" class="" data-caption="'.$value['imageCaption'].'" alt="'.$value['imageTitle'].'" data-name="'.$value['imageName'].'" itemprop="image" />
        </li>';
    }

    return $images;
}
?>