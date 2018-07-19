<?php
 require_once '../../config.php';
 require_once '../../functions.php';
// 获取数据库里面的 登录的这个人 用户名和头像 返回给前端
// 谁登录的 就获取谁的 信息
// 在登录的时候session里面记住 id  这里可以拿出来使用
session_start();
$userId=$_SESSION['user_id'];//登录的人的 id
// 连接数据库
$connect=connect();
// 写sql
$sql="select * from  users where id={$userId}";
// 执行sql
$queryResult=query($connect,$sql);  //二维数组 有一个查到的用户
// print_r($queryResult);
$response=["code"=>0,"msg"=>"操作失败"]; // 如果没有  没有这个人  返回失败
// 如果有  证明有这个人查询到了
if($queryResult){//
    //成功
    $response["code"]=1;
    $response["msg"]="操作成功";
    $response["avatar"]=$queryResult[0]['avatar'];
    $response["nickname"]=$queryResult[0]['nickname'];
}
// 以json格式返回     
header("content-type:application/json;charset=utf8");
echo json_encode( $response );
?>