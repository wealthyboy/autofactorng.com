<?php  


use Illuminate\Database\Eloquent\Model as Eloquent;


class Wallet extends Eloquent{
    
    protected $table = 'wallet';
    
    
     public function user(){
        return $this->belongsTo(User::class);
    }
}