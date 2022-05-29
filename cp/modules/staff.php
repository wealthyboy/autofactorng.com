<?php 

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);



require_once $_SERVER["DOCUMENT_ROOT"].'/init/init.php';
$request = \Illuminate\Http\Request::capture();

if ($request->isMethod('get')) { 
    
    

    $staff = Staff::find($request->query('id'));
    if ($staff){
         $staff->delete();
         exit(header('Location: https://autofactorng.com/cp/index.php?p=staff'));
    }
    exit(header('Location: https://autofactorng.com/cp/index.php?p=staff'));
    

}

   
if ($request->isMethod('post')) { 
    
    
    if ($request->query('edit')) { 
        $staff = Staff::find($request->query('id'));
        $staff->name =  $request->full_name;
        $staff->phone =  $request->phone_number;
        $staff->role =  $request->role;
        $staff->address =  $request->address;
        $staff->save();
        exit(header('Location: https://autofactorng.com/cp/index.php?p=staff'));
    } else  {
        $staff = new Staff;
        $staff->name =  $request->full_name;
        $staff->phone =  $request->phone_number;
        $staff->role =  $request->role;
        $staff->address =  $request->address;
        $staff->save();
        exit(header('Location: https://autofactorng.com/cp/index.php?p=staff'));
    }
}

?>