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
    echo $user;

    if(isset($_SESSION['uid1']) && isset($_SESSION['sex']) && $user){
        try{
            $desired = $_SESSION['sex'] == 'male' ? 'female' : 'male';
            $ret = $facebook->api( array(
                'method' => 'fql.query',
                'query' => "SELECT message_count,recipients from thread WHERE thread_id IN (SELECT thread_id FROM message WHERE thread_id IN (SELECT thread_id, subject, recipients FROM thread WHERE folder_id =0 ) AND (author_id IN  (SELECT uid FROM user WHERE uid in (SELECT uid2 from friend where uid1 = me()) and sex = '".$desired."') ) ) ORDER BY message_count DESC",
            ));
            $user2 = $ret[0]['recipients'][0] == $_SESSION['uid1'] ? $ret[0]['recipients'][1] : $ret[0]['recipients'][0];
            $_SESSION['uid2'] = $user2;
            header("Location: imagemaker.php");
        } catch(FacebookApiException $e){
            echo "error in FB";
        } catch(Exception $e){
            echo "error in PHP";
        }
    } else{
        echo "Refresh page";
    }
?>
