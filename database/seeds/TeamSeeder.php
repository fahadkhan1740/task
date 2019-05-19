<?php

use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teams')->truncate();

        DB::table('teams')->insert([
            [
                'title' => 'Bangalore',
                'logo_path' => 'images/bangalore.png'
            ],[
                'title' => 'Delhi',
                'logo_path' => 'images/delhi.png'
            ],[
                'title' => 'Kolkata',
                'logo_path' => 'images/kolkata.png'
            ],[
                'title' => 'Punjab',
                'logo_path' => 'images/punjab.png'
            ]
        ]);
    }
}
