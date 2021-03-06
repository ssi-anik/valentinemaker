<?php
    session_start();
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
            
            // original image source
            $path = 'dummy.png';
            //create image with the dummy
            $originalImage = imagecreatefrompng($path);
            // get jpeg images converted to png
            $u1 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?link=".$a);
            $u2 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?link=".$b);

            if(imagecopymerge($originalImage, $u1, 30, 60, 0, 0, imagesx($u1), imagesy($u1), 100) && imagecopymerge($originalImage,$u2, 777, 235,0, 0, imagesx($u2), imagesy($u2), 100)){
                $n1 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?name=".$_SESSION['uf1']."&pos=1");
                $n2 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?name=".$_SESSION['uf2']."&pos=2");
                if(imagecopymerge($originalImage, $n1, 30, 12, 0, 0, imagesx($n1), imagesy($n1), 100) && imagecopymerge($originalImage,$n2, 497, 360, 0, 0, imagesx($n2), imagesy($n2), 100)){
                    // image name to be stored in
                    $img_name = "users/".$_SESSION['uid1'].".png";
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