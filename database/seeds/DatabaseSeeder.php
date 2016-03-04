<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(SUsers::class);
        $this->call(Roles::class);
        $this->call(RoleUsers::class);
        $this->call(emmanuels_company::class);
    }
}
