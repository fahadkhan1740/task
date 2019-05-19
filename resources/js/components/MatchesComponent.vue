<template>
    <div class="container">
        <div class="row">
            <h5 class="pull-left">Matches</h5><br>
            <button class="btn btn-primary" @click="resetFixtures">Reset Fixtures</button>
        </div>
        <div v-for="match in matches" class="container">
            <div class="col-md-12" style="margin: 10px;">
                <table class="table-bordered">
                    <thead>
                    <tr>
                        <td>Teams</td>
                        <td>Score</td>
                        <td>Run Rate</td>
                        <td>Scorecard</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>{{ match.home_team.title }}</td>
                        <td>{{ match.home_team_runs }}/{{ match.home_team_wickets }} ({{ match.home_team_overs > 0 ?
                            match.home_team_overs + 1 : 0 }})
                        </td>
                        <td>{{ match.home_team_run_rate }}</td>
                        <td>
                            <button @click="showScore(match.id)">Show</button>
                        </td>
                    </tr>
                    <tr>
                        <td>{{ match.away_team.title }}</td>
                        <td>{{ match.away_team_runs }}/{{ match.away_team_wickets }} ({{ match.away_team_overs > 0 ?
                            match.away_team_overs + 1 : 0 }})
                        </td>
                        <td>{{ match.away_team_run_rate }}</td>
                        <td>
                            <button @click="showScore(match.id)">Show</button>
                        </td>
                    </tr>
                    <tr>
                        <td>Result:</td>
                        <td>{{ match.result ? match.result : 'Match has not started'}}</td>
                        <td></td>
                        <td>
                            <button class="btn btn-warning" @click="startMatch(match.id)">Start Match</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "MatchesComponent",
        data() {
            return {
                matches: Array
            }
        },
        mounted() {
            this.getAllMatches()
        },
        methods: {
            resetFixtures() {
                axios.get('api/league/create').then(res => {
                    this.getAllMatches();
                }).catch(error => console.error(error))
            },
            getAllMatches() {
                axios.get('api/match').then(res => {
                    this.matches = res.data
                }).catch(error => console.error(error))
            },
            startMatch(matchId) {
                axios.get(`api/match/create?match_id=${matchId}`).then(res => {
                    setTimeout(() => {
                        this.getAllMatches()
                    }, 5);
                }).error(console.error(error))
            },
            showScore(id) {
                window.open(`scorecard/index?matchId=${id}`, '_blank');
            }
        }
    }
</script>

<style scoped>

</style>
