<?php

use Carbon\Carbon;
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
            ['name' => 'AB de Villiers', 'team_id' => 1, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Virat Kohli', 'team_id' => 1, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Gurkeerat Singh', 'team_id' => 1, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Shimron Hetmyer', 'team_id' => 1, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Yuzvendra Chahal', 'team_id' => 1, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Dale Steyn', 'team_id' => 1, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Mohammed Siraj', 'team_id' => 1, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Umesh Yadav', 'team_id' => 1, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Shikhar Dhawan', 'team_id' => 2, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Shreyas Iyer', 'team_id' => 2, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Colin Ingram', 'team_id' => 2, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Prithvi Shaw', 'team_id' => 2, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Avesh Khan', 'team_id' => 2, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Kagiso Rabada', 'team_id' => 2, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Trent Boult', 'team_id' => 2, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Ishant Sharma', 'team_id' => 2, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Joe Denly', 'team_id' => 3, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Rinku Singh', 'team_id' => 3, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Chris Lynn', 'team_id' => 3, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Shubman Gill', 'team_id' => 3, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Piyush Chawla', 'team_id' => 3, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Kuldeep Yadav', 'team_id' => 3, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Sandeep Warrier', 'team_id' => 3, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Matt Kelly', 'team_id' => 3, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'K. L. Rahul', 'team_id' => 4, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'David Miller', 'team_id' => 4, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Karun Nair', 'team_id' => 4, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Chris Gayle', 'team_id' => 4, 'type' => 'batsmen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Mohammed Shami', 'team_id' => 4, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Andrew Tye', 'team_id' => 4, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Mujeeb Ur Rahman', 'team_id' => 4, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['name' => 'Ravichandran Ashwin', 'team_id' => 4, 'type' => 'bowler', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);
    }
}
