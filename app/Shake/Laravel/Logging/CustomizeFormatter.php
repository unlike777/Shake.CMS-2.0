<?php

namespace App\Shake\Laravel\Logging;

use App\Shake\Laravel\Logging\ExtLineFormatter as LineFormatter;

class CustomizeFormatter
{
    /**
     * Customize the given logger instance.
     *
     * @param  \Illuminate\Log\Logger  $logger
     * @return void
     */
    public function __invoke($logger)
    {
        //Оформляем логи
        $handler = $logger->popHandler();
        
        //меняем формат логов на более читаемый
        $format = "[%datetime%] %channel%.%level_name%: %message% %context%\n\n"
            ."%extra%\n\nMETHOD: %extra.method%\nINPUT: %extra.input%\n"
            ."PATH: %extra.path%\nIP: %extra.ip%\n\n"
            ."***********************************************\n\n";
        
        /** @var $formatter LineFormatter; */
        $formatter = app(LineFormatter::class);
        $formatter->setFormat($format);
        $formatter->allowInlineLineBreaks(true);
        $formatter->ignoreEmptyContextAndExtra(true);
        
        $handler->setFormatter($formatter);
        $logger->pushHandler($handler);
        
        //дополнительная информация в логах
        $logger->pushProcessor(function($record) {
            $record['extra']['ip'] = request()->getClientIp();
            $record['extra']['method'] = request()->method();
            $record['extra']['path'] = request()->fullUrl();
            $record['extra']['headers'] = request()->header();
            $record['extra']['input'] = request()->all();
            
            if (isset($record['context']['exception'])) {
                $record['message'] = (string)$record['context']['exception'];
            }
            return $record;
        });
        
//        foreach ($logger->getHandlers() as $handler) {
//            $handler->setFormatter(...);
//        }
    }
}
