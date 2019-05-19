<template>
    <div>
        <h4>Scorecard</h4>
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
            <tr v-for="batsman in batsmen">
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
                    <td>NB: {{ noBalls }}, W: {{ wideBalls }}</td>
                    <td>{{ noBalls + wideBalls }}</td>
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
            <tr v-for="bowler in bowlers">
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
</template>

<script>
    export default {
        name: "ScorecardComponent",
        data() {
            return {
                batsmen: Array,
                bowlers: Array,
                noBalls: '',
                wideBalls: ''
            }
        },
        mounted() {
            this.getScorecard(2);
        },
        methods: {
            getScorecard(matchId) {
                axios.get(`api/scorecard/${matchId}`).then(res => {
                    this.batsmen = res.data.batsmen
                    this.bowlers = res.data.bowlers
                    this.noBalls = res.data.extras.no_balls
                    this.wideBalls = res.data.extras.wide_balls
                    console.log(this.bowlers)
                }).catch(error => console.error(error))
            }
        }
    }
</script>

<style scoped>

</style>
