<?php
/**
 * Created by PhpStorm.
 * User: guoxingong
 * Date: 2019/4/18
 * Time: 10:30
 */

namespace App\Lib;

use Monolog\Formatter\JsonFormatter as BaseJsonFormatter;


class SqlJsonFormatter extends BaseJsonFormatter
{
    public function format(array $record)
    {
        // 这个就是最终要记录的数组，最后转成Json并记录进日志
        $messageArr = explode('---', $record['message']);
        $newRecord = [
            'time'       => ($messageArr[1] ?? 0) .' ms',
            'sql'        => $messageArr[0],
            'context'    => $record['context'],
        ];

        return $this->toJson($this->normalize($newRecord), true) . ($this->appendNewline ? "\n" : '');
    }
}
