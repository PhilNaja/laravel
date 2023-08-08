<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Type extends Controller
{
    public function  destroymt($id) 
    {
        $data=DB::table('metres')->where('meter_type',$id)->get();
        try {
            if($data=='[]'){
            DB::table('meter_types')->where('id',$id)->delete();
            return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จ');  
        }else{
            return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ เนื่องจากถูกนำไปใช้แล้ว');
        }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ ');
        }
       
    }
    public function  destroyfee($id) 
    {
        $data=DB::table('fee_transections')->where('fee_id',$id)->get();
        try {
            if($data=='[]'){
                DB::table('fees')->where('id',$id)->delete();
            return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จ');  
            }else{
                return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ เนื่องจากถูกนำไปใช้แล้ว');
            }

            
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ ');
        }
       
    }
    public function updatefeetype(Request $request,$id)
    {
        try {
            if($request->price_unit>0){
                DB::table('fees')->where('id', $id)->update([
                    'name'=>$request->name,
                    'price_unit' => $request->price_unit,
                    'updated_at'=>Now(),
                ]);
            return redirect()->back()->with('success', 'อัปเดทข้อมูลสำเร็จ');
        }else{
            return redirect()->back()->withErrors('ห้ามใส่ค่าติดลบ หรือ 0');
        }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('อัปเดทข้อมูลไม่สำเร็จ ');
        }
    }
    public function updatemetertype(Request $request,$id)
    {
        try {
            if($request->price_unit>0){
            DB::table('meter_types')->where('id', $id)->update([
                'name'=>$request->name,
                'price_unit' => $request->price_unit,
                'updated_at'=>Now(),
            ]);
            return redirect()->back()->with('success', 'อัปเดทข้อมูลสำเร็จ');
        }else{
            return redirect()->back()->withErrors('ห้ามใส่ค่าติดลบ หรือ 0');
        }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('อัปเดทข้อมูลไม่สำเร็จ ');
        }

    }
    public function addType(Request $request)
    {
        if($request->type==1){
            try {
                if($request->price_unit>0){
                    DB::table('fees')->insert([
                        'name' => $request->name,
                        'price_unit' => $request->price_unit,
                        'created_at'=>Now(),
                        'updated_at'=>Now(),
                    ]);
                    return redirect()->back()->with('success','เพิ่มข้อมูลสำเร็จ');
                }else{
                    return redirect()->back()->withErrors('Price/Unit ห้ามใส่ค่าติดลบ หรือ 0');
                }
               
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors('เพิ่มข้อมูลไม่สำเร็จ ');
            }
        }elseif($request->type==2){
            try {
                if($request->price_unit>0){
                    DB::table('meter_types')->insert([
                        'name' => $request->name,
                        'price_unit' => $request->price_unit,
                        'created_at'=>Now(),
                        'updated_at'=>Now(),
                    ]);
                    return redirect()->back()->with('success','เพิ่มข้อมูลสำเร็จ');
                }else{
                    return redirect()->back()->withErrors('Price/Unit ห้ามใส่ค่าติดลบ หรือ 0');
                }
               
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors('เพิ่มข้อมูลไม่สำเร็จ ');
            }
        }else{
            return redirect()->back()->withErrors('เพิ่มข้อมูลไม่สำเร็จ ');
        }
        return redirect()->back()->withErrors('เพิ่มข้อมูลไม่สำเร็จ ');
        
    }
    public function addmeter(Request $request)
    {
        try {
            if($request->price_unit>0){
                DB::table('meter_types')->insert([
                    'name' => $request->name,
                    'price_unit' => $request->price_unit,
                    'created_at'=>Now(),
                    'updated_at'=>Now(),
                ]);
                return redirect()->back()->with('success','เพิ่มข้อมูลสำเร็จ');
            }else{
                return redirect()->back()->withErrors('Price/Unit ห้ามใส่ค่าติดลบ หรือ 0');
            }
           
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('เพิ่มข้อมูลไม่สำเร็จ ');
        }
    }
}
