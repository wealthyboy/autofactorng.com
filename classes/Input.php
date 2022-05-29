<?php class Input{
    
	

	protected $originalFileName;
	protected $originalTmpName;
	protected $originalFileSize;
	protected $originalFileType;
	
	protected  $dir = '/images/banner/';
	
    public static function exists($type = 'post'){
   
    switch($type){
    case 'post':
    return (!empty($_POST)) ? true : false;
    break;
    case 'get':
    return (!empty($_GET)) ? true : false;
    break;
    default:
    return false;
    break;
   
       }
    }
    public static function get($item){
        if(!empty($_POST[$item])){
            return $_POST[$item];           
        }else if(!empty($_GET[$item])){
            return $_GET[$item];
           
         }       
        return '';
      }
     
     public function File($file){
     
     	$this->originalFileName = basename($_FILES[$file]["name"]);
     	$this->originalTmpName = $_FILES[$file]["tmp_name"];
     	$this->originalFileSize = $_FILES[$file]["size"];
     	$this->originalFileType = $_FILES[$file]["type"];
     	
     	
     	return $this;
     
     }
      
      public function move(){
      	
      	if (move_uploaded_file($this->originalTmpName, $_SERVER['DOCUMENT_ROOT'].'/'.$this->dir.$this->originalFileName)) {
      		return  true;
      	}
      	 return false;
      }
     
      public function FileName(){
      	return $this->originalFileName;
      }
      public function TmpName(){
      	return $this->originalTmpName;
      }
      public function FileSize(){
      	return $this->originalFileSize;
      }
      public function FileType(){
      	return $this->originalFileType;
      }
      /**
       * Determine if the uploaded data contains a file.
       *
       * @param  string  $key
       * @return bool
       */
      public function hasFile($key)
      { 
      	if ( !empty($_FILES[$key]['name'])){ 
      		return  true;
      		
      	}
      	
      	 return false;
      	
      }
      
      public function isFile (){
      	
      	$check = getimagesize($this->originalTmpName);
      	if($check !== false) {
      		return true;
      	
      	 
      	return false;
      }
     
   
  }   
   

}


 ?>