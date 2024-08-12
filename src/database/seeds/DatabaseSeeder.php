<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // create default user
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@localhost',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
        ]);

        // create default content for legal mentions
        DB::table('contenuses')->insert([
            'name' => 'mentionslegales',
            'contenu' => '',
        ]);

        // create default content for help
        DB::table('contenuses')->insert([
            'name' => 'aide',
            'contenu' => '',
        ]);

        // create default content for changelog
        DB::table('contenuses')->insert([
            'name' => 'changelog',
            'contenu' => '',
        ]);

        // create default content for future
        DB::table('contenuses')->insert([
            'name' => 'avenir',
            'contenu' => '',
        ]);

        // create default content for game creation
        DB::table('contenuses')->insert([
            'name' => 'creerjeu',
            'contenu' => '',
        ]);

    }
}
