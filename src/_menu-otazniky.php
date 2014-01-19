<?php
  echo '<div id="menu_up">'."\n";
  
  echo '<div class="menu_polozka ';
  if($active==1) echo 'menu_active"';
  else echo 'menu_text"';
  echo '><a href="index.php?page=o-firme">O firmì</a></div>'."\n";
  
  echo '<div class="menu_polozka ';
  if($active==2) echo 'menu_active"';
  else echo 'menu_text"';
  echo '><a href="index.php?page=sortiment">Sortiment</a></div>'."\n";
  
  echo '<div class="menu_polozka ';
  if($active==3) echo 'menu_active"';
  else echo 'menu_text"';
  echo '><a href="index.php?page=akcni-nabidka">Akèní nabídka</a></div>'."\n";
  
  echo '<div class="menu_polozka ';
  if($active==4) echo 'menu_active"';
  else echo 'menu_text"';
  echo '><a href="index.php?page=reference">Reference</a></div>'."\n";
  
  echo '<div class="menu_polozka ';
  if($active==5) echo 'menu_active"';
  else echo 'menu_text"';
  echo '><a href="index.php?page=kontakt">Kontakt</a></div>'."\n";

  echo '</div>'."\n";  
?>                            