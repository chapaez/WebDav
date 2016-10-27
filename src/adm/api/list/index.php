<?
header('Content-Type: application/json');


echo json_encode([
    ["command"=>"del","time"=>1476877601,"url"=>"/schedule/"],
    ["command"=>"add","time"=>1476877123,"url"=>"/schedule/"],
    ["command"=>"add","time"=>1476877651,"url"=>"/schedule/"],
    ["command"=>"del","time"=>1476876661,"url"=>"/schedule/"],
    ["command"=>"add","time"=>1476877555,"url"=>"/schedule/"],
    ["command"=>"del","time"=>1412590851,"url"=>"/schedule/"],
    ["command"=>"add","time"=>1478244013,"url"=>"/schedule/"],
]);
