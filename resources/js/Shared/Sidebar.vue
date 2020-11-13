<template>
<div>
    <div class="left-side-menu">

        <div class="slimscroll-menu">

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <div class="user-box">

                    <div class="float-left">
                        <img src="/admin/images/users/avatar-1.jpg" alt="" class="avatar-md rounded-circle">
                    </div>
                    <div class="user-info">
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Shipan Mazumder <i class="mdi mdi-chevron-down"></i>
                            </a>
                            <ul class="dropdown-menu" x-placement="bottom-start" style="position: absolute; transform: translate3d(0px, 29px, 0px); top: 0px; left: 0px; will-change: transform;">
                                <li><a href="#" class="dropdown-item"><i class="mdi mdi-face-profile mr-2"></i>Reset Profile<div class="ripple-wrapper"></div></a></li>
                                <li><a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="mdi mdi-power-settings mr-2"></i> Logout</a></li>

                                <form id="logout-form" action="#" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </ul>
                        </div>
                        <p class="font-13 text-muted m-0">Admin</p>
                    </div>
                </div>

                <ul class="metismenu" id="side-menu">

                    <li class="mm-active">
                        <a href="/dashboard" class="waves-effect active">
                            <i class="mdi mdi-home"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>
                </ul>

            </div>
            <!-- End Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

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
