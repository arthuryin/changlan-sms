<?php

namespace Arthuryin\ChuanglanSms\ChuanglanHelper;

/**
 * 创蓝短信接口
 * Class ChuangLanSmsApi
 * @package Arthur\Chuanglan\ChuangLanHelper
 */
class ChuangLanSmsApi
{
    private $apiSendUrl = 'http://sms.253.com/msg/HttpBatchSendSM';//创蓝发送短信接口URL
    private $apiBalanceQueryUrl = 'http://sms.253.com/msg/QueryBalance'; //创蓝短信余额查询接口URL
    private $apiAccount = ''; //创蓝账号
    private $apiPassword = ''; //创蓝密码

    /**
     * ChuangLanSmsApi constructor.
     * @param $apiAccount env配置账号
     * @param $apiPassword env配置密码
     */
    public function __construct()
    {
        $this->apiAccount = env('CL_ACCOUNT', '');
        $this->apiPassword = env('CL_PASSWORD', '');
    }

    /**
     * 设置帐号密码
     * @param $apiAccount
     * @param $apiPassword
     */
    public function setConfig($apiAccount, $apiPassword)
    {
        $this->apiAccount = $apiAccount;
        $this->apiPassword = $apiPassword;
    }

    /**
     * 发送短信
     * @param $mobile   手机号码
     * @param $msg  短信内容
     * @param string $needstatus 是否需要状态报告
     * @return mixed
     */
    public function sendSMS($mobile, $msg, $needstatus = 'false')
    {
        //创蓝接口参数
        $postArr = array(
            'account' => $this->apiAccount,
            'pswd' => $this->apiPassword,
            'msg' => $msg,
            'mobile' => $mobile,
            'needstatus' => $needstatus
        );
        $result = $this->curlPost($this->apiSendUrl, $postArr);
        return $result;
    }

    /**
     * 查询额度, 地址
     * @return mixed
     */
    public function queryBalance()
    {
        //查询参数
        $postArr = array(
            'account' => $this->apiAccount,
            'pswd' => $this->apiPassword,
        );
        $result = $this->curlPost($this->apiBalanceQueryUrl, $postArr);
        return $result;
    }

    /**
     * 处理返回值
     * @param $result
     * @return array
     */
    public function execResult($result)
    {
        $result = preg_split("/[,\r\n]/", $result);
        return $result;
    }

    /**
     * 通过CURL发送HTTP请求
     * @param string $url //请求URL
     * @param array $postFields //请求参数
     * @return mixed
     */
    private function curlPost($url, $postFields)
    {
        $postFields = http_build_query($postFields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

    //魔术获取
    public function __get($name)
    {
        return $this->$name;
    }

    //魔术设置
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}