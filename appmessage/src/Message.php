<?php namespace Message;

use Illuminate\Database\Eloquent\Model;


class Message extends Model {

	//
	protected $table = 'message';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['sender_id', 'receiver_id', 'read_status','message_text'];


}
