<?php

namespace App\Http\Controllers\Backend;

use App\Library\Helper;
use App\Library\Notify;    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Auth;
use Hash;
use Illuminate\Support\Arr;
use Carbon\Carbon;

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
    public function index(Request $request) {
        if((isset(Auth::user()->id))){
            $roles = Role::where("status","!=","delete")->get();

            return view('backend.dashboard', compact('roles'));
                
         
        }else {
            // Redirect to login
            return redirect()->route('login');
        }
    }
    public function changePassword(Request $request) {
    if ($request->isMethod('post')) {
        $user = Auth::user();
        if ($user) {
            if (Hash::check($request->input('old-pass'), $user->password)) {
                if ($request->input('pass') != $request->input('old-pass')) {
                    if ($request->input('pass') == $request->input('confirm-pass')) {
                        $user->password = Hash::make($request->input('pass'));
                        if ($user->save()) {
                            Auth::logout(); // Logout the user after changing the password.
                            $request->session()->flash('success', 'Password changed successfully. Please login again.');
                            return redirect('/admin');
                        } else {
                            $request->session()->flash('error', 'Password not changed! Try again later.');
                            return view('backend.changepassword');
                        }
                    } else {
                        $request->session()->flash('error', 'Passwords do not match.');
                        return view('backend.changepassword');
                    }
                } else {
                    $request->session()->flash('error', 'Please add diffrent password old password and new password same.');
                    return view('backend.changepassword');
                }
            } else {
                $request->session()->flash('error', 'Old Passwords do not match.');
                return view('backend.changepassword');
            }
        } else {
            $request->session()->flash('error', 'Access Denied');
            return view('backend.changepassword');
        }
    }

    $user = Auth::user();
    if ($user) {
        return view('backend.changepassword');
    } else {
        $request->session()->flash('error', 'Access Denied');
        return redirect('/login');
    }
}

    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        $items = array();
        $items = Transaction::whereYear('created_at',$year)->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
        $result=[];
        foreach($items as $month=>$item_collections){
            foreach($item_collections as $item){
                $amount=$item->amount;
                $m=intval($month);
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        // dd($result);
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;


    }



}
