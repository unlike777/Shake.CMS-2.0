<?php

namespace App\Console\Commands\Modules;

use File;
use Illuminate\Console\Command;

class Migration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modules:migration {module_name} {name} {--create=} {--table=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create migration for module';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $module_name = $this->argument('module_name');
        $migrations_folder = 'migrations';
        
        if (!File::exists(module_path($module_name))) {
            $this->error('Module "'.ucfirst($module_name).'" doesn\'t exists');
        }
        
        $migrations_path = module_path($module_name, $migrations_folder);
        
        if (!File::exists($migrations_path)) {
            File::makeDirectory($migrations_path);
        }
        
        $params = [
            'name' => $this->argument('name'),
            '--path' => 'app/Modules/'.ucfirst($module_name).'/'.$migrations_folder,
        ];
        
        if ($option = $this->option('create')) {
            $params['--create'] = $option;
        } else if ($option = $this->option('table')) {
            $params['--table'] = $option;
        }
        
        $this->call('make:migration', $params);
    }
}
