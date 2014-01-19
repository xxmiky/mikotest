<?php 

    date_default_timezone_set("Europe/Prague");
    require_once './config/config.php';
    require_once './classes/ModelRS.php';
    $model = new ModelRS();
    
?>

<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html>
    <head>
        <meta http-equiv=\"Content-type\" content=\"text/html; charset=windows-1250\" />
        <title>Úprava kategorií</title>
        <link rel=stylesheet type="text/css" href="css/style.css" media="screen,projection" />

        <style type="text/css">
            a{
                color: blue;

            }
        </style>
    </head>
    <body>

        <h1>Úprava kategorií</h1>
        <a href="/">Zpět</a>
        <?php 
            if (isset($_SESSION['out'])) {
                echo '<p class="out">'.$_SESSION['out'].'</p>';
                unset($_SESSION['out']);
            } 
            if (isset($_SESSION['out_error'])) {
                echo '<p class="out_error">'.$_SESSION['out_error'].'</p>';
                unset($_SESSION['out_error']);
            } 
        ?>
        
        <ul>
            <?php
            $main_categories = $model->getMainCategories();
            foreach ($main_categories as $main) {
                
                ?>
            <li><?php echo $main->title; ?>&nbsp;&nbsp;<a href="actions.php?action=addCategory&id=<?php echo $main->id_category?>"><img src="images/add.png" /></a> 
                <?php $cat = $model->getCategoryChilds($main->id_category);
                      echo $model->printCategories($cat); ?>
            </li>
                
            <?php } ?>
        </ul>


    </body>
</html>