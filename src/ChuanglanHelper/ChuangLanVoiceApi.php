<?php

namespace Arthuryin\ChuanglanSms\ChuanglanHelper;

/**
 * 创蓝语音短信接口
 * Class ChuangLanVoiceApi
 * @package Arthur\Chuanglan\ChuangLanHelper
 */
class ChuangLanVoiceApi
{
    private $apiSendUrl = 'http://audio.253.com/voice?';//创蓝发送语音验证接口URL
    private $apiBalanceQueryUrl = ''; //创蓝余额查询接口URL
    private $apiAccount = ''; //创蓝账号
    private $apiPassword = ''; //创蓝密码
    private $apiKey = ''; //创蓝密钥

    /**
     * 构造函数
     * @param $apiAccount
     * @param $apiPassword
     */
    public function __construct()
    {
        $this->apiAccount = env('CLV_ACCOUNT', '');
        $this->apiPassword = env('CLV_PASSWORD', '');
        $this->apiKey = env('CLV_KEY', '');
    }

    /**
     * 发送短信
     * @param $mobile 接收手机号
     * @param $code 语音验证码
     * @return mixed
     */
    public function sendSMS($mobile, $code)
    {
        date_default_timezone_set("Asia/Shanghai");
        $timestamp = date("YmdHis");

        //接口参数
        $data = array();
        $data['organization'] = $this->apiAccount; //必填
        $data['phonenum'] = $mobile; //必填
        $data['timestamp'] = $timestamp; //选填
        $data['content'] = md5($this->apiKey . $data['phonenum'] . $this->apiPassword . $timestamp); //必填
        $data['vfcode'] = $code; //必填
        $data['shownum'] = '075561614676';  //审核通过的来电显示号码  //必填
        //以下为选填
        $data['uniqueid'] = uniqid();  //请求唯一标识  //选填
        $data['ringtime'] = 45; //选填
        $data['ivrfileid'] = '';//选填

        $bodyArr['voiceinfo'] = $data;
        $body = 'method=vcfplay&voiceinfo=' . urlencode(json_encode($bodyArr));

        $result = $this->curlPost($this->apiSendUrl, $body);
        return $result;
    }

    /**
     * 处理返回值
     * @param $result
     * @return array
     */
    public function execResult($result)
    {
        $result = json_decode($result, true);
        return $result;
    }

    /**
     * 通过CURL发送HTTP请求
     * @param $url
     * @param $body
     * @return mixed
     */
    private function curlPost($url, $body)
    {
        // 提交请求
        $con = curl_init();
        curl_setopt($con, CURLOPT_URL, $url);
        curl_setopt($con, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($con, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($con, CURLOPT_HEADER, 0);
        curl_setopt($con, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($con, CURLOPT_POST, 1);
        curl_setopt($con, CURLOPT_POSTFIELDS, $body);

        $result = curl_exec($con);
        $result = mb_convert_encoding($result, 'utf-8', 'GBK,UTF-8,ASCII');
        curl_close($con);

        return $result;
    }

}
