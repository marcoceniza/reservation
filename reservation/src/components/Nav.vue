<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-end">
            <div class="adminProfile">
                <a class="user_icon" @click="profile" href="javascript:;"><i class="bi bi-person-circle"></i></a>
                <ul v-if="showProfile">
                    <li><a href="javascript:;"><i class="bi bi-person-fill"></i> Profile</a></li>
                    <li><a @click="logout" href="javascript:;"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
export default {    
    data() {
        return {
            showProfile: false
        }
    },
    methods: {
        profile() {
            this.showProfile = !this.showProfile;
        },
        logout() {
            localStorage.clear('user_info');
            localStorage.clear('user_token');

            setTimeout(() => { window.location.reload() }, 2000);
        }
    }
}
</script>

<style scoped>
.user_icon{font-size: 25px; color: #fff;}
.user_icon:hover{opacity: 0.6;}
.adminProfile ul{position: absolute; right: 0; list-style-type: none; top: 54px; background: #62666a; text-align: center; margin: 0 auto; padding: 0; width: 150px; max-width: 100%;}
.adminProfile ul li{border-bottom: 1px solid #fff;}
.adminProfile ul li a{display: block; text-decoration: none; color: #fff; padding: 10px 0;}
.adminProfile ul li a:hover{opacity: 0.5;}
</style>