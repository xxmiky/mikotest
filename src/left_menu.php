    
<?php
    $main_categories = $model->getMainCategories();
//    print_r($main_categories);
?>

<div id="menu">
    <?php foreach ($main_categories as $cat){ ?>
        <div class="menu_seznam"><a href="#"><?php echo $cat->title; ?></a></div>
    <?php } ?>
  </div>
