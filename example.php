<?php
    require 'php-sdk/facebook.php';
    $facebook = new Facebook( array (
        'appId' => '210621112477292',
        'secret' => '0a204f80a3d1444bf733b066a1cf3521'
        )
    );
    
    foreach($_SESSION as $key => $value)    {
        echo $key."=>".$value."<br/>";
    }
?>