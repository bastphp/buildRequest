基于lumen框架的guzzlehttp/guzzle组件封装的远程请求的组件
##useAge
* @param string $method post get 等
* @param string $url 链接的地址
* @param mixed $params 参数支持数组和字符串
* @param array $header 请求头的数据仅支持数组
* @param callable $errorCall 访问失败后处理失败逻辑的回调函数,参数为抛出的异常
* @param mixed ...$option 不限个数的参数,用与其他参数传参
* @return array
* @throws \GuzzleHttp\Exception\GuzzleException