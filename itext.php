<?php 

    ####################### BEGIN USER EDITS #######################
    $imagewidth = 500;
    $imageheight = 100;
    $fontsize = "40";
    $fontangle = "0";
    $font = "Chewy.ttf";
    $text = "123456789";
    $backgroundcolor = "003366";
    $textcolor = "FFCC66";
    ######################## END USER EDITS ########################

    ### Convert HTML backgound color to RGB
    if( eregi( "([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})", $backgroundcolor, $bgrgb ) ){
        $bgred = hexdec( $bgrgb[1] );   
        $bggreen = hexdec( $bgrgb[2] );   
        $bgblue = hexdec( $bgrgb[3] );
    }

    ### Convert HTML text color to RGB
    if( eregi( "([0-9a-f]{2})([0-9a-f]{2})([0-9a-f]{2})", $textcolor, $textrgb ) ){
        $textred = hexdec( $textrgb[1] );  
        $textgreen = hexdec( $textrgb[2] );  
        $textblue = hexdec( $textrgb[3] );
    }

    ### Create image
    $im = imagecreate( $imagewidth, $imageheight );

    ### Declare image's background color
    $bgcolor = imagecolorallocate($im, $bgred,$bggreen,$bgblue);

    ### Declare image's text color
    $fontcolor = imagecolorallocate($im, $textred,$textgreen,$textblue);

    ### Get exact dimensions of text string
    $box = @imageTTFBbox($fontsize,$fontangle,$font,$text);

    ### Get width of text from dimensions
    $textwidth = abs($box[4] - $box[0]);

    ### Get height of text from dimensions
    $textheight = abs($box[5] - $box[1]);

    ### Get x-coordinate of centered text horizontally using length of the image and length of the text
    $xcord = ($imagewidth/2)-($textwidth/2)-2;

    ### Get y-coordinate of centered text vertically using height of the image and height of the text
    $ycord = ($imageheight/2)+($textheight/2);

    ### Declare completed image with colors, font, text, and text location
    imagettftext ( $im, $fontsize, $fontangle, $xcord, $ycord, $fontcolor, $font, $text );

    ### Display completed image as PNG
    imagepng($im,"underline.png");
    echo "<img src='underline.png'/>"; 
    imagedestroy($im); 
?>