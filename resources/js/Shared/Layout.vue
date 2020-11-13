<template>
<div>
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <inertia-link class="navbar-brand" href="/">Doelcampus</inertia-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li>
                        <inertia-link :href="$route('game')">
                            Game
                        </inertia-link>
                    </li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->

                    <li class="nav-item dropdown">
                        <inertia-link id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Shipan Mazumder
                        </inertia-link>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <inertia-link class="dropdown-item" href="#" @click="logout">Logout</inertia-link>
                            <!--<inertia-link href="/logout" method="post">Logout</inertia-link>-->
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <slot />
    </main>
</div>
</template>

<script>
import axios from 'axios';
export default {
    methods: {
        async logout() {
            await axios.post('/logout', {});
            window.location.href = "/";
        }
    }
}
</script>

<style lang="scss" scoped>

</style>
