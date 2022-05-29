<?php 
      require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

if (Input::exists('get') && Input::get('value')) {

     $model =  Cars::getInstance()->find_by_id(Input::get('model_id'));

     $year_to_delete = explode(',', $model->year);

    
     $key = array_search(Input::get('value'),$year_to_delete);
     if($key == 0 || $key >0){
         $new_year = array_splice($year_to_delete, $key);
         Cars::getInstance()->update(Input::get('model_id'),[
         'year'=>implode(',',$year_to_delete)
         ]);

         (new Redirect())->back();
     }
     

}
