<?php

Route::group(['prefix' => 'v1'], function()
{
	Route::resource('companies.messages', 'MessagesController', ['except' => ['create', 'edit']]);
});