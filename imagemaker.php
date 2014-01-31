<?php
    session_start();

    // add from 0 to 9, A to Z, and a to z
    $a = array_merge(range(0,9),range('A','Z'),range('a','z'));
    function randomKeyGenerator($length){
        // return string is set to empty string
        $stringToBeReturned = "";
        // the global array is taken which holds the character set
        global $a;
        //array length;
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

    if($user && isset($_SESSION['uid1']) && isset($_SESSION['uid2'])){
        try{
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
            /*
            // get the first name of the user
            $request_url ="https://graph.facebook.com/" . $_SESSION['uid1']. "?fields=first_name";
            $requests = file_get_contents($request_url);
            $data = json_decode($requests);
            $_SESSION['uf1'] = $data->first_name;
            //get the image of the user
            $request_url ="https://graph.facebook.com/" . $_SESSION['uid1']. "?fields=picture.width(140).height(120)";
            $requests = file_get_contents($request_url);
            $data = json_decode($requests);
            $a = $data->picture->data->url;
            //get the first name of the second user
            $request_url ="https://graph.facebook.com/" . $_SESSION['uid2']. "?fields=first_name";
            $requests = file_get_contents($request_url);
            $data = json_decode($requests);
            $_SESSION['uf2'] = $data->first_name;
            //get the image of the second user
            $request_url ="https://graph.facebook.com/" . $_SESSION['uid2']. "?fields=picture.width(140).height(120)";
            $requests = file_get_contents($request_url);
            $data = json_decode($requests);
            $b = $data->picture->data->url;*/
            // original image source
            $path = 'dummy.png';
            //create image with the dummy
            $originalImage = imagecreatefrompng($path);
            // get jpeg images converted to png
            $u1 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?link=".$a);
            $u2 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?link=".$b);

            if(imagecopymerge($originalImage, $u1, 40, 65, 0, 0, imagesx($u1), imagesy($u1), 100) && imagecopymerge($originalImage,$u2, 777, 235,0, 0, imagesx($u2), imagesy($u2), 100)){
                $n1 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?name=".$_SESSION['uf1']."&pos=1");
                $n2 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?name=".$_SESSION['uf2']."&pos=2");
                if(imagecopymerge($originalImage, $n1, 40, 17, 0, 0, imagesx($n1), imagesy($n1), 100) && imagecopymerge($originalImage,$n2, 497, 360, 0, 0, imagesx($n2), imagesy($n2), 100)){
                    // random key generator
                    $rand = randomKeyGenerator(5);
                    // image name to be stored in
                    $img_name = "users/".$_SESSION['uid1']."_".$rand.".png";
                    // create the image to that path
                    imagepng($originalImage,$img_name);
                    // destroy the images.
                    imagedestroy($originalImage);
                    imagedestroy($u1);
                    imagedestroy($u2);

                    //echo the image name to the ajax
                    echo $img_name;
                } else{
                    echo "image creation with text error";
                    imagedestroy($originalImage);
                    imagedestroy($u1);
                    imagedestroy($u2);

                }

            } else{
                // above snippet was not executed and merge was not successfull
                echo "Can't copy merge";
                // destroy the images.
                imagedestroy($originalImage);
                imagedestroy($u1);
                imagedestroy($u2);
            }
        } catch(Exception $e){
            echo $e;
        }
    }



?>