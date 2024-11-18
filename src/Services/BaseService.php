<?php
declare(strict_types=1);

namespace Exewen\Sellfox\Services;

use Exewen\Sellfox\Exception\SellfoxException;

class BaseService
{
    private $responseSuccessCode = 0;

    /**
     * 通用响应检查
     * @param $result
     * @return void
     */
    protected function checkResponse($result)
    {
        if (!is_array($result)) {
            throw new SellfoxException('Sellfox:' . __FUNCTION__ . '响应解析异常');
        }
        if (!isset($result['code'])) {
            throw new SellfoxException('Sellfox:' . __FUNCTION__ . '响应格式异常');
        }
        if ($result['code'] !== $this->responseSuccessCode) {
            $msg = $result['msg'] ?? '';
            throw new SellfoxException('Sellfox:' . __FUNCTION__ . '响应code异常(' . $result['code'] . ') ' . $msg);
        }
    }

}