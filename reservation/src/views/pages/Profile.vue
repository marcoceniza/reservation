<template>
    <Nav />

    <div class="row dash_con">
        <section class="col-2">
            <Tabs />
        </section>
        <section class="col-10">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                    <h5><i class="bi bi-person-fill"></i> Profile</h5>
                </div>
                <div class="row bg-body-tertiary p-4 profile_inner">
                    <div class="col-2 profile_box">
                        <div class="profile_con">
                            <figure><img class="img-fluid img-thumbnail mx-auto d-block" src="https://placehold.co/400" alt=""></figure>
                            <h5>{{ adminDatas.first_name }} {{ adminDatas.last_name }} <span>{{ adminDatas.email }}</span></h5>
                        </div>
                    </div>
                    <div class="col-9 profile_box">
                        <div class="profile_con">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="true">Profile</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="updateProfile-tab" data-bs-toggle="tab" data-bs-target="#updateProfile-tab-pane" type="button" role="tab" aria-controls="updateProfile-tab-pane" aria-selected="false">Update Profile</button>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                                    <ul class="list-group">
                                        <li class="list-group-item">Firstname: {{ adminDatas.first_name }}</li>
                                        <li class="list-group-item">Lastname: {{ adminDatas.last_name }}</li>
                                        <li class="list-group-item">Age: {{ adminDatas.age }}</li>
                                        <li class="list-group-item">Phone: {{ adminDatas.phone }}</li>
                                        <li class="list-group-item">Address: {{ adminDatas.address }}</li>
                                        <li class="list-group-item">Email: {{ adminDatas.email }}</li>
                                        <li class="list-group-item">Password: {{ adminDatas.password }}</li>
                                    </ul> 
                                </div>
                                <div class="tab-pane fade" id="updateProfile-tab-pane" role="tabpanel" aria-labelledby="updateProfile-tab" tabindex="0">
                                    <form action="/action_page.php">
                                        <div class="d-flex">
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="editFirstname" class="form-label">Firstname:</label>
                                                <input type="text" class="form-control" placeholder="Enter firstname" v-model="editFirstname">
                                            </div>
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="editLastname" class="form-label">Lastname:</label>
                                                <input type="text" class="form-control" placeholder="Enter lastname" v-model="editLastname">
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="editAge" class="form-label">Age:</label>
                                                <input type="text" class="form-control" placeholder="Enter age" v-model="editAge">
                                            </div>
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="editPhone" class="form-label">Phone:</label>
                                                <input type="text" class="form-control" placeholder="Enter phone" v-model="editPhone">
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="email" class="form-label">Address:</label>
                                                <input type="text" class="form-control" id="email" placeholder="Enter address" v-model="editAddress">
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="editEmail" class="form-label">Email:</label>
                                                <input type="text" class="form-control" placeholder="Enter email" v-model="editEmail">
                                            </div>
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="editPassword" class="form-label">Password:</label>
                                                <input :type="inputType" class="form-control" placeholder="Enter password" v-model="editPassword">
                                                <p class="showPassIcon" v-if="editPassword.length != 0">
                                                    <i @click="showPassHandler" v-if="inputType == 'password'" class="bi bi-eye-fill"></i>
                                                    <i @click="showPassHandler" v-else class="bi bi-eye-slash-fill"></i>
                                                </p>
                                            </div>
                                        </div>
                                        <button v-if="loadingState" class="btn btn-primary btn-block" disabled>
                                            <span class="spinner-grow spinner-grow-sm"></span>
                                            Updating...
                                        </button>
                                        <button v-else @click.prevent="updateInfo" type="submit" class="btn btn-primary mx-2">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

</template>

<script>
import axiosRes from '@/main';
import Nav from '@/components/Nav.vue';
import Tabs from '@/components/Tabs.vue';

export default {
    name: 'adminRooms',
    components: { Nav, Tabs },
    data() {
        return {
            loadingState: false,
            loadingState2: true,
            resultMessage: '',
            updateMessage: '',
            adminDatas: '',
            photoBaseURL: 'http://localhost:8080/uploads/',
            user: '',
            editEmail: '',
            editPassword: '',
            editFirstname: '',
            editLastname: '',
            editAge: '',
            editPhone: '',
            editAddress: '',
            inputType: 'password'
        }
    },
    created() {
        this.user = JSON.parse(localStorage.getItem('user_info'));
    },
    methods: {
        showPassHandler() {
            this.inputType == 'password' ? this.inputType = 'text' : this.inputType = 'password';
        },
        updateInfo() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('userID', this.user.user_id);
            formData.append('firstname', this.editFirstname);
            formData.append('lastname', this.editLastname);
            formData.append('age', this.editAge);
            formData.append('phone', this.editPhone);
            formData.append('address', this.editAddress);
            formData.append('email', this.editEmail);
            formData.append('password', this.editPassword);

            axiosRes.post('/updateAdmin', formData).then(res => {
                this.loadingState = false;
                this.updateMessage = {
                    message: res.data.result,
                    isSuccess: res.data.success ? true : false
                };

                if(res.data.success) {
                    // this.editFirstname = '';
                    // this.editLastname = '';
                    // this.editAge = '';
                    // this.editPhone = '';
                    // this.editAddress = '';
                    // this.editEmail = '';
                    // this.editPassword = '';

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            });
        }
    },
    mounted() {
        axiosRes.get('/fetchAdmin').then(res => {
            this.loadingState2 = false;
            
            res.data.result.forEach(res => {
                if(res.user_id == this.user.user_id) {
                    this.adminDatas = res;
                    this.editEmail = res.email;
                    this.editPassword = res.password;
                    this.editFirstname = res.first_name;
                    this.editLastname = res.last_name;
                    this.editAge = res.age;
                    this.editPhone = res.phone;
                    this.editAddress = res.address;
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
.dash_con section ul li a{display: block; text-decoration: none; padding: 12px 20px; background: #0d6efd; color: #fff; border: 1px solid #adceff;}
.dash_con section ul li a:first-child{border-bottom: none;}
.dash_con section ul li a:hover{opacity: 0.8;}
.dash_con section ul li a i{padding-right: 5px;}
.profile_box h5{text-align: center;}
.profile_box h5 span{display: block; color: #a2a2a2; font-size: 18px;}
.profile_box ul{margin: 25px 0 0;}
.profile_box ul li{margin-bottom: 6px; color: #555;}
.profile_inner .profile_con{box-shadow: 0px 0px 5px #c8c8c8; border-radius: 4px; padding: 12px 8px 40px; min-height: 350px;}
.showPassIcon{position: relative;}
.showPassIcon i{position: absolute; right: 8px; bottom: 7px; z-index: 12; background: #fff; padding-left: 4px;cursor: pointer;}
</style>