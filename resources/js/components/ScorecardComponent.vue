<template>
    <div>

        <div class="container">
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" href="#first" role="tab" data-toggle="tab">1st Innings</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#second" role="tab" data-toggle="tab">2nd Innings</a>
                </li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="first">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Batsman</th>
                            <th scope="col">Status</th>
                            <th scope="col">R</th>
                            <th scope="col">B</th>
                            <th scope="col">4s</th>
                            <th scope="col">6s</th>
                            <th scope="col">S/R</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="batsman in homeBatsmen">
                            <th scope="row"></th>
                            <td>{{ batsman.player.name }}</td>
                            <td>{{ batsman.status }}</td>
                            <td>{{ batsman.batting_runs }}</td>
                            <td>{{ batsman.batting_balls }}</td>
                            <td>{{ batsman.batting_fours }}</td>
                            <td>{{ batsman.batting_sixes}}</td>
                            <td>{{ batsman.strike_rate }}</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td>Extras</td>
                            <td>NB: {{ homeNoBalls }}, W: {{ homeWideBalls }}</td>
                            <td>{{ homeNoBalls + homeWideBalls }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Total</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>

                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Bowler</th>
                            <th scope="col">O</th>
                            <th scope="col">M</th>
                            <th scope="col">R</th>
                            <th scope="col">W</th>
                            <th scope="col">E/R</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="bowler in homeBowlers">
                            <th scope="row"></th>
                            <td>{{ bowler.player.name }}</td>
                            <td>{{ bowler.bowling_overs }}</td>
                            <td>{{ bowler.bowling_maiden }}</td>
                            <td>{{ bowler.bowling_runs }}</td>
                            <td>{{ bowler.bowling_wickets }}</td>
                            <td>{{ bowler.economy}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="second">
                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Batsman</th>
                            <th scope="col">Status</th>
                            <th scope="col">R</th>
                            <th scope="col">B</th>
                            <th scope="col">4s</th>
                            <th scope="col">6s</th>
                            <th scope="col">S/R</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="batsman in awayBatsmen">
                            <th scope="row"></th>
                            <td>{{ batsman.player.name }}</td>
                            <td>{{ batsman.status }}</td>
                            <td>{{ batsman.batting_runs }}</td>
                            <td>{{ batsman.batting_balls }}</td>
                            <td>{{ batsman.batting_fours }}</td>
                            <td>{{ batsman.batting_sixes}}</td>
                            <td>{{ batsman.strike_rate }}</td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td>Extras</td>
                            <td>NB: {{ awayNoBalls }}, W: {{ awayWideBalls }}</td>
                            <td>{{ awayNoBalls + awayWideBalls }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Total</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>

                    <table class="table table-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Bowler</th>
                            <th scope="col">O</th>
                            <th scope="col">M</th>
                            <th scope="col">R</th>
                            <th scope="col">W</th>
                            <th scope="col">E/R</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="bowler in awayBowlers">
                            <th scope="row"></th>
                            <td>{{ bowler.player.name }}</td>
                            <td>{{ bowler.bowling_overs }}</td>
                            <td>{{ bowler.bowling_maiden }}</td>
                            <td>{{ bowler.bowling_runs }}</td>
                            <td>{{ bowler.bowling_wickets }}</td>
                            <td>{{ bowler.economy}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <h4>Scorecard</h4>

    </div>
</template>

<script>
    export default {
        name: "ScorecardComponent",
        data() {
            return {
                homeBatsmen: Array,
                homeBowlers: Array,
                homeNoBalls: '',
                homeWideBalls: '',
                awayBatsmen: Array,
                awayBowlers: Array,
                awayNoBalls: '',
                awayWideBalls: ''
            }
        },
        mounted() {
            this.getScorecard(2);
        },
        methods: {
            getScorecard(matchId) {
                axios.get(`api/scorecard/${matchId}`).then(res => {
                    this.homeBatsmen = res.data.home.home_batsmen
                    this.homeBowlers = res.data.home.home_bowlers
                    this.homeNoBalls = res.data.home.home_extras.no_balls
                    this.homeWideBalls = res.data.home.home_extras.wide_balls
                    this.awayBatsmen = res.data.away.away_batsmen
                    console.log(res.data.away)
                    console.log(this.awayBatsmen)
                    this.awayBowlers = res.data.away.away_bowlers
                    console.log(this.awayBowlers)
                    this.awayNoBalls = res.data.away.away_extras.no_balls
                    this.awayWideBalls = res.data.away.away_extras.wide_balls
                }).catch(error => console.error(error))
            }
        }
    }
</script>

<style scoped>

</style>
