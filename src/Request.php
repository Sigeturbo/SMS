<?php

namespace SigeTurbo\SMS;

use \Exception as Exception;

class Request
{
    private $user;
    private $token;
    private $url;
    private $version = 'php-1.1';

    /**
     * Request constructor.
     * @param $user
     * @param $token
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
        $this->url = env('SMS_SERVER', config('sms.server'));
    }

    /**
     * Method POST
     * @param $resource
     * @param $data
     * @return mixed
     * @throws Exception
     */
    public function post($resource, $data)
    {
        $request = $this->buildRequest($resource, "POST", $data);
        return $this->executeRequest($request, $resource);
    }

    /**
     * Method GET
     * @param $resource
     * @param string $data
     * @return mixed
     * @throws Exception
     */
    public function get($resource, $data = '{}')
    {
        $request = $this->buildRequest($resource, "GET", $data);
        return $this->executeRequest($request, $resource);
    }

    /**
     * Method DELETE
     * @param $resource
     * @param string $data
     * @return mixed
     * @throws Exception
     */
    public function delete($resource, $data = '{}')
    {
        $request = $this->buildRequest($resource, "DELETE", $data);
        return $this->executeRequest($request, $resource);
    }

    /**
     * Build Request
     * @param $resource
     * @param $method
     * @param $data
     * @return array
     */
    private function buildRequest($resource, $method, $data)
    {
        $data_string = json_encode($data);
        $request = array("url" => $this->url . $resource, "method" => $method, "body" => $data_string);

        $auth_string = $this->user . ":" . $this->token;
        $auth = base64_encode($auth_string);

        $request["headers"] = array(
            "Authorization" => "Basic " . $auth,
            "Content-Type" => "application/json",
            "Content-Length" => strlen($data_string),
            "X-API-Source" => $this->version
        );
        return $request;
    }

    /**
     * Execute Request
     * @param $request
     * @param $resource
     * @return mixed
     * @throws Exception
     */
    protected function executeRequest($request, $resource)
    {
        $handler = curl_init($request["url"]);
        curl_setopt($handler, CURLOPT_CUSTOMREQUEST, $request["method"]);
        curl_setopt($handler, CURLINFO_HEADER_OUT, TRUE);
        curl_setopt($handler, CURLOPT_VERBOSE, true);
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
        $headers = $this->parseHeaders($request["headers"]);
        curl_setopt($handler, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($handler, CURLOPT_POSTFIELDS, $request["body"]);

        $response = curl_exec($handler);
        $code = curl_getinfo($handler, CURLINFO_HTTP_CODE);
        if ($code != 200) {
            $errorMessage = $this->getErrorMessage($handler, $resource);
            throw new Exception($errorMessage);
        }

        return json_decode(utf8_encode($response));
    }

    /**
     * Parse Headers
     * @param $arrayHeaders
     * @return array
     */
    private function parseHeaders($arrayHeaders)
    {
        $headers = array();
        foreach ($arrayHeaders as $key => $value) {
            array_push($headers, $key . ": " . $value);
        }
        return $headers;
    }

    /**
     * Get Error Message
     * @param $handler
     * @param $resource
     * @return string
     */
    private function getErrorMessage($handler, $resource)
    {
        $code = curl_getinfo($handler, CURLINFO_HTTP_CODE);
        $error_description = curl_error($handler);
        switch ($code) {
            case 0 : {
                return 'Server not found, check your internet connection or proxy configuration. [' . $error_description . ']';
            }
            case 401 : {
                return 'Unauthorized resource [' . $resource . ']. Check your user credentials';
            }
            default : {
                return 'Unexpected error [' . $resource . '] [code=' . $code . ']';
            }
        }
    }
}
