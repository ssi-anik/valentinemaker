<?php
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
    foreach($_SESSION as $key => $value)    {
        echo $key."=>".$value."<br/>";
    }
?>