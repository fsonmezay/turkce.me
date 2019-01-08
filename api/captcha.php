<?PHP
  // Adapted for The Art of Web: www.the-art-of-web.com
  // Please acknowledge use of this code by including this header.

  // initialise image with dimensions of 120 x 30 pixels
  $image = @imagecreatetruecolor(240, 40) or die("Cannot Initialize new GD image stream");

  // set background to white and allocate drawing colours
  $background = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
  imagefill($image, 0, 0, $background);
  $linecolor = imagecolorallocate($image, 0xCC, 0xCC, 0xCC);
  $textcolor = imagecolorallocate($image, 0xbb, 0x33, 0x33);

  // draw random lines on canvas
  for($i=0; $i < 6; $i++) {
    imagesetthickness($image, rand(1,2));
    imageline($image, 0, rand(0,40), 240, rand(2,34), $linecolor);
  }

  session_start();

  // add random digits to canvas
  $digit = '';
  for($x = 45; $x <= 195; $x += 30) {
    $digit .= ($num = rand(0, 9));
    imagechar($image, rand(5, $x), $x, rand(2, 24), $num, $textcolor);
  }

  // record digits in session variable
  $_SESSION['digits'] = $digit;

  // display image and clean up
  header('Content-type: image/png');
  imagepng($image);
  imagedestroy($image);
?>
