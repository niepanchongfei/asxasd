<?php
//  1引入config与functions
require_once '../config.php';
require_once '../functions.php';
//// 这些数据的名字都是 后台和 前端 约定的 比如现在我们约定    categoryId 分类  currentPage第几次 pageSize每次的条数
$categoryId=$_POST['categoryId']; // 是哪个分类的
$currentPage=$_POST['currentPage'];//要第几次的数据
$pageSize=$_POST['pageSize'];//每次要10条
$offset=($currentPage-1)*$pageSize;// 从哪个索引开始取
$connect=connect();// 2连接数据库
// 写sql
$sql="select p.id,p.title,p.feature,p.content,p.created,
        p.views,p.likes,u.nickname,c.name,
    (select count(id) from comments where post_id=p.id ) as commentsCount
    from posts p
    left join categories c on c.id=p.category_id
    left join users u on u.id=p.user_id
    where p.category_id={$categoryId}
    limit {$offset},{$pageSize}";
    // echo $sql;
$postArr=query($connect,$sql);// 执行sql返回的是一个二维数组
// 返回给前端 这些 code 0失败1成功   msg  data  也是我们两个商量约定好的
// 除了数据 还要顺便返回一个当前分类 总共有多少篇文章
$sqlCount="select count(id) as pageCount 
from posts where category_id={$categoryId}";
// 执行sql获取总条数
$countArr=query($connect,$sqlCount);//二维数组
// print_r($countArr);
$pageCount=$countArr[0]['pageCount'];//总条数
$response=["code"=>0,"msg"=>"操作失败"];//默认 失败的
if($postArr){//如果有数据 成功获取到数据
    $response["code"]=1;
    $response["msg"]="操作成功";
    $response["data"]=$postArr;//把数组 赋值给 data
    $response["pageCount"]=$pageCount;//总条数
}
// 返回对应的数据给前端
// 告诉ajax我是一个json
header("content-type:application/json;charset=utf8");
echo json_encode($response);//把这个给前端
// echo 这里一定要这样  前端只认识 echo 后面的东西
// echo 什么前端就拿到什么
// json_encode(数组) 把数组转化成字符串
// json_decode(字符串) 把字符串转化成数组



?>