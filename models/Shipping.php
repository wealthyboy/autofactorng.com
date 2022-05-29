<?php  


use Illuminate\Database\Eloquent\Model as Eloquent;


class Shipping extends Eloquent{
    
    protected $table = 'shipping';
    
    public $timestamps = false;
    
    
     public function state(){
        return $this->belongsTo(State::class);
    }
}