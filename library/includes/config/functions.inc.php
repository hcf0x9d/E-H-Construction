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
    include '/controllers/rotator.controllers.php';

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
        $images .= '<li class="rotator-images-item" data-project="'.$ProjLink.'" style="background: url('.$KeyImage.') center center no-repeat;background-size:cover;"></li>';

        $dots .='<li class="rotator-dots-dot" data-project="'.$ProjLink.'"></li>';

    }

    return array('dots' => $dots, 'captions' => $captions, 'images' => $images);
}

?>