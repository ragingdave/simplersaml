<?php

Route::resources(
	Config::get('simplersaml.routePrefix'), 'RagingDave\SimplerSaml\Http\Controllers\SamlController'
);
