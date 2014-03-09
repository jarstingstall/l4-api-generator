<?php

Route::group(array('prefix' => 'v1'), function()
{
	Route::resource('users', 'UsersController', ['except' => ['create', 'edit']]);

	Route::resource('message-events', 'MessageEventsController', ['except' => ['create', 'edit']]);
});