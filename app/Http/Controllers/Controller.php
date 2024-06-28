<?php

namespace App\Http\Controllers;
use App\Library\Helper;
use App\Library\Notify;
use App\Library\ResponseMessages;
use App\User;
use App\UserDevice;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use Config;
use DB;
use Carbon\Carbon;
use DOMDocument;
use Log;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
	public function checkUserDevice($id, $device_id, $device_token) {
		if (stripos(url()->current(), 'api') !== false) {
			$device = UserDevice::where('user_id', $id)->where('device_id', $device_id)->whereStatus('active')->first();
			if (!isset($device->id)) {
				return false;
			}
			return true;
		} else {
			return true;
		}
	}

	public function pushNotificationSendActive($user, $push, $type) {
		try
		{
          	$notification = new Notificationuser();
          	$notification->sender_id = $push['sender_id'];
          	$notification->receiver_id = $user->id;
          	$notification->notification_type = $push['notification_type'];
          	$notification->title = $push['title'];
          	$notification->type = $type;
          	$notification->description = $push['description'];
          	$notification->status = 'active';
          	$notification->save();
          	$sound = true;
          	$alert = true;
	        /*if ($user->sound == 'Yes') {
	            $sound = 'true';
	        }
          	if ($user->alert == 'Yes') {
              	$alert = 'true';
          	}*/
          	$headtitle = ucfirst($push['title']);
		    $extramessage = ucfirst($push['description']);
		    $notification_type = ucfirst($push['notification_type']);
          	if (isset($user->devices)) {
          		foreach ($user->devices as $k => $v) {
	          		$device_type = isset($v) && !empty($v->device_type) ? $v->device_type : 'android' ;
		          	$apptoken = isset($v) && !empty($v->device_token) ? $v->device_token : '' ;
		          	
					if ($device_type == 'android') {
		              	$this->androidPushNotification($apptoken, $headtitle, $extramessage, $sound, $alert, $type, $notification_type);
		          	}
		          	if ($device_type == 'ios') {
		              	$this->sendIosNotification($apptoken, $headtitle, $extramessage, $sound, $alert, $type, $notification_type);
		          	}
	          	}
          	}
			return [];
		} catch (\Exception $ex) {
			return [];
		}
	}

	public function pushNotification($userId, $push, $type, $contestId) {
		try
		{
          	$notification = new Notificationuser();
          	$notification->sender_id = $push['sender_id'];
          	$notification->receiver_id = $userId;
			$notification->order_id = $contestId;
          	$notification->notification_type = $push['notification_type'];
          	$notification->title = $push['title'];
          	$notification->type = $type;
          	$notification->description = $push['description'];
          	$notification->status = 'active';
          	$notification->save();
          	$sound = true;
          	$alert = true;
	        /*if ($user->sound == 'Yes') {
	            $sound = 'true';
	        }
          	if ($user->alert == 'Yes') {
              	$alert = 'true';
          	}*/
          	$headtitle = ucfirst($push['title']);
		    $extramessage = ucfirst($push['description']);
		    $notification_type = ucfirst($push['notification_type']);
		    $user = User::select('id', 'notification', 'email_alert')->where('id', $userId)->first();
          	if (isset($user->devices)) {
          		foreach ($user->devices as $k => $v) {
	          		$device_type = isset($v) && !empty($v->device_type) ? $v->device_type : 'android' ;
		          	$apptoken = isset($v) && !empty($v->device_token) ? $v->device_token : '' ;
		          	
					if ($device_type == 'android') {
		              	$this->androidPushNotification($apptoken, $headtitle, $extramessage, $sound, $alert, $type, $notification_type);
		          	}
		          	if ($device_type == 'ios') {
		              	$this->sendIosNotification($apptoken, $headtitle, $extramessage, $sound, $alert, $type, $notification_type);
		          	}
	          	}
          	}
			return [];
		} catch (\Exception $ex) {
			return [];
		}
	}

	public function pushNotificationRegister($users, $push, $type) {
		try
		{
          	$notification = new Notificationuser();
          	$notification->sender_id = $push['sender_id'];
          	$notification->receiver_id = $users->id;
          	$notification->notification_type = $push['notification_type'];
          	$notification->title = $push['title'];
          	$notification->type = $type;
          	$notification->description = $push['description'];
          	$notification->status = 'active';
          	$notification->save();
          	$sound = true;
          	$alert = true;
	        /*if ($user->sound == 'Yes') {
	            $sound = 'true';
	        }
          	if ($user->alert == 'Yes') {
              	$alert = 'true';
          	}*/
          	$headtitle = ucfirst($push['title']);
		    $extramessage = ucfirst($push['description']);
		    $notification_type = ucfirst($push['notification_type']);
          	if (isset($users->devices)) {
          		foreach ($users->devices as $k => $v) {
	          		$device_type = isset($v) && !empty($v->device_type) ? $v->device_type : 'android' ;
		          	$apptoken = isset($v) && !empty($v->device_token) ? $v->device_token : '' ;
		          	
					if ($device_type == 'android') {
		              	$this->androidPushNotification($apptoken, $headtitle, $extramessage, $sound, $alert, $type, $notification_type);
		          	}
		          	if ($device_type == 'ios') {
		              	$this->sendIosNotification($apptoken, $headtitle, $extramessage, $sound, $alert, $type, $notification_type);
		          	}
	          	}
          	}
			return [];
		} catch (\Exception $ex) {
			return [];
		}
	}


	public function pushNotificationAdmin($user_id, $push, $type) {
		try
		{
          	$notification = new Notificationuser();
          	$notification->sender_id = $push['sender_id'];
          	$notification->receiver_id = $user_id;
          	$notification->notification_type = $push['notification_type'];
          	$notification->title = $push['title'];
          	$notification->type = $type;
          	$notification->description = $push['description'];
          	$notification->status = 'active';
          	$notification->save();

			return [];
		} catch (\Exception $ex) {
			return [];
		}
	}


	public function generateReferralCode($user_id) {
		
		$letters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

		$code = substr($letters, mt_rand(0, 24), 2) . mt_rand(1000, 9999) . substr($letters, mt_rand(0, 23), 3) . mt_rand(10, 99).$user_id;

		return $code;
	}


   	public $response = array(
		"status" => 500,
		"message" => "Internal server error",
		"data" => null,
	);

	public $paginate = 10;

    public function checkKeys($input = array(), $required = array()) {
		$existance = implode(", ", array_diff($required, $input));
		if (!empty($existance)) {
			if (count(array_diff($required, $input)) == 1) {
				$this->response = array(
					"status" => 401,
					"message" => $existance . " key is missing",
					"data" => null,
				);
			} else {
				$this->response = array(
					"status" => 401,
					"message" => $existance . " keys are missing",
					"data" => null,
				);
			}
			$this->shut_down();
			exit;
		}
	}

	public function updateUserDevice($id, $device_id, $device_token, $device_type) {
		if (stripos(url()->current(), 'api') !== false) {
			if (($device_type == 'android') || ($device_type == 'ios') || ($device_type == 'web')) {
				if (($device_type == 'android') || ($device_type == 'ios') || ($device_type == 'web')) {
					$device = UserDevice::where('user_id', $id)->where('device_id', $device_id)->first();
					if (empty($device)) { 
						$user = User::where('id', $id)->first();
						if (!empty($user)) {
							if ($user->status == 'active') {
								$device = new UserDevice;
								$device->user_id = $id;
								$device->device_id = $device_id;
								$device->device_token = $device_token;
								$device->device_type = $device_type;
							    return $device->save();
							    
							} else { 
								if ($user->status == 'inactive') {
									$this->response = array(
										"status" => 666,
										"message" => ResponseMessages::getStatusCodeMessages(216),
										"data" => null,
										
									);
									$this->shut_down();
								exit;
								} else{
									$this->response = array(
										"status" => 666,
										"message" => ResponseMessages::getStatusCodeMessages(217),
										"data" => null,
										//"logout" => 1,
									);
									$this->shut_down();
								exit;
								}
							}
							
						}else{
							$this->response = array(
								"status" => 403,
								"message" => ResponseMessages::getStatusCodeMessages(5),
								"data" => null,
								"logout" => 1,
							);
							$this->shut_down();
								exit;
						}
					}else{
						$user = User::where('id', $id)->first();
						if (!empty($user)) {
							if ($user->status == 'active') {
								$device->user_id = $id;
								$device->device_id = $device_id;
								$device->device_token = $device_token;
								$device->device_type = $device_type;
								$device->status = 'active';
							    return $device->save();
							} else { 
								if ($user->status == 'inactive') {
									$this->response = array(
										"status" => 666,
										"message" => ResponseMessages::getStatusCodeMessages(216),
										"data" => null,
										
									);
									$this->shut_down();
								exit;
								} else{
									$this->response = array(
										"status" => 403,
										"message" => ResponseMessages::getStatusCodeMessages(217),
										"data" => null,
										"logout" => 1,
									);
									$this->shut_down();
								exit;
								}
							}
						}else{
							$this->response = array(
								"status" => 403,
								"message" => ResponseMessages::getStatusCodeMessages(5),
								"data" => null,
								"logout" => 1,
							);
							$this->shut_down();
							exit;
						}
					}
				}else{
					return true;
				}
			}else{
				$this->response = array(
					"status" => 515,
					"message" => ResponseMessages::getStatusCodeMessages(515),
					"data" => null,
					"logout" => 1,
				);
				$this->shut_down();
				exit;
			}
		} else {
			return true;
		}
	}
	
	function shut_down(Request $request = null,$userid=null) {
		if ((isset(Auth::user()->id)) && ($user = User::where("id", Auth::user()->id)->first())) {
			if ($user->status == 'active') {

			}else{
				$this->response['status'] = 403;
				$this->response['message'] = ResponseMessages::getStatusCodeMessages(5);
				$this->response['data'] = null;
			}
		}
		echo json_encode($this->response);
	}
}
