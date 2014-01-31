<?php
    session_start();
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
    require 'php-sdk/facebook.php';
    $facebook = new Facebook( array (
        'appId' => '210621112477292',
        'secret' => '0a204f80a3d1444bf733b066a1cf3521'
        )
    );
    $user = $facebook->getUser();
    if($user ){
        $request_url ="https://graph.facebook.com/" . $_SESSION['uid1']. "?fields=picture.width(140).height(120)";
        $requests = file_get_contents($request_url);
        $data = json_decode($requests);
        $a = $data->picture->data->url;
        $request_url ="https://graph.facebook.com/" . $_SESSION['uid2']. "?fields=picture.width(140).height(120)";
        $requests = file_get_contents($request_url);
        $data = json_decode($requests);
        $b = $data->picture->data->url;
        $path = 'dummy.png';
        $originalImage = imagecreatefrompng($path);
        $u1 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?l=".$a);
        $u2 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?l=".$b);
        if(imagecopymerge($originalImage, $u1, 45, 70, 0, 0, imagesx($u1), imagesy($u1), 100) && imagecopymerge($originalImage,$u2, 715, 260,0, 0, imagesx($u2), imagesy($u2), 100)){
            $rand = randomKeyGenerator(5);
            $img_name = "users/".$_SESSION['uid1']."_".$rand;
            imagepng($originalImage,$img_name);
            imagedestroy($originalImage);
            echo $img_name.".png";

        } else{
            echo "Can't copy merge";
        }
    }



?>