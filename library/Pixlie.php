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
 * @package    Pixlie
 * @copyright  Copyright (c) 2012 Steffen Hagdorn (http://www.pixlie.org)
 * @license    http://www.pixlie.org/license/     MIT License
 *
 */

  require_once('Pixlie/PixlieCache.php');
  require_once('Pixlie/PixlieException.php');
  require_once('Pixlie/PixlieImage.php');
  require_once('Pixlie/PixlieRenderer.php');
  require_once('Pixlie/PixlieRenderOptions.php');
  require_once('Pixlie/PixlieSourceImage.php');

  class Pixlie
  {

    /**
     * The cache object
     */
    private $_cache = NULL;

    /**
     * The renderer object
     */
    private $_renderer = NULL;

    /**
     * Sets the cache engine
     *
     * @param PixlieCache $cache
     */
    public function setCache(PixlieCache $cache)
    {
       $this->_cache = $cache;
    }

    /**
     * Sets the renderer
     *
     * @param PixlieRenderer $renderer
     */
    public function setRenderer(PixlieRenderer $renderer)
    {
      $this->_renderer = $renderer;
    }

    /**
     * Returns the current cache engine
     *
     * @return PixlieCache $cache
     */
    public function getCache()
    {
      return($this->_cache);
    }

    /**
     * Returns the current renderer
     *
     * @return PixlieRenderer $renderer
     */
    public function getRenderer()
    {
      return($this->_renderer);
    }

    /**
     * First opens the source image, then checks the cache and calculates
     * the image with the renderer if necessary
     *
     * @param string $srcFilePath
     * @param PixlieRenderOptions $renderOptions OPTIONAL
     * @return PixlieImage $image
     */
    public function render($srcFilePath, PixlieRenderOptions $renderOptions = NULL)
    {
      $sourceImage = new PixlieSourceImage($srcFilePath);
      if($renderOptions === NULL){
        $renderOptions  = new PixlieRenderOptions();
      }
      if($this->getCache() === NULL){
        $this->setCache(new PixlieFileCache());
      }
      $image = new PixlieImage($sourceImage,$renderOptions);
      if(!$this->getCache()->isCached($image)){
        if($this->getRenderer() === NULL){
          $this->setRenderer(new PixlieGdRenderer());
        }
        $this->getRenderer()->render($image,$this->getCache());
      }
      return($image);
    }

  }
