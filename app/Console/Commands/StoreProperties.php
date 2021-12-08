<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\PropertyService;

class StoreProperties extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'properties:store';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store properties that are defined in file [../public/json/properties.json] ';

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
     * @return int
     */
    public function handle(PropertyService $propertyService)
    {
        $propertyService->addPropertiesFromDictionary();

        return 0;
    }
}
