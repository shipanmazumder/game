<template>
<div>
    <layout>
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mt-4 text-center" v-for="chunk in games" :key="chunk.id">
                                <div class="col-md-3" v-for="game in chunk" :key="game.id">
                                    <inertia-link :href="$route('gameUsers',{'game':game.id})">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title">{{game.name}}</h5>
                                                <h6 class="card-subtitle mb-2 text-muted">{{game.game_short_code}}</h6>
                                                <h6 class="card-subtitle mb-2 text-muted">{{game.category.name}}</h6>
                                            </div>
                                        </div>
                                    </inertia-link>
                                </div>
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
export default {
    props: {
        games: Array
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
