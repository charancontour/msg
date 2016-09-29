<?php
Route::get("broadcastmessage","Message\MessageController@broadcaststore");
Route::get("readmsg/{id}","Message\MessageController@readmsg");
Route::get("index",function(){
  return config('message.table');
});
