<?php

define('MAX_IMAGE_WIDTH', 650);
define('MAX_IMAGE_HEIGHT', 450);
define('MAX_IMAGE_SMALL_WIDTH', 230);
define('MAX_IMAGE_SMALL_HEIGHT', 160);

class ModelRS {
    
    public function __construct() {
        
    }
    
    public static function removeDia($string){
        $convert_table = Array( 'ä'=>'a', 'Ä'=>'A', 'á'=>'a', 'Á'=>'A', '?'=>'a', '?'=>'A', '?'=>'a', '?'=>'A', 'â'=>'a', 'Â'=>'A','è'=>'c','È'=>'C','æ'=>'c','Æ'=>'C','ï'=>'d','Ï'=>'D','ì'=>'e','Ì'=>'E','é'=>'e','É'=>'E','ë'=>'e','Ë'=>'E','?'=>'e','?'=>'E','?'=>'e','?'=>'E','í'=>'i','Í'=>'I','?'=>'i','?'=>'I','?'=>'i','?'=>'I','î'=>'i','Î'=>'I','¾'=>'l','¼'=>'L','å'=>'l','Å'=>'L','ñ'=>'n','Ñ'=>'N','ò'=>'n','Ò'=>'N','?'=>'n','?'=>'N','ó'=>'o','Ó'=>'O','ö'=>'o','Ö'=>'O','ô'=>'o','Ô'=>'O','?'=>'o','?'=>'O','?'=>'o','?'=>'O','õ'=>'o','Õ'=>'O','ø'=>'r','Ø'=>'R','à'=>'r','À'=>'R','š'=>'s','Š'=>'S','œ'=>'s','Œ'=>'S',''=>'t',''=>'T','ú'=>'u','Ú'=>'U','ù'=>'u','Ù'=>'U','ü'=>'u','Ü'=>'U','?'=>'u','?'=>'U','?'=>'u','?'=>'U','?'=>'u','?'=>'U','ý'=>'y','Ý'=>'Y','ž'=>'z','Ž'=>'Z','Ÿ'=>'z',''=>'Z');
        return strtr($string, $convert_table);
    }
    
    public static function removeCharacters($string){
        $convert_table = Array( '-'=>'-', ',' => '-', '_'=>'-', ' '=>'-', '`'=>'-', ';'=>'-', '+'=>'-', '*'=>'-', '/'=>'-', '"'=>'-', '\''=>'-','<'=>'-','>'=>'-','|'=>'-','\\'=>'-', '='=>'-', '%'=>'-', '^'=>'-', '&'=>'-', '@'=>'-', '!'=>'-','['=>'-', ']'=>'-', '{'=>'-', '}'=>'-', '('=>'-', ')'=>'-', '^'=>'-', '°'=>'-', '~'=>'-', '´'=>'-', '¡'=>'-');
        return strtr($string, $convert_table);
    }
    
    private function makeURL($name, $edit = FALSE){
        $url = strtolower($this->removeCharacters($this->removeDia($name)));
        $is_in_db = dibi::query("SELECT id_category FROM category WHERE url = %s", $url)->fetchSingle();
        if (!$is_in_db || $edit){
            return $url;
        } else {
            $number = 1;
            while (true) {
                $new_url = $url.'-'.$number;
                if (!dibi::query("SELECT id_category FROM category WHERE url = %s", $new_url)->fetchSingle()){
                    break;
                } else {
                    $number++;
                }
            }
            return $new_url;
        }
    }


    public function getMainCategories() {
        return dibi::query("SELECT * FROM category where id_parent = 0")->fetchAll();

    }
    
    public function getCategory($id_category) {
        return dibi::query("SELECT * FROM category WHERE id_category = %i", $id_category)->fetch();
    }
    public function getCategoryChilds($id_category) {

        $childs = dibi::query("SELECT * FROM category where id_parent = %i order by order_category", $id_category)->fetchAll();
        if (empty($childs))
            return NULL;
        foreach ($childs as $child) {
            $child['childs'] = $this->getCategoryChilds($child->id_category);
        }
        return $childs;

    }
    
