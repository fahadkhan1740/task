<?php

use Illuminate\Database\Seeder;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('players')->truncate();

        DB::table('players')->insert([
            ['name' => 'AB de Villiers', 'team_id' => 1, 'type' => 'batsmen'],
            ['name' => 'Virat Kohli', 'team_id' => 1, 'type' => 'batsmen'],
            ['name' => 'Gurkeerat Singh', 'team_id' => 1, 'type' => 'batsmen'],
            ['name' => 'Shimron Hetmyer', 'team_id' => 1, 'type' => 'batsmen'],
            ['name' => 'Yuzvendra Chahal', 'team_id' => 1, 'type' => 'bowler'],
            ['name' => 'Dale Steyn', 'team_id' => 1, 'type' => 'bowler'],
            ['name' => 'Mohammed Siraj', 'team_id' => 1, 'type' => 'bowler'],
            ['name' => 'Umesh Yadav', 'team_id' => 1, 'type' => 'bowler'],
            ['name' => 'Shikhar Dhawan', 'team_id' => 2, 'type' => 'batsmen'],
            ['name' => 'Shreyas Iyer', 'team_id' => 2, 'type' => 'batsmen'],
            ['name' => 'Colin Ingram', 'team_id' => 2, 'type' => 'batsmen'],
            ['name' => 'Prithvi Shaw', 'team_id' => 2, 'type' => 'batsmen'],
            ['name' => 'Avesh Khan', 'team_id' => 2, 'type' => 'bowler'],
            ['name' => 'Kagiso Rabada', 'team_id' => 2, 'type' => 'bowler'],
            ['name' => 'Trent Boult', 'team_id' => 2, 'type' => 'bowler'],
            ['name' => 'Ishant Sharma', 'team_id' => 2, 'type' => 'bowler'],
            ['name' => 'Joe Denly', 'team_id' => 3, 'type' => 'batsmen'],
            ['name' => 'Rinku Singh', 'team_id' => 3, 'type' => 'batsmen'],
            ['name' => 'Chris Lynn', 'team_id' => 3, 'type' => 'batsmen'],
            ['name' => 'Shubman Gill', 'team_id' => 3, 'type' => 'batsmen'],
            ['name' => 'Piyush Chawla', 'team_id' => 3, 'type' => 'bowler'],
            ['name' => 'Kuldeep Yadav', 'team_id' => 3, 'type' => 'bowler'],
            ['name' => 'Sandeep Warrier', 'team_id' => 3, 'type' => 'bowler'],
            ['name' => 'Matt Kelly', 'team_id' => 3, 'type' => 'bowler'],
            ['name' => 'K. L. Rahul', 'team_id' => 4, 'type' => 'batsmen'],
            ['name' => 'David Miller', 'team_id' => 4, 'type' => 'batsmen'],
            ['name' => 'Karun Nair', 'team_id' => 4, 'type' => 'batsmen'],
            ['name' => 'Chris Gayle', 'team_id' => 4, 'type' => 'batsmen'],
            ['name' => 'Mohammed Shami', 'team_id' => 4, 'type' => 'bowler'],
            ['name' => 'Andrew Tye', 'team_id' => 4, 'type' => 'bowler'],
            ['name' => 'Mujeeb Ur Rahman', 'team_id' => 4, 'type' => 'bowler'],
            ['name' => 'Ravichandran Ashwin', 'team_id' => 4, 'type' => 'bowler']
        ]);
    }
}
