<?php
require_once '../config.php';
require_once '../functions.php';
// checkLogin();//这个方法 可以判断 是否登录
?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
    <?php include_once 'public/_navbar.php' ?>
    <div class="container-fluid">
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong><span id="msg"></span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id="data">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
            <div class="form-group">
              <label for="classname">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="classname">
            </div>
            <div class="form-group">
              <button id="btn-add" class="btn btn-primary" type="button">添加</button>
              <button id="btn-edit" class="btn btn-primary" type="button" style="display:none">编辑完成</button>
              <button id="btn-cancle" class="btn btn-primary" type="button" style="display:none">取消编辑</button>
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id="delAll" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
               <!-- 坑  -->
          
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php  $current_page='categories'; ?>
 <?php include_once 'public/_aside.php'; ?>

  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>
    $(function(){
      //页面加载完成后会触发
      // 发送ajax获取所有分类的 数据   拼接字符串渲染到页面上
      $.ajax({
        type:"post",
        url:"api/_getCategoryData.php",
        success:function(res){
          // console.log(res)
          if(res.code==1){
            var str='';
            var data=res.data;//数组 里面有四个分类
            $.each(data,function(i,e){//e就是每一个分类对象
                str+=`<tr data-categoryid="${e.id}">
                        <td class="text-center"><input type="checkbox"></td>
                        <td>${e.name}</td>
                        <td>${e.slug}</td>
                        <td>${e.classname}</td>
                        <td class="text-center">
                          <a href="javascript:;" data-categoryid="${e.id}" class="btn btn-info btn-xs edit">编辑</a>
                          <a href="javascript:;"  class="btn btn-danger btn-xs del">删除</a>
                        </td>
                      </tr>`;
            })
            //循环完了 
            $(str).appendTo('tbody');
        
            // $('tbody').html(str)
          }
        }
      })


      // 点击 添加 发送ajax到后台    后台判断分类是否存在  存在就返回存在了 如果不存在添加
      $("#btn-add").on("click",function(){
        // 获取表单数据
        var name=$("#name").val();
        var slug=$("#slug").val();
        var classname=$("#classname").val();
        // 判断是否为空
        if(name==''){
            // 提示不能为空
            $("#msg").text('不能为空');
            $(".alert").show();
            return;
        }
        if(slug==''){
            // 提示不能为空
            $("#msg").text('slug不能为空');
            $(".alert").show();
            return;
        }
        // 发送ajax到后台
        $.ajax({
          type:"post",
          url:"api/_addCategory.php",
          data:$("#data").serialize(),
          success:function(res){
              // console.log(res);
              if(res.code==1){
                // 如果添加成功 动态追加一个tr到页面
               var str=`<tr>
                        <td class="text-center"><input type="checkbox"></td>
                        <td>${name}</td>
                        <td>${slug}</td>
                        <td>${classname}</td>
                        <td class="text-center">
                          <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                          <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                        </td>
                      </tr>`;
               $("tbody").append(str);
              }
          }
        })
      })
      // 点击编辑 把对应的点击这个数据 填写到表单的框里面
      //点击编辑按钮 获取自定义的id  把这个id 设置到编辑完成按钮上面
      var tr='';//点击编辑的把那个tr存在这里
      $("tbody").on("click",".edit",function(){
        // 把自己的id 设置到 编辑完成按钮上面
        var categoryid=$(this).attr("data-categoryid");
        // 设置到 编辑完成按钮上面
         tr=$(this).parents('tr');
        $("#btn-edit").attr("data-categoryid",categoryid);
        // 显示编辑完成 和取消编辑按钮  隐藏添加按钮
        $("#btn-add").hide();
        $("#btn-edit").show();
        $("#btn-cancle").show();
        // 获取当前这个tr的每个数据 填写到表单里面
        // $(this).parent().parent()
        var name=$(this).parents('tr').children().eq(1).text();
        var slug=$(this).parents('tr').children().eq(2).text();
        var classname=$(this).parents('tr').children().eq(3).text();
        $("#name").val(name);
        $("#slug").val(slug);
        $("#classname").val(classname);
      })
      // 点击编辑完成按钮  发送ajax到后台   
      $("#btn-edit").on("click",function(){
        // 获取name slug classname 还要获取到你要修改的id
        //刚刚点击编辑的时候 设置过来的
        var categoryid=$(this).attr("data-categoryid");
        var name=$("#name").val();
        var slug=$("#slug").val();
        var classname=$("#classname").val();
        // 判断是否为空
        if(name==''){
            // 提示不能为空
            $("#msg").text('不能为空');
            $(".alert").show();
            return;
        }
        // 把修改的 name slug classname id 发送到后台
        $.ajax({
          type:"post",
          url:"api/_updateCategory.php",
          data:{id:categoryid,name:name,slug:slug,classname:classname},
          success:function(res){
             if(res.code==1){
               //把修改的数据 写到那个tr里面
               tr.children().eq(1).text(name);
               tr.children().eq(2).text(slug);
               tr.children().eq(3).text(classname);
               // 清空文本框的值
               $("#name").val('')
               $("#slug").val('')
               $("#classname").val('')
               //  显示添加按钮 隐藏编辑完成与取消编辑
               $("#btn-add").show();
               $("#btn-edit").hide();
               $("#btn-cancle").hide();
             }
          }
        })


      })

      // 取消编辑
      // 点击取消编辑按钮
      // 清空 文本框的 值
      // 显示添加按钮  隐藏编辑完成和取消编辑按钮

      // 删掉
      // 点击删除按钮
      $('tbody').on("click",'.del',function(){
         // 获取要删除的id 写在tr上面 一会又很多地方都要用 这样减少很多代码
          var row=$(this).parents('tr');//获取当前的tr;
          var categoryid=row.attr('data-categoryid');
         // 发送ajax到后台
         $.ajax({
           type:"post",
           url:"api/_delCategory.php",
           data:{id:categoryid},
           success:function(res){
              // console.log(res)
              if(res.code==1){
                // 删除这个tr
                row.remove();//jq方法 自杀
              }
           }
         })
      })
      // thead input  全选
      // tbody input  很多的那些
      //  全选 绑定点击事件
      $("thead input").on("click",function(){
          var status=$(this).prop("checked");
          $("tbody input").prop("checked",status);//不能使用attr方法
          if(status){//全部选中 就应该显示 批量删除按钮
              $("#delAll").show();
          }else{
            $("#delAll").hide();
          }
      })
      // 给tbody里面的 绑定事件
      $("tbody").on("click","input",function(){
        var all=$("thead input");//全选框
        var cks=$("tbody input");//所有的框
        // var cksChecked=$("tbody input:checked"); // 所有被选中的框
        // size() 是jq的方法 获取多少个数 类似 length
        // if(cks.size()==$("tbody input:checked").size()){//所有的框个数 和 所有选中的框的 个数一样就全选了
        //   all.prop("checked",true)
        // }else{
        //   all.prop("checked",false)
        // }
        all.prop("checked",cks.size()==$("tbody input:checked").size());
        if($("tbody input:checked").size()>=2){
          $("#delAll").show();
        }else{
          $("#delAll").hide();
        }

      })

      // 批量删除
      $("#delAll").on("click",function(){
        var ids=[];//用来存 所有的 id
        // 获取 选中到的 那些框的id
        var csk=$("tbody input:checked");//选中的框
        csk.each(function(i,e){
            // $(e) 每一个选的框
            //获取tr上的id
           var id= $(e).parents('tr').attr("data-categoryid");
           ids.push(id);
        })
        // 循环完 所有的 选中的 id 就放到了 ids这个数组里面
        //  alert(ids)
        $.ajax({
          type:"post",
          url:"api/_delAll.php",
          data:{ ids:ids },
          success:function(res){
            // console.log(res)
            if(res.code==1){
              csk.parents('tr').remove();
            }
          }
        })
      })





})
  
  </script>
</body>
</html>
