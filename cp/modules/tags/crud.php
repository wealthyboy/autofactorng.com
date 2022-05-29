<?php 
 require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

if (Input::exists('post')) {

	 $check = Tags::getInstance()->find('product_id',Input::get('product_id'));
       
	
	if (!empty($check)){

		if ($check->tag == Input::get('tag')){
           Tags::getInstance()->update(Input::get('product_id'),[
             'tag'=>0
         ]);
        echo json_encode(['status'=>'Updated!','tag'=>Input::get('tag')]);
        return;
		}
		
        Tags::getInstance()->update(Input::get('product_id'),[
             'tag'=>Input::get('tag')
        ]);
        echo json_encode(['status'=>'Updated!','tag'=>Input::get('tag')]);
         return;
	 } else{
	 	Tags::getInstance()->product_id=Input::get('product_id');
	    Tags::getInstance()->tble_name=Input::get('table');
	    Tags::getInstance()->tag =Input::get('tag');
			if (Tags::getInstance()->Insert()) {
			 echo json_encode(['status'=>'Inserted!','tag'=>Input::get('tag')]);
			   
			}
			 return;
	 }
 
 	

 }

?>