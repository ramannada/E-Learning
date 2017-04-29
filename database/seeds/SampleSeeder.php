<?php

use Phinx\Seed\AbstractSeed;

class SampleSeeder extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data = [
            'test'  => 'test',
        ];

        $this->insert('test', $data);
    }
}
