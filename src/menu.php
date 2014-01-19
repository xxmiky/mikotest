<?php
 if (!isset($_GET['page'])) {
        $stranka = "uvod";
     } else {
        $stranka = $_GET['page'];
}
  echo '<div id="menu_top">'."\n";
  
  echo '<div><a class="';
  if($stranka=="o-firme") echo 'ofirme-active"';
  else echo 'ofirme"';
  echo 'href="#"></a></div>'."\n";
//  echo 'href="/o-firme"></a></div>'."\n";
  
  echo '<div><a class="';
  if($stranka=="fotogalerie") echo 'foto-active"';
  else echo 'foto"';
  echo 'href="#"></a></div>'."\n";
//  echo 'href="/fotogalerie"></a></div>'."\n";
  
  echo '<div><a class="';
  if($stranka=="sortiment") echo 'sortiment-active"';
  else echo 'sortiment"';
  echo 'href="#"></a></div>'."\n";
//  echo 'href="index.php?page=sortiment"></a></div>'."\n";
//  echo 'href="/sortiment"></a></div>'."\n";
  
  echo '<div><a class="';
  if($stranka=="kontakt") echo 'kontakt-active"';
  else echo 'kontakt"';
  echo 'href="#"></a></div>'."\n";
//  echo 'href="/kontakt"></a></div>'."\n";
  
  echo '<div><a class="';
  if($stranka=="akce-novinky") echo 'akce-active"';
  else echo 'akce"';
  echo 'href="#"></a></div>'."\n";
//  echo 'href="/akce-novinky"></a></div>'."\n";
  
  echo '</div>'."\n";  
  
  
?>

                               