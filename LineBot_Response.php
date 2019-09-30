<?php
//接起在heroku server時設定的token
$accessToken=getenv('1xyOb9wSVPVRyEbDT+Bp51It8Il7Qi0Hm9vIlC+pu19CZBprktHTLS2a1TfRViBURJOfeabXlzChX5P8Y1V6RS4/a1hXCKjNR4MiVc3diruddp/WLvXYGv22GuwjFONORnHEDuGHLkJ15nOlR2tT+wdB04t89/1O/w1cDnyilFU=');
//當有人回話時機器人接收到會傳到input內，我們要讀取資訊封包
$json_string = file_get_contents('D:\Apache24\htdocs\123.txt');
//decode
$jsonObj = json_decode($json_string);
//取得回傳訊息的型態
$type = $jsonObj->{"events"}[0]->{"message"}->{"type"};
//取的回傳訊息的文字
$text = $jsonObj->{"events"}[0]->{"message"}->{"text"};
//當每一次訊息傳送過來時都會有一組replayToken,有時效性30秒,不會重複，是讓MESSAGE API驗證這組token是否通過認證並且發送給api
$replyToken = $jsonObj->{"events"}[0]->{"replyToken"};
//只要有文字傳送過來就會回復相同文字
if ($text != null){
   $send = [
    "type" => "text",
    "text" => $text
   ];
}
//設定變數$post_data為最後傳入給LINE API的封包
$post_data = [
    "replyToken" => $replyToken,
    "messages" => [$send]
   ];
   $ch = curl_init("https://api.line.me/v2/bot/message/reply");
   curl_setopt($ch, CURLOPT_POST, true);
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data));
   curl_setopt($ch, CURLOPT_HTTPHEADER, array(
     'Content-Type: application/json; charser=UTF-8',
     'Authorization: Bearer ' . $accessToken
     ));
   $result = curl_exec($ch);
   curl_close($ch);
?>