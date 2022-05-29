<?php 
require_once 'class.db.php';
require_once $_SERVER["DOCUMENT_ROOT"].'/init/autoload.php';

class Banner  extends DB { 
	
	public $banner_id;
	public $title;
	public $link;
	public $sort_order;
	public $image;
	public $msg;
	public $fielde ='banner_id';
	
	protected $table_name='banner';
	protected static $_instance;
	public  $errors=[];
	
	public function find_by_id($id){
		return $this->find('banner_id', $id);
	}
	
	public function all($col=[]){
		 
		if (!$col) {
			return $result = $this->run_sql("SELECT * FROM ".$this->table_name ." ORDER BY sort_order asc");
		}
	
		if (!empty($col)) {
			return $result = $this->run_sql("SELECT ".implode(', ', $col)."FROM ".$this->table_name."ORDER BY sort_order asc");
		}
	
	}
	
	
	public function edit(){
		
	
	}
	public function save(){
		
		if (Input::exists('post')) {
			
			$banner = new Banner();
			
			
			
			$file = (new Input())->File('image');
			
			if($file->hasFile('image')){
			
				if(getimagesize($file->TmpName()) === false ){
					$this->errors[]  ='The File You Are Trying To Upload Is Not An Image!!!';
					return false;
				}else if($file->FileSize() > 1500000){
					$this->errors[]  ='The File You Are Trying To Upload Is Too Big!!!';
					return false;
				}
			}
			
			if (Input::get('banner_id') ) {
           	   $image = $file->FileName() ? $file->FileName() : Input::get('file_in_database') ;
           	   
				$this->update(Input::get('banner_id'), [
						'title'=>Input::get('title'),
						'link'=>Input::get('link'),
						'sort_order'=>Input::get('sort_order'),
						'image'=>$image 
				]);
				if ( $image) { 
					$file->move();
				}
				
			    $this->msg = "Banner Updated";
				return true;
			
			}
			
			$banner->title=Input::get('title');
			$banner->link=Input::get('link');
			$banner->sort_order=Input::get('sort_order');
			$banner->image=$file->FileName();
			$file->move();
			if ($banner->Insert()) {
				$this->msg="Banner Created";
				return true;
			}
			
		}
		
		return  false;
	}
	
}







?>