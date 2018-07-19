<?php
// 连接数据库
$connect=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
// 写sql
$sql="select * from categories where id!=1";
// 执行sql
$result=mysqli_query($connect,$sql);//查询获取的是结果集 还不能直接用 需要while循环拿出来
// var_dump($result);
$arr=[];//空数组
while($row=mysqli_fetch_assoc($result)){
    // print_r($row);//循环一次拿出一行 是一个数组
    $arr[]=$row;//把数据放入$arr数组
}
//  print_r( $arr);//二维数组 一个大数组 里面有一行一行数据组成的小数组

?>
<div class="header">
    <h1 class="logo"><a href="index.php"><img src="static/assets/img/logo.png" alt=""></a></h1>
    <ul class="nav">
        <?php foreach($arr as $value) : ?>
            <li><a href="list.php?categoryId=<?php echo $value['id'] ?>"><i class="fa <?php echo $value['classname'] ?>"></i><?php echo $value['name'] ?></a></li>
        <?php endforeach ?>
        <!-- <li><a href="list.php"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="list.php"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="list.php"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="list.php"><i class="fa fa-gift"></i>美奇迹</a></li> -->
    </ul>
    <div class="search">
    <form>
        <input type="text" class="keys" placeholder="输入关键字">
        <input type="submit" class="btn" value="搜索">
    </form>
    </div>
    <div class="slink">
    <a href="javascript:;">链接01</a> | <a href="javascript:;">链接02</a>
    </div>
</div>