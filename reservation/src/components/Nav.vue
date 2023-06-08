<template>
    <div v-if="logoutLoader" class="popup">
        <div class="loader"></div>
    </div>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-end">
            <div class="adminProfile">
                <a class="user_icon" @click.prevent="profile" href="javascript:;"><i class="bi bi-person-circle"></i></a>
                <ul v-if="showProfile">
                    <li><a @click="$router.push('/admin/profile')" href="javascript:;"><i class="bi bi-person-fill"></i> Profile</a></li>
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
            showProfile: false,
            logoutLoader: false
        }
    },
    methods: {
        profile() {
            this.showProfile = !this.showProfile;
        },
        logout() {
            this.logoutLoader = true;
            localStorage.clear('user_info');
            localStorage.clear('user_token');

            setTimeout(() => { window.location.reload() }, 1000);
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

.popup { position:fixed;top:0;left:0;width:100%;height:100%;background-color:rgba(0,0,0,0.5);display:flex;align-items:center;justify-content:center;z-index:9999;}

.loader { border:4px solid #f3f3f3;border-top:4px solid #3498db;border-radius:50%;width:50px;height:50px;animation:spin 1s linear infinite;background-color:transparent;}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>