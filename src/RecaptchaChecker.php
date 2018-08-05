<?php
/**
 * Created by PhpStorm.
 * User: svc
 * Date: 05.08.2018
 * Time: 22:51
 */

namespace Svc;

use Curl;


class RecaptchaChecker
{
    private $url = "https://www.google.com/recaptcha/api/siteverify";
    private $secret;

    /**
     * RecaptchaConnector constructor.
     * @param string $secret
     * @throws \Exception
     */
    function __construct(string $secret = "")
    {
        if (empty($secret)) {
            throw new \Exception("Secret key must be filled");
        }
        $this->secret = $secret;
    }

    /**
     * @param string $code
     * @return bool
     */
    function check(string $code)
    {
        $curl = new Curl\Curl();
        try {
            $curl->post($this->url, [
                'secret' => $this->secret,
                'response' => $code
            ]);

            if ($curl->error) {
                return false;
            }
            $response = json_decode($curl->response);

            return $response->success;
        } catch (\Exception $exception) {
            return false;
        }
    }
}