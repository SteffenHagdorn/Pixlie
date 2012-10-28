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
 * @package    PixlieSourceImage
 * @copyright  Copyright (c) 2012 Steffen Hagdorn (http://www.pixlie.org)
 * @license    http://www.pixlie.org/license/     MIT License
 *
 */

  class PixlieSourceImage
  {

    /**
     * The path to the source image which will be converted
     */
    private $_srcFilePath;

    /**
     * The file type of the source image
     */
    private $_srcType;

    /**
     * The width of the source image
     */
    private $_width;

    /**
     * The height of the source image
     */
    private $_height;

    /**
     * Constructor
     *
     * @param string $srcFilePath
     */
    public function __construct($srcFilePath)
    {
      $this->_srcFilePath = $srcFilePath;
      $this->checkFileAccess();
      $this->setImageInfos();
    }

    /**
     * Checks if the source image is readable
     *
     * @throws PixlieException
     */
    private function checkFileAccess()
    {
      if(!is_readable($this->_srcFilePath)){
        throw new PixlieException('The source image was not found or not readable.');
      }
    }

    /**
     * Reads the width, height and mime type of the source image
     *
     * @param string $srcFilePath
     * @throws PixlieException
     */
    private function setImageInfos()
    {
      $imageInfo = getimagesize($this->_srcFilePath);
      $this->_width  = (int) $imageInfo[0];
      $this->_height = (int) $imageInfo[1];
      if($this->_width == 0 OR $this->_height == 0){
        throw new PixlieException('The image dimensions of the source image can not be read.');
      }
      switch($imageInfo['mime']){
        case 'image/jpg': $this->_srcType = PixlieRenderOptions::JPG;
                          break;
        case 'image/jpeg':$this->_srcType = PixlieRenderOptions::JPG;
                          break;
        case 'image/png': $this->_srcType = PixlieRenderOptions::PNG;
                          break;
        case 'image/gif': $this->_srcType = PixlieRenderOptions::GIF;
                          break;
        default:          throw new PixlieException('The file type '.$imageInfo['mime'].' of the source image is not supported.');
                          break;
      }
    }

    /**
     * Returns the filetype of the source image
     *
     * @return string $filetype
     */
    public function getType()
    {
      return $this->_srcType;
    }

    /**
     * Returns the filesize of the source image
     *
     * @return int $filesize
     */
    public function getSize()
    {
      return filesize($this->_srcFilePath);
    }

    /**
     * Returns the path to the source image
     *
     * @return string $filepath
     */
    public function getPath()
    {
      return $this->_srcFilePath;
    }

    /**
     * Returns the width of the source image
     *
     * @return int $width
     */
    public function getWidth()
    {
      return $this->_width;
    }

    /**
     * Returns the height of the source image
     *
     * @return int $height
     */
    public function getHeight()
    {
      return $this->_height;
    }

  }
