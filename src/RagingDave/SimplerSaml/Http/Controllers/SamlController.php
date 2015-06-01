<?php namespace RagingDave\SimplerSaml\Http\Controllers;

use Illuminate\Contracts\Config\Repository as Config;
use Illuminate\Contracts\Events\Dispatcher as Event;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RagingDave\SimplerSaml\Events\SamlLogin;
use RagingDave\SimplerSaml\Events\SamlLogout;
use RagingDave\SimplerSaml\Services\SamlAuth;

/**
 * Class SamlController
 *
 * @package RagingDave\SimplerSaml\Http\Controllers
 */
class SamlController extends Controller
{
	/**
	 * @var Config
	 */
	protected $config;

	/**
	 * @var SamlAuth
	 */
	protected $sa;

	protected $event;

	/**
	 * @param Config $config
	 * @param Event $event
	 * @param SamlAuth $sa
	 */
	public function __construct(Config $config, Event $event, SamlAuth $sa)
	{
		$this->sa = $sa;
		$this->event = $event;
		$this->config = $config;
	}

	public function getLogin()
	{
		$samlIdp = $this->config->get('simplersaml.idp');
		$this->sa->requireAuth(array(
			'saml:idp' => $samlIdp,
		));

		$this->event->fire(new SamlLogin($this->sa->user()));

		$loginRedirect = $this->config->get('simplersaml.loginRedirect');

		return redirect()->to($loginRedirect);
	}

	public function getLogout(Request $request)
	{
		if ($this->sa->isAuthenticated())
		{
			$this->sa->logout();
		}

		// Pass through the currently authenticated user
		$this->event->fire(new SamlLogout($request->user()));

		$logoutRedirect = $this->config->get('simplersaml.logoutRedirect');

		return redirect()->to($logoutRedirect);
	}
}
