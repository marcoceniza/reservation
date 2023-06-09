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
                            <h3>Name <span>title</span></h3>
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
                                        <li class="list-group-item">Firstname: test</li>
                                        <li class="list-group-item">Lastname: test</li>
                                        <li class="list-group-item">Email: test</li>
                                        <li class="list-group-item">Phone: test</li>
                                        <li class="list-group-item">Address: test</li>
                                    </ul> 
                                </div>
                                <div class="tab-pane fade" id="updateProfile-tab-pane" role="tabpanel" aria-labelledby="updateProfile-tab" tabindex="0">
                                    <form action="/action_page.php">
                                        <div class="d-flex">
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="email" class="form-label">Firstname:</label>
                                                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                            </div>
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="email" class="form-label">Lastname:</label>
                                                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="email" class="form-label">Email:</label>
                                                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                            </div>
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="email" class="form-label">Phone:</label>
                                                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="mb-3 mt-3 mx-2 flex-fill">
                                                <label for="email" class="form-label">Address:</label>
                                                <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary mx-2">Update</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal for Updating Room -->
    <div class="modal fade" id="updateRoomModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Update Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div v-if="updateMessage" :class="{'alert': true, 'alert-danger': !updateMessage.isSuccess, 'alert-success': updateMessage.isSuccess}">
                        <strong>{{ updateMessage.message }}</strong>
                    </div>
                    <form>
                        <div class="mb-3 mt-3">
                            <label for="name" class="form-label">Name: <span class="requiredInput">*</span></label>
                            <input type="text" class="form-control" placeholder="Enter name" v-model="editName">
                        </div>
                        <div class="mb-3 mt-3">
                            <div class="d-flex justify-content-between">
                                <section>
                                    <label for="capacity" class="form-label">Capacity: <span class="requiredInput">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter capacity" v-model="editCapacity">
                                </section>
                                <section>
                                    <label for="price" class="form-label">Price: <span class="requiredInput">*</span></label>
                                    <input type="text" class="form-control" placeholder="Enter price" v-model="editPrice">
                                </section>
                            </div>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="name" class="form-label">Category: <span class="requiredInput">*</span></label>
                            <select class="form-control" v-model="editCategory">
                                <option value="1" :selected="editCategory === '1'">With Aircon</option>
                                <option value="0" :selected="editCategory === '0'">Without Aircon</option>
                            </select>
                        </div>
                        <div class="mb-3 mt-3">
                            <label for="location" class="form-label">Location: <span class="requiredInput">*</span></label>
                            <input type="text" class="form-control" placeholder="Location" v-model="editLocation">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Photo:</label>
                            <input type="file" class="form-control" @change="handleEditUpload">
                            <small class="updatePhotoNote">Note: If you dont want to update photo, just leave it blank</small>
                        </div>
                        <div class="d-grid">
                            <button v-if="loadingState" class="btn btn-primary btn-block" disabled>
                                <span class="spinner-grow spinner-grow-sm"></span>
                                Updating...
                            </button>
                            <button v-else @click.prevent="updateRoom" type="submit" class="btn btn-primary btn-block">Update</button>
                        </div>
                    </form> 
                </div>

            </div>
        </div>
    </div>

</template>

<script>
import axiosRes from '@/main';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';
import Nav from '@/components/Nav.vue';
import Tabs from '@/components/Tabs.vue';

