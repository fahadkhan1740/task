<template>
    <div class="container">
        <div class="row">
            <h5 class="pull-left">Matches component</h5>
            <button class="btn btn-primary" @click="resetFixtures">Reset Fixtures</button>
        </div>
        <div v-for="match in matches" class="container">
            <div class="col-md-12">
                <div class="col-md-3">
                    {{ match.started_at }} <br>
                    {{ match.ended_at }}
                </div>
                <div class="col-md-2">
                    {{ match.status }}
                </div>
                <div class="col-md-4 pull-right">
                    <table class="table table-sm table-bordered">
                        <tbody>
                            <tr>
                                <td>{{ match.home_team.title }}</td>
                                <td>{{ match.home_team_runs }}/{{ match.home_team_wickets }} ({{ match.home_team_overs > 0 ? match.home_team_overs + 1  : 0 }})</td>
                                <td>{{ match.home_team_run_rate }}</td>
                            </tr>
                            <tr>
                                <td>{{ match.away_team.title }}</td>
                                <td>{{ match.away_team_runs }}/{{ match.away_team_wickets }} ({{ match.away_team_overs > 0 ? match.away_team_overs + 1 : 0}})</td>
                                <td>{{ match.away_team_run_rate }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-warning" @click="startMatch(match.id)">Start Match</button>
                </div>
            <p>Result: {{ match.result ? match.result : 'Match has not started'}}</p>
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
                axios.get(`api/match/create?match_id=${matchId}`).then(res => console.log(res)).error(console.error(error))
            }
        }
    }
</script>

<style scoped>

</style>
