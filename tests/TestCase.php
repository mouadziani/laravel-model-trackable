<?php

namespace LaravelModelTrackable\Tests;

use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase as Base;

abstract class TestCase extends Base
{
    protected function setUp(): void
    {
        parent::setUp();

        $config = require __DIR__.'/config/database.php';

        $db = new DB();
        $db->addConnection($config['sqlite']);
        $db->setAsGlobal();
        $db->bootEloquent();

        $this->migrate();
        $this->seed();
    }

    /**
     * Migrate the database.
     *
     * @return void
     */
    protected function migrate()
    {
        DB::schema()->dropAllTables();

        //TODO: create tables for testing
    }

    protected function seed()
    {
        //TODO: create fake records for testing
    }
}
