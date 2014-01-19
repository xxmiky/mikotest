<?php   
//  print_r($_GET);
  session_start();
  
  require_once './src/config.php';
  require_once './src/Model.php';
  $model = new Model();
  
  
  if (isset($_GET['id_category'])){
    $id_category = $_GET['id_category'];
  } else if (isset ($_GET['url']) && strlen($_GET['url']) > 1 ){
      // v url je lomitko (napr. $_GET[url] => /jedna ) url od pozice posledniho /
      $url_offset = strripos($_GET['url'], '/') + 1;
//      var_dump(strlen($_GET['url']), $url_offset);
      if (strlen($_GET['url']) == $url_offset){
          //lomitko na konci
        $new_url = substr($_GET['url'], 0, strlen($_GET['url'])-1);  
        $new_url_offset = strripos($new_url, '/') + 1;
//        var_dump($new_url, $new_url_offset);
        $id_category = $model->getIdCategoryFromUrl(substr($new_url, $new_url_offset));
      } else {
          //bez lomitka na konci
        $id_category = $model->getIdCategoryFromUrl(substr($_GET['url'],$url_offset));
      }
  } else {
      $id_category = MENU_ID_OSVETLENI;
  }
  
  
  
  $category_info = $model->getCategory($id_category);
  $breadcrump = $model->getBreadCrump($id_category);
  
  $title = $category_info->title . " | Milan Kodad MIKO Opaøany";

//    $navigationMenu = $model->getNavigationMenu(MENU_ID_OSVETLENI, $id_category);
//  echo $navigationMenu;
//  die;

    require_once './src/hlavicka.php';
    require_once './src/menu.php';
    
    ?>

<div>

    <div id="banner">
        <a href="/" title="Miko Interiéry" >
            <img class="no_border" src="/images/banner_osvetleni.png" alt="Miko Interiéry" title="Miko Interiéry" height="257" width="690">
        </a>
    </div>
    

    <div id="next">
        <div class="next_bar">
<!--            <h3>Akce Kanapa - Léto 2012</h3>        
            <table width="250px" class="no_border">
                <tr><td><a href="sedaci-soupravy.php?page=sedacky-kanapa" title="Akce Kanapa">
                            <img src="image-akce/akce-kanapa-matrace-leto2012-small.jpg" alt="Akce Kanapa" title="Akce Kanapa" class="no_border" width="80px">
                        </a></td>
                    <td><a href="sedaci-soupravy.php?page=sedacky-kanapa-basic" title="Akce Kanapa">
                            <img src="image-akce/akce-kanapa-basic-leto2012-small.jpg" alt="Akce Kanapa" title="Akce Kanapa" class="no_border" width="80px">
                        </a></td></tr>
                <tr><td>Matrace ke koupi <br>sedací soupravy<br><a href="sedaci-soupravy.php?page=sedacky-kanapa" title="Akce Kanapa">Kanapa</a></td>
                    <td><a href="sedaci-soupravy.php?page=sedacky-kanapa-basic" title="Akce Kanapa">øada BASIC<br>-25%</a></td></tr>
            </table>
            <p>
                <a href="index.php?page=akce-novinky">více...</a>
            </p>-->
        </div>
    </div> 

    <div id="logo">
        <span class="nadpis"><?php echo $category_info->title; ?></span>
    </div >

    <div id="middle">
        <div id="menu">
            <div class="menu_seznam_sortiment"><a href="/">Sortiment</a></div>
            <?php  foreach ($breadcrump as $bread) { ?>
                <!--<div class="menu_seznam_sortiment"><a href="/osvetleni.php?id_category=<?php // echo $bread->id_category; ?>"><?php // echo $bread->title; ?></a></div>-->
                <?php if ($bread->id_category == MENU_ID_OSVETLENI) { ?>
                    <div class="menu_seznam_sortiment"><a href="/<?php echo $bread->url; ?>"><?php echo $bread->title; ?></a></div>
                <?php } else { ?>
                    <div class="menu_seznam_sortiment"><a href="/testovaci-kategorie/<?php echo $bread->url; ?>"><?php echo $bread->title; ?></a></div>
                <?php } ?>
            <?php } ?>
                
            <?php 
                $subcategories = $model->getCategoryAllChilds($id_category);
                if (count($subcategories) > 0)
                    foreach ($subcategories as $subcat) {
            ?>
                    <!--<div class="menu_seznam"><a href="/osvetleni.php?id_category=<?php // echo $subcat->id_category; ?>" title="<?php // echo $subcat->title; ?>"><?php // echo $subcat->title; ?></a></div>-->
                    <div class="menu_seznam"><a href="/testovaci-kategorie/<?php echo $subcat->url; ?>" title="<?php echo $subcat->title; ?>"><?php echo $subcat->title; ?></a></div>

            <?php } ?>
                    
            <div class="menu_seznam_sortiment">&nbsp;</div>
            <div class="menu_seznam_sortiment"><a href="/">Sortiment</a></div>
            <div class="menu_seznam_sortiment"><a href="/testovaci-kategorie">TESTOVACI STRANKA</a></div>
            
            <div class="menu_seznam_new">
            <?php  
            $navigationMenu = $model->getNavigationMenu(MENU_ID_OSVETLENI, $id_category);
//            
            echo $navigationMenu;
//            die;
            ?>
            </div>
            
            <div class="menu_seznam_sortiment"><a href="../../formular.php">Poptávkový formuláø</a></div>
        </div>
        <div id="main">
            <p class="navigace">
                <a href="/">Sortiment</a> &nbsp;&gt;&gt;&nbsp;
            <?php  foreach ($breadcrump as $bread) { ?>
                <?php if ($bread->id_category != $id_category){ 
/*                        echo '<a href="/osvetleni.php?id_category='.$bread->id_category; ?>"><?php echo $bread->title; ?></a> &nbsp;&gt;&gt;&nbsp;  */
                        echo '<a href="/testovaci-kategorie/'.$bread->url; ?>"><?php echo $bread->title; ?></a> &nbsp;&gt;&gt;&nbsp;
                <?php } else {
                        echo $bread->title;
                      }
                    } ?>
            </p>

            
            <?php 
                $categoryProducts = $model->getProducts($id_category);
                if (count($categoryProducts) > 0)
                    foreach ($categoryProducts as $product) {
            ?>
                    <div class="rozdeleni2">
                        <h3><?php echo $product->name; ?></h3>
                        <div class="product-picture">                               
                            <a href="/sortiment/testovaci-kategorie/<?php echo $product->picture; ?>" rel="lightbox" title="<?php echo $product->name; ?>">
                                <img class="no_border" src="/sortiment/testovaci-kategorie/<?php echo $product->picture_small; ?>" alt="<?php echo $product->name; ?>" title="<?php echo $product->name; ?>">
                            </a>
                        </div>
                        <div class="product-description">                               
                            <p><?php echo nl2br($product->description); ?></p>
                        </div>
                        <h3>Cena:</h3>
                        <h4><?php echo $product->prize; ?> Kè</h4>
                    </div>
                    

            <?php } ?>
            
        </div> 
    </div>
    <div id="footer"></div>    

</div>
    
<?php
  
    include_once './src/paticka.php';
 
?>