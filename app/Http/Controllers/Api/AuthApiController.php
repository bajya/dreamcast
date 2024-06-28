<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use App\Library\Helper;
use App\Library\Notify;
use App\Library\ResponseMessages;
use App\User;
use App\UserDevice;
use Auth;
use Config;
use DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Session;
use URL;
use Image;
use File;
use PDF;
use Carbon\Carbon;
use Log;

class AuthApiController extends Controller {
	
	public function __construct()
    {
        $this->middleware('auth');
    }

	//function call to addUser
	public function addUser(Request $request) {
		$this->checkKeys(array_keys($request->all()), array("name", "phone_code", "mobile", "role_id", "device_id", "device_token", "device_type"));
		try {
			$input = $request->all();
  			$validate = Validator($request->all(), [
	            'name' => 'required|regex:/^[a-zA-Z]+$/',
	            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            	'email' => 'required|email',
				'phone_code' => 'required',
		        'mobile' => 'required|min:10|numeric',
		        'role_id' => 'required|numeric',
	        ]);
	        $attr = [
	            'name' => 'User Name',
	            'image' => 'Image',
            	'email' => 'Email',
				'phone_code' => 'Country Code',
		        'mobile' => 'Phone No',
		        'role_id' => 'Role',
	        ];
	        $validate->setAttributeNames($attr);
	        if ($validate->fails()) {
				$errors = $validate->errors();
				$this->response = array(
					"status" => 300,
					"message" => $errors->first(),
					"data" => null,
					"errors" => $errors,
				);
			}else{
				if (($request->device_type == 'android') || ($request->device_type == 'ios') || ($request->device_type == 'web')) {
					if ($user = User::where('id', Auth::user()->id)->first()) {
						$this->updateUserDevice($user->id, $request->device_id, $request->device_token, $request->device_type);
					
						$newuser = new User;
						$newuser->password = Hash::make($input['mobile']);
						$newuser->name = $input['name'];
						$newuser->phone_code = $input['phone_code'];
						$newuser->mobile = $input['mobile'];
						$newuser->email = $input['email'];
						$newuser->role_id = $input['role_id'];
						$newuser->description = $input['description'];
						if ($request->hasfile('image')) {
                            $file = $request->file('image');
                            $filename = time() . $file->getClientOriginalName();
                            $filename = str_replace(' ', '', $filename);
                            $filename = str_replace('.jpeg', '.jpg', $filename);
                            $file->move(public_path('img/avatars'), $filename);
                            $newuser->avatar = $filename;
                        }
						if ($newuser->save()) {
							$page_no = 0;
							$results = $this->allUserList($user, $page_no, $request);
							if (!empty($results) && count($results) > 0) {
								if ($request->device_type == 'web') {
									$results = view('backend.users.list',compact('results'))->render();
								}
								$this->response = array(
									"status" => 200,
									"message" => ResponseMessages::getStatusCodeMessages(125),
									"data" => !empty($results) ? $results : '',
								);
							}else{
								$this->response = array(
									"status" => 300,
									"message" => ResponseMessages::getStatusCodeMessages(520),
									"data" => null,
								);
							}
						}else{
							$this->response = array(
								"status" => 300,
								"message" => ResponseMessages::getStatusCodeMessages(123),
								"data" => null,
							);
						}
					} else {
						$this->response = array(
							"status" => 403,
							"message" => ResponseMessages::getStatusCodeMessages(5),
							"data" => null,
						);
					}
				}
				else{
					$this->response = array(
						"status" => 300,
						"message" => ResponseMessages::getStatusCodeMessages(214),
						"data" => null,
					);
				}
			}
		} catch (\Exception $ex) {
			$this->response = array(
				"status" => 501,
				"message" => ResponseMessages::getStatusCodeMessages(501),
				"data" => null,
			);
		}
		$this->shut_down();
		exit;
	}

	//Use for Added User list
	public function userList(Request $request) {
		// check keys are exist
		$this->checkKeys(array_keys($request->all()), array("from_date", "end_date", "search", "page", "device_id", "device_token", "device_type"));
		try {
			$input = $request->all();
			$validate = Validator($request->all(), [
			 	'page' => 'required|numeric',
			]);
			$attr = [
				'page' => 'Page No',
			];
			$validate->setAttributeNames($attr);
			if ($validate->fails()) {
				$errors = $validate->errors();
				$this->response = array(
					"status" => 300,
					"message" => $errors->first(),
					"data" => null,
					"errors" => $errors,
				);
			}else{	
				if (($request->device_type == 'android') || ($request->device_type == 'ios') || ($request->device_type == 'web')) {
					if ((isset(Auth::user()->id)) && ($user = User::where("id", Auth::user()->id)->first())) {
						$this->updateUserDevice($user->id, $request->device_id, $request->device_token, $request->device_type);
						if (isset($request->page) && !empty($request->page)) {
							$page_no = $request->page - 1;
						}else{
							$page_no = 0;
						}
						$results = $this->allUserList($user, $page_no, $request);
						if (!empty($results) && count($results) > 0) {
							if ($request->device_type == 'web') {
								$results = view('backend.users.list',compact('results'))->render();
							}
							$this->response = array(
								"status" => 200,
								"message" => ResponseMessages::getStatusCodeMessages(125),
								"data" => !empty($results) ? $results : '',
							);
						}else{
							$this->response = array(
								"status" => 300,
								"message" => ResponseMessages::getStatusCodeMessages(520),
								"data" => null,
							);
						}						
					} else {
						$this->response = array(
							"status" => 403,
							"message" => ResponseMessages::getStatusCodeMessages(5),
							"data" => null,
						);
					}
				}else{
					$this->response = array(
						"status" => 300,
						"message" => ResponseMessages::getStatusCodeMessages(214),
						"data" => null,
					);
				}
			}
		} catch (\Exception $ex) {
			$this->response = array(
				"status" => 501,
				"message" => ResponseMessages::getStatusCodeMessages(501),
				"data" => null,
			);
		}
		$this->shut_down();
		exit;
	}

	public function allUserList($user, $page_no, $request) {
		
		$query = User::select('id', 'name', 'email', 'avatar as image', 'phone_code', 'description', 'role_id', 'mobile', DB::raw("DATE_FORMAT(created_at,'%b %d, %Y') as created_date"))->with(['role' => function ($q) {
			$q->select('id', 'name');
		}])->whereHas('role', function ($q) use ($request)  {
            $q->where('status', 'active');
		});
		if (isset($request->search) && !empty($request->search)) {
			$query->where(function ($q1) use ($request) {
                $q1->where('name', 'like', '%' . $request->search . '%');
                $q1->orWhere('phone_code', 'like', '%' . $request->search . '%');
                $q1->orWhere('mobile_number', 'like', '%' . $request->search . '%');
                $q1->orWhere('description', 'like', '%' . $request->search . '%');
            });
		}	
		$users = $query->where('id', '!=', '1')->where('status', '!=', 'delete')->orderBy('id', 'desc')->offset($page_no*20)->take(20)->get();
		
		return $users;
	}
  
}