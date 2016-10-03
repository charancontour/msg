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

	public function __construct()
	{
		$this->table = config('message.table');
	}
	public function index()
	{
		$notifications = DB::table($this->table)
											->where("receiver_id","=",292)
											->where('read_status',"=",0)
											->get();
		return json_encode($notifications);
	}
	public function broadcaststore()
	{
		$input = Request::all();
		$location_id = $input["locationid"];
		$msg_text  = $input['message_text'];
		if($location_id != 0){
			$users =  User::where('id','!=',1)
											->where('location_id',$location_id)
											->get();
		}
		else{
			$users =  User::where('id','!=',1)
											->get();
		}

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

		$result = DB::table($this->table)
								->insert($input);
		if($result){
			\Session::flash('flash_message','Message broadcasted to all users successfully.');
		}
		else{
			\Session::flash('flash_message','Message couldnot be broadcasted, please try again later');
		}
		return redirect()->back();

	}
	public function readmsg($id)
	{
		$msg = DB::tabel($this->table)
								->where('id','=',$id)
								->update(['read_status'=>1,'updated_at'=>date('Y-m-d H:i:s')]);
		$msg->read_status = 1;
		$msg->save();
		return json_encode($msg);
	}
	public function emailincompleteusercourses()
	{
		$users = User::all();
		$efront_user_ids = array();
		$emails = array();
		foreach ($users as $user) {
			$efont_user_ids[] = $user->$efront_user_id;
		}
		$efront_user_ids = implode(",",$efront_user_ids);

		$incomplete_courses = DB::connection('mysql2')->select(
													DB::raw("select u.id as user_id,u.name,u.surname,u.email as user_email,c.name as course_name from users as u,users_to_courses as utc,courses as c
																	 where u.id in ($efront_user_ids)
																	 and u.id = utc.users_id
																	 and c.id = utc.courses_id
																	 and utc.status != 'completed'
																	 ORDER BY user_id ASC"));

		$user_courses = [];
		foreach ($incomplete_courses as $course) {
			if(!array_key_exists($user_courses,$course->user_id)){
			  $user_courses[$course->user_id] = array(
					'email'=>$course->user_email,
					'name'=>$course->name,
					'surname' => $course->surname,
					'courses' => array("$course->course_name")
				);
			}
			else{
				$user_courses[$course->user_id]['courses'][] = $course->course_name;
			}
		}

		Mail::queue('emails.welcome', $data, function ($message) {
    //
		});
		$result = true;
		if($result){
			\Session::flash('flash_message','Message broadcasted to all users successfully.');
		}
		else{
			\Session::flash('flash_message','Message couldnot be broadcasted, please try again later');
		}
		return redirect()->back();

	}

}
