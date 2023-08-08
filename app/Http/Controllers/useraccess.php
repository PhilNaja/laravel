<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class useraccess extends Controller
{

    public function updaterole(Request $request){
        try {
            DB::table('users')->where('id',$request->id)->update([
                'role'=>$request->role,
            ]);   
            return redirect()->back()->with('success', 'แก้ไขข้อมูลสำเร็จ');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('ไม่สามารถแก้ไขข้อมูลได้');
        }
    }
    public function create(Request $request)
    {
        $data=DB::table('users')->where('email',$request->email)->get();
        try {
            if($data=='[]'){
                DB::table('users')->insert([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role'=>'0',
                    'password' => Hash::make($request->password),
        
                ]);
                return redirect()->back()->with('success','สำเร็จ');
            }else{
                return redirect()->back()->withErrors('Email นี้ถูกใช้ไปแล้ว');
            }
            
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('ไม่สามารถแก้ไขข้อมูลได้');
        }
        
    }
}
