<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\bill;
use App\Http\Controllers\useraccess;
use App\Http\Controllers\Debt;
use App\Http\Controllers\Metre;
use App\Http\Controllers\Type;
use App\Http\Controllers\Navbar;
use App\Http\Controllers\changepassword;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/change', [changepassword::class, 'showChangePasswordForm'])->name('password.change');
Route::post('/change-password', [changepassword::class, 'changePassword'])->name('password.update');
Route::POST('/sreach',[HouseController::class,'sreach'])->middleware('verified');
Route::get('billuser/{id}', [HomeController::class, 'bill']);
//user
Route::get('/detail/{id}',[HouseController::class,'detail']);
Route::get('/', function () {
    return view('auth.login');
});
Auth::routes(['verify'=>true]);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/changePW',[Navbar::class,'changePW']);
    Route::post('password', [Navbar::class, 'password_action'])->name('password.action');
    Route::middleware(['role'])->group(function(){
        //1stpage
        Route::get('admin/home', [HomeController::class, 'adminhome'])->name('admin.home');
        Route::get('/filterhome',[HomeController::class,'filterhome']);
    
    
        // Route::get('data',[HomeController::class,'index']);
        // Route::get('/edit/{id}',[HouseController::class,'edit']);
        // Route::get('/destroybill/{id}',[HouseController::class,'destroybill']);  
        // Route::get('/metretypepage',[bill::class,'metretypepage']);
        // Route::get('/feetype',[bill::class,'feetype']);
       
        
       
        
       
        
        //navbar
        Route::match(['get', 'post'],'/userpage',[Navbar::class,'userpage']);
        Route::get('/debtpage',[Navbar::class,'debtpage']);
        Route::get('/houselist',[Navbar::class,'houselist']);
        Route::get('/bill',[Navbar::class,'bill']);
        Route::get('/typepage',[Navbar::class,'type']);
        Route::match(['get', 'post'],'/metrepage',[Navbar::class,'meterpage']);
       
        //type
        Route::put('/updatefeetype/{id}',[Type::class,'updatefeetype']);
        Route::get('/destroyfee/{id}',[Type::class,'destroyfee']);
        Route::get('/destroymt/{id}',[Type::class,'destroymt']);
        Route::post('/addtype',[Type::class,'addtype']);
        Route::match(['get', 'post'],'/addmeter',[Type::class,'addmeter']);
        Route::put('/updatemetertype/{id}',[Type::class,'updatemetertype']);
    
        //house
        Route::get('/destroy',[HouseController::class,'destroy']);
        Route::put('/update/{id}',[HouseController::class,'update']);
        Route::post('addhome',[HouseController::class,'store']);
        Route::get('/filterhouse',[HouseController::class,'filterhouse']);
        
        
        //metre
        Route::get('/destroymetre',[Metre::class,'destroymetre']);
        Route::get('/metreon',[Metre::class,'metreon']);
        Route::get('/metreoff',[Metre::class,'metreoff']);
        Route::put('/updatemeter/{id}',[Metre::class,'updatemeter']);
        Route::post('/meter',[Metre::class,'meter']);
        
        //debt
        Route::get('/destroydebt',[Debt::class,'destroydebt']);
        Route::post('/updatedebt/{id}',[Debt::class,'updatedebt']);
        Route::post('/debt',[Debt::class,'debt']);
        Route::get('/filterdebtpage',[Debt::class,'filterdebtpage']);
        
        
        //bill
        Route::post('/addbill',[bill::class,'addbill']);
        Route::post('/fine/{id}',[bill::class,'fine']);
        Route::get('/billstatus',[bill::class,'billstatus']);
        Route::get('/destroybill',[bill::class,'destroybill']);
        Route::get('/filterbill',[bill::class,'filterbill']);
        
        
    
        //user
        Route::post('/create',[useraccess::class,'create']);
        Route::get('/updaterole',[useraccess::class,'updaterole']);
        Route::get('/usersreach',[useraccess::class,'usersreach']);
        

        
        
        
    });
    
});
