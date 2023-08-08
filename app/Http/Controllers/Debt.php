<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Debt extends Controller
{
    public function  destroydebt(Request $request) 
    {
        try {
            if($request->balance==0){
            DB::table('debts')->where('id',$request->id)->delete();
            return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จ');  
        }else{
            return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ');
        }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ');
        }
       
    }
    public function updatedebt(Request $request,$id)
    {
        try {
            $data = DB::table('debts')->where('id', $id)
        ->get(); 
        if($data[0]->total_balance>=$data[0]->balance+$request->balance&&$request->balance!=0){
            DB::table('debts')->where('id', $data[0]->id)->update([
                'balance'=>$data[0]->balance+$request->balance,
                'updated_at'=>Now(),
            ]);
            DB::table('debt_transections')->insert([
                'debt_id'=>$id,
                'bill_id'=>$data[0]->id,
                'billingcycle' => date('m-Y'),
                'created_at'=>Now(),
                'updated_at'=>Now(),
            ]);
            return redirect()->back()->with('success', 'อัปเดทข้อมูลสำเร็จ');

        }else{
            return redirect()->back()->withErrors('อัปเดทข้อมูลไม่สำเร็จ(เนื่องจากจ่ายเงินเกินหนี้ หรือ ใส่เลข 0)');
        }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('อัปเดทข้อมูลไม่สำเร็จ ');
        }
        
    }
    public function debt(Request $request){
        $data=DB::table('debts')->where('house_id' , $request->house_id,)->get();
        try {
            if($data=='[]'){
                DB::table('debts')->insert([
                    'house_id' => $request->house_id,
                    'total_balance' => $request->amount,
                    'balance'=>0,	
                    'note' => $request->note,
                    'created_at'=>Now(),
                    'updated_at'=>Now(),
                ]);
                return redirect()->back()->with('success','เพิ่มข้อมูลสำเร็จ');
            }else{
                return redirect()->back()->withErrors('บ้านหลังสร้างหนี้ย้อนหลังไปแล้ว');
            }

        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('เพิ่มข้อมูลไม่สำเร็จ ');
        }
    }
}
