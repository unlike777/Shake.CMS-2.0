<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Shake\Laravel\Logs\ExtLineFormatter as LineFormatter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Schema::defaultStringLength(191); //old MySQL
        
        
//        //Оформляем логи
//        $monolog = \Log::getMonolog();
//        $handler = $monolog->popHandler();
//    
//        //меняем формат логов на более читаемый
//        $format = "[%datetime%] %channel%.%level_name%: %message% %context%\n\n"
//            ."%extra%\n\nMETHOD: %extra.method%\nINPUT: %extra.input%\n"
//            ."PATH: %extra.path%\nIP: %extra.ip%\n\n"
//            ."***********************************************\n\n";
//    
//        /**
//         * @var $formatter LineFormatter;
//         */
//        $formatter = app(LineFormatter::class);
//        $formatter->setFormat($format);
//        $formatter->allowInlineLineBreaks(true);
//        $formatter->ignoreEmptyContextAndExtra(true);
//        
//        $handler->setFormatter($formatter);
//        $monolog->pushHandler($handler);
//    
//        //дополнительная информация в логах
//        $monolog->pushProcessor(function($record) {
//            $record['extra']['ip'] = request()->getClientIp();
//            $record['extra']['method'] = request()->method();
//            $record['extra']['path'] = request()->fullUrl();
//            $record['extra']['headers'] = request()->header();
//            $record['extra']['input'] = request()->all();
//            return $record;
//        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
