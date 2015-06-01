<?php

Route::controllers([
	Config::get('simplersaml.routePrefix') => 'RagingDave\SimplerSaml\Http\Controllers\SamlController',
]);