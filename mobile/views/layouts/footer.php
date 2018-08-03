<?php 
use yii\helpers\Url;
use mobile\assets\AppAsset;
AppAsset::register($this);
 ?>
<link media="all" rel="stylesheet" type="text/css" href="/css/bootstrap.css" />
<div class="container-fluid" id="footer-display">
 <div class="footer-nav mynav off">
  <div class="row">
   <div class="col-xs-12 footer-nav-background">      
   </div> 
  </div>
 </div>
 <div class="footer-nav2 mynav off">
  <div class="row">
   <div class="col-xs-12 footer-nav-background">
      <a href="" onfocus="this.blur()">
        <div class="footer-div">
            家校沟通
        </div>
     </a>
     <a href="" onfocus="this.blur()">
        <div class="footer-div">
            平安通知
        </div>
     </a>
     <a href="" onfocus="this.blur()">
        <div class="footer-div">
           水卡服务
        </div>
     </a>
     <a href="" onfocus="this.blur()">
        <div class="footer-div">
           餐卡服务
        </div>
     </a>
  
     <a href="" onfocus="this.blur()">
        <div class="footer-div">
            亲情电话
        </div>
     </a>    
   </div> 
  </div>
 </div> 
 
 <div class="footer-nav3 mynav off">
  <div class="row">
   <div class="col-xs-12 footer-nav-background">
       <a href="<?= Url::toRoute(['information/index']); ?>" onfocus="this.blur()">
        <div class="footer-div">
            我的资料
        </div>
       </a>    
       <a href="" onfocus="this.blur()">
        <div class="footer-div">
            最新动态
        </div>
       </a>
        <a href="" onfocus="this.blur()">
        <div class="footer-div">
            内部交流
        </div>
       </a>
       <a href="" onfocus="this.blur()">
        <div class="footer-div">
            学校公告
        </div>
       </a>     
       <a href="" onfocus="this.blur()">
        <div class="footer-div">
            投诉建议
        </div>
       </a>       
       <a href="/information/help" onfocus="this.blur()">
        <div class="footer-div">
            使用帮助
        </div>
       </a>
   </div> 
  </div>
 </div>
</div>
<!-- 页脚菜单 -->
<div class="container-fluid">
  <div class="row" id="footer">
       <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 footer-center">
         <li>
             <a href="<?php echo Url::toRoute(['homepage/index']); ?>" onfocus="this.blur()">
                 <div class="row">
                    <span class="glyphicon glyphicon-home"></span>
                 </div>
                 <span>首页</span>
             </a>
         </li>
       </div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 footer-center">
         <li>
             <a href="<?php echo Url::toRoute(['zfend/index']);?>" onfocus="this.blur()">
                 <div class="row">
                    <span class="glyphicon glyphicon-send"></span>
                 </div>
                 <span>我要支付</span>
             </a>
         </li>
       </div>
       <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 footer-center">
         <li>
             <div class="footer-menu" id="footer-nav2">
                 <div class="row">
                    <span class="glyphicon glyphicon-map-marker"></span>
                 </div>
                 <span>家校互动</span>
             </div>
         </li>
       </div>
       <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 footer-center">
         <li>
             <div class="footer-menu" id="footer-nav3">
                 <div class="row">
                    <span class="glyphicon glyphicon-heart-empty"></span>
                 </div>
                 <span>个人中心</span>
             </div>
         </li>       
       </div>
  </div>
</div>
<script type="text/javascript">
  
 // 底部菜单导航 遮盖  掌上物业
  $(".footer-menu").click(function(){ 
     var thisid = $(this).attr("id");
   $(".mynav").each(function() {
     if($(this).hasClass(thisid)){
       if($(this).hasClass("on")){
            $(this).slideUp(300);
         $(this).removeClass("on").addClass("off");
         }else{
         $("."+thisid).slideDown(300);
         $(this).removeClass("off").addClass("on");
           
      }
       
     }else{
            $(this).slideUp(300);
      $(this).removeClass("on").addClass("off");
     }
     });
   
  });
  </script>