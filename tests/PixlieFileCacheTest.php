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
 * @package    PixlieFileCacheTest
 * @copyright  Copyright (c) 2012 Steffen Hagdorn (http://www.pixlie.org)
 * @license    http://www.pixlie.org/license/     MIT License
 *
 */

  require_once('../library/Pixlie/PixlieCache.php');
  require_once('../library/Pixlie/PixlieSourceImage.php');
  require_once('../library/Pixlie/PixlieImage.php');
  require_once('../library/Pixlie/PixlieRenderOptions.php');
  require_once('../library/Pixlie/PixlieException.php');

  class PixlieFileCacheTest extends PHPUnit_Framework_TestCase
  {
    public function setUp() {
      // Clear the cache dir before running the tests
      foreach(glob("cache/*") as $file) {
        if(strpos($file, 'index.html') === false) {
          unlink($file);
        }
      }
    }

    /**
     * @test
     */
    public function isCachedReturnsFalseIfNotCached()
    {
      $cache = new PixlieFileCache();
      $sourceImage = new PixlieSourceImage('testimages/MrJelly.gif');
      $renderOptions = new PixlieRenderOptions();
      $renderOptions->setOutputType(PixlieRenderOptions::PNG);
      $image = new PixlieImage($sourceImage,$renderOptions);
      $this->assertFalse($cache->isCached($image));
    }

  }