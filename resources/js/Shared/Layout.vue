<template>
<div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <inertia-link class="navbar-brand" :href="$route('dashboard')">{{$page.props.appName}} </inertia-link>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li :class="['nav-item', {'active': isUrl('dashboard')}]">
                    <inertia-link class="nav-link" :href="$route('dashboard')">
                        Dashboard
                    </inertia-link>
                </li>
                <li :class="['nav-item', {'active': isUrl('game')}]">
                    <inertia-link class="nav-link" :href="$route('game')">
                        Game
                    </inertia-link>
                </li>
                 <li :class="['nav-item', {'active': isUrl('bot-message')}]">
                    <inertia-link class="nav-link" :href="$route('botMessage')">
                        Bot Message
                    </inertia-link>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $page.props.auth.name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <inertia-link class="dropdown-item" href="#" @click="logout">Logout</inertia-link>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        <slot />
    </div>
</div>
</template>

<script>
import axios from 'axios';
export default {
    data(){
        return {
        url:""
        }
    },
    methods: {
        async logout() {
            await axios.post(route('logout'), {});
            window.location.href = "/";
        },
        isUrl(...urls) {
            if (urls[0] === '') {
                return this.url === ''
            }
            return urls.filter(url => location.pathname.substr(1).startsWith(url)).length
        },
    }
}
</script>

<style lang="scss" scoped>

</style>
