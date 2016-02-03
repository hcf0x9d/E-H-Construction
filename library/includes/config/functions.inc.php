<?php
    // Redirect?
    //userAgent($_SERVER['HTTP_USER_AGENT']);
    
    function userAgent($ua)
    {
        
        $iphone = strstr(strtolower($ua), 'iphone'); //Search for 'mobile' in user-agent (iPhone have that)
        $android = strstr(strtolower($ua), 'android'); //Search for 'android' in user-agent
        $windowsPhone = strstr(strtolower($ua), 'phone'); //Search for 'phone' in user-agent (Windows Phone uses that)
        $iPad = strstr(strtolower($ua),'ipad');
        
        if($iphone || $android || $windowsPhone){ //If it's a phone and NOT a tablet
            header('Location: http://m.ehconstructionco.com'.$_SERVER[REQUEST_URI]);
        }
        if($iPad){
            // return 'desktop';
        }
        else{
            //return 'desktop';
        }    
    }
    
    
?>