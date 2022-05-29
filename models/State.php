<?php  


use Illuminate\Database\Eloquent\Model as Eloquent;


class State extends Eloquent{
    
    public $timestamps = false;
    
    protected $table = 'state';
    

    
    public function shipping(){
        return $this->hasOne(Shipping::class);
    }
    
    
    
}