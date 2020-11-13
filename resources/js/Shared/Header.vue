<template>
<div>
    <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">
            <li class="dropdown notification-list d-none d-md-inline-block">
                <inertia-link href="#" id="btn-fullscreen" class="nav-link waves-effect waves-light">
                    <i class="mdi mdi-crop-free noti-icon"></i>
                </inertia-link>
            </li>

            <li class="dropdown notification-list">
                <inertia-link class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="/admin/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
                </inertia-link>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->
                    <div class="dropdown-header noti-title">
                        <h6 class="text-overflow m-0">Welcome !</h6>
                    </div>
                    <div class="dropdown-divider"></div>
                    <!-- item-->
                    <inertia-link class="dropdown-item notify-item" href="#" @click="logout"><i class="mdi mdi-power-settings"></i>
                        <span>Logout</span>
                    </inertia-link>

                </div>
            </li>

        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <inertia-link href="#" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="/admin/images/logo.png" alt="">
                    <!-- <span class="logo-lg-text-dark">Moltran</span> -->
                </span>
                <span class="logo-sm">
                    <!-- <span class="logo-lg-text-dark">M</span> -->
                    <img src="/admin/images/logo.png" alt="">
                </span>
            </inertia-link>

            <inertia-link href="#" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="/admin/images/logo.png" alt="">
                    <!-- <span class="logo-lg-text-dark">Moltran</span> -->
                </span>
                <span class="logo-sm">
                    <!-- <span class="logo-lg-text-dark">M</span> -->
                    <img src="/admin/images/logo-sm.png" alt="">
                </span>
            </inertia-link>
        </div>

        <!-- LOGO -->

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="mdi mdi-menu"></i>
                </button>
            </li>
        </ul>
    </div>
</div>
</template>

<script>
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
