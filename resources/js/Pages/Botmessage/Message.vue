<template>
<div>
    <layout>
        <div class="container">
            <div class="row">
                <div class="col-md-12" v-if="add">
                    <div class="card">
                        <div class="card-header">Bot Message Add For {{game.name}}</div>
                        <div class="card-body">
                            <form @submit.prevent="storeData">
                                <div class="col-md-6" style="float: left;">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" placeholder="Title" id="title" v-model="botMessage.title">
                                        <div v-if="errors.title"><span class="invalid">{{ errors.title[0] }}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subtitle">Subtitle</label>
                                        <input type="text" class="form-control" placeholder="Subtitle" id="subtitle" v-model="botMessage.subtitle">
                                        <div v-if="errors.subtitle"><span class="invalid">{{ errors.subtitle[0] }}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="button_title">Button Title</label>
                                        <input type="text" class="form-control" placeholder="Button Title" id="button_title" v-model="botMessage.button_title">
                                        <div v-if="errors.button_title"><span class="invalid">{{ errors.button_title[0] }}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image_url">Image Url</label>
                                        <input type="text"  class="form-control" placeholder="Image Url" id="image_url" v-model="botMessage.image_url">
                                        <div v-if="errors.image_url"><span class="invalid">{{ errors.image_url[0] }}</span></div>
                                    </div>
                                </div>
                                  <div class="col-md-6" style="float: left;">
                                    <div class="form-group">
                                        <label for="message_time">Message Time</label>
                                        <input type="text"  class="form-control" placeholder="Message Time" id="message_time" v-model="botMessage.message_time">
                                        <div v-if="errors.message_time"><span class="invalid">{{ errors.message_time[0] }}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="number" min="1" class="form-control" placeholder="Position" id="position" v-model="botMessage.position">
                                        <div v-if="errors.position"><span class="invalid">{{ errors.position[0] }}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="data">Data</label>
                                         <textarea class="form-control" placeholder="Data" id="data" v-model="botMessage.data" cols="30" rows="5"></textarea>
                                        <div v-if="errors.data"><span class="invalid">{{ errors.data[0] }}</span></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" v-if="edit">
                    <div class="card">
                        <div class="card-header">Bot Message Add For {{game.name}}</div>
                        <div class="card-body">
                            <form @submit.prevent="updateData">
                                 <div class="col-md-6" style="float: left;">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control" placeholder="Title" id="title" v-model="botMessage.title">
                                        <div v-if="errors.title"><span class="invalid">{{ errors.title[0] }}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="subtitle">Subtitle</label>
                                        <input type="text" class="form-control" placeholder="Subtitle" id="subtitle" v-model="botMessage.subtitle">
                                        <div v-if="errors.subtitle"><span class="invalid">{{ errors.subtitle[0] }}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="button_title">Button Title</label>
                                        <input type="text" class="form-control" placeholder="Button Title" id="button_title" v-model="botMessage.button_title">
                                        <div v-if="errors.button_title"><span class="invalid">{{ errors.button_title[0] }}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="image_url">Image Url</label>
                                        <input type="text"  class="form-control" placeholder="Image Url" id="image_url" v-model="botMessage.image_url">
                                        <div v-if="errors.image_url"><span class="invalid">{{ errors.image_url[0] }}</span></div>
                                    </div>
                                </div>
                                  <div class="col-md-6" style="float: left;">
                                    <div class="form-group">
                                        <label for="message_time">Message Time</label>
                                        <input type="text"  class="form-control" placeholder="Message Time" id="message_time" v-model="botMessage.message_time">
                                        <div v-if="errors.message_time"><span class="invalid">{{ errors.message_time[0] }}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="position">Position</label>
                                        <input type="number" min="1" class="form-control" placeholder="Position" id="position" v-model="botMessage.position">
                                        <div v-if="errors.position"><span class="invalid">{{ errors.position[0] }}</span></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="data">Data</label>
                                         <textarea class="form-control" placeholder="Data" id="data" v-model="botMessage.data" cols="30" rows="5"></textarea>
                                        <div v-if="errors.data"><span class="invalid">{{ errors.data[0] }}</span></div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Bot Message Views For {{game.name}}</div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Sl.</th>
                                            <th>Title</th>
                                            <th>Subtitle</th>
                                            <th>Button Title</th>
                                            <th>Message Time</th>
                                            <th>Image Url</th>
                                            <th>Data</th>
                                            <th>Position</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr v-for="(message,index) in messages" :key="index">
                                        <td>{{++index}}</td>
                                        <td>{{message.title}}</td>
                                        <td>{{message.subtitle}}</td>
                                        <td>{{message.button_title}}</td>
                                        <td>{{message.message_time}}</td>
                                        <td>{{message.image_url}}</td>
                                        <td>{{message.data}}</td>
                                        <td>{{message.position}}</td>
                                        <td>
                                            <inertia-link class="btn  btn-primary" :href="$route('gameBotMessageEdit',{game:game.id,message:message.id})">
                                                    <font-awesome-icon icon="edit" />
                                            </inertia-link>

                                            <inertia-link :href="$route('gameBotMessagePublish',{game:game.id,message:message.id})">
                                                <button :class="[message.status==1 ? 'btn  btn-success' : 'btn  btn-danger' ]">
                                                    <font-awesome-icon icon="check-circle" />
                                                </button>
                                            </inertia-link>
                                            <button class="btn btn-danger" @click="deleteData(message.id)">
                                                    <font-awesome-icon icon="trash" />
                                            </button>
                                        </td>
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
export default {
    props: {
        add: Boolean,
        edit: Boolean,
        errors: Object,
        messages: Array,
        game: Object,
        messageObj: Object
    },
    data() {
        return {
            botMessage: {
                title: "",
                subtitle: "",
                button_title: "",
                image_url: "",
                message_time: "",
                position: "",
                data: "",
            }
        }

    },
    created() {
        if (this.edit)
            this.botMessage = this.messageObj
    },
    methods: {
        async storeData() {
            let response = await this.$inertia.post(route('gameBotMessageAdd',{"game":this.game.id}), this.botMessage);
            if (Object.keys(this.errors).length <= 0) {
                this.$swal('Create Success');
                this.reset();
            }
        },
        async updateData() {
            let response = await this.$inertia.post(route('gameBotMessageUpdate',{"game":this.game.id,"message":this.messageObj.id}), this.botMessage);
            if (Object.keys(this.errors).length <= 0) {
                this.$swal('Update Success');
                this.reset();
            }
        },
         deleteData(id) {
            this.$swal({
                 title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$inertia.get(route('gameBotMessageDelete',{"game":this.game.id,"message":id}), this.botMessage);
                    this.$swal(
                    'Deleted!',
                    'Your data has been deleted.',
                    'success'
                    )
                }
                });
        },
        reset() {
            this.botMessage = {
                title: "",
                subtitle: "",
                button_title: "",
                image_url: "",
                message_time: "",
                position: "",
                data: "",
            }
        }
    }
}
</script>

<style lang="scss" scoped>
    .invalid{
        color: 	#FF0000;
    }
</style>
