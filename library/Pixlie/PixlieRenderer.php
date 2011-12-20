<?php
/**
 * Pixlie
 *
 * LICENSE (MIT)
 *
 * Copyright (c) 2012 Steffen Hagdorn
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the Software
 * is furnished to do so, subject to the following conditions:
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR
 * IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * @category   Pixlie
 * @package    PixlieRenderer
 * @copyright  Copyright (c) 2012 Steffen Hagdorn (http://www.pixlie.org)
 * @license    http://www.pixlie.org/license/     MIT License
 *
 */

  interface PixlieRendererInterface
  {
    public function render(PixlieImage $image, PixlieCache $cache);
  }

  abstract class PixlieRenderer
  {

  }

  class PixlieGdRenderer extends PixlieRenderer implements PixlieRendererInterface
  {

    /**
     * Determines which range from the original image must be cut out and
     * executes the copy operation
     *
     * @param PixlieImage $image
     * @param PixlieCache $cache
     * @return boolean $status
     * @todo Check if GD Lib exists
     * @todo Check the maximum file size with the source image object
     * @todo Increase the memory during the calculation
     */
    public function render(PixlieImage $image, PixlieCache $cache)
    {
      if(($image->getSourceImage()->getHeight() / $image->getSourceImage()->getWidth() * $image->getWidth()) > $image->getHeight()){
        $cut_w = $image->getSourceImage()->getWidth();
        $cut_h = (int) round(($image->getSourceImage()->getWidth() / $image->getWidth()) * $image->getHeight());
        $cut_x = 0;
        $cut_y = (int) round(($image->getSourceImage()->getHeight() - $cut_h) / 4);
      }
      else{
        $cut_w = (int) round(($image->getSourceImage()->getHeight() / $image->getHeight()) * $image->getWidth());
        $cut_h = $image->getSourceImage()->getHeight();
        $cut_x = (int) round(($image->getSourceImage()->getWidth() - $cut_w) / 2);
        $cut_y = 0;
      }
      $srcImageResoruce = $this->createSrcImageResource($image);
      $dstImageResource = imagecreatetruecolor($image->getWidth(),$image->getHeight());
      $status = imagecopyresampled($dstImageResource,$srcImageResoruce,0,0,$cut_x,$cut_y,$image->getWidth(),$image->getHeight(),$cut_w,$cut_h);
      $this->storeDstImageResource($dstImageResource,$image,$cache);
      imagedestroy($srcImageResoruce);
      imagedestroy($dstImageResource);
      return $status;
    }

    /**
     * Opens the original image as a resource
     *
     * @param PixlieImage $image
     * @return resource $srcImageResource
     * @throws PixlieException
     */
    private function createSrcImageResource(PixlieImage $image)
    {
      switch($image->getSourceImage()->getType()){
        case PixlieRenderOptions::JPG : $srcImageResource = @imagecreatefromjpeg($image->getSourceImage()->getPath());
                                        break;
        case PixlieRenderOptions::GIF : $srcImageResource = @imagecreatefromgif($image->getSourceImage()->getPath());
                                        break;
        case PixlieRenderOptions::PNG : $srcImageResource = @imagecreatefrompng($image->getSourceImage()->getPath());
                                        break;
        default: throw new PixlieException('The file type of the source image is not supported by the renderer.');
                 break;
      }
      if(!$srcImageResource){
        throw new PixlieException('The source image is not readable by the renderer.');
      }
      return $srcImageResource;
    }

    /**
     * Writes the resource of the final image as a file
     *
     * @param resource $dstImageResource
     * @param PixlieImage $image
     * @param PixlieCache $cache
     * @return boolean $status
     * @throws PixlieException
     */
    private function storeDstImageResource($dstImageResource, PixlieImage $image, PixlieCache $cache)
    {
      switch($image->getType()){
        case PixlieRenderOptions::JPG : $status = imagejpeg($dstImageResource,$cache->getCacheFilepath($image),$image->getRenderOptions()->getQuality());
                                        break;
        case PixlieRenderOptions::GIF : $status = imagegif($dstImageResource,$cache->getCacheFilepath($image));
                                        break;
        case PixlieRenderOptions::PNG : $quality = 10 - ((int) round($image->getRenderOptions()->getQuality() / 10));
                                        if($quality == 10){
                                          $quality = 9;
                                        }
                                        $status = imagepng ($dstImageResource,$cache->getCacheFilepath($image),$quality);
                                        break;
        default: throw new PixlieException('Render options output type is not supported by the renderer.');
                 break;
      }
      if(!$status){
        throw new PixlieException('The rendered image could not stored.');
      }
      $cache->registerResource($image);
      return $status;
    }

  }
