<?
class Captcha
{
    static private $url = "https://www.google.com/recaptcha/api/siteverify";
    static private $secret = "6LeheekUAAAAAIIKBsxmVmFwTeV2oolCq_76S_QU";

    static function check($gRecaptchaResponse)
    {
        $request = ["secret" => static::$secret, "response" => $gRecaptchaResponse];
        $options = [
            "http" => [
                "method" => "POST",
                "content" => http_build_query($request)
            ]
        ];
        $context = stream_context_create($options);
        $verify = file_get_contents(static::$url, false, $context);
        $captchaSuccess = json_decode($verify);
        return $captchaSuccess->success;
    }
}
