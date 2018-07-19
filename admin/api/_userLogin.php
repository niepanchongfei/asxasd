<?php
    require_once '../../config.php';
    require_once '../../functions.php';
    // 后台
    // 接收ajax发来的邮箱和密码
    $email=$_POST['email'];
    $password=$_POST['password'];
    // 查询数据库  是否有这个邮箱和密码
    //  连接数据库
    $connect=connect();
    $sql="select * from  users where email='{$email}' and 
    password='{$password}' and status='activated'";
    // 执行sql
    $queryResult=query($connect,$sql);  //二维数组 有一个查到的用户
    $response=["code"=>0,"msg"=>"操作失败"]; // 如果没有  没有这个人  返回失败
    // 如果有  证明有这个人就登录成功
    if($queryResult){//登录成功
        //登录成功 记住他已经登录过了
        session_start();//一定要先开启
        $_SESSION['isLogin']=1;//isLogin值是1 代表登录了
        // setcookie('denglu',true)
        // 记住当前登录的这个人的id 以后要用
        $_SESSION['user_id']=$queryResult[0]['id'];
        $response["code"]=1;
        $response["msg"]="登录成功";
    }
    // 以json格式返回     
    header("content-type:application/json;charset=utf8");
    echo json_encode( $response );


?>