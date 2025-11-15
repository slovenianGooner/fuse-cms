<?php

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {
    Route::livewire('/', 'pages::dashboard')->name('dashboard');
});
