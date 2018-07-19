<?php
 require_once '../../config.php';
 require_once '../../functions.php';
// 查询数据库 获取数据 返回给前端
// 接收前端传过来 id classname name slug
$id=$_POST['id'];
$name=$_POST['name'];
$slug=$_POST['slug'];
$classname=$_POST['classname'];
// 连接数据库
$connect=connect();
// 写sql
$sql="update categories 
set name='{$name}'
,slug='{$slug}',classname='{$classname}' 
where id={$id}";
// 执行sql
$queryResult=mysqli_query($connect,$sql);//成功返回true
$response=["code"=>0,"msg"=>"操作失败"]; // 如果没有  没有这个人  返回失败
// 如果true 证明更新成功了
if($queryResult){//
    //成功
    $response["code"]=1;
    $response["msg"]="操作成功";
}
// 以json格式返回     
header("content-type:application/json;charset=utf8");
echo json_encode( $response );
?>