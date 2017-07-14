<?php

/**
* This class resizes a given image. It offers suport for transparent PNG and GIF
*
* @author Iosif Chiriluta <iosifdev@gmail.com>
* @version 1.0
* @release date 09.27.2011
*/
class Resize {
protected $src;
protected $width;
protected $height;
protected $type;
protected $dest;
protected $new_width;
protected $new_height;

/**
* The construct function
*
* @access: public
* @param: string $src
* @param: string $dest
* @param: integer $width
* @param: integer $height
*/
public function __construct($src, $dest, $width = NULL, $height = NULL) {
if(!isset($src) || $src === NULL || $src === '')
throw new Exception("<b>Error:</b> Missing argument 1 for Resize::__construct()");
if(!isset($dest) || $dest === NULL || $dest === '')
throw new Exception("<b>Error:</b> Missing argument 2 for Resize::__construct()");

$this->src = $src;	
$this->dest = $dest;

$this->getImageDetails($this->src);
$this->setSize($width, $height);
}

/**
* Get size and type of source image
*
* @access public
* @param string $image
*/
public function getImageDetails($image) {

$temp = getimagesize($this->src);
if(null == $temp)
throw new Exception('Error while extracting the source image information');

$this->width = $temp[0];
$this->height = $temp[1];
$this->type = $temp[2];
}

/**
* Set size for the new image
*
* @access public
* @param integer $width
* @param integer $height
*/
public function setSize($width, $height) {
if (null === $width && null === $height) {
$this->new_width = $this->width;
$this->new_height = $this->height;
}
elseif (isset($width) && isset($height)) {
$this->new_width = $width;
$this->new_height = $height;
}
elseif(isset($width) && !isset($height)) {
$this->new_width = $width;
$this->new_height = round($this->new_width * $this->height / $this->width);
}
elseif(!isset($width) && isset($height)) {
$this->new_height = $height;
$this->new_width = round($this->new_height * $this->width / $this->height);
}
if($this->new_height != (int)$this->new_height || $this->new_width != (int)$this->new_width)
throw new Exception('<b>Error:</b> Parameters 3 and 4 expect to be type of integer');
}

/**
* Create and return the new image
*
* @access: public
*/
public function run() {
if(!($new_image = @imagecreatetruecolor($this->new_width, $this->new_height)))
throw new Exception("Error while the new image was initialized");

switch($this->type) {
case 1:
$image = imagecreatefromgif($this->src);
$transparent_index = imagecolortransparent($image);
$transparent_color = imagecolorsforindex($image, $transparent_index);
$transparent_index = imagecolorallocate($new_image, $transparent_color['red'], $transparent_color['green'], $transparent_color['blue']);
imagefill($new_image, 0, 0, $transparent_index);
imagecolortransparent($new_image, $transparent_index);
break;
case 2:
$image = imagecreatefromjpeg($this->src);
break;
case 3:
$image = imagecreatefrompng($this->src);
imagealphablending($new_image, false);
imagesavealpha($new_image, true);
break;
default:
throw new Exception('<b>Error:</b> The image type was not recognized');
break;
}

try {
imagecopyresampled($new_image, $image, 0, 0, 0, 0, $this->new_width, $this->new_height, $this->width, $this->height);
}
catch(Exception $e) {
throw new Exception("<b>Error:</b> The image couldn't be resized");
}

switch($this->type) {
case 1:
imagegif($new_image, $this->dest);
break;
case 2:
imagejpeg($new_image, $this->dest);
break;
case 3:
imagepng($new_image, $this->dest);
break;
default:
throw new Exception('Error while the image was created');
break;
}

$this->releaseMemory($image, $new_image);
}

/**
* Destroy created image
*
* @access protected
* @param string $image
* @param string $new_image
*/
protected function releaseMemory(&$image, &$new_image) {
imagedestroy($image);
imagedestroy($new_image);
}
}
?>