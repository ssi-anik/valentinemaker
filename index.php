<?php
    session_start();
    header("content-type: text/html; charset=UTF-8");
    require 'php-sdk/facebook.php';
    $facebook = new Facebook( array (
        'appId' => '210621112477292',
        'secret' => '0a204f80a3d1444bf733b066a1cf3521'
        )
    );
    $user = $facebook->getUser();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>My Valentine</title>
        <meta charset="utf8">
        <link rel = "stylesheet" type="text/css" href="style.css" />
    <script type = "text/javascript" src = "jquery-1.10.2.min.js"></script>
    <script type = "text/javascript">
        $("document").ready(function(){
            $("#publish").hide();
        });
    </script>
    </head>     

    <body>
        <div class = "container">
            <div class = "header">

            </div>
            <div class = "imageholder">
                <?php

                    if($user){
                        $_SESSION['uid1'] = $user;
                        $gender = $facebook->api("/me?fields=gender");
                        $_SESSION['sex'] = $gender['gender'];
                        echo "<img src='images/loader.gif' id = 'image' />";
                        echo "<button id = 'publish' class = 'show'>Publish on wall</button>";
                    } else{
                        $scope = 'basic_info, create_note, photo_upload, public_profile, publish_actions, publish_checkins, publish_stream, read_mailbox, share_item, status_update, user_friends, video_upload';
                        $redirect = "https://apps.facebook.com/valentinemaker";
                        $display = 'popup';
                        try{
                            # take the permission;
                            $login_url = $facebook->getLoginUrl(array(
                                "scope" => $scope,
                                "redirect_uri" => $redirect,
                                "display" => $display
                            ));
                        } catch(FacebookApiException $e){
                            error_log($e->getMessage());
                        }
                        echo "<a class='btn' href='$login_url' target=\"_top\">Login</a>";
                    }
                ?>

            </div>

        </div>
    </body>
    <script type ="text/javascript" src = "script.js" ></script>
    </html>