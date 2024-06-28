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
use Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Log;

class ApiController extends Controller {


	protected function guard() {
		return auth()->guard('web');
	}

	// UNAUTHORIZED ACCESS
	public function appLogin()
	{
		$this->response = array(
			"status" => 403,
			"message" => ResponseMessages::getStatusCodeMessages(214),
			"data" => null,
			"access_token" => ''
		);
	}
}

	
