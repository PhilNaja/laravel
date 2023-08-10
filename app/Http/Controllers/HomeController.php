<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\House;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function bill($id)
    {
        try {
            $data['house']=DB::table('houses')->where('email',$id)->get();
            $data['paid']=DB::table('bills')->where('house_id',  $data['house'][0]->id)
            ->where('status', 1)
            ->get();
            return view('compronents.page.user.billuser',$data);
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors($th);
        }
        
    }
    public function adminhome()
    {
        $data['feetotal'] = DB::table('fee_transections')
            ->join('fees', 'fee_transections.fee_id', '=', 'fees.id')
            ->where('fee_transections.billingcycle',date("m-Y"))
            ->selectRaw('SUM(fees.price_unit) as total')
            ->first()
            ->total;
        $data['fine'] = DB::table('fine_transections')
        ->where('billingcycle',date("m-Y"))
        ->sum('amount');
        $data['metre'] = DB::table('metre_transections')
        ->where('billingcycle',date("m-Y"))
        ->sum('amount');
        $data['billamount'] = DB::table('bills')
        ->where('billingcycle',date("m-Y"))
        ->sum('amount');
        $data['billispaid'] = DB::table('bills')
        ->where('ispaid',1)
        ->where('billingcycle',date("m-Y"))
        ->sum('amount');
        $data['billnotpaid'] = DB::table('bills')
        ->where('billingcycle',date("m-Y"))
        ->where('ispaid',0)
        ->sum('amount');
        $data['notpaid'] = DB::table('bills')
        ->where('billingcycle',date("m-Y"))
        ->where('ispaid',0)
        ->count('id');
        $data['ispaid'] = DB::table('bills')
        ->where('billingcycle',date("m-Y"))
        ->where('ispaid',1)
        ->count('id');
        $data['allbill'] = DB::table('bills')
        ->where('billingcycle',date("m-Y"))
        ->count('id');
        $data['house'] = DB::table('houses')
        ->count('id');
        return view('homeadmin',$data);
    }
    public function filterhome(Request $request)
    {
        $data['feetotal'] = DB::table('fee_transections')
            ->join('fees', 'fee_transections.fee_id', '=', 'fees.id')
            ->where('fee_transections.billingcycle',$request->mount."-".$request->year)
            ->selectRaw('SUM(fees.price_unit) as total')
            ->first()
            ->total;
            $data['house'] = DB::table('houses')
            ->count('id');
        $data['fine'] = DB::table('fine_transections')
        ->where('billingcycle',$request->mount."-".$request->year)
        ->sum('amount');
        $data['metre'] = DB::table('metre_transections')
        ->where('billingcycle',$request->mount."-".$request->year)
        ->sum('amount');
        $data['billamount'] = DB::table('bills')
        ->where('billingcycle',$request->mount."-".$request->year)
        ->sum('amount');
        $data['billispaid'] = DB::table('bills')
        ->where('ispaid',1)
        ->where('billingcycle',$request->mount."-".$request->year)
        ->sum('amount');
        $data['billnotpaid'] = DB::table('bills')
        ->where('billingcycle',$request->mount."-".$request->year)
        ->where('ispaid',0)
        ->sum('amount');
        $data['notpaid'] = DB::table('bills')
        ->where('billingcycle',$request->mount."-".$request->year)
        ->where('ispaid',0)
        ->count('id');
        $data['ispaid'] = DB::table('bills')
        ->where('billingcycle',$request->mount."-".$request->year)
        ->where('ispaid',1)
        ->count('id');
        $data['allbill'] = DB::table('bills')
        ->where('billingcycle',$request->mount."-".$request->year)
        ->count('id');
        return view('homeadmin',$data);
    }
}
