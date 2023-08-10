<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class bill extends Controller
{
    public function  destroybill(Request $request) 
    {
        try {
            $data['bill']=DB::table('bills')->where('id',$request->id)
            ->where('status',0)
            ->get();
            if($data['bill']!='[]'){
                DB::table('bills')->where('id',$request->id)->delete();
                return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จ');  
            }else{
                return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ ');
            }
            
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ ');
        }
        return back();  
    }
    public function addbill(Request $request){
        try {
            $house = DB::table('houses')->get();
            $checkbefore=DB::table('bills')->where('billingcycle' ,date('m-Y'))->get();
                    foreach($house as $item){
                        $total = 0;
                        $id=$item->id.date('mY');
                             $data = DB::table('metres')
                             ->join('metre_transections','metres.id','=','metre_transections.metre_id')
                             ->where('metres.house_id',$item->id)
                             ->where('metre_transections.bill_id',null)
                             ->select('metre_transections.id as id','metre_transections.amount as amount')->get();
                             $fee =  DB::table('fees')
                             ->get();
                             if($data!='[]'){
                                 foreach($data as $metre){
                                     $total+=$metre->amount;
                                     DB::table('metre_transections')->where('id', $metre->id)->update([
                                         'bill_id'=>$id,
                                         'updated_at'=>Now(),
                                     ]);
                                 }    
                             }else{
                                 $date='0'.(date('m')-1).date('-Y');
                                 $mtdata = DB::table('metres')
                                 ->join('metre_transections','metres.id','=','metre_transections.metre_id')
                                 ->where('metres.house_id',$item->id)
                                 ->where('metre_transections.billingcycle','0'.(date('m')-1).date('-Y'))
                                 ->select('metres.id as id','metres.unit as unit'
                                 ,'metre_transections.unit as pre_unit','metre_transections.pre_unit as old_unit'
                                 ,'metre_transections.amount as amount')
                                 ->get();
                                 if($mtdata!='[]'){
                                     foreach($mtdata as $mt){
                                         $total+=($mt->unit-$mt->pre_unit)*($mt->amount/($mt->pre_unit-$mt->old_unit));
                                         DB::table('metre_transections')->insert([
                                             'metre_id' => $mt->id,
                                             'bill_id'=>$id,
                                             'price_unit' =>$mt->amount/($mt->pre_unit-$mt->old_unit),
                                             'amount'=>($mt->unit-$mt->pre_unit)*($mt->amount/($mt->pre_unit-$mt->old_unit)),
                                             'unit'=>$mt->unit,
                                             'pre_unit'=>$mt->pre_unit,
                                             'billingcycle'=>date('m-Y'),
                                             'created_at'=>Now(),
                                             'updated_at'=>Now(),
                                         ]);
                                     } 
                                 }   
                             }
                             if($fee!='[]'){
                                foreach($fee as $fee){
                                    $total+=$fee->price_unit;
                            DB::table('fee_transections')->insert([
                                'fee_id'=>$fee->id,
                                'house_id' => $item->id,
                                'bill_id'=>$id,
                                'billingcycle' => date('m-Y'),
                                'created_at'=>Now(),
                                'updated_at'=>Now(),
                            ]);}
                            }
                        DB::table('bills')->insert([
                        'id'=>$id,
                        'house_id' => $item->id,
                        'amount' => $total,
                        'billingcycle' => date('m-Y'),
                        'status' => false,
                        'ispaid'=>false,
                        'created_at'=>Now(),
                        'updated_at'=>Now(),
                    ]);
                    $data=[];
                    $total=0;
                }
                
                    
                    
    
            return redirect()->back()->with('success','เพิ่มข้อมูลสำเร็จ');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('เพิ่มข้อมูลไม่สำเร็จ');
        }
 
    }
    public function fine(Request $request,$id)
    {
        try {
            if($request->amount>0){
                $data = DB::table('bills')->where('id', $id)->get();
            DB::table('fine_transections')->insert([
                'house_id' => $data[0]->house_id,
                'bill_id'=>$id,
                'amount'=>$request->amount,
                'billingcycle' => date('m-Y'),
                'created_at'=>Now(),
                'updated_at'=>Now(),
            ]);
            DB::table('bills')->where('id', $id)->update([
                'amount'=>$data[0]->amount+$request->amount,
                'updated_at'=>Now(),
            ]);
            return redirect()->back()->with('success','เพิ่มข้อมูลสำเร็จ');
            }else{
                return redirect()->back()->withErrors('ห้ามใส่ค่าติดลบ หรือ 0');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('เพิ่มข้อมูลไม่สำเร็จ');
        }
        
    }
    public function  billstatus(Request $request) 
    {
        try {
            DB::table('bills')->where('id',$request->id)->update([
                'status'=>true,
            ]);
            return redirect()->back()->with('success','บิลหมายเลข '.$request->id.' ถูกเผยแพร่แล้ว');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ');
        }
       
    }
    public function filterbill(Request $request)
    {
        $data['data'] = DB::table('bills')->where('billingcycle',$request->mount."-".$request->year)->get();  
        $data['billingcycle'] = DB::table('bills')->select('billingcycle')->distinct()->get();
        $data['houses'] = DB::table('houses')->get();  
        return view('compronents.page.bill',$data);
    }

}
