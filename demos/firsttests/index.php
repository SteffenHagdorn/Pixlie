<?php

  error_reporting(E_ALL);
  require_once('../../library/Pixlie.php');
  
  
  try{

    $pixlie = new Pixlie();
    $pixlie->setCache(new PixlieFileCache('cache/'));


    //Version A

    $thumbnail = new PixlieRenderOptions();
    $thumbnail->setWidth(300);
    $thumbnail->setHeight(200);
    $thumbnail->setOutputType(PixlieRenderOptions::PNG);

    $imageOne = $pixlie->render("../../tests/testimages/MrJelly.gif",$thumbnail);


    //Version B    

    $imageTwo = $pixlie->render("../../tests/testimages/MrJelly.gif",PixlieRenderOptions::create()->setHeight(233)->setWidth(300));


  }catch(Exception $e){
    echo '<h1>'.$e->getMessage().'</h1>';
  }

?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Test</title
  </head>
  <body>

    <h1>Bild 1</h1>  
    <code><?php var_dump($imageOne); ?></code>
    <p>
      <img src="<?php echo $imageOne->getResource(); ?>" width="<?php echo $imageOne->getWidth(); ?>" height="<?php echo $imageOne->getHeight(); ?>">
    </p>

    <h1>Bild 2</h1>  
    <code><?php var_dump($imageTwo); ?></code>
    <p>
      <img src="<?php echo $imageTwo->getResource(); ?>" width="<?php echo $imageTwo->getWidth(); ?>" height="<?php echo $imageTwo->getHeight(); ?>">
    </p>

  </body>
</html>