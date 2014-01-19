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
        <title>Přehled produktů</title>

        <link rel=stylesheet type="text/css" href="css/style.css" media="screen,projection" />

        <style type="text/css">
            a{
                color: blue;

            }
        </style>
    </head>
    <body class="produkty">

        <h1>Přehled produktů - <?php echo $model->getCategoryName($_GET['id_category']); ?></h1>
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
        <p><a href="/rs/">Zpět</a></p>
        <p><a href="actions.php?action=addProduct&id_category=<?php echo $_GET['id_category']?>">Přidat produkt</a></p>
        
            <?php 
                $products = $model->getProducts($_GET['id_category']); 
                foreach ($products as $prod) { 
            ?>
                <div class="rozdeleni2">
                    <h3><?php echo $prod->name; ?></h3>
                    <div class="product-picture">                               
                        <a href="<?php echo $prod->picture; ?>" rel="lightbox" title="<?php echo $prod->name; ?>">
                            <img class="no_border" src="<?php echo $prod->picture_small; ?>" alt="<?php echo $prod->name; ?>" title="<?php echo $prod->name; ?>">
                        </a>
                    </div>
                    <div class="product-description">                               
                        <p><?php echo nl2br($prod->description); ?></p>
                    </div>
                    <h3>Cena:</h3>
                    <h4><?php echo $prod->prize; ?> Kč</h4>
                    <p>
                        <a href="actions.php?action=editProduct&id_product=<?php echo $prod->id_product; ?>" title="Upravit"><img src="images/edit.png" /></a>
                        <a href="actions.php?action=deleteProduct&id_product=<?php echo $prod->id_product; ?>" title="Smazat"><img src="images/delete.png" /></a>
                    </p>
                </div>  
            <?php } ?>
                    
    </body>
</html>
 