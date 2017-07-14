<?php

namespace App\Console\Commands\Modules;

use File;
use Illuminate\Console\Command;

class Make extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'modules:make {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create folders structure for module';

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
        $module_name = $this->argument('name');
        $dirs = ['Controllers/Admin', 'routes', 'views/admin', 'Models'];
        $files = ['routes/admin.php', 'routes/web.php'];
        
        foreach ($dirs as $dir) {
            File::makeDirectory(module_path($module_name, $dir), 493, true);
        }
        
        foreach ($files as $file) {
            File::put(module_path($module_name, $file), "<?php\n");
        }
    }
}
