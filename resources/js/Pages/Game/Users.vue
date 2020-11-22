<template>
<div>
    <layout>
        <div class="container">
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Game Users View</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Name</th>
                                            <th>User Id</th>
                                            <th>Score</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="users.data.length>0">
                                        <tr v-for="(user,index) in users.data" :key="index">
                                            <td>{{++index}}</td>
                                            <td>{{user.game_user.name}}</td>
                                            <td>{{user.game_user.user_unique_id}}</td>
                                            <td>{{user.score}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4"><pagination :links="users.links"></pagination></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </layout>
</div>
</template>

<script>
import Pagination from "./../../Shared/Pagination"
export default {
    components:{
      Pagination
    },
    props: {
        users: Object
    },
    data() {
        return {}
    },
    created() {
    },
    methods: {
    }
}
</script>

<style lang="scss" scoped>
</style>
