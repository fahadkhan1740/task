<template>
    <div>
        <h4>Standings</h4>
        <table class="table table-sm">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Team</th>
                <th scope="col">MP</th>
                <th scope="col">W</th>
                <th scope="col">L</th>
                <th scope="col">Points</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="standing in standings">
                <th scope="row">{{ standing.standing_id }}</th>
                <td>{{ standing.team.title }}</td>
                <td>{{ standing.matches_played }}</td>
                <td>{{ standing.wins }}</td>
                <td>{{ standing.lose }}</td>
                <td>{{ standing.points }}</td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "StandingsComponent",
        data() {
            return {
                standings: Array
            }
        },
        mounted() {
            this.getStandings()
        },
        methods: {
            getStandings() {
                axios.get('api/league').then(res => {
                    this.standings = res.data;
                }).catch(error => console.error(error))
            }
        },
    }
</script>

<style scoped>

</style>
