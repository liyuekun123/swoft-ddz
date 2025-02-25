<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>这是一个斗地主打牌测试工具</title>
</head>
<style>
.show{
    width:1000px;
    margin:10px;
    padding:10px
    border:1px solid red;
    float: left;
}
.btn{
    height: 25px;
    width: 80px;
}
#url{
    height: 25px;
    width: 400px;
}
li{
    padding:10px 0px;
}

</style>
<body>
<div class="show">
    <h1>昵称:<?php echo $account;?><span id="master"></span></h1>
    <div >
        服务器链接:
        <input id="url" value="ws://192.168.10.10:18308/game" >
        <input class="btn" type="button" value="连接" id="ConnBt" onclick="conn()">
    </div>
    <br>
    <div >
        <input class="btn" type="button" value="游戏开始" id="conn" name="conn" onclick="start()">
        <input class="btn" type="button" value="叫地主" id="call" name="call" onclick="call()" disabled>
        <input class="btn" type="button" value="不叫" id="nocall" name="nocall" onclick="nocall()" disabled>
        <input class="btn" type="button" value="打牌" id="play" name="play" onclick="play()" disabled>
        <input class="btn" type="button" value="过牌" id="pass" name="pass" onclick="pass()" disabled>
    </div>
    <br>
	我的手牌:
    <div class="showcard">
		<div id="chair_1" name="chair_1"></div>
		<div id="chair_2" name="chair_2"></div>
		<div id="chair_3" name="chair_3"></div>
    </div>
	<br>
    <br>
	<br>
    <br>
	上次出牌:
	<div id="last_card" name="last_card"></div>
	<br>
    <br>
	<br>
    <br>
	本次出牌:
	<div id="out_card" name="out_card"></div>
	<br>
    <br>
	<br>
    <br>
    <div>
        <textarea style="HEIGHT: 300px; WIDTH: 600px" rows="1" cols="1" readonly name="msgText" id="msgText"></textarea>
    </div>
    <br>
    <div>
        发送消息：
        <input style="HEIGHT: 21px; WIDTH: 300px" size="17" id="SendText" value="send data test">
		<input class="btn" type="button" value="发送" onclick="send()">
        <input class="btn" type="button" value="清除数据" onclick="clear_msg();">
    </div>
</div>
</body>
<script src="client/Init.js?v15"></script>
<script src="client/Const.js?v15"></script>
<script src="client/Req.js?v15"></script>
<script src="client/Resp.js?v15"></script>
<script src="client/Packet.js?v15"></script>
<script src="client/msgpack.js?v15"></script>
<script type="text/javascript" >
var info = {};
//连接websocket
function conn() {
	var url = document.getElementById('url').value;
	obj = Init.webSock(url);
	return obj;
}
	//websocket
var obj = conn();

//游戏开始
function start() {
	Req.GameStart(obj, []);
}

//叫地主开始
function call() {
    //叫地主之前, 先要获取登录数据,人数是否够数
	Req.GameCall(obj, 1);
}

//不叫地主
function nocall() {
	Req.GameCall(obj, 0);
}

//玩牌
function play() {
	var data = {};
	data['status'] = 1;
	data['chair_id'] = info.chair_id;
	var obj_box = document.getElementsByName("handcard");
	var check_val = [];
    for(k in obj_box){
        if(obj_box[k].checked)
            check_val.push(obj_box[k].value);
    }
	if(check_val.length == 0) {
		alert('请选牌!');
		return false;
	}
	data['card'] = check_val;
	Req.PlayGame(obj, data);
}

//过牌
function pass() {
	var data = {};
	data['status'] = 0;
	data['chair_id'] = info.chair_id;
	data['card'] = [];
	Req.PlayGame(obj, data); 
}

//发送消息函数
function send(){
	var data = document.getElementById('SendText').value;
	if(data.length <= 0) return ;
	Req.ChatMsg(obj, data);
}
	
//请求消息框
function clear_msg() {
	document.getElementById('msgText').innerHTML = '';
}

</script>
</html>