<?php


// 判断是否登录的方法
function checkLogin(){
    // 只有登录了 才显示 没有登录跳转到登录页面 强行让你登录
  session_start();
  //  $_SESSION['isLogin']  1 代表你登录了 
  if(!isset( $_SESSION['isLogin'] ) ||  $_SESSION['isLogin']!=1 ){
      // 你没有登录 跳转
      header("location:login.php");
      //kkk
  }
}
// 连接数据库
function connect(){
    $connect=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
    return $connect;
}

// 查询  调用函数的地方就得到了 那个函数的返回值
// query()
function query($connect,$sql){
    $result=mysqli_query($connect,$sql);//结果集
    return fetch( $result );
}

// 转成成二维数组
function fetch($result){
    $arr=[];
    while($row=mysqli_fetch_assoc($result)){
        $arr[]=$row;
    }
    return $arr;
}





?>