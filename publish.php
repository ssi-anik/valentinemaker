<?php
    session_start();
    require 'php-sdk/facebook.php';
    $facebook = new Facebook( array (
        'appId' => '210621112477292',
        'secret' => '0a204f80a3d1444bf733b066a1cf3521'
        )
    );
    $user = $facebook->getUser();
    if($user){
        

        /*try{
        $facebook->setFileUploadSupport(true);
        $imageSource = 'http://thawing-harbor-1192.heroku.com/images/Tanay.png';
        $params = array(
        'access_token' => $facebook->getAccessToken();
        'source' => "@".$imageSource,
        'place' => '155021662189',
        'tags' => array(100000089173455),
        'message' => 'Nothing to say, trying to upload a photo USING graph EXPLORER'
        );
        $postId = $facebook->api( '/me/photos', 'POST', $params);
        print_r($postId);
        } catch(FacebookApiException $e){
        print_r($e);
        }*/
        /*try{


        $facebook->setFileUploadSupport(true);
        $img = 'http://thawing-harbor-1192.heroku.com/images/error.png';
        $toPost = "none";//$_SESSION['sex'] == "male" ? "her" : "him";
        $message = "Yes, I've got $toPost. Who's yours?";             
        $_SESSION['uid2']
        $photo = $facebook->api(
        '/me/photos', 
        'POST',
        array(
        'image' => '@' . $img,
        'place' => '155021662189',
        'message' => $message,
        'tags' => array( 100000089173455)
        )
        );



        } catch(FacebookApiException $e){
        print_r($e);
        } catch(Exception $e){
        print_r($e);
        }*/

    }

?>
