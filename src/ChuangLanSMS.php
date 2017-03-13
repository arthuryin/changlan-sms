<?php
namespace Arthuryin\ChuanglanSms;
use Arthuryin\ChuanglanSms\ChuanglanHelper\ChuangLanSmsApi;
use Arthuryin\ChuanglanSms\ChuanglanHelper\ChuangLanVoiceApi;


Class ChuangLanSMS {
    private $appName = null;//签名
    private $apiAccount = ''; //创蓝账号
    private $apiPassword = ''; //创蓝密码
    /**
     * 初始化
     * @param type $appName
     * @param type $apiAccount
     * @param type $apiPassword
     */
    public function __construct($appName,$apiAccount,$apiPassword) {
        $this->appName = $appName;
        $this->apiAccount = $apiAccount;
        $this->apiPassword = $apiPassword;
    }

    /**
     * 设置签名
     * @param $appName
     */
    public function setAppName($appName) {
        $this->appName = $appName;
    }
    /**
     * 设置帐号密码
     * @param $apiAccount
     * @param $apiPassword
     */
    public function setConfig($apiAccount,$apiPassword){
        $this->apiAccount = $apiAccount;
        $this->apiPassword = $apiPassword;
    }
    /**
     * 发送文本短信消息
     * @param $phone 电话号码
     * @param $code 短信验证码
     * @return bool
     */
    public function sendSms($phone, $code) {
        $clapi = new ChuanglanSmsApi($this->apiAccount,$this->apiPassword);
        $result = $clapi->sendSMS("{$phone}", "【{$this->appName}】您好，您的验证码是{$code}", "false");
        $result = $clapi->execResult($result);
        if (isset($result[1]) && $result[1] == 0) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * 发送语音短信消息
     * @param type $phone 电话号码
     * @param type $code 短信验证码
     * @return bool
     */
    public function sendVoice($phone, $code) {
        $clapi = new ChuanglanVoiceApi($this->apiAccount,$this->apiPassword);
        $result = $clapi->sendSMS("{$phone}", "【{$this->appName}】您好，您的验证码是{$code}", "false");
        $result = $clapi->execResult($result);
        if (isset($result[1]) && $result[1] == 0) {
            return true;
        } else {
            return faslse;
        }
    }
    /**
     * 文本短信消息查询
     */
    public function querySms() {
        $clapi = new ChuanglanSmsApi();
        $result = $clapi->execResult($clapi->queryBalance());
        if (isset($result[1]) && $result[1]) {
            switch ($result[1]) {
                case 0:
                    echo "剩余{$result[3]}条";
                    break;
                case 101:
                    echo '无此用户';
                    break;
                case 102:
                    echo '密码错';
                    break;
                case 103:
                    echo '查询过快';
                    break;
            }
        } else {
            echo "查询失败";
        }
    }
    /**
     * 语音短信消息查询
     */
    public function queryVoice() {
        $clapi = new ChuanglanVoiceApi();
        $result = $clapi->execResult($clapi->queryBalance());
        if (isset($result[1]) && $result[1]) {
            switch ($result[1]) {
                case 0:
                    echo "剩余{$result[3]}条";
                    break;
                case 101:
                    echo '无此用户';
                    break;
                case 102:
                    echo '密码错';
                    break;
                case 103:
                    echo '查询过快';
                    break;
            }
        } else {
            echo "查询失败";
        }
    }
}
