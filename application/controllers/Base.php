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

abstract class Base_Controller extends Controller_Abstract
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

    public function init()
    {
        $this->getRequest()->setParam($_GET);
    }

    public function indexAction()
    {
        try {
            $this->auth();
            $this->validate();

            $this->process();
        } catch (NeedLoginException $e) {
            Log::info($e->getMessage(), $e->getTrace(), 'error');
            $this->redirect('/login');
        } catch (CustomException $e) {
            Log::info($e->getMessage(), $e->getTrace(), 'error');
            $this->display('/error/error');
        } catch (ValidationException $e) {
            Log::info($e->getMessage(), $e->getTrace(), 'error');
            foreach ($e->errors() as $field => $error) {
                $this->display('/error/error');
                break;
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage(), $e->getTrace(), 'error');
            $this->display('/error/error');
        } finally {
            Log::info('input', $this->getRequest()->getParams());
        }
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