<?php
namespace Arthuryin\ChuanglanSms;

use Arthuryin\ChuanglanSms\ChuanglanHelper\ChuangLanSmsApi;
use Arthuryin\ChuanglanSms\ChuanglanHelper\ChuangLanVoiceApi;


Class ChuangLanSMS
{

    private $appName = null;//签名
    private $apiAccount = ''; //创蓝账号
    private $apiPassword = ''; //创蓝密码

    /**
     * 初始化
     * @param type $appName
     * @param type $apiAccount
     * @param type $apiPassword
     */
    public function __construct($appName)
    {
        $this->appName = $appName;
    }

    /**
     * 发送文本短信消息
     * @param int $phone 接收人电话号
     * @param $code 验证码
     * @return bool
     */
    public function sendSms($phone, $code)
    {
        $clapi = new ChuanglanSmsApi();
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
    public function sendVoice($phone, $code)
    {
        $clapi = new ChuangLanVoiceApi($this->apiAccount, $this->apiPassword);
        $result = $clapi->sendSMS($phone, $code);
        $result = $clapi->execResult($result);
        if ($result) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 文本短信消息查询
     * @return string 返回结果
     */
    public function querySms()
    {
        $clapi = new ChuanglanSmsApi();
        $result = $clapi->execResult($clapi->queryBalance());

        if (!is_array($result)) {
            return '查询失败';
        }

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
    }

    /**
     * 语音短信消息查询
     */
    public function queryVoice()
    {
        $clapi = new ChuanglanVoiceApi();
        $result = $clapi->execResult($clapi->queryBalance());

        if (!is_array($result)) {
            return '查询失败';
        }

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
    }
}