    public function printCategories($categories){
        if (!is_null($categories)){
            
            $out = '<ul>';
            foreach ($categories as $cat) {
                
                $out .= '<li><a href="products.php?id_category='.$cat->id_category.'">'.$cat->title.'</a>';
                //pouze 3 podkategorie
                if ($cat->level < 3){
                    $out .= '&nbsp;&nbsp;<a title="Pøidat podkategorii" href="actions.php?action=addCategory&id='.$cat->id_category.'"><img src="images/add.png" /></a>';
                }
                $out .= '&nbsp;&nbsp;<a title="Upravit podkategorii" href="actions.php?action=editCategory&id='.$cat->id_category.'"><img src="images/edit.png" /></a>
                         &nbsp;&nbsp;<a title="Smazat podkategorii" href="actions.php?action=delCategory&id='.$cat->id_category.'"><img src="images/delete.png" /></a>
                    ';
                
                if (!is_null($cat->childs)){
                    $out .= $this->printCategories($cat->childs);
                }
                $out .= '</li>';
            }
            $out .= '</ul>';
            return $out;
        }
        return '';
    }
    
    public function getCategoryName($id_category){
        return dibi::query("SELECT title FROM category WHERE id_category = %i", $id_category)->fetchSingle();
    }
    
    public function getCategoryUrl($id_category){
        return dibi::query("SELECT url FROM category WHERE id_category = %i", $id_category)->fetchSingle();
    }
    
    public function getCategoryLevel($id_category){
        return dibi::query("SELECT level FROM category WHERE id_category = %i", $id_category)->fetchSingle();
    }
    
    public function getCategoryFullUrl($id_category){
        return dibi::query("SELECT full_url FROM category WHERE id_category = %i", $id_category)->fetchSingle();
    }
    
    public function saveNewCategory($id_parent, $name, $level){
        
        $order = dibi::query("SELECT MAX(order_category) FROM category where id_parent = %i", $id_parent)->fetchSingle();
        $url = $this->makeURL($name);        
//        die($url);
        $data = array(
            'id_parent' => $id_parent,
            'title' => $name,
            'order_category' => $order+1,
            'level' => $level,
            'url' => $url,
            'full_url' => $this->getCategoryFullUrl($id_parent)."/".$url
        );
        dibi::query("INSERT INTO category",$data);
        return dibi::insertId();
    }
    
    public function editCategory($id_category, $name){
        $category = $this->getCategory($id_category);
        $url = $this->makeURL($name, TRUE);   
        $data = array(
            'title' => $name,
            'url' => $url,
            'full_url' => $this->getCategoryFullUrl($category->id_parent)."/".$url
        );
        return (boolean) dibi::query("UPDATE category set ",$data, " WHERE id_category = %i", $id_category);
    }
    
    public function deleteCategory($id_category){
        return (boolean) dibi::query("DELETE FROM category WHERE id_category = %i", $id_category);
    }
  
    public function getProducts($id_category){
        return dibi::query("SELECT * FROM products WHERE id_category = %i", $id_category)->fetchAll();
    }
    
    public function getProduct($id_product){
        return dibi::query("SELECT * FROM products WHERE id_product = %i", $id_product)->fetch();
    }
    
    public function getCategoryProduct($id_product){
        return dibi::query("SELECT id_category FROM products WHERE id_product = %i", $id_product)->fetchSingle();
    }
    
