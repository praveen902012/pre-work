<?php
namespace Redlof\Core\Helpers;

use Exceptions\ActionFailedException;

/**
 * API Helper class
 */

class MsgHelper
{

    private static $API = 'https://api.msg91.com/api/v5/otp';
    private static $AppKey = 'rdZbReza2yge9OXO19dASMtRY51icjyEZVqxLLUQnT4OO9aDlUlSeR4i7W5o1zjZo0GMhA6np5JNaka4jVYip_VVHqOb4kxjkd1C-Dgw7ygLVin-Ju1BCi_mmI7-cPvqck-aZ_ylpFj4qaEgGqkAjg==';

    private static $SMSFLOWAPI = "https://api.msg91.com/api/v5/flow/";
    private static $SMSAPI = 'https://api.msg91.com/api/v2/sendsms';
    private static $VerifyAPI = 'https://api.msg91.com/api/v5/otp/verify';
    private static $resendOTP = 'https://api.msg91.com/api/v5/otp/retry';
    private static $SMSAppKey = "212223Ap6yiNtk5ae06695";

    private static $senderId = 'RTEPRD';
    private static $OTPLength = 4;

    public static function sendSyncSMS($Data)
    {
        $senderId = "RTEPRD";
        $route = "4";

        $postData = array(
            'sender' => $senderId,
            'route' => $route,
            'country' => '91',
            'sms' => array(
                array(
                    'message' => $Data['message'],
                    'to' => array(
                        self::getPhoneNumber($Data['phone']),
                    ),
                ),
            ),
            'unicode' => 1,
        );

        $ch = curl_init();

        $msgdata = json_encode($postData);

        $authentication_key = self::$SMSAppKey;

        curl_setopt_array($ch, array(
            CURLOPT_URL => self::$SMSAPI,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $msgdata,
            CURLOPT_HTTPHEADER => array(
                "authkey: $authentication_key",
                "content-type: application/json",
            ),
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //get response
        $output = curl_exec($ch);

        //Print error if any
        if (curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
        return $output;
    }

    public static function sendTemplateSMS($Data)
    {
        $smsKey = self::$SMSAppKey;

        $postData = array(
            "flow_id" => $Data['flow_id'],
            "sender" => self::$senderId,
            "mobiles" => '91' . self::getPhoneNumber($Data['phone']),
        );

        // Prepare the variables
        if (isset($Data['variables']) && !empty($Data['variables'])) {
            foreach ($Data['variables'] as $key => $variable) {
                $postData[$key] = $variable;
            }
        }

        $formData = json_encode($postData);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => self::$SMSFLOWAPI,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $formData,
            CURLOPT_HTTPHEADER => array(
                "authkey: $smsKey",
                "content-type: application/JSON",
            ),
        ));

        //Ignore SSL certificate verification
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

        $response = curl_exec($curl);

        if (curl_errno($curl)) {
            echo 'error:' . curl_error($curl);
        }

        curl_close($curl);

        return $response;
    }

    public static function sendSMS($Data, $type = 'campowner')
    {
        $senderId = "RTEPRD";

        $postData = array(
            'authkey' => self::$SMSAppKey,
            'mobiles' => self::getPhoneNumber($Data['phone']),
            'message' => $Data['message'],
            'sender' => $senderId,
            'route' => $route,
            'unicode' => 1,
        );

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => self::$SMSAPI,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData,
        ));

        //Ignore SSL certificate verification
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        //get response
        $output = curl_exec($ch);

        //Print error if any
        if (curl_errno($ch)) {
            echo 'error:' . curl_error($ch);
        }

        curl_close($ch);
        return $output;
    }

    public static function generateOTP($Data)
    {

        //Sanity check
        $RetVal = self::validatePhoneNumber($Data);

        if (!$RetVal) {
            throw new ActionFailedException("Invalid phone number");
        }

        $response = self::callGenerateAPI($Data);
        $response = json_decode($response, true);

        if ($response["type"] == "error") {
            $resp['message'] = $response["message"];
            throw new ActionFailedException($resp['message']);
        }

        return true;
    }

    private static function callGenerateAPI($Data)
    {

        $FullAPI = self::$API . '?authkey=' . self::$SMSAppKey . '&template_id=' . env('MSG_OTP_TEMPLATE_ID', '622ecaf71878260138482703') . '&mobile=91' . self::getPhoneNumber($Data['phone']) . '&sender=' . self::$senderId . '&otp_length=' . self::$OTPLength;

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $FullAPI,
        ));

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    public static function verifyOTP($Data)
    {

        $FullAPI = self::$VerifyAPI . '?authkey=' . self::$SMSAppKey . '&mobile=91' . self::getPhoneNumber($Data['phone']) . '&otp=' . $Data['otp'] . '&retrytype=text';

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $FullAPI,
        ));

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);

        // var_dump($response);

        if ($response["type"] == "error") {
            throw new ActionFailedException("Enter valid OTP");
        }

        return true;
    }

    public static function resendOTP($Data)
    {

        $FullAPI = self::$resendOTP . '?authkey=' . self::$SMSAppKey . '&mobile=91' . self::getPhoneNumber($Data['phone']) . '&retrytype=text';

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $FullAPI,
        ));

        $result = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($result, true);

        if ($response["type"] == "error") {
            if (isset($response['message'])) {
                throw new ActionFailedException($response["message"]);
            } else {
                throw new ActionFailedException("Error Processing This Request");

            }

        }

        return true;
    }

    private static function getAPIMessage($code)
    {
        $msg = '';

        switch ($code) {
            case 'OTP_EXPIRED':
                $msg = 'Your OTP has expired, try resending new OTP.';
                break;

            case 'INVALID_OTP':
                $msg = 'You have entered invalid OTP';
                break;

            case 'OTP_INVALID':
                $msg = 'You have entered invalid OTP';
                break;
        }

        return $msg;
    }

    private static function validatePhoneNumber($Data)
    {
        if (preg_match('/^\(?[0-9]{3}\)?|[0-9]{3}[-. ]? [0-9]{3}?[0-9]{4}$/', self::getPhoneNumber($Data['phone']))) {
            return true;
        }

        return false;
    }

    public static function getPhoneNumber($phone)
    {

        if (env('APP_ENV') === 'production') {
            return $phone;
        }

        return env('OTP_PHONE', $phone);
    }
}
