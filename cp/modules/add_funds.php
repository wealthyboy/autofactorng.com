<?php 

require_once $_SERVER["DOCUMENT_ROOT"].'/init/init.php';
$request = \Illuminate\Http\Request::capture();

   
if ($request->isMethod('post')) { 
    
    $wallet = Wallet::where('user_id', $request->query('id'))->first();
    
    if (null !== $wallet ){
        if ($request->type == true){
           $amount  = $request->amount +  $wallet->amount;
        } else {
          $amount  = $wallet->amount - $request->amount ;
        }
        $wallet->amount  = $amount > 0 ? $amount : 0;
        $wallet->save();
        exit(header('Location: https://autofactorng.com/cp/index.php?p=users'));
    } else {
        $wallet = new Wallet;
        $wallet->amount =  $request->amount;
        $wallet->user_id =  $request->query('id');
        $wallet->save();
        exit(header('Location: https://autofactorng.com/cp/index.php?p=users'));
    }
   // return header('https://stage.autofactorng.com/cp/index.php?p=users');
}

?>