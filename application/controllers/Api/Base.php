<?php

use SwuOS\Openapi\Exception\CustomException;
use SwuOS\Openapi\Exception\InvalidRequestMethod;
use SwuOS\Openapi\Exception\NeedLoginException;
use SwuOS\Openapi\Exception\UnsupportedRequestMethodException;
use SwuOS\Openapi\Library\Log;
use Illuminate\Container\Container;
use Illuminate\Translation\ArrayLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\Factory;
use Illuminate\Validation\ValidationException;
use Yaf\Controller_Abstract;

abstract class Api_Base_Controller extends Controller_Abstract
{
    protected $needLogin = true;

    /**
     * 参数校验规则
     *
     * @return array
     */
    abstract protected function rules(): array;

    /**
     * 参数校验失败提示文案
     *
     * @return array
     */
    abstract protected function messages(): array;

    /**
     * 业务逻辑方法
     *
     * @return mixed
     */
    abstract protected function process();

    /**
     * 设置接口请求方式
     *
     * @return string
     */
    protected function method(): string
    {
        return 'GET';
    }

    /**
     * @throws InvalidRequestMethod
     * @throws UnsupportedRequestMethodException
     */
    public function init()
    {
        if ($this->getRequest()->method !== $this->method()) {
            throw new InvalidRequestMethod($this->getRequest()->method);
        }

        switch ($this->method()) {
            case 'GET':
                $parameters = $_GET;
                break;
            case 'POST':
                $parameters = $_POST;
                break;
            default:
                throw new UnsupportedRequestMethodException($this->method());
        }

        $this->getRequest()->setParam($parameters);
    }

    public function indexAction()
    {
        try {
            $this->auth();
            $this->validate();

            $this->process();
        } catch (CustomException $e) {
            Log::info($e->getMessage(), $e->getTrace(), 'error');
            $this->response([], $e->getCode(), $e->getMessage());
        } catch (ValidationException $e) {
            Log::info($e->getMessage(), $e->getTrace(), 'error');
            foreach ($e->errors() as $field => $error) {
                $this->response([], -2, $error[0] ?? $field . '无效');
                break;
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage(), $e->getTrace(), 'error');
            $this->response([], -1, '系统错误');
        } finally {
            Log::info('input', $this->getRequest()->getParams());
        }
    }

    protected function response(array $data, int $code = 0, string $message = 'success')
    {
        $responseData = [
            'errno' => $code,
            'msg'   => $message,
            'data'  => empty($data) ? new stdClass() : $data,
        ];

        Log::info('output', $responseData);

        headers_sent() || header('Content-Type: application/json');

        $this->getResponse()->setBody(json_encode($responseData, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 校验参数
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validate()
    {
        $factory = new Factory(new Translator(new ArrayLoader(), ''), Container::getInstance());

        $factory->validate($this->getRequest()->getParams(), $this->rules(), $this->messages(), []);
    }

    protected function auth()
    {
        if ($this->needLogin === false) {
            return true;
        }

        if (isset($_SESSION['loginInfo']['status']) && $_SESSION['loginInfo']['status']) {
            return true;
        }

        throw new NeedLoginException();
    }
}