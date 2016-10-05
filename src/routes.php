<?php
Route::post("broadcastmessage","Message\MessageController@broadcaststore");
Route::get("readmsg/{id}","Message\MessageController@readmsg");
Route::get("emailincompleteusercourses","Message\MessageController@emailincompleteusercourses");
Route::get("notifications","Message\MessageController@index");
Route::get('loadadminview',function(){
  return view('vendor.message.admin');
});


Route::get("testmail","Message\MessageController@testmail");
