<?php namespace Message;

use App\Commands\Command;

use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Mail;
use Log;
class SendEmail extends Command implements SelfHandling, ShouldBeQueued {

	use InteractsWithQueue, SerializesModels;

	public $user;

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct($user)
	{
		$this->user = $user;
	}

	/**
	 * Execute the command.
	 *
	 * @return void
	 */
	public function handle()
	{
		$user = $this->user;
		Mail::send('vendor.message.emailincomplete', $user, function($message) use($user)
		{
		    $message->to($user['email'], $user['name'])->subject('Welcome!');
		});
	}

}
