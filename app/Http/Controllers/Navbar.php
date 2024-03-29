<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Navbar extends Controller
{
    public function userpage(){
        $data['users'] = DB::table('users')->paginate(6);  
        return view('compronents.page.useraccess',$data);
    }
    public function meterpage() 
    {   
        $data['houses'] = DB::table('houses')->get(); 
        $data['metre'] = DB::table('metres')
        ->join('meter_types','metres.meter_type','=','meter_types.id')
        ->join('houses','metres.house_id','=','houses.id')
        ->select('metres.unit','metres.status','metres.updated_at','meter_types.name','meter_types.price_unit','metres.id as id','houses.housenumber as house_id')->get(); 
        $data['type'] = DB::table('meter_types')->get();  
        return view('compronents.page.metre',$data);
    }
    public function houselist()
    {
        $data['debt'] =  DB::table('debts')
        ->where('house_id','1')->get();
        $data['houses'] = DB::table('houses')->paginate(6);  
        return view('compronents.page.tablehouse',$data);
    }
    public function bill()
    {
        $data['data'] = DB::table('bills')->where('billingcycle',date('m-Y'))->get();  
        $data['billingcycle'] = DB::table('bills')->select('billingcycle')->distinct()->get();
        $data['houses'] = DB::table('houses')->select('id')->get();  
        return view('compronents.page.bill',$data);
    }
    public function debtpage()
    {
        $data['house']=DB::table('houses')->get();
        $data['debt']=DB::table('debts')
        ->join('houses','debts.house_id','=','houses.id')
        ->select('debts.id','houses.housenumber','debts.total_balance','debts.balance','debts.note')
        ->paginate(6);
        return view('compronents.page.debt',$data);
    }
    public function type()
    {
        $data['fee']=DB::table('fees')->get();
        $data['meter_type']=DB::table('meter_types')->get();
        return view('compronents.page.type',$data);
    }
    public function changePW()
    {
        return view('compronents.page.changepassword');
    }
    public function password_action(Request $request)
    {
        $request->validate([
            'old_password' => 'required|current_password',
            'new_password' => 'required|confirmed',
        ]);
        $user = User::find(Auth::id());
        $user->password = Hash::make($request->new_password);
        $user->save();
        $request->session()->regenerate();
        return back()->with('success', 'Password changed!');
    }
}
