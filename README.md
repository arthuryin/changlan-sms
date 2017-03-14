# PHP - laravel 创蓝短信验证

基于laravel开发, 开源的. 该项目包含创蓝短信验证, 语音验证接入.

- v1.0.1 增加创蓝语音验证新版接口,更快更稳定

## 轻松安装

 1. 项目根目录运行 `composer require arthuryin/changlan-sms` 或者在项目文件 composer.json 添加 "arthuryin/changlan-sms": "^1.0"
 2. 运行命令 `composer update`
 3. `.env` 配置创蓝账号
        CL_ACCOUNT=N42****2 #短信账户
        CL_PASSWORD=N2Gk****ic21 #短信账户密码
        CLV_ACCOUNT=YC7****50 #语音账户
        CLV_PASSWORD=Sx********21e6 #语音账户密码
        CLV_KEY=cc23a****************012c337 #密钥
        
## 轻松上手

在想用的地方直接使用即可, 可以设置签名为适合更多场景

### Example  发送短信验证
```
        <?php
        
        namespace App\Http\Controllers;
        
        use Arthuryin\ChuanglanSms;
        use Illuminate\Http\Request;
        
        use App\Http\Requests;
        
        class SmsController extends Controller
        {
            public function getSendMS()
            {
                $changlan = new ChuanglanSms\ChuangLanSMS('签名');   // 签名是自己申请
                $result = $changlan->sendSms(18602******, 3713);    // 接收手机号, 验证码
                
            }
        
            public function getSendVoice()
            {
                $changlan = new ChuanglanSms\ChuangLanSMS();
                $result = $changlan->sendVoice(18602******, 1132); // 接收手机号, 验证码
            }

        }
```

## [项目主页](https://github.com/Arthuryin/changlan-sms)

