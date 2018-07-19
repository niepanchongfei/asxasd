
  <div class="aside">
    <div class="profile">
      <img class="avatar" src="../static/uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
      <li class="active">
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li>
      <!-- 文章这个li 是否要展开的 -->
      <!-- 约定 $bool 为 true 就代表展开 false代表不需要展开 -->
        <?php
          // echo $current_page;//posts 只要设置$current_page是这几个单词的一个
          // 约定的 $bool 为 true 就代表展开 false代表不需要展开
          // 展开加上对应的 样式即可展开
          $postArr=['posts','post-add','categories'];
          $bool=in_array($current_page,$postArr);
        ?>
        <a href="#menu-posts" 
           class="<?php echo $bool ? '': 'collapsed'  ?>" 
           data-toggle="collapse"
          <?php  echo $bool ? 'aria-expanded="true"':'' ?>
        >
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" 
            class="collapse <?php echo $bool ? 'in': ''  ?>"
            <?php  echo $bool ? 'aria-expanded="true"':'' ?>
        >
          <li><a href="posts.php">所有文章</a></li>
          <li><a href="post-add.php">写文章</a></li>
          <li><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li>
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li>
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
      <?php
          // echo $current_page;//posts
          $postArr1=['nav-menus','slides','settings'];
          $bool1=in_array($current_page,$postArr1);
        ?>
        <a href="#menu-settings" class="<?php echo $bool1 ? '': 'collapsed'  ?>" 
        data-toggle="collapse"
        <?php  echo $bool1 ? 'aria-expanded="true"':'' ?>>
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo $bool1 ? 'in': ''  ?>"
        <?php  echo $bool1 ? 'aria-expanded="true"':'' ?>
        >
          <li><a href="nav-menus.php">导航菜单</a></li>
          <li><a href="slides.php">图片轮播</a></li>
          <li><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script>
    // 页面一打开就要发送ajax'拿头像和用户名显示到页面
    $(function(){
      $.ajax({
        type:"post",
        url:"api/_getUserAvator.php",
        success:function(res){
            // console.log(res);
            // alert(res)
            // 动态生成用户名和头像
            $('.avatar').attr('src',res.avatar);
            $('.name').text(res.nickname);
        }
      })

    })
  
  </script>