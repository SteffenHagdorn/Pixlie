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
 * @package    PixlieImage
 * @copyright  Copyright (c) 2012 Steffen Hagdorn (http://www.pixlie.org)
 * @license    http://www.pixlie.org/license/     MIT License
 *
 */

  class PixlieImage
  {

    /**
     * The original image which will be converted
     */
    private $_sourceImage;

    /**
     * The options while creating the new image should be considered
     */
    private $_renderOptions;

    /**
     * Path to the cache resource
     */
    private $_resource = NULL;

    /**
     * The width of the final image
     */
    private $_width;

    /**
     * The height of the final image
     */
    private $_height;

    /**
     * Constructor
     *
     * @param PixlieSourceImage $sourceImage
     * @param PixlieRenderOptions $renderOptions
     */
    public function __construct(PixlieSourceImage $sourceImage, PixlieRenderOptions $renderOptions)
    {
      $this->_sourceImage   = $sourceImage;
      $this->_renderOptions = $renderOptions;
      $this->calculateDimensions();
    }

    /**
     * Checks the rendering options which side lengths are fixed, and then
     * calls the appropriate calculation of the image size
     *
     */
    private function calculateDimensions()
    {
      if($this->getRenderOptions()->getWidth() !== PixlieRenderOptions::AUTO AND $this->getRenderOptions()->getHeight() !== PixlieRenderOptions::AUTO){
        $this->calculateDimensionsBothFixed();
      }
      elseif($this->getRenderOptions()->getWidth() !== PixlieRenderOptions::AUTO){
        $this->calculateDimensionsWidthFixed();
      }
      elseif($this->getRenderOptions()->getHeight() !== PixlieRenderOptions::AUTO){
        $this->calculateDimensionsHeightFixed();
      }
      else{
        $this->calculateDimensionsNothingFixed();
      }
    }

    /**
     * Size calculation when rendering options have a fixed width and height
     *
     */
    private function calculateDimensionsBothFixed()
    {
      $this->_width  = $this->getRenderOptions()->getWidth();
      $this->_height = $this->getRenderOptions()->getHeight();
    }

    /**
     * Size calculation when rendering options have a fixed width and auto height
     *
     */
    private function calculateDimensionsWidthFixed()
    {
      $this->_width  = $this->getRenderOptions()->getWidth();
      $newHeight = $this->getSourceImage()->getHeight() / $this->getSourceImage()->getWidth() * $this->_width;
      if($this->getRenderOptions()->getMin() !== PixlieRenderOptions::AUTO AND $newHeight < $this->getRenderOptions()->getMin()){
        $newHeight = $this->getRenderOptions()->getMin();
      }
      if($this->getRenderOptions()->getMax() !== PixlieRenderOptions::AUTO AND $newHeight > $this->getRenderOptions()->getMax()){
        $newHeight = $this->getRenderOptions()->getMax();
      }
      $this->_height = (int) round($newHeight,0);
    }

    /**
     * Size calculation when rendering options have auto weight and a fixed height
     *
     */
    private function calculateDimensionsHeightFixed()
    {
      $this->_height = $this->getRenderOptions()->getHeight();
      $newWidth = $this->getSourceImage()->getWidth() / $this->getSourceImage()->getHeight() * $this->_height;
      if($this->getRenderOptions()->getMin() !== PixlieRenderOptions::AUTO AND $newWidth < $this->getRenderOptions()->getMin()){
        $newWidth = $this->getRenderOptions()->getMin();
      }
      if($this->getRenderOptions()->getMax() !== PixlieRenderOptions::AUTO AND $newWidth > $this->getRenderOptions()->getMax()){
        $newWidth = $this->getRenderOptions()->getMax();
      }
      $this->_width = (int) round($newWidth,0);
    }

    /**
     * Size calculation when rendering options have auto weight and height
     *
     */
    private function calculateDimensionsNothingFixed()
    {
      $this->_width  = $this->getSourceImage()->getWidth();
      $this->_height = $this->getSourceImage()->getHeight();
      if($this->getRenderOptions()->getMin() !== PixlieRenderOptions::AUTO){
        if($this->_width  < $this->getRenderOptions()->getMin()){
          $this->_width = $this->getRenderOptions()->getMin();
        }
        if($this->_height < $this->getRenderOptions()->getMin()){
          $this->_height = $this->getRenderOptions()->getMin();
        }
      }
      if($this->getRenderOptions()->getMax() !== PixlieRenderOptions::AUTO){
        if($this->_width > $this->getRenderOptions()->getMax()){
          $this->_width = $this->getRenderOptions()->getMax();
        }
        if($this->_height > $this->getRenderOptions()->getMax()){
          $this->_height = $this->getRenderOptions()->getMax();
        }
      }
    }

    /**
     * Returns the render options
     *
     * @return PixlieRenderOptions $renderOptions
     */
    public function getRenderOptions()
    {
      return $this->_renderOptions;
    }

    /**
     * Returns the source image
     *
     * @return PixlieSourceImage $sourceImage
     */
    public function getSourceImage()
    {
      return $this->_sourceImage;
    }

    /**
     * Returns the width
     *
     * @return int $width
     */
    public function getWidth()
    {
      return $this->_width;
    }

    /**
     * Returns the height
     *
     * @return int $height
     */
    public function getHeight()
    {
      return $this->_height;
    }

    /**
     * Returns the file type of the final image
     *
     * @return const $filetype
     */
    public function getType()
    {
      if($this->_renderOptions->getOutputType() == PixlieRenderOptions::AUTO){
        return $this->_sourceImage->getType();
      }
      else{
        return $this->_renderOptions->getOutputType();
      }
    }

    /**
     * Sets the path to the cache resource
     *
     * @param string $resource
     */
    public function setResource($resource)
    {
      $this->_resource = $resource;
    }

    /**
     * Returns path to the cache resource
     *
     * @return NULL | string $resource
     */
    public function getResource()
    {
      return $this->_resource;
    }

  }
