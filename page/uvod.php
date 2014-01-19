<div id="left_main">
    <div id="banner_home">
       <map name="banner-obr">
        <area href="index.php" shape="rect" coords="0, 0, 690, 257"></map>
        <img src="images/banner_miko.jpg" alt="Miko Interiéry" title="Miko Interiéry" class="no_border" height="257" width="690" usemap="#banner-obr">
    </div>
    
    <div id="logo_home">
    <span class="nadpis">Vítejte na stránkách MIKO-INTERIÉRY</span>
    </div >
    
    <div id="middle_home">
       <?php require_once './src/left_menu.php'; ?>
              
       <div id="main_home">
       
        <?php 
            foreach ($main_categories as $cat) {    
                if ($cat->id_category != MENU_ID_OSVETLENI) {
                ?>
                
                <div class="rozdeleni">
                    <p><a href="#" title="<?php echo $cat->title; ?>">
                    <img src="/<?php echo $cat->picture; ?>" alt="<?php echo $cat->title; ?>" title="<?php echo $cat->title; ?>" class="no_border"></a></p>
                    <h3><a href="#" title="<?php echo $cat->title; ?>"><?php echo $cat->title; ?></a></h3>
                </div>
                <?php } else { ?>
                <div class="rozdeleni">
                    <p><a href="<?php echo $cat->url; ?>" title="<?php echo $cat->title; ?>">
                    <img src="/<?php echo $cat->picture; ?>" alt="<?php echo $cat->title; ?>" title="<?php echo $cat->title; ?>" class="no_border"></a></p>
                    <h3><a href="<?php echo $cat->url; ?>" title="<?php echo $cat->title; ?>"><?php echo $cat->title; ?></a></h3>
                </div>
        <?php  }#  
            }?>
          
       </div> 
          
    </div>
    <div id="footer_home"></div>
</div>
      
<div id="news">
  <div id="news_top"></div>
  <div id="news_mid">
   
    <div class="news-bar">    <br><br><br>
        <h3><a style="color: red" href="/rs/">Úprava kategorií a produktù</a></h3>
     
     
     </div> 
     <!-- 
     <div class="news-bar">
      <h3>Akce Inelis</h3>
     <h3>do 30.4.2011</h3>
      <a href="../images/zafira.png" rel="lightbox" title="Akce Inelis do 30.4.2011">
      <img src="../images/zafira-small.png" alt="Akce Inelis" title="Akce Inelis" class="no-border" border="0">
      </a>
    </div>    
     
     <div class="news-bar">   
     <h3>Akce Kanapa</h3>
     <h3>Léto 2012</h3>
      <p>                          
      <a href="sedaci-soupravy.php?page=sedacky-kanapa" title="Akce Kanapa">
      <img src="image-akce/akce-kanapa-matrace-leto2012-small.jpg" alt="Akce Kanapa" title="Akce Kanapa" class="no_border" width="100px" >
      </a><br>
      Matrace ke koupi <br>sedací soupravy <a href="sedaci-soupravy.php?page=sedacky-kanapa" title="Akce Kanapa">Kanapa</a>
      </p>
      <p><a href="index.php?page=akce-novinky">více...</a></p>
     </div>
     
     <div class="news-bar">   
     <h3>Akce Kanapa</h3>
     <h3>Léto 2012</h3>
      <p>                          
      <a href="sedaci-soupravy.php?page=sedacky-kanapa-basic" title="Akce Kanapa">
      <img src="image-akce/akce-kanapa-basic-leto2012-small.jpg" alt="Akce Kanapa" title="Akce Kanapa" class="no_border" width="100px" >
      </a><br>
      <a href="sedaci-soupravy.php?page=sedacky-kanapa-basic" title="Akce Kanapa">øada BASIC -25%</a>
      </p>
      <p><a href="index.php?page=akce-novinky">více...</a></p>
     </div>
      -->
      
      <!-- 
      <p>
      <a href="sedaci-soupravy.php?page=sedacky-kanapa-basic" title="øada Basic">
      <img src="sortiment/sedaci-soupravy/sedacky-kanapa-basic.jpg" alt="øada Basic" title="øada Basic" class="no_border">
      </a><br>
      <a href="sedaci-soupravy.php?page=sedacky-kanapa-basic" title="øada Basic">-25% øada BASIC</a>  
      </p>
     </div>
     
     <div class="news-bar">
     <h3>Akce Recor</h3>
     <h3>Bøezen</h3>
      <p>
      <a href="sedaci-soupravy.php?page=sedacky-recor" title="Akce Recor">
      <img src="sortiment/sedaci-soupravy/akce-recor.jpg" alt="Akce Recor" title="Akce Recor" class="no_border">
      </a><br>
      <a href="sedaci-soupravy.php?page=sedacky-recor" title="Akce Recor">-15% na vybrané sedaèky a køesla</a>
      </p>
      -->
     
     
  </div>
  <div id="news_bot"></div>
</div>
