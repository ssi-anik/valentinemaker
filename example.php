<?php
    require 'php-sdk/facebook.php';
    $facebook = new Facebook( array (
        'appId' => '210621112477292',
        'secret' => '0a204f80a3d1444bf733b066a1cf3521'
        )
    );
    $request_url ="https://graph.facebook.com/" . $_SESSION['uid1']. "?fields=picture.width(140).height(120),first_name";
    $requests = file_get_contents($request_url);
    $data = json_decode($requests);
    print_r($data);
    $a = $data->picture->data->url;
    $_SESSION['uf1'] = $data->first_name;
    $request_url ="https://graph.facebook.com/" . $_SESSION['uid2']. "?fields=picture.width(140).height(120),first_name";
    $requests = file_get_contents($request_url);
    print_r($data);
    $data = json_decode($requests);
    $b = $data->picture->data->url;
    $_SESSION['uf2'] = $data->first_name;
    foreach($_SESSION as $key => $value)    {
        echo $key."=>".$value."<br/>";
    }
?>