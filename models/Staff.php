<?php  


use Illuminate\Database\Eloquent\Model as Eloquent;


class Staff extends Eloquent{
    
    protected $table = 'staff';
    
    public $timestamps = false;
    
    
     public function user(){
        return $this->belongsTo(User::class);
    }
}