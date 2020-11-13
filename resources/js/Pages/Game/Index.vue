<template>
<div>
    <layout>
        <div class="container">
            <div class="row">
                <div class="col-md-12" v-if="add">
                    <form @submit.prevent="storeData">
                        <div class="col-md-6" style="float: left;">
                            <div class="form-group">
                                <label for="name">Game Name</label>
                                <input type="text" class="form-control" placeholder="Game Name" id="name" v-model="game.name">
                                <div v-if="errors.name">{{ errors.name[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="game_short_code">Game Short Code</label>
                                <input type="text" class="form-control" placeholder="Game Short Code" id="game_short_code" v-model="game.game_short_code">
                                <div v-if="errors.game_short_code">{{ errors.game_short_code[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="app_id">APP ID</label>
                                <input type="text" class="form-control" placeholder="APP ID" id="app_id" v-model="game.app_id">
                                <div v-if="errors.app_id">{{ errors.app_id[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" v-model="game.category_id" class="form-control">
                                    <option value="">--Select--</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                                </select>
                                <div v-if="errors.category_id">{{ errors.category_id[0] }}</div>
                            </div>
                        </div>
                        <div class="col-md-6" style="float: left;">
                            <div class="form-group">
                                <label for="game_access_token">Game Access Token</label>
                                <input type="text" class="form-control" placeholder="Game Access Token" id="game_access_token" v-model="game.game_access_token">
                                <div v-if="errors.game_access_token">{{ errors.game_access_token[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="game_verify_token">Game Verify Token</label>
                                <input type="text" class="form-control" placeholder="Game Verify Token" id="game_verify_token" v-model="game.game_verify_token">
                                <div v-if="errors.game_verify_token">{{ errors.game_verify_token[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" v-model="game.description" placeholder="Description" rows="5"></textarea>
                                <div v-if="errors.description">{{ errors.description[0] }}</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="col-md-12" v-if="edit">
                    <form @submit.prevent="updateData">
                        <div class="col-md-6" style="float: left;">
                            <div class="form-group">
                                <label for="name">Game Name</label>
                                <input type="text" class="form-control" placeholder="Game Name" id="name" v-model="game.name">
                                <div v-if="errors.name">{{ errors.name[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="app_id">APP ID</label>
                                <input type="text" class="form-control" placeholder="APP ID" id="app_id" v-model="game.app_id">
                                <div v-if="errors.app_id">{{ errors.app_id[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" v-model="game.category_id" class="form-control">
                                    <option value="">--Select--</option>
                                    <option v-for="category in categories" :key="category.id" :value="category.id">{{category.name}}</option>
                                </select>
                                <div v-if="errors.category_id">{{ errors.category_id[0] }}</div>
                            </div>
                        </div>
                        <div class="col-md-6" style="float: left;">
                            <div class="form-group">
                                <label for="game_access_token">Game Access Token</label>
                                <input type="text" class="form-control" placeholder="Game Access Token" id="game_access_token" v-model="game.game_access_token">
                                <div v-if="errors.game_access_token">{{ errors.game_access_token[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="game_verify_token">Game Verify Token</label>
                                <input type="text" class="form-control" placeholder="Game Verify Token" id="game_verify_token" v-model="game.game_verify_token">
                                <div v-if="errors.game_verify_token">{{ errors.game_verify_token[0] }}</div>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea name="description" id="description" class="form-control" v-model="game.description" placeholder="Description" rows="5"></textarea>
                                <div v-if="errors.description">{{ errors.description[0] }}</div>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Sl.</th>
                                    <th>Game Name</th>
                                    <th>Game Short Code</th>
                                    <th>App ID</th>
                                    <th>Category</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                <tr v-for="(game,index) in games" :key="index">
                                    <td>{{++index}}</td>
                                    <td>{{game.name}}</td>
                                    <td>{{game.game_short_code}}</td>
                                    <td>{{game.app_id}}</td>
                                    <td>{{game.category.name}}</td>
                                    <td>{{game.description}}</td>
                                    <td>
                                        <inertia-link :href="$route('gameEdit',{game:game.id})"><button class="btn  btn-primary">
                                                <font-awesome-icon icon="edit" />
                                            </button></inertia-link>
                                        <inertia-link :href="$route('gameControl',{game:game.id})">
                                            <button :class="[game.status==1 ? 'btn  btn-success' : 'btn  btn-danger' ]">
                                                <font-awesome-icon icon="check-circle" />
                                            </button>
                                        </inertia-link>
                                    </td>
                                </tr>
                            </thead>
                        </table>
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
        add: Boolean,
        edit: Boolean,
        errors: Object,
        categories: Array,
        games: Array,
        gameObject: Object
    },
    data() {
        return {
            error: this.errors,
            game: {
                name: "",
                game_short_code: "",
                game_access_token: "",
                game_verify_token: "",
                app_id: "",
                description: "",
                category_id: ""
            }
        }

    },
    created() {
        if (this.edit)
            this.game = this.gameObject
    },
    methods: {
        async storeData() {
            let response = await this.$inertia.post(route('game'), this.game);
            if (Object.keys(this.errors).length <= 0) {
                this.$swal('Create Success');
                this.emptyGameObject();
            }
        },
        async updateData() {
            let response = await this.$inertia.post(route('gameUpdate'), this.game);
            if (Object.keys(this.errors).length <= 0) {
                this.$swal('Update Success');
                this.emptyGameObject();
            }
        },
        emptyGameObject() {
            this.game.name = '';
            this.game.game_short_code = '';
            this.game.game_access_token = '';
            this.game.game_verify_token = '';
            this.game.app_id = '';
            this.game.description = '';
            this.game.category_id = '';
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
