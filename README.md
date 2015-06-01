# SimplerSaml

Welcome to the even Simpler simplesamlphp integration for Laravel 5.

This library enables simple interaction between your Laravel application and using authentication from an IDP.

Feel free to bring up shortcomings in issues/PR so I can improve this and make it better for everyone.

## Setup

Add the package to your composer.json:

    composer require ragingdave/simplersaml:dev-master

Add the service provider in `app/config/app.php`:

    'RagingDave/SimplerSaml/SimplerSamlServiceProvider',
    
(OPTIONALLY) Publish the config to make changes:
    
    php artisan vendor:publish --provider="RagingDave/SimplerSaml/SimplerSamlServiceProvider" --tag="config"
    
## Configuration
This is pretty customizable from the start so if there is something missing chances are, I missed it, and you
can help improve the package by telling me about it and I'll see what I can do (OR better yet submit a PR).

- Saml User Model (simplersaml.model)
  - This basically just is used currently to map saml attribute names to something that is meaningful for your application.
   (Ideally, this should be the only part to have to override)

- Routing (simplersaml.enableRoutes, simplersaml.routePrefix)
  - This will determine if the built in routes are registered and what they should register at.
  - A routePrefix of 'saml' will trigger routes 'saml/login' and 'saml/logout'
  - boolean value of enableRoutes will enable or disable the built-in routes entirely.
 
- SP and IDP (simplersaml.sp, simplersaml.idp)
  - These are pretty self-explanatory if you are using simplesamlphp, but...
  - sp should be the configured sp in the metadata (gets passed to SimpleSAML_Auth_Simple as the authSource)
  - idp is the configured idp in the simplesamlphp metadata
 
- Redirects (simplersaml.loginRedirect, simplersaml.logoutRedirect)
  - These determine the path to redirect to after login and logout (passed to redirect()->to())

## Usage

So for this you can use the built-in middleware and augment them to add the saml isAuthenticated check, or use the
SamlAuthenticate, and SamlRedirectIfAuthenticated included in this package.  Anything more advanced like combining
laravel session checking and saml session checking can be done by you by adding to the built-in Authenticate and 
RedirectIfAuthenticated.

There are a few events that are fired from this package to hook into the login and logout functions of the saml flow.

    RagingDave\SimplerSaml\Events\SamlLogin
    RagingDave\SimplerSaml\Events\SamlLogout

These can be listened for and acted upon to enable creating/logging in the saml user into a local laravel session to use
    
    Auth::user(), Auth::check(), etc.
    
throughout the application. The problem here is that if the saml session times out, the laravel session could still be valid.
The middleware in this package takes care of this so take a look in `` for an example.
