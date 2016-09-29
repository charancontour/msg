<?php namespace Message;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Request;
use App\User;
use Message\Message;
use Auth;
use DB;

class MessageController extends Controller {

	//
	public function index()
	{

	}
	public function broadcaststore()
	{
		// $input = Request::all();
		$msg_text  = "Hero";
		$users =  User::where('id','!=',1)->get();
		$input = array();
		foreach ($users as $user) {
			$temp_array = array();
			$temp_array['sender_id'] = 1;
			$temp_array['receiver_id'] = $user->id;
			$temp_array['message_text'] = $msg_text;
			$temp_array['read_status'] = 0;
			$temp_array['created_at'] = date('Y-m-d H:i:s');
			$temp_array['updated_at'] = date('Y-m-d H:i:s');

			$input[]=$temp_array;
		}

		$result = DB::table('message')
								->insert($input);

		return "All Good";

	}
	public function readmsg($id)
	{
		$msg = Message::findOrFail($id);
		$msg->read_status = 1;
		$msg->save();
		return json_encode($msg);
	}

}
