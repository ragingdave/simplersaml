<?php namespace RagingDave\SimplerSaml\Events;

use RagingDave\SimplerSaml\Contracts\User;

use Illuminate\Queue\SerializesModels;

class SamlLogin
{
	use SerializesModels;

	/**
	 * @var User
	 */
	public $user;

	/**
	 * Create a new event instance.
	 *
	 * @param User $user
	 * @return \RagingDave\SimplerSaml\Events\SamlLogin
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}

}
