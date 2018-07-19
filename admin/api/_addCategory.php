<?php
 require_once '../../config.php';
 require_once '../../functions.php';
// 查询数据库 获取数据 返回给前端
$name=$_POST['name'];
// print_r($_POST);
// 连接数据库
$connect=connect();
// 写sql
$countSql="select count(*) as count 
from categories where name='{$name}'";
// 执行sql
$countResult=query($connect,$countSql);  //二维数组 有一个 条数 
$count=$countResult[0]['count'];//0代表没有不存在 1 存在
$response=["code"=>0,"msg"=>"操作失败"]; // 如果没有  没有这个人  返回失败
// 如果有  证明查询到了
if($count>0){// 有一条 证明有这个分类
    $response["code"]=0;
    $response["msg"]="分类已经存在";
}else{//没有这个分类 可以添加
    // sql添加
    // $sqlAdd="insert into categories(name,slug,classname) values('体育','zongyi','fa-xx')"
    $keys=array_keys($_POST);// [name,slug,classname]
    $values=array_values($_POST);// [体育,tiyu,fa]
    $sqlAdd="insert into 
    categories(".implode(',', $keys).") 
    values('".implode("','",$values)."')";
    $addResult=mysqli_query($connect,$sqlAdd);//成功返回true  失败返回false
    if( $addResult){//成功
        $response["code"]=1;
        $response["msg"]="添加成功";
    }
}
// 以json格式返回     
header("content-type:application/json;charset=utf8");
echo json_encode( $response );
?>