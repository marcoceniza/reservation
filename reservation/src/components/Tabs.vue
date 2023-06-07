<template>
    <ul>
        <li><a :class="{ active: $route.path === '/admin/dashboard' }" href="javascript:;" @click="$router.push('/admin/dashboard')"><i class="bi bi-house-check-fill"></i> Dashboard <span :class="{ badge: true, 'text-bg-light': $route.path === '/admin/dashboard', 'text-bg-danger': $route.path !== '/admin/dashboard', 'float-end': true }">{{ pendingReservation.length > 0 ? pendingReservation.length : '' }}</span></a></li>
        <li><a :class="{ active: $route.path === '/admin/reservation' }" href="javascript:;" @click="$router.push('/admin/reservation')"><i class="bi bi-calendar2-plus-fill"></i> Reservation</a></li>
        <li><a :class="{ active: $route.path === '/admin/rooms' }" href="javascript:;" @click="$router.push('/admin/rooms')"><i class="bi bi-building-fill-add"></i> Rooms</a></li>
        <li><a :class="{ active: $route.path === '/admin/customers' }" href="javascript:;" @click="$router.push('/admin/customers')"><i class="bi bi-people-fill"></i> Customers</a></li>
    </ul>
</template>

<script>
import axiosRes from '@/main';

export default {
    data() {
        return {    
            pendingReservation: []
        }
    },
    mounted() {
        axiosRes.get('/fetchRoom').then(res => {
            res.data.result.forEach(res => {
                if(res.created_status == 0) {
                    this.pendingReservation.push(res);
                }
            });
        });
    }
}
</script>

<style scoped>
.alert{text-align: center;}
thead tr th{text-align: center;}
.updatePhotoNote{font-style: italic; color: #ff1414; font-weight: bold; font-size: 10px;}
.btn_action a:nth-child(2){margin: 0 3px;}
.user_icon{font-size: 25px; color: #fff;}
.user_icon:hover{opacity: 0.6;}
.requiredInput{color: #f70e0e;}
.categoryNote{color: #ff1414; font-size: 10px; font-weight: bold; font-style: italic;}
.spinnerClass{margin-top: 50px;}
.spinnerClass div{margin: 0 4px;}
.row{height: 100vh;}
.dash_con section:first-child{box-shadow: 0px 0px 12px #d7d7d7;padding: 0;}
.dash_con section ul{list-style-type: none; padding: 0;}
.dash_con section ul li a{display: block; text-decoration: none; padding: 12px 30px; color: #0d6efd; border: 1px solid #adceff;}
.dash_con section ul li a:first-child{border-bottom: none;}
.dash_con section ul li a:hover{opacity: 0.8;}
.dash_con section ul li a i{padding-right: 5px;}
.active{background: #0d6efd; color: #fff !important;}
</style>