<?php
 require_once '../../config.php';
 require_once '../../functions.php';
// 查询数据库 获取数据 返回给前端
// 接收前端传过来 id 
$ids=$_POST['ids'];//[5,6]
// 连接数据库
$connect=connect();
// 写sql
$sql="delete from categories 
where id in (".implode(',',$ids).")";
// 执行sql
$queryResult=mysqli_query($connect,$sql);//成功返回true
$response=["code"=>0,"msg"=>"操作失败"]; // 如果没有  没有这个人  返回失败
// 如果true 证明删除成功了
if($queryResult){//
    //成功
    $response["code"]=1;
    $response["msg"]="操作成功";
}
// 以json格式返回     
header("content-type:application/json;charset=utf8");
echo json_encode( $response );
?>