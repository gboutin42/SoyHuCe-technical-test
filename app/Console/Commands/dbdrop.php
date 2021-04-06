<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class dbdrop extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:drop {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop database based on config file or
	the provided parameter';

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
    public function handle()
    {

		$schemaName = $this->argument('name') ?: config('database.connections.mysql.database');

		$query = "DROP DATABASE IF EXISTS $schemaName";
		DB::statement($query);

		echo "Database $schemaName droped successfully";
    }
}
