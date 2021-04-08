<?php


namespace DaShan\buildRequest;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ServerException;

class Access
{
    /**
     * @param string $method post get 等
     * @param string $url 链接的地址
     * @param mixed $params 参数支持数组和字符串
     * @param array $header 请求头的数据仅支持数组
     * @param callable $errorCall 访问失败后处理失败逻辑的回调函数,参数为抛出的异常
     * @param mixed ...$option 不限个数的参数,用与其他参数传参
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public static function buildRequest($method, $url, $params = '', array $header = [], $errorCall = null ,...$option)
    {
        try {
            $client = new Client();
            $options = [];
            if (!empty($params)) {
                if (is_array($params)) {
                    $options = array_merge($options, $params);
                } else {
                    $options['body'] = $params;
                }
            }
            if (!empty($header)) {
                $options['headers'] = $header;
            }
            array_map(function ($value) use (&$options) {
                foreach ($value as $key => $item) {
                    $options[$key] = $item;
                }
            }, $option);
            $response = $client->request($method, $url, $options);
            if ($response->getStatusCode() == 200) {
                $result = $response->getBody()->getContents();
                return json_decode($result, true);
            } else {
                if (!is_null($errorCall)){
                    return $errorCall(new \Exception('http status code error', ErrorCode::HTTP_CODE_ERROR));
                }
                throw new \Exception('http status code error', ErrorCode::HTTP_CODE_ERROR);
            }
        } catch (ServerException $e) {
            if (!is_null($errorCall)){
                return $errorCall($e);
            }
            throw new \Exception($e->getMessage(), ErrorCode::HTTP_CODE_ERROR);
        } catch (ClientException $e) {
            if (!is_null($errorCall)){
                return $errorCall($e);
            }
            throw new \Exception($e->getMessage(), ErrorCode::HTTP_CODE_ERROR);
        }
    }
}
