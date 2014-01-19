<?php

class Model {
    
    public function __construct() {
        
    }


    public function getMainCategories() {
        return dibi::query("SELECT * FROM category where id_parent = 0 ORDER BY order_category")->fetchAll();

    }
    
    public function getCategory($id_category) {
        return dibi::query("SELECT * FROM category WHERE id_category = %i", $id_category)->fetch();
    }
    
    public function getIdCategoryFromUrl($url){
        return dibi::query("SELECT id_category FROM category WHERE url = %s", $url)->fetchSingle();
    }
    
    public function getCategoryAllChilds($id_category) {

        $childs = dibi::query("SELECT * FROM category where id_parent = %i order by order_category", $id_category)->fetchAll();
        if (empty($childs))
            return NULL;
        foreach ($childs as $child) {
            $child['childs'] = $this->getCategoryAllChilds($child->id_category);
        }
        return $childs;

    }
    
    public function getCategoryChilds($id_category){
        return dibi::query("SELECT * FROM category WHERE id_parent = %i ORDER BY order_category", $id_category)->fetchAll();
    }
    
    public function getCategoryName($id_category){
        return dibi::query("SELECT title FROM category WHERE id_category = %i", $id_category)->fetchSingle();
    }
    
    public function saveNewCategory($id_parent, $name){
        $order = dibi::query("SELECT MAX(order_category) FROM category where id_parent = %i", $id_parent)->fetchSingle();
        dibi::query("INSERT INTO category(id_parent, title, order_category) VALUES(%i, %s, %i)", $id_parent, $name, $order+1);
        return dibi::insertId();
    }
    
    public function editCategory($id_category, $name){
        return (boolean) dibi::query("UPDATE category set title = %s WHERE id_category = %i", $name, $id_category);
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
    
    public function saveNewProduct($data){
        dibi::query("INSERT INTO products", $data);
        return dibi::insertId();
    }
    
    public function editProduct($id_product, $data){
        return (boolean) dibi::query("UPDATE products SET ",$data, " WHERE id_product = %i", $id_product);
    }
    
  
    public function getBreadCrump($id_category){
        $ret = array();
        $category = $this->getCategoryToBreadCrump($id_category);
        array_push($ret, $category);
        
        $parent = $this->getCategoryToBreadCrump($category->id_parent);
        while ($parent){
            if ($parent->id_parent == 0){
                array_push($ret, $parent);
                break;
            }
            array_push($ret, $parent);
            $parent = $this->getCategoryToBreadCrump($parent->id_parent);
        }
        return array_reverse($ret);
        
    }
    
    public function getCategoryToBreadCrump($id_category){
        return dibi::query("SELECT id_category, title, id_parent, url FROM category WHERE id_category = %i", $id_category)->fetch();
    }
    
    public function getCategoryTree($category, $return_only_ids = FALSE){
        
        $tree = array();
        
        if ($return_only_ids)
            array_push($tree, $category->id_category);
        else
            array_push($tree, $category);
        
        $parent = $this->getCategory($category->id_parent);
        if($parent){
            while ($parent->id_parent != 0){
                if ($return_only_ids)
                    array_push($tree, $parent->id_category);
                else
                    array_push($tree, $parent);

                $parent = $this->getCategory($parent->id_parent);
            }
            if ($return_only_ids)
                array_push($tree, $parent->id_category);
            else
                array_push($tree, $parent);
        }
        return  $tree;
        
    }
    
    
    public function getNavigationMenu($root_category, $id_category){
        
        $category = $this->getCategory($id_category);
        $IdsTree = $this->getCategoryTree($category, TRUE);
        
        return $this->printCategories($this->getCategoryAllChilds($root_category), $IdsTree);
        
        
    }
    
    private function printCategories($categories, $IdsTree){
//        echo '<pre>';
//        print_r($categories);
//        print_r($IdsTree);
//        echo '</pre>';
//        die;
        if (!is_null($categories)){
            
            $out = '<ul">';
            foreach ($categories as $cat) {
                if (in_array($cat->id_category, $IdsTree) || in_array($cat->id_parent, $IdsTree)){
                
                    $out .= '<li><a href="/'.$cat->full_url.'">'.$cat->title.'</a>';
                    if (!is_null($cat->childs)){
                        $out .= $this->printCategories($cat->childs, $IdsTree);
                    }
                    $out .= '</li>';
                }
            }
            $out .= '</ul>';
            return $out;
        }
        return '';
    }
    
}


?>