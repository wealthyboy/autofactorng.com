<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



require_once $_SERVER["DOCUMENT_ROOT"].'/init/init.php';
$request = \Illuminate\Http\Request::capture();

if ($request->isMethod('get')) { 
    $shipping = Shipping::find($request->query('id'));
    if ($shipping){
         $shipping->delete();
         exit(header('Location: https://autofactorng.com/cp/index.php?p=shipping'));
    }
    exit(header('Location: https://autofactorng.com/cp/index.php?p=shipping'));

}

   
if ($request->isMethod('post')) { 
        $shipping = new Shipping;
        $shipping->price =  $request->price;
        $shipping->state_id =  $request->state_id;
        $shipping->save();
        exit(header('Location: https://autofactorng.com/cp/index.php?p=shipping'));
}

?>