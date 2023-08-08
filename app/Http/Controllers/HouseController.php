<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\House;
use App\Models\Bill;
use Illuminate\Support\Facades\Hash;

class HouseController extends Controller
{
    public function store(Request $request) {
        $data=DB::table('houses')->where('housenumber',$request->housenumber,)->get();
        $email=DB::table('users')->where('email',$request->email)->get();
        try {
            if($data=='[]'){
                if($email=='[]'){
                    $request->validate([
                        'housenumber' => 'required',
                    ]);
                    $data= DB::table('houses')->insert([
                        'housenumber' => $request->housenumber,
                        'owner' => $request->owner,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'created_at'=>Now(),
                        'updated_at'=>Now(),
            
                    ]);
                    DB::table('users')->insert([
                        'name' => $request->owner,
                        'email' => $request->email,
                        'password' => Hash::make('thenineteen'),
                        'created_at'=>Now(),
                        'updated_at'=>Now(),
                    ]);
                    return redirect()->back()->with('success', 'เพิ่มข้อมูลสำเร็จ');
                }else{
                    return redirect()->back()->withErrors('Email นี้ถูกใช้ไปแล้ว');
                }
                
            }else{
                return redirect()->back()->withErrors('บ้านเลขที่นี้ถูกใช้ไปแล้ว');
            }
           
        } catch (\Exception $e) {
            return redirect()->back()->withErrors('เพิ่มข้อมูลไม่สำเร็จ');
        }
    }
    public function update(Request $request, $id) {
        try {
            $request->validate([
                'housenumber' => 'required',
            ]);
            $data= DB::table('houses')->where('id', $id)->update([
                'housenumber' => $request->housenumber,
                'owner' => $request->owner,
                'email' => $request->email,
                'phone' => $request->phone,
                'updated_at'=>Now(),
    
            ]);
            return redirect()->back()->with('success', 'อัปเดทข้อมูลสำเร็จ');
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('อัปเดทข้อมูลไม่สำเร็จ ');
        }
    }
    public function  destroy(Request $request) 
    {
        try {
            $data['bill']=DB::table('bills')->where('house_id',$request->id)->get();
            $data['metre']=DB::table('metres')->where('house_id',$request->id)->get();
            $data['debt']=DB::table('debts')->where('house_id',$request->id)->get();
            if($data['bill']=='[]'&&$data['metre']=='[]'&&$data['debt']=='[]'){
                $delete= House::find($request->id)->delete();
                return redirect()->back()->with('success', 'ลบข้อมูลสำเร็จ');  
            }else{
                return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ ');
            }
            
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('ลบข้อมูลไม่สำเร็จ ');
        }
       
    }
    public function detail($id)
    {
        $date = date('m-Y');
        $data['house'] = DB::table('houses')->join('bills','houses.id','=','bills.house_id')->
        where('bills.id', $id)->get();  
        $data['metre'] = DB::table('metre_transections')->
        join('metres','metre_transections.metre_id','=','metres.id')->
        join('meter_types','metres.meter_type','=','meter_types.id')->
        where('bill_id', $id)->get();
        $data['fee'] = DB::table('fee_transections')->
        join('fees','fee_transections.fee_id','=','fees.id')->
        where('fee_transections.bill_id', $id)->get();
        $data['debt'] = DB::table('debts')->
        join('bills','debts.house_id','=','bills.house_id')->
        where('bills.id', $id)->get();
        $data['fine'] = DB::table('fine_transections')->
        join('bills','fine_transections.bill_id','=','bills.id')->
        where('fine_transections.bill_id', $id)->
        select('fine_transections.amount as amount')
        ->get();
        $data['bill'] = DB::table('bills')
        ->where('ispaid', 0)
        ->whereNotIn('billingcycle', [$date])
        ->whereNotIn('id', [$id])
        ->get();
        
        return view('compronents.page.detail',$data);
    }
    public function filterhouse(Request $request)
    {
        $data['debt'] =  DB::table('debts')
        ->where('house_id','1')->get();
        $data['houses'] = DB::table('houses')
        ->where('housenumber','like','%'.$request->housenumber.'%')
        ->paginate(6);  
        return view('compronents.page.tablehouse',$data);
    }
}
