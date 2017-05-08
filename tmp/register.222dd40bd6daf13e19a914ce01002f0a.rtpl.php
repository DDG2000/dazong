<?php if(!class_exists('raintpl')){exit;}?> <?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("inc/css") . ( substr("inc/css",-1,1) != "/" ? "/" : "" ) . basename("inc/css") );?>
<title>注册页面</title>
</head>
<body>
	<div class="userformpage w1100 c">
		<div class="userform-head cb">
			<a href="#" class="logo2 vmt ib">聚能</a><span class="logo2-text">欢迎注册</span>
		</div>
		<div class="userform-content">
			<span class="fr userform-go">已有帐号？<a href="http://www.bigsm.com/index.php?act=user&m=public&w=login" class="fr">立即登录</a></span>
			<form action="##" method="POST" class="register" id="register" autocomplete="on">
				<div class="item">
					<span class="title ib" danger>手机号码：</span>
					<input type="text" text name="Vc_mobile" placeholder="请输入手机号" value=""/>
				</div>
				<div class="item">
					<span class="title ib" danger>短信验证码：</span>
					<input type="text" yzm id="yzm" maxlength="4" name="kcode" placeholder="请输入短信验证码"/><a href="javascript:;" class="ib btn-get" id="getYzm">获取验证码</a>
					<span class="msg-box" for="yzm"></span>
				</div>
				<div class="item">
					<span class="title ib" danger>密码：</span>
					<input type="password" text name="Vc_password" data-rule="密码: required;password;" placeholder="请输入密码">
				</div>
				<div class="item">
					<span class="title ib" danger>确认密码：</span>
					<input type="password" text name="repassword" data-rule="确认密码: required;match(Vc_password);" placeholder="请再次输入相同密码"/>
				</div>
				<div class="item">
					<span class="title ib" danger>真  实姓名：</span>
					<input type="text" text name="Vc_truename" placeholder="请输入真实姓名" data-rule="真实姓名:required;chinese;length[2~]"/>
				</div>
				<div class="item">
					<span class="title ib" danger>公司名称：</span>
					<input type="text" text name="Vc_company" data-rule="公司名字:required;"/>
				</div>
				<div class="item fs0">
					<span class="title ib" danger>所在城市：</span>
					<div class="ib select">
						<input type="text" select data-type="country" value="中国">
						<input class="hidden" type="text" name="I_countryID" value="1" />
						<div content class="cb"></div>
					</div>
					<div class="ib select" id="province">
						<input type="text" select data-type="province" value="四川">
						<input type="text" class="hidden" name="I_provinceID" value="1">
						<div content class="cb"></div>
					</div>
					<div class="ib select" id="city">
						<input type="text" select data-type="city" value="达州市">
						<input type="text" class="hidden" name="I_cityID" value="1">
						<div content class="cb"></div>
					</div>
					<div class="ib select" id="district">
						<input type="text" data-type="district" select value="大竹县">
						<input type="text" class="hidden" name="I_districtID" value="1">
						<div content class="cb"></div>
					</div>
				</div>
				<div class="item">
					<input type="text" addr name="Vc_address"  data-rule="详细地址:required;limits;"/>
				</div>
				<div class="item">
					<span class="title ib vmm" danger>公司性质：</span>
					<div class="ib vmm xingzhi-wrap">
						<input class="hidden" type="text" name="" value="" id="compnay_hidden">
						<label class="check"><input type="checkbox" name="Vc_propID[]" data-id="1" value="1"/>制造工厂</label>
						<label class="check"><input type="checkbox" name="Vc_propID[]" data-id="2" value="2"/>贸易商</label>
						<label class="check"><input type="checkbox" name="Vc_propID[]" data-id="3" value="3"/>终端用户</label>
						<label class="check"><input type="checkbox" name="Vc_propID[]" data-id="4" value="4"/>其他</label>
					</div>
				</div>
				<div class="item">
					<label class="check read"><input type="checkbox"/></label><span xieyi>我已阅读并同意<a href="javascript:;">《聚能用户服务协议》</a></span>
				</div>
				<button type="submit">提交注册</button>
			</form>
		</div>
		<div class="userformpage-footer">
			<ul class="w userpage-nav ib-li tac">
				<li><a href="#">关于我们</a></li>|
				<li><a href="#">网站公告</a></li>|
				<li><a href="#">人才招聘</a></li>|
				<li><a href="#">联系我们</a></li>|
				<li><a href="#">法律说明</a></li>|
				<li><a href="#">安全保障</a></li>
			</ul>
			<div class="w cprt tac">
				四川鑫能裕丰电子商务有限公司版权所有<em class="space"></em><a href="#">蜀ICP备140000000000号</a>
			</div>
		</div>
	</div>
	<?php $tpl = new RainTPL;$tpl_dir_temp = self::$tpl_dir;$tpl->assign( $this->var );$tpl->draw( dirname("inc/js") . ( substr("inc/js",-1,1) != "/" ? "/" : "" ) . basename("inc/js") );?>