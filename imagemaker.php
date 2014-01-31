<?php
    session_start();
    //font init
    $textred = 102;
    $textgreen = 153;
    $textblue = 153;
    $fontsize = "30";
    $fontangle = "0";
    $font = "Chewy.ttf";
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

    // the function adds the text to the image
    /*function positionText(&$originalImage, $text, $who){
    $textred = 102;
    $textgreen = 153;
    $textblue = 153;
    $fontsize = "30";
    $fontangle = "0";
    $font = "Chewy.ttf";

    ### Declare image's text color
    $fontcolor = imagecolorallocate( $originalImage, $textred,$textgreen,$textblue);
    ### Get exact dimensions of text string
    $box = @imageTTFBbox($fontsize,$fontangle,$font,$text);
    ### Get width of text from dimensions
    $textwidth = abs($box[4] - $box[0]);
    ### Get height of text from dimensions
    $textheight = abs($box[5] - $box[1]);
    ###place text 
    if($who == 1){
    imagettftext ( $originalImage, $fontsize, $fontangle, 45, 50, $fontcolor, $font, $text );
    } else{
    imagettftext ( $originalImage, $fontsize, $fontangle, 855 - $textwidth, 390, $fontcolor, $font, $text );
    }
    }*/
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
            $u1 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?l=".$a);
            $u2 = imagecreatefrompng("http://workspace.nazuka.net/sendback.php?l=".$b);

            if(imagecopymerge($originalImage, $u1, 45, 70, 0, 0, imagesx($u1), imagesy($u1), 100) && imagecopymerge($originalImage,$u2, 715, 260,0, 0, imagesx($u2), imagesy($u2), 100)){
                $fontcolor = imagecolorallocate( $originalImage, $textred,$textgreen,$textblue);
                ### Get exact dimensions of text string
                $box = @imageTTFBbox($fontsize,$fontangle,$font,$text);
                ### Get width of text from dimensions
                $textwidth = abs($box[4] - $box[0]);
                ### Get height of text from dimensions
                $textheight = abs($box[5] - $box[1]);
                //text for user1
                imagettftext ( $originalImage, $fontsize, $fontangle, 45, 50, $fontcolor, $font, $_SESSION['uf1'] );
                
                
                $fontcolor = imagecolorallocate( $originalImage, $textred,$textgreen,$textblue);
                ### Get exact dimensions of text string
                $box = @imageTTFBbox($fontsize,$fontangle,$font,$text);
                ### Get width of text from dimensions
                $textwidth = abs($box[4] - $box[0]);
                ### Get height of text from dimensions
                $textheight = abs($box[5] - $box[1]);
                //text for user2
                imagettftext ( $originalImage, $fontsize, $fontangle, 855 - $textwidth, 390, $fontcolor, $font, $_SESSION['uf2'] );
                /*
                // add text first name to the image
                positionText($originalImage, $_SESSION['uf1'], 1);
                // add text second user name to the
                positionText($originalImage, $_SESSION['uf2'], 2);*/
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