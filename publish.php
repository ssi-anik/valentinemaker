<?php
    session_start();
    require 'php-sdk/facebook.php';
    $facebook = new Facebook( array (
        'appId' => '210621112477292',
        'secret' => '0a204f80a3d1444bf733b066a1cf3521'
        )
    );
    $user = $facebook->getUser();
    if($user && isset($_GET['photo']) && strpos( $_GET['photo'],$_SESSION['uid1'])!==False){
        try{
            $facebook->setFileUploadSupport(true);
            $toPost = $_SESSION['sex'] == "male" ? "her" : "him";
            $message = "Yes, I've found ". $toPost.". So, who's yours?";             
            $imageSource = $_GET['photo'];
            $params = array(
                'access_token' => $facebook->getAccessToken(),
                'source' => "@".$imageSource,
                'message' => $message
            );
            $postId = $facebook->api( '/me/photos', 'POST', $params);
            echo "ok";
        } catch(FacebookApiException $e){
            print_r($e);
        }

    } else{
        echo "not set";
    }

?>
