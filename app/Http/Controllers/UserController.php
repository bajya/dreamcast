<?php
    
namespace App\Http\Controllers;
    
use App\Library\Helper;
use App\Library\Notify;    
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use URL;
use Illuminate\Support\Arr;
use Mail;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public $user;
    public $columns;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->user = new User;
       
        $this->columns = [
            "select", "name", "email","created_at", "activate", "action",
        ];
    }

    public function index(Request $request) {
        return view('backend.users.index');
    }

    public function usersAjax(Request $request) {
    
       
    }
    public function create() {
      
    }

    public function store(Request $request) {
        
    }

    public function show(Request $request, $id = null) {
        
    }

    public function edit(Request $request, $id = null) {
        
    }

    public function update(Request $request, $id = null) {
        

    }
  
    public function checkUsers(Request $request, $id = null) {
        
        if (isset($request->email)) {
            $check = User::where('email', $request->email);
            if (isset($id) && $id != null) {
                $check = $check->where('id', '!=', $id);
            }
            $check = $check->where('status', '!=', 'delete')->count();
            if ($check > 0) {
                return "false";
            } else {
                return "true";
            }
        } else {
            return "true";
        }
    }
 

}