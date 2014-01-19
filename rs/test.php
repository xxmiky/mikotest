<?php 

    date_default_timezone_set("Europe/Prague");
    require_once './config/config.php';
    require_once './classes/ModelRS.php';
    $model = new ModelRS();
    
?>

                <?php $cat = $model->getCategoryChilds(1);
                echo $model->printCategories($cat); ?>
                    