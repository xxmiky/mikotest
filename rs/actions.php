<?php 

    date_default_timezone_set("Europe/Prague");
    require_once './config/config.php';
    require_once './classes/ModelRS.php';
    $model = new ModelRS();
    
    define('TEST', FALSE);

    //kategorie
    if (isset($_GET['action']) && $_GET['action'] == 'addCategory'){
        $action = 'addCategory';
        $level = $model->getCategoryLevel($_GET['id']);
        require './views/addCategoryForm.php';
    }
    
    if (isset($_GET['action']) && $_GET['action'] == 'editCategory'){
        $action = 'editCategory';
        $name = $model->getCategoryName($_GET['id']);
        require './views/addCategoryForm.php';
    }
    
    if (isset($_GET['action']) && $_GET['action'] == 'delCategory'){
        if ($model->deleteCategory($_GET['id'])){
            $_SESSION['out'] = "Kategorie se povedla odstranit";
            if (TEST)
                header('Location: http://miko.localhost/rs/');
            else
                header('Location: http://new.miko-interiery.cz/rs/');
        }
    }
    
    //produkty
    if (isset($_GET['action']) && $_GET['action'] == 'addProduct'){
        $action = 'addProduct';
        require './views/addProductForm.php';
    }
    
    if (isset($_GET['action']) && $_GET['action'] == 'editProduct'){
        $action = 'editProduct';
        $product = $model->getProduct($_GET['id_product']);
        require './views/addProductForm.php';
    }
    
    
    if (isset($_POST['addCategorySubmit']) && $_POST['addCategorySubmit'] == 'Uložit'){
        if ($model->saveNewCategory($_POST['id_category'], trim($_POST['name']), $_POST['level'])){
            $_SESSION['out'] = "Kategorie se povedla pøidat";
            if (TEST)
                header('Location: http://miko.localhost/rs/');
            else
                header('Location: http://new.miko-interiery.cz/rs/');
        }
    }
    if (isset($_POST['editCategorySubmit']) && $_POST['editCategorySubmit'] == 'Upravit'){
        if ($model->editCategory($_POST['id_category'], trim($_POST['name']))){
            $_SESSION['out'] = "Kategorie se povedla upravit";
            if (TEST)
                header('Location: http://miko.localhost/rs/');
            else
                header('Location: http://new.miko-interiery.cz/rs/');
        }
    }
        
//    die(print_r($_POST));
    if (isset($_POST['addProductSubmit']) && $_POST['addProductSubmit'] == 'Uložit'){
        unset($_POST['addProductSubmit']);
        if (strlen($_POST['name']) > 0){
            if ($out = $model->saveNewProduct($_POST, $_FILES)){
                $_SESSION['out'] = "Produkt se povedl pøidat";
            }
            else {
                $_SESSION['out'] = $out;
            }
        } else {
            $_SESSION['out_error'] = "Nebyl zadán žádný název produktu";
        }
        if (TEST)
            header('Location: http://miko.localhost/rs/products.php?id_category='.$_POST['id_category']);
        else
            header('Location: http://new.miko-interiery.cz/rs/products.php?id_category='.$_POST['id_category']);
    }
    if (isset($_POST['editProductSubmit']) && $_POST['editProductSubmit'] == 'Upravit'){
        unset($_POST['editProductSubmit']);
//        die(print_r($_POST));
        if ($model->editProduct($_POST['id_product'], $_POST)){
            $_SESSION['out'] = "Produkt se povedl upravit";
            if (TEST)
                header('Location: http://miko.localhost/rs/products.php?id_category='.$model->getCategoryProduct($_POST['id_product']));
            else
                header('Location: http://new.miko-interiery.cz/rs/products.php?id_category='.$model->getCategoryProduct($_POST['id_product']));
        }
    }
    
    if (isset($_GET['action']) && $_GET['action'] == 'deleteProduct'){
        if ($model->deleteProduct($_GET['id_product'])){
            $_SESSION['out'] = "Produkt se povedl odstranit";
            if (TEST)
                header('Location: http://miko.localhost/rs/');
            else
                header('Location: http://new.miko-interiery.cz/rs/');
        }
    }
    
    if(!isset($_POST) || !isset($_GET['action'])){
        if (TEST)
            header('Location: http://miko.localhost/rs/');
        else
            header('Location: http://new.miko-interiery.cz/rs/');
    }
        
    
    
    
?>
