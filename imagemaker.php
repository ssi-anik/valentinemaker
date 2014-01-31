<?php
    session_start();
    $path = 'dummy.png';
    $originalImage = imagecreatefrompng($path);
    $a = array_merge(range(0,9),range('A','Z'),range('a','z'));
    function randomKeyGenerator($length){
        $stringToBeReturned = "";
        global $a;
        $arrayLength = count($a)-1;
        for($i = 1; $i <= $length; $i++){
            $stringToBeReturned .= $a[rand(0,$arrayLength)];
        }
        return $stringToBeReturned; 
    }
    function positionText($text,$who){
        $textred = 102;
        $textgreen = 153;
        $textblue = 153;
        $fontsize = "30";
        $fontangle = "0";
        $font = "Chewy.ttf";

        ### Declare image's text color
        $fontcolor = imagecolorallocate( global $originalImage, $textred,$textgreen,$textblue);
        ### Get exact dimensions of text string
        $box = @imageTTFBbox($fontsize,$fontangle,$font,$text);
        ### Get width of text from dimensions
        $textwidth = abs($box[4] - $box[0]);
        ### Get height of text from dimensions
        $textheight = abs($box[5] - $box[1]);
        ###place text 
        if($who == 1){
            imagettftext ( global $originalImage, $fontsize, $fontangle, 45, 50, $fontcolor, $font, $text );
        } else{
            imagettftext ( global $originalImage, $fontsize, $fontangle, 855 - $textwidth, 390, $fontcolor, $font, $text );
        }
    }
    require 'php-sdk/facebook.php';
    $facebook = new Facebook( array (
        'appId' => '210621112477292',
        'secret' => '0a204f80a3d1444bf733b066a1cf3521'
        )
    );
    $user = $facebook->getUser();
    if($user ){
        $request_url ="https://graph.facebook.com/" . $_SESSION['uid1']. "?fields=picture.width(140).height(120),first_name";
        $requests = file_get_contents($request_url);
        $data = json_decode($requests);
        $a = $data->picture->data->url;
        $_SESSION['uf1'] = $data->first_name;
        $request_url ="https://graph.facebook.com/" . $_SESSION['uid2']. "?fields=picture.width(140).height(120),first_name";
        $requests = file_get_contents($request_url);
        $data = json_decode($requests);
        $b = $data->picture->data->url;
        $_SESSION['uf2'] = $data->first_name;
        $u1 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?l=".$a);
        $u2 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?l=".$b);
        if(imagecopymerge($originalImage, $u1, 45, 70, 0, 0, imagesx($u1), imagesy($u1), 100) && imagecopymerge($originalImage,$u2, 715, 260,0, 0, imagesx($u2), imagesy($u2), 100)){
            positionText($_SESSION['uf1'], 1);
            positionText($_SESSION['uf2'], 2);
            $rand = randomKeyGenerator(5);
            $img_name = "users/".$_SESSION['uid1']."_".$rand.".png";
            imagepng($originalImage,$img_name);
            imagedestroy($originalImage);
            echo $img_name;

        } else{
            echo "Can't copy merge";
            imagedestroy($originalImage)
        }
    }



?>