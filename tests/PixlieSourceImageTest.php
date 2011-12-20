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
 * @package    PixlieSourceImageTest
 * @copyright  Copyright (c) 2012 Steffen Hagdorn (http://www.pixlie.org)
 * @license    http://www.pixlie.org/license/     MIT License
 *
 */

  require_once('../library/Pixlie/PixlieSourceImage.php');
  require_once('../library/Pixlie/PixlieRenderOptions.php');
  require_once('../library/Pixlie/PixlieException.php');

  class PixlieSourceImageTest extends PHPUnit_Framework_TestCase
  {


   /**
    * @test
    */
   public function constructorThrowsExceptionOnFileNotFound()
   {
     $this->setExpectedException('PixlieException');
     $srcImage = new PixlieSourceImage('notfound.jpg');
   }

   /**
    * @test
    */
   public function constructorThrowsExceptionOnFileTypeNotSupported()
   {
     $this->setExpectedException('PixlieException');
     $srcImage = new PixlieSourceImage('PixlieSourceImageTest.php');
   }

   /**
    * @test
    */
   public function getTypeReturnsCorrectValue()
   {
     $testImage = 'testimages/MrJelly.gif';
     $srcImage = new PixlieSourceImage($testImage);
     $this->assertSame('gif',$srcImage->getType());
   }

   /**
    * @test
    */
   public function getSizeReturnsCorrectValue()
   {
     $testImage = 'testimages/MrJelly.gif';
     $srcImage = new PixlieSourceImage($testImage);
     $this->assertSame(filesize($testImage),$srcImage->getSize());
   }

   /**
    * @test
    */
   public function getPathReturnsCorrectValue()
   {
     $testImage = 'testimages/MrJelly.gif';
     $srcImage = new PixlieSourceImage($testImage);
     $this->assertSame($testImage,$srcImage->getPath());
   }

   /**
    * @test
    */
   public function getWidthAndGetHeightReturnsCorrectValue()
   {
     $testImage = 'testimages/MrJelly.gif';
     $srcImage = new PixlieSourceImage($testImage);
     $this->assertSame(180,$srcImage->getWidth());
     $this->assertSame(180,$srcImage->getHeight());
   }

 }