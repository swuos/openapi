<?php

class Index_Controller extends Base_Controller
{
    protected $needLogin = false;

    /**
     * 参数校验规则
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'page'     => 'sometimes|integer',
            'pageSize' => 'sometimes|integer',
        ];
    }

    /**
     * 参数校验失败提示文案
     *
     * @return array
     */
    protected function messages(): array
    {
        return [
            'page.integer'     => 'page 必须是整数',
            'pageSize.integer' => 'pageSize 必须是整数',
        ];
    }

    /**
     * 业务逻辑方法
     *
     * @return mixed
     */
    protected function process()
    {

    }
}