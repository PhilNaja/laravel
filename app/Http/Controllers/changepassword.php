<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class changepassword extends Controller
{
    public function showChangePasswordForm()
    {
        return view('compronents.page.changepassword');
    }

    public function changePassword(Request $request)
    {

        $user = DB::table('users')->where('id',$request->user_id)->get();

        if (Hash::check($request->current_password, $user[0]->password)) {
            DB::table('users')->where('id',$request->user_id)->update([
                'password' => Hash::make($request->password)
            ]  
            );
            return redirect()->back()->with('success', 'อัปเดทข้อมูลสำเร็จ');
        }

        // $user->update([
        //     'password' => Hash::make($request->password),
        // ]);

        // return redirect()->route('password.change')->with('success', 'Password changed successfully.');
    }
}
