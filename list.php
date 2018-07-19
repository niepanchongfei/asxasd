<?php
require_once 'config.php';

// 接收传来的分类id
$categoryId=$_GET['categoryId'];//3
// 查询当前分类下的文章
// echo $categoryId;
// 连接数据库
$connect=mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);
// 写sql
$sql="select p.id,p.title,p.feature,p.content,p.created,
     p.views,p.likes,u.nickname,c.name,
    (select count(id) from comments where post_id=p.id ) as commentsCount
    from posts p
    left join categories c on c.id=p.category_id
    left join users u on u.id=p.user_id
    where p.category_id={$categoryId}
    limit 10";
// 执行sql   返回的是结果集
$postResult=mysqli_query($connect,$sql);
// 转化成二维数组
$postArr=[];
while($row=mysqli_fetch_assoc($postResult)){
  $postArr[]=$row;
}
// print_r($postArr);
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>阿里百秀-发现生活，发现美!</title>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="list.php"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="list.php"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="list.php"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="list.php"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
     <!-- 这是header 左边部分 -->
     <?php   include_once 'public/_header.php';   ?>
    <!-- 这是aside 右边部分  -->
    <?php   include_once 'public/_aside.php';   ?>
    <div class="content">
<div class="panel new">
<!-- 全部都是同一个分类 随便拿一条数据来用即可 -->
  <h3><?php  echo $postArr[0]['name']  ?></h3>
  <?php  foreach($postArr as $value) :  ?>
    <div class="entry">
      <div class="head">
        <!-- 标题 点击跳转到detail.php并且带上postId -->
        <a href="detail.php?postId=<?php  echo $value['id']  ?>"> <?php  echo $value['title']  ?></a>
      </div>
      <div class="main">
        <p class="info"><?php  echo $value['nickname']  ?> 发表于 <?php  echo $value['created']  ?></p>
        <p class="brief"> <?php  echo $value['content']  ?></p>
        <p class="extra">
          <span class="reading">阅读(<?php  echo $value['views']  ?>)</span>
          <span class="comment">评论(<?php  echo $value['commentsCount']  ?>)</span>
          <a href="detail.php" class="like">
            <i class="fa fa-thumbs-up"></i>
            <span>赞(<?php  echo $value['likes']  ?>)</span>
          </a>
          <a href="javascript:;" class="tags">
            分类：<span><?php  echo $value['name']  ?></span>
          </a>
        </p>
        <a href="javascript:;" class="thumb">
          <img src="static/uploads/hots_2.jpg" alt="">
        </a>
      </div>
    </div>
  <?php  endforeach  ?>
  <div class="loadmore">
      <span class="btn"> 加载更多</span>
  </div>
</div>
</div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="static/assets/vendors/jquery/jquery.min.js"></script>
  <script>
    $(function(){
      var currentPage=1;//第几次
      var id=location.search.split('=')[1];//当前分类id
      // 加载更多绑定点击事件
      $('.loadmore .btn').on('click',function(){
          // 点击加载更多 请求第二次的十条数据  再点第三次。。。
          // 发送ajax 拿到数据 渲染到页面上
          currentPage++;
          $.ajax({
              type:"post",
              url:"api/_getMorePost.php",
              data:{
                categoryId:id,
                currentPage:currentPage,
                pageSize:10
              },
              success:function(res){
                  console.log(res);
                  // {code: 1, msg: "操作成功", data: Array(10)}
                  if(res.code==1){//一定成功了
                      // 循环数组  渲染页面
                      var data=res.data;//数组
                      $.each(data,function(index,val){
                          // console.log(val)  index是索引 val 是数组里面的每一项 他一篇文章
                          var str=`<div class="entry">
                                      <div class="head">
                                        <a href="detail.php?postId=${val.id}">${val.title}</a>
                                      </div>
                                      <div class="main">
                                        <p class="info">${val.nickname} 发表于 ${val.created}</p>
                                        <p class="brief">${val.content}</p>
                                        <p class="extra">
                                          <span class="reading">阅读(${val.views})</span>
                                          <span class="comment">评论(${val.commentsCount})</span>
                                          <a href="detail.php" class="like">
                                            <i class="fa fa-thumbs-up"></i>
                                            <span>赞(${val.likes})</span>
                                          </a>
                                          <a href="javascript:;" class="tags">
                                            分类：<span>${val.name}</span>
                                          </a>
                                        </p>
                                        <a href="javascript:;" class="thumb">
                                          <img src="${val.feature}" alt="">
                                        </a>
                                      </div>
                                    </div>`;
                          var entry=$(str);//把符合标签的字符串转化成jq对象
                          // console.log(entry)
                          entry.insertBefore('.loadmore');//把这篇文章追加到 loadmore之前 
                      })
                      // 判断是否已经是点击的最后了
                      // 计算总共的次数
                      var maxPage=Math.ceil(res.pageCount/10);
                      if(maxPage==currentPage){//已经点击到最大了
                          // 如果是隐藏加载更多
                          $('.loadmore').hide();
                          alert('客官，已经木有更多数据了。。。')
                      }
                   
                  }
              }
          })
    })
    

    })
  
  </script>
</body>
</html>