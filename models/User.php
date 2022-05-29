<?php  

use Illuminate\Database\Eloquent\Model as Eloquent;


class User extends Eloquent{
    
    public function wallet(){
        return $this->hasOne(Wallet::class);
    }
    
    public function fund(){
        return null !== $this->wallet ? $this->wallet->amount : null;  
    }
    
    
     public function state(){
        return $this->belongsTo(State::class);
    }
    
     public function sustractFromWallet($total){
        if ( null !== $this->wallet ) {
            $wallet = Wallet::where('user_id', $this->id)->first();
            $amount = $this->fund() - $total;
            $wallet->amount  = $amount >= 0 ? $amount : 0;
            $wallet->save();
        }
    }
    
}