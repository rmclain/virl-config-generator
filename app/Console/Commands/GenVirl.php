<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Virl\VirlParser;
use Illuminate\Support\Facades\File;

class GenVirl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'virl:generate {folder}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a virl file with configs from folder of configs';


    /**
     * Create a new command instance.
     *
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
        // Take the starting folder as input
        $folder = $this->argument('folder');
        $list = File::directories(storage_path('virl').'/'.$folder);

        $configs = [];
        foreach($list as $dir) {
            $sub = File::directories($dir);
            foreach($sub as $subDir) {
                array_push($configs, $subDir);
            }
        }

        $bar = $this->output->createProgressBar(count($configs));
        $this->comment(PHP_EOL);
        $this->comment("Processing " . count($configs). " directories for files.");
        foreach($configs as $configDir)
        {
            $vp = new VirlParser($configDir);
            $vp->injectFiles();
            $bar->advance();
        }
        $bar->finish();
        $this->comment(PHP_EOL);
    }
}
