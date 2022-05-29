<?php  
require_once 'class.db.php';

  class Deals extends DB{

    public $deal_id;
    public $deal_value;
    public $valid_to;
    public $cat_id;
    public $sub_cat_id;
    public $product_id;
    public $tble_name ;

    protected $table_name='deals';
    protected static $_instance;
    public  $errors=[];  

    public static function allProductDeals(){
        $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE deal_type ='single' ");
        return  $result;
    }



    public static function dealIsPresentInSubcat($sub_cat_id){
        $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE sub_cat_id = '{$sub_cat_id}' AND deal_type ='sub_category' LIMIT 1");
        return  !empty($result) ? true : false;
    }

    public static function deleteProductInSubCat($sub_cat_id){
        $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE sub_cat_id = '{$sub_cat_id}' AND deal_type ='single' LIMIT 1");
        if (!empty($result) ){
           $result = array_shift($result);
           Deals::getInstance()->delete('id', $result->id);
          
        }
        return  false;
    }
    public static function  allSubCatProductDeals(){
      $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE deal_type ='multiple_product' ");
      return  !empty($result) ?   $result : false;
    }

    public static function RemoveExpiredProductDeals(){
      $products = Deals::allSubCatProductDeals();
      if(!empty($products)){
        foreach ($products as $product) {  
            if($product->valid_to < date('Y-m-d')){
                  Deals::getInstance()->destroy($product->id);  
                  return true;
            } 
          }
      }
      
       return false;
    }

    public static function productHasDeal($product_id){
        $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE product_id = '{$product_id}' AND  deal_type ='single' LIMIT 1");
         return  !empty($result) ? true : false;
    }
    public static function getCyberSaleDeals($product_id){
        $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE product_id = '{$product_id}' AND  deal_type ='cybersale'  ");
         return  !empty($result) ?  array_shift($result) : false;
    }
    public static function getCatDeals($id){
        $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE cat_id = '{$id}' AND  deal_type ='sub_category'  ");
         return  !empty($result) ?  array_shift($result) : false;
    }

    public static function getSubCatDeals($id){
        $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE sub_cat_id = '{$id}' AND  deal_type ='sub_category'  ");
         return  !empty($result) ?  array_shift($result) : false;
    }
    //This pattern is not really good
    public static function getProductsDeal($id,$product_name){
         $prod_name = '';
        if(preg_match("~\bfor\b~",$product_name)){
           $prod_name = explode('for',$product_name);
           $prod_name = rtrim($prod_name[0],' '); 

           $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE sub_cat_id = '{$id}' AND  deal_type ='multiple_product' AND product_name ='{$prod_name}' ");

            return  !empty($result) ?  array_shift($result) : false; 

        } 
            $prod_name = explode(' ',$product_name);
            $prod_name = rtrim($prod_name[0],' '); 

            $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE sub_cat_id = '{$id}' AND  deal_type ='multiple_product' AND  product_name ='{$prod_name}'
            ");

             return  !empty($result) ?  array_shift($result) : false; 

            $prod_name = explode(' ',$product_name);
            $prod_name = rtrim($prod_name[0].' '.$prod_name[1],' '); 

            $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE sub_cat_id = '{$id}' AND  deal_type ='multiple_product' AND  product_name ='{$prod_name}'
            ");

             return  !empty($result) ?  array_shift($result) : false; 

        
        
        
        
        return   false;
    }

    public static function getProductDeal($id){
        $result = DB::getInstance()->run_sql("SELECT * FROM deals WHERE product_id = '{$id}' AND  deal_type ='single' ");
        return  !empty($result) ?  array_shift($result) : false;
    }



}