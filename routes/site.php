<?php

use Illuminate\Support\Facades\Route;


  Route::get('/'                    , 'IntroController@index')->name('intro');
  Route::get('/privacy-policy'      , 'IntroController@privacyPolicy')->name('IntroPrivacyPolicy');
  Route::post('/send-message'       , 'IntroController@sendMessage');
  Route::get('/lang/{lang}'         , 'IntroController@SetLanguage');

  Route::group(['middleware' => ['guest']], function () {

  });

  Route::group(['middleware' => ['auth']], function () {
    Route::get('/show-chat/{id}', 'ChatController@getChatRoom')->name('getChatRoom');
    Route::post('/upload-chat-file', 'ChatController@uploadChatFile')->name('uploadChatFile');
  });


