<?php

Route::group(array('prefix' => 'v1'), function()
{
	Route::resource('users', 'UsersController', ['except' => ['create', 'edit']]);

	Route::resource('messages', 'MessagesController', ['except' => ['create', 'edit']]);

	Route::resource('call-events', 'CallEventsController', ['except' => ['create', 'edit']]);

	Route::resource('message-events', 'MessageEventsController', ['except' => ['create', 'edit']]);
});