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
 * @package    PixlieRenderOptionsTest
 * @copyright  Copyright (c) 2012 Steffen Hagdorn (http://www.pixlie.org)
 * @license    http://www.pixlie.org/license/     MIT License
 *
 */

  require_once('../library/Pixlie/PixlieRenderOptions.php');
  require_once('../library/Pixlie/PixlieException.php');

  class PixlieRenderOptionsTest extends PHPUnit_Framework_TestCase
  {

   public function setUp()
   {
     $this->imageOptions = new PixlieRenderOptions();
   }

   /**
    * @test
    */
   public function initialValuesSetCorrect()
   {
     $this->assertSame(PixlieRenderOptions::AUTO,$this->imageOptions->getOutputType());
     $this->assertSame(100,$this->imageOptions->getQuality());
     $this->assertSame(PixlieRenderOptions::AUTO,$this->imageOptions->getWidth());
     $this->assertSame(PixlieRenderOptions::AUTO,$this->imageOptions->getHeight());
     $this->assertSame(PixlieRenderOptions::AUTO,$this->imageOptions->getMin());
     $this->assertSame(PixlieRenderOptions::AUTO,$this->imageOptions->getMax());
   }

   /**
    * @test
    */
   public function setQualityStoresValue()
   {
     $returnedValue = $this->imageOptions->setQuality(100);
     $this->assertSame(100,$this->imageOptions->getQuality());
   }

   /**
    * @test
    */
   public function setOutputTypeStoresValue()
   {
     $returnedValue = $this->imageOptions->setOutputType(PixlieRenderOptions::JPG);
     $this->assertSame(PixlieRenderOptions::JPG,$this->imageOptions->getOutputType());
   }

   /**
    * @test
    */
   public function setOutputTypeThrowsExceptionOnWrongOutputType()
   {
     $this->setExpectedException('PixlieException');
     $returnedValue = $this->imageOptions->setOutputType('jpeg');
   }

   /**
    * @test
    */
   public function setWidthStoresValue()
   {
     $returnedValue = $this->imageOptions->setWidth(123);
     $this->assertSame(123,$this->imageOptions->getWidth());
   }

   /**
    * @test
    */
   public function setHeightStoresValue()
   {
     $returnedValue = $this->imageOptions->setHeight(234);
     $this->assertSame(234,$this->imageOptions->getHeight());
   }

   /**
    * @test
    */
   public function setMinStoresValue()
   {
     $returnedValue = $this->imageOptions->setMin(345);
     $this->assertSame(345,$this->imageOptions->getMin());
   }

   /**
    * @test
    */
   public function setMaxStoresValue()
   {
     $returnedValue = $this->imageOptions->setMax(456);
     $this->assertSame(456,$this->imageOptions->getMax());
   }

   /**
    * @test
    */
   public function setWidthReturnsImageOptionsInstance()
   {
     $returnedValue = $this->imageOptions->setWidth(100);
     $this->assertSame($this->imageOptions,$returnedValue);
   }

 }