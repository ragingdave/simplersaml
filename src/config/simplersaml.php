<?php

return [
	// Configured SP name that this application will use
	'sp' => 'default-sp',

	// Configured IDP to authenticate against
	'idp' => 'https://openidp.feide.no',

	// User Model to use for easy saml attribute mapping
    'model' => 'RagingDave\SimplerSaml\User',

    // Enable the built in routes for saml authentication (default: true)
    'enableRoutes' => true,

    // Prefix for saml login/logout routes ie saml => host.com/saml/login and host.com/saml/logout
    'routePrefix' => 'saml',

    // Location to redirect to after login
    'loginRedirect' => '/home',

    // Location to redirect to after logout
    'logoutRedirect' => '/',
];