export default {
    name: 'adminRooms',
    components: { DataTable, DataTablesCore, Nav, Tabs },
    data() {
        return {
            loadingState: false,
            loadingState2: true,
            name: '',
            capacity: '',
            price: '',
            category: '',
            categoryOptions: [
                { value: 1, label: 'With Aircon' },
                { value: 0, label: 'Without Aircon' }
            ],
            location: '',
            editName: '',
            editCapacity: '',
            editPrice: '',
            editCategory: '',
            editLocation: '',
            editRoomPhoto: '',
            resultMessage: '',
            updateMessage: '',
            deleteMessage: '',
            deleteConfirmMessage: '',
            rooms: '',
            viewRoom: '',
            getRoomID: '',
            roomPhoto: '',
            getConfirmDeleteID: '',
            photoBaseURL: 'http://localhost:8080/uploads/'
        }
    },
    methods: {
        formatCategory(num) {
            let convertToNumber = parseInt(num);
            if(convertToNumber == 1) return num = 'With Aircon';
            else return num = 'Without Aircon';
        },
        getSpecificRoom(ID) {
            this.rooms.forEach(res => {
                if(res.room_type_id === ID) {
                    this.getRoomID = res.room_type_id;
                    this.editName = res.name;
                    this.editCapacity = res.capacity;
                    this.editPrice = res.price;
                    this.editCategory = res.category;
                    this.editLocation = res.location;
                }
            });
        },
        handleEditUpload(event) {
            this.editRoomPhoto = event.target.files[0];
        },
        updateRoom() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('roomID', this.getRoomID);
            formData.append('name', this.editName);
            formData.append('capacity', this.editCapacity);
            formData.append('price', this.editPrice);
            formData.append('category', this.editCategory);
            formData.append('location', this.editLocation);
            this.editRoomPhoto !== '' ? formData.append('photo', this.editRoomPhoto) : '';

            axiosRes.post('/updateRoom', formData).then(res => {
                console.log(this.editCategory);
                this.loadingState = false;
                this.updateMessage = {
                    message: res.data.result,
                    isSuccess: res.data.success ? true : false
                };

                if(res.data.success) {
                    this.editName = '';
                    this.editCapacity = '';
                    this.editPrice = '';
                    this.editCategory = '';
                    this.editLocation = '';
                    this.editRoomPhoto = '';

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            });
        },
        deleteRoom() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('roomID', this.getConfirmDeleteID);

            axiosRes.post('/deleteRoom', formData).then(res => {
                this.loadingState = false;
                if(res.data.success) {
                    this.deleteConfirmMessage = {
                        message: res.data.result,
                        isSuccess: true
                    };

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }else {
                    return;
                }
            });
        },
        viewSpecificRoom(ID) {
            this.rooms.forEach(res => {
                if(res.room_type_id === ID) {
                    this.viewRoom = res;
                }
            });
        },
        handleUpload(event) {
            this.roomPhoto = event.target.files[0];
        },
        addRoom() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('name', this.name);
            formData.append('capacity', this.capacity);
            formData.append('price', this.price);
            formData.append('category', this.category);
            formData.append('location', this.location);
            formData.append('photo', this.roomPhoto);

            axiosRes.post('/addRoom', formData).then(res => {
                this.loadingState = false;
                this.resultMessage = {
                    message: res.data.result,
                    isSuccess: res.data.success ? true : false
                };

                if(res.data.success) {
                    this.name = '';
                    this.capacity = '';
                    this.price = '';
                    this.category = '';
                    this.location = '';
                    this.roomPhoto = '';

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            });
        },
        formatDate(dateString) {
            const date = new Date(dateString);
            const formattedDate = date.toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: 'numeric',
                minute: 'numeric',
                second: 'numeric',
                hour12: true
            });
            return formattedDate;
        }
    },
    mounted() {
        axiosRes.get('/fetchRooms').then(res => {
            this.loadingState2 = false;
            this.rooms = res.data.result;
        });

        DataTable.use(DataTablesCore);
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
.profile_box h3{text-align: center;}
.profile_box h3 span{display: block; color: #a2a2a2; font-size: 18px;}
.profile_box ul{margin: 25px 0 0;}
.profile_box ul li{margin-bottom: 6px; color: #555;}
.profile_inner .profile_con{box-shadow: 0px 0px 5px #c8c8c8; border-radius: 4px; padding: 12px 8px 40px; min-height: 350px;}
</style>