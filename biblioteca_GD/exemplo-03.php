<?php
    $image = imagecreatefromjpeg("certificado.jpg");
    
    $titlecolor = imagecolorallocate($image, 0, 0, 0);
    $gray = imagecolorallocate($image, 100, 100, 100);
    
    imagettftext($image, 32, 0, 320, 250, $titlecolor, "fonts" . DIRECTORY_SEPARATOR . "Bevan" .
                                                        DIRECTORY_SEPARATOR."Bevan-Regular.ttf", "CERTIFICADO");
    imagettftext($image, 32, 0, 375, 350, $titlecolor,"fonts" . DIRECTORY_SEPARATOR . "Playball" .
                                                        DIRECTORY_SEPARATOR."Playball-Regular.ttf", "Jefferson Moreira Lopo");
    imagestring($image, 3, 440, 370, utf8_decode("Concluído em: ") . date("d/m/Y"), $titlecolor);
    
    header("Content-type: image/jpeg");
    //imagejpeg($image, "certificado-" . date("Y-m-d") . ".jpg");
    imagejpeg($image);
    imagedestroy($image);

