<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Metre extends Controller
{
    public function updatemeter(Request $request,$id)
    {
        $data=DB::table('metres')->where('id', $id)->get();
        try {
            if($data[0]->unit<$request->unit){
                DB::table('metres')->where('id', $id)->update([
                    'unit' => $request->unit,
                    'updated_at'=>Now(),
                ]);
                $date= date('m-Y');
                $data = DB::table('metre_transections')
                ->where('billingcycle',$date)->where('metre_id',$id)->get();
                if($data!='[]'){
                    DB::table('metre_transections')->where('id', $data[0]->id)->update([
                        'amount'=>($request->unit-$data[0]->unit)*$data[0]->price_unit,
                        'unit'=>$request->unit,
                        'pre_unit'=>$data[0]->unit,
                        'updated_at'=>Now(),
                    ]);
                } 

            }else{
                return redirect()->back()->withErrors('ค่าที่ใส่มาน้อกว่าหรือเท่ากับ Unit ปัจจุบัน');
            }
            
            return redirect()->back()->with('success', 'อัปเดทข้อมูลสำเร็จ');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('อัปเดทข้อมูลไม่สำเร็จ ');
        }
        
    }
    public function meter(Request $request)
    {
        try {
            $id =random_int(100, 999).date('mY');
        DB::table('metres')->insert([
            'id'=>$id,
            'house_id' => $request->house_id,
            'unit' => $request->unit,
            'meter_type' => $request->meter_id,
            'status' => true,
            'created_at'=>Now(),
            'updated_at'=>Now(),
        ]);
        $data = DB::table('meter_types')
        ->where('id', $request->meter_id)
        ->select('price_unit')->get(); 
        DB::table('metre_transections')->insert([
            'metre_id' => $id,
            'price_unit' => $data[0]->price_unit,
            'amount'=>0,
            'unit'=>$request->unit,
            'pre_unit'=>$request->unit,
            'billingcycle'=>date('m-Y'),
            'created_at'=>Now(),
            'updated_at'=>Now(),
        ]);
        return redirect()->back()->with('success','เพิ่มข้อมูลสำเร็จ');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('เพิ่มข้อมูลไม่สำเร็จ ');
        }
    }
    public function  destroymetre(Request $request) 
    {
        try {
            $data['total']=DB::table('metre_transections')->where('metre_id',$request->id
        )
        ->where('bill_id',null)
        ->count();
        $data['null']=DB::table('metre_transections')->where('metre_id',$request->id
        )
        ->where('bill_id',null)
        ->get();
        if($data['null']!='[]'&&$data['total']==1){
            DB::table('metres')->where('id',$request->id)->delete();
            DB::table('metre_transections')->where('metre_id',$request->id)->delete();
            return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จ');  
        }else{
            return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ');
        }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ');
        }
       
    }
    public function metreon(Request $request) 
    {

        try {
                DB::table('metres')->where('id',$request->id)->update([
                    'status'=>true,
                ]);
                return redirect()->back()->with('success','มิเตอร์หมายเลข '.$request->id.' ถูกเปิดใช้งานแล้ว');

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('xxx');
        }
       
    }
    public function metreoff(Request $request) 
    {

        try {
                DB::table('metres')->where('id',$request->id)->update([
                    'status'=>false,
                ]);
                return redirect()->back()->withErrors('มิเตอร์หมายเลข '.$request->id.' ถูกปิดใช้งานแล้ว');

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้งค่ะ');
        }
       
    }
}
