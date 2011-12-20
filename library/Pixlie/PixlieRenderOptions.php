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
 * @package    PixlieRenderOptions
 * @copyright  Copyright (c) 2012 Steffen Hagdorn (http://www.pixlie.org)
 * @license    http://www.pixlie.org/license/     MIT License
 *
 */

  class PixlieRenderOptions
  {

    /**
     * PixlieRenderOptions default values
     *
     */
    private $_quality    = 100,
            $_outputType = self::AUTO,
            $_width      = self::AUTO,
            $_height     = self::AUTO,
            $_max        = self::AUTO,
            $_min        = self::AUTO;

    /**
     * RenderOptions constants
     *
     */
    const AUTO = 'auto';
    const JPG  = 'jpg';
    const PNG  = 'png';
    const GIF  = 'gif';

    /**
     * Factory method for chaining
     *
     * @return PixlieRenderOptions $newInstance;
     */
    public function create()
    {
      return new self();
    }

    /**
     * Sets the quality of the image to be generated
     *
     * @param int $quality
     * @return PixlieRenderOptions $this
     * @throws PixlieException
     */
    public function setQuality($quality)
    {
      if($quality < 0 OR $quality > 100){
        throw new PixlieException('PixlieRenderOptions: Quality must be between 0 and 100 - '.$outputType.' given.');
      }
      $this->_quality = (int) $quality;
      return $this;
    }

    /**
     * Returns the value set for the quality of the image to be generated
     *
     * @return int $quality
     */
    public function getQuality()
    {
      return $this->_quality;
    }

    /**
     * Sets the file outputType of the image to be generated
     *
     * @param const $outputType
     * @return PixlieRenderOptions $this
     * @throws PixlieException
     */
    public function setOutputType($outputType)
    {
      if($outputType==self::AUTO OR $outputType==self::JPG OR $outputType==self::PNG OR $outputType==self::GIF){
        $this->_outputType = $outputType;
      }
      else
      {
        throw new PixlieException('PixlieRenderOptions: Unknown outputType '.$outputType);
      }
      return $this;
    }

    /**
     * Returns the constant set for the file outputType of the image to be generated
     *
     * @return const $outputType
     */
    public function getOutputType()
    {
      return $this->_outputType;
    }

    /**
     * Sets the width of the image to be generated
     *
     * @param int $width
     * @return PixlieRenderOptions $this
     * @todo validate a maximum width value
     */
    public function setWidth($width)
    {
      $this->_width = (int) $width;
      return $this;
    }

    /**
     * Returns the value set for the width of the image to be generated
     *
     * @return int $width
     */
    public function getWidth()
    {
      return $this->_width;
    }

    /**
     * Sets the height of the image to be generated
     *
     * @param int $height
     * @return PixlieRenderOptions $this
     * @todo validate a maximum height value
     */
    public function setHeight($height)
    {
      $this->_height = (int) $height;
      return $this;
    }

    /**
     * Returns the value set for the height of the image to be generated
     *
     * @return int $height
     */
    public function getHeight()
    {
      return $this->_height;
    }

    /**
     * Setting the maximum side length of the image to be generated
     *
     * @param int $max
     * @return PixlieRenderOptions $this
     * @todo validate a maximum max value
     */
    public function setMax($max)
    {
      $this->_max = (int) $max;
      return $this;
    }

    /**
     * Returns the value set for the maximum side length of the image to be generated
     *
     * @return int $max
     */
    public function getMax()
    {
      return $this->_max;
    }

    /**
     * Setting the minimum side length of the image to be generated
     *
     * @param int $min
     * @return PixlieRenderOptions $this
     * @todo validate a maximum min value
     */
    public function setMin($min)
    {
     $this->_min = (int) $min;
     return $this;
    }

    /**
     * Returns the value set for the minimum side length of the image to be generated
     *
     * @return int $min
     */
    public function getMin()
    {
      return $this->_min;
    }

  }