    public function saveNewProduct($data, $files){
//        echo '<pre>';
//        print_r($data);
//        print_r($files);
        
        $category_path = $this->getCategoryUrl($data['id_category']);
        
        //obrazek
        if (isset($files) && is_array($files)){
            if ($files['file'] != 0){

                $size = getimagesize($files['file']['tmp_name']);
    //            print_r($size);
                $pomer = $size[0]/$size[1];
                // sirka je mensi nez vyska - obr. svisle
                if ($size[0] >= $size[1]){
                    $obr = imagecreatetruecolor(MAX_IMAGE_HEIGHT, MAX_IMAGE_HEIGHT/$pomer);
                    $obr_small = imagecreatetruecolor(MAX_IMAGE_SMALL_HEIGHT, MAX_IMAGE_SMALL_HEIGHT/$pomer);
                }
                // sirka je vetsi nez vyska - obr. nalezato
                if ($size[0] < $size[1]){
                    $obr = imagecreatetruecolor(MAX_IMAGE_WIDTH, MAX_IMAGE_WIDTH/$pomer);
                    $obr_small = imagecreatetruecolor(MAX_IMAGE_SMALL_WIDTH, MAX_IMAGE_SMALL_WIDTH/$pomer);
                }
                if ($files['file']['type'] == 'image/jpeg' || $files['file']['type'] == 'image/jpg' || $files['file']['type'] == 'image/pjpeg' ){
                    $image = imagecreatefromjpeg($files['file']['tmp_name']);
                }
                if ($files['file']['type'] == 'image/png' ){
                    $image = imagecreatefrompng($files['file']['tmp_name']);
                }

                if ($size[0] >= $size[1]){
                    imagecopyresampled($obr, $image, 0, 0, 0, 0, (int) MAX_IMAGE_HEIGHT, (int) MAX_IMAGE_HEIGHT/$pomer, $size[0], $size[1]);
                    imagecopyresampled($obr_small, $image, 0, 0, 0, 0, MAX_IMAGE_SMALL_HEIGHT, MAX_IMAGE_SMALL_HEIGHT/$pomer, $size[0], $size[1]);
                }
                if ($size[0] > $size[1]){
                    imagecopyresampled($obr, $image, 0, 0, 0, 0, MAX_IMAGE_WIDTH, MAX_IMAGE_WIDTH/$pomer, $size[0], $size[1]);
                    imagecopyresampled($obr_small, $image, 0, 0, 0, 0, MAX_IMAGE_SMALL_WIDTH, MAX_IMAGE_SMALL_WIDTH/$pomer, $size[0], $size[1]);
                }   

                $image_name = "/sortiment/".$category_path."/".strtolower($this->removeCharacters($this->removeDia($data['name'].'-'.$files['file']['name'])));
                $image_name_small = "/sortiment/".$category_path."/small/".strtolower($this->removeCharacters($this->removeDia($data['name'].'-'.$files['file']['name'])));
                $image_name_original = "/sortiment/".$category_path."/original/".strtolower($this->removeCharacters($this->removeDia($data['name'].'-'.$files['file']['name'])));

                if (!file_exists("./../sortiment/".$category_path)){
                    if (!mkdir("./../sortiment/".$category_path, 0777, true)){
                        die('Nepodarilo se vytvorit adresar.');
                    }
                    if (!mkdir("./../sortiment/".$category_path."/small/", 0777, true)){
                        die('Nepodarilo se vytvorit adresar small.');
                    }
                    if (!mkdir("./../sortiment/".$category_path."/original/", 0777, true)) {
                        die('Nepodarilo se vytvorit adresare original.');
                    }
                }

                if ($files['file']['type'] == 'image/jpeg' || $files['file']['type'] == 'image/jpg' || $files['file']['type'] == 'image/pjpeg' ){
                    imagejpeg($obr, "./..".$image_name); /* Uložime obr do složky */
                    imagejpeg($obr_small, "./..".$image_name_small); /* Uložime miniaturu do složky */
                }
                if ($files['file']['type'] == 'image/png' ){
                    imagepng($obr, "./..".$image_name); /* Uložime obr do složky */
                    imagepng($obr_small, "./..".$image_name_small); /* Uložime miniaturu do složky */
                }
                imagedestroy($obr); /* A odstranime z Cache */
                imagedestroy($obr_small); /* A odstranime z Cache */
                move_uploaded_file($files['file']['tmp_name'], "./..".$image_name_original); /* A uložime oroginál */


            } else if ($files['type'] != 'image/jpeg' && $files['type'] != 'image/jpg' && $files['type'] != 'image/pjpeg'  && $files['type'] != 'image/png'){
                die('ko');
                return 'Nepovedlo se pøidat produkt <br> Nepovolený formát fotografie (povolené typy: JPG, JPEG, PNG).';

            } else {
                die('ko');
                return 'Nepovedlo se pøidat produkt <br> Nepodaøilo se nahrát fotografii';
            }
            $data['picture'] = $image_name;
            $data['picture_small'] = $image_name_small;
        }
        if (dibi::query("INSERT INTO products", $data)){
            return dibi::insertId();
        } else {
            return 'Produkt se nepovedlo pridat';
        }
    }
    
    public function editProduct($id_product, $data){
        return (boolean) dibi::query("UPDATE products SET ",$data, " WHERE id_product = %i", $id_product);
    }
    
    public function deleteProduct($id_product){
        return (boolean) dibi::query("DELETE FROM products WHERE id_product = %i", $id_product);
    }
    
    
}


?>