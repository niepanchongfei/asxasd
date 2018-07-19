<?php
header("content-type:text/html;charset=utf8");
// Array
// (
//     [name] => 体育
//     [slug] => tiyu
//     [classname] => fa
// )
$post=[
    'name'=> '体育',
    'slug' => 'tiyu',
    'classname' => 'fa'
];
$keys=array_keys($post);//把数组里面的 键 拿出来 组成一个新数组
// print_r($keys);  [name,slug,classname] 变成字符串 ,分割的
$keyStr=implode(',',$keys); // name,slug,classname
// echo $keyStr;
$vaules=array_values($post);//把数组里面的 值 拿出来 组成一个新数组

// print_r($vaules); //   [体育,tiyu,fa]
$valStr=implode("','",$vaules); //

// echo $valStr;
// insert into categories(name,slug,classname) values('体育','zongyi','fa')
// 获取到前端传过来的数据  目的要插入到数据
$sql="insert into categories(".$keyStr.") values('".$valStr."')";
// print_r($post);

echo $sql;


?>