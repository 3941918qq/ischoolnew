<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<link rel="stylesheet" href="/im/im.css">
<!--<div id="pull-left" style="margin-left: 10px;width: 75%;min-width: 600px;display: block;">
</div>-->
<div id="rcs-app"></div>
<!-- 
SDK 文档：http://www.rongcloud.cn/docs/web.html#sdk
-->
<script src="//cdn.ronghub.com/RongIMLib-2.3.0.js"></script>
<!-- <script src="./libs/RongEmoji.js"></script> -->
<script src="//cdn.ronghub.com/RongEmoji-2.2.6.min.js"></script> 

<script src="/im/libs/utils.js"></script>
<script src="/im/libs/qiniu-upload.js"></script>

<script src="/im/template.js"></script>
<script src="/im/emoji.js"></script>
<script src="/im/im.js"></script>

<!-- 实例化 -->
<script>
/*
具体使用时：
1：切换到自己的 key 和 token
2：移除 im.js 里的 sendTextMessage(instance); 这行代码
3：自行二次开发
4：参考
    - 用户数据处理 http://support.rongcloud.cn/kb/NjQ5
    - 消息状态 http://support.rongcloud.cn/kb/NjMz
    - 集成指南 https://rongcloud.github.io/websdk-demo/integrate/guide.html
    - 其他 demo https://github.com/rongcloud/websdk-demo
*/    
(function(){
//    var appKey = "3argexb6r934e";
//    var token = "b/jvjEFD41TIVT0nsf9+L3ryPPkHsvRwWZV8SVI5ICcZ2I5Nl4OdNO01OjZxjjmVlD2dmk4RZ90=";
      var appKey = "<?= $appkey?>";
    var token = "<?= $token?>";
    var par=eval(<?= $parList?>);
//    console.log(par);
    RCS.init({
        appKey: appKey,
        token: token,
        target: document.getElementById('rcs-app'),
        showConversitionList: true,
        par:par,
        templates: {
            button: ['<div id="pull-left" style="margin-left: 10px;width: 75%;min-width: 600px;display: block;">',
                    '<div class="rongcloud-consult rongcloud-im-consult" style="display:none;">',
                    '   <button onclick="RCS.showCommon()"><span class="rongcloud-im-icon">开始会话</span></button>',
                    '</div>',
                    '<div class="customer-service" ></div></div>'].join('')//"templates/button.html",
            // chat: "templates/chat.html",
            // closebefore: 'templates/closebefore.html',
            // conversation: 'templates/conversation.html',
            // endconversation: 'templates/endconversation.html',
            // evaluate: 'templates/evaluate.html',
            // imageView: 'templates/imageView.html',
            // leaveword: 'templates/leaveword.html',
            // main: 'templates/main.html',
            // message: 'templates/message.html',
            // messageTemplate: 'templates/messageTemplate.html',
            // userInfo: 'templates/userInfo.html', 
        },
        extraInfo: {
            // 当前登陆用户信息
            userInfo: {
                name: "游客",
                grade: "VIP"
            },
            // 产品信息
            requestInfo: {
                productId: "123",
                referrer: "10001",
                define: "" // 自定义信息
            }
        }
    });
})()


</script>

</html>