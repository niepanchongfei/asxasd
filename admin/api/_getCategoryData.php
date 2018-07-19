<?php
 require_once '../../config.php';
 require_once '../../functions.php';
// 查询数据库 获取所有分类 返回给前端
// 连接数据库
$connect=connect();
// 写sql
$sql="select * from categories";
// 执行sql
$queryResult=query($connect,$sql);  //二维数组 所有分类数据
// print_r($queryResult);
$response=["code"=>0,"msg"=>"操作失败"]; // 如果没有  没有这个人  返回失败
// 如果有  证明有查询到了
if($queryResult){//
    //成功
    $response["code"]=1;
    $response["msg"]="操作成功";
    $response["data"]=$queryResult;
}
// 以json格式返回     
header("content-type:application/json;charset=utf8");
echo json_encode( $response );
?>