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
(function(){
    var appKey = "<?= $appkey?>";
    var token = "<?= $token?>";
    var par=eval(<?= $parList?>);
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


