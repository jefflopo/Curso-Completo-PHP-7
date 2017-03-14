<?php
    $image = imagecreatefromjpeg("certificado.jpg");
    
    $titlecolor = imagecolorallocate($image, 0, 0, 0);
    $gray = imagecolorallocate($image, 100, 100, 100);
    
    imagestring($image, 5, 450, 150, "CERTIFICADO", $titlecolor);
    imagestring($image, 5, 440, 350, "Jefferson Moreira Lopo", $titlecolor);
    imagestring($image, 3, 440, 370, utf8_decode("Concluído em: ") . date("d/m/Y"), $titlecolor);
    
    header("Content-type: image/jpeg");
    imagejpeg($image, "certificado-" . date("Y-m-d") . ".jpg");
    imagedestroy($image);

