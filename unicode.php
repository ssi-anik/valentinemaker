<?php
function wrap2($fontSize, $angle, $fontFace, $string, $width)
{    
    $ret = "";
    $arr = explode(' ', $string);
    foreach ( $arr as $word )
    {   $teststring = $ret.' '.$word;
        $testbox = imagettfbbox($fontSize, $angle, $fontFace, $teststring);
        if ( $testbox[2] > $width )
        {
            $ret.=($ret==""?"":"\n").$word;
        } 
        else 
        {
            $ret.=($ret==""?"":' ').$word;
        }
    }
    return $ret;
}

$textval = 'मंदिर  वीडियो';
// buffer output in case there are errors
ob_start();
$textcolor = '6E6E6E';
$font="DejaVuSansMono.ttf";    

$size = 20;
$padding= 2;
$bgcolor= "ffffff";

$transparent = 0;
$antialias = 0;

$fontfile = $fontpath.$font;
$textval = wrap2($size, $angle, $font, $textval, $width = 250);
$box= imageftbbox( $size, 0, $fontfile, $textval, array());
$boxwidth= $box[4];
$boxheight= abs($box[3]) + abs($box[5]);
$width= $boxwidth + ($padding*2) + 1;
$height= $boxheight + ($padding) + 0;
$textx= $padding;
$texty= ($boxheight - abs($box[3])) + $padding;

// create the image
$png= imagecreate($width, $height);


$color = str_replace("#","",$bgcolor);
$red = hexdec(substr($bgcolor,0,2));
$green = hexdec(substr($bgcolor,2,2));
$blue = hexdec(substr($bgcolor,4,2));
$bg = imagecolorallocate($png, $red, $green, $blue);

$color = str_replace("#","",$textcolor);
$red = hexdec(substr($textcolor,0,2));
$green = hexdec(substr($textcolor,2,2));
$blue = hexdec(substr($textcolor,4,2));
$tx = imagecolorallocate($png, $red, $green, $blue);



imagettftext( $png, $size, 0, $textx, $texty, $tx, $fontfile, $textval );

header("content-type: image/jpeg");
imagejpeg($png);
imagedestroy($png);
exit;
?>