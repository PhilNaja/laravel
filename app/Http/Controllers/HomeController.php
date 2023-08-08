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
            ->selectRaw('SUM(fees.price_unit) as total')
            ->first()
            ->total;
        $data['debt'] = DB::table('debts')
        ->sum('total_balance');
        $data['metre'] = DB::table('metre_transections')
        ->sum('amount');
        $data['billamount'] = DB::table('bills')
        ->sum('amount');
        $data['billispaid'] = DB::table('bills')
        ->where('ispaid',1)
        ->sum('amount');
        $data['billnotpaid'] = DB::table('bills')
        ->where('ispaid',0)
        ->sum('amount');
        $data['notpaid'] = DB::table('bills')
        ->where('ispaid',0)
        ->count('id');
        $data['ispaid'] = DB::table('bills')
        ->where('ispaid',1)
        ->count('id');
        $data['allbill'] = DB::table('bills')
        ->count('id');
        return view('homeadmin',$data);
    }
}
