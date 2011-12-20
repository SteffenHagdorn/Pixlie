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
 * @package    PixieCache
 * @copyright  Copyright (c) 2012 Steffen Hagdorn (http://www.pixlie.org)
 * @license    http://www.pixlie.org/license/     MIT License
 *
 */

  interface PixlieCacheInterface
  {
    public function isCached(PixlieImage $image);
    public function getCacheFilePath(PixlieImage $image);
    public function registerResource(PixlieImage $image);
  }

  abstract class PixlieCache
  {

  }

  class PixlieFileCache extends PixlieCache implements PixlieCacheInterface
  {

    /**
     * Cache folder path
     */
    private $_cacheFolder;

    /**
     * Constructor
     *
     * @param string $cacheFolder OPTIONAL
     * @todo Validate $cacheFolder parameter
     */
    public function __construct($cacheFolder = 'cache/')
    {
      $this->_cacheFolder = $cacheFolder;
    }

    /**
     * Creates the cache file name
     *
     * @param PixlieImage $image
     * @return string $cacheFilename
     */
    public function getCacheFilename(PixlieImage $image)
    {
      return md5($image->getSourceImage()->getPath())
             .'-'.$image->getWidth().'x'.$image->getHeight()
             .'.'.$image->getType();
    }

    /**
     * Returns the path to the cache file including the folder and file name
     *
     * @param PixlieImage $image
     * @return string $cacheFilenpath
     */
    public function getCacheFilepath(PixlieImage $image)
    {
      return $this->_cacheFolder.$this->getCacheFilename($image);
    }

    /**
     * Updates the cache file path in the given image
     *
     * @param PixlieImage $image
     */
    public function registerResource(PixlieImage $image)
    {
      $image->setResource($this->getCacheFilepath($image));
    }

    /**
     * Checks if the file exists in the cache directory
     *
     * @param PixlieImage $image
     * @return boolean $fileExists
     */
    public function isCached(PixlieImage $image)
    {
      if(file_exists($this->getCacheFilepath($image))){
        $image->setResource($this->getCacheFilepath($image));
        return true;
      }
      else{
        return false;
      }
    }

  }
