<template>
    <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
        <div class="container-fluid d-flex justify-content-end">
            <div class="adminProfile">
                <a class="user_icon" href=""><i class="bi bi-person-circle"></i></a>
            </div>
        </div>
    </nav>

    <div class="row dash_con">
        <section class="col-2">
            <ul>
                <li><a href="javascript:;" @click="$router.push('/admin/dashboard')"><i class="bi bi-house-check-fill"></i> Dashboard</a></li>
                <li><a href="javascript:;" @click="$router.push('/admin/rooms')"><i class="bi bi-building-fill-add"></i> Rooms</a></li>
            </ul>
        </section>
        <section class="col-10">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                    <h5><i class="bi bi-house-check-fill"></i> Dashboard</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addRoomModal"><i class="bi bi-plus-circle-fill"></i> Add</button>
                </div>

                <div v-if="deleteMessage" :class="{'alert': true, 'alert-danger': !deleteMessage.isSuccess, 'alert-success': deleteMessage.isSuccess}">
                    <strong>{{ deleteMessage.message }}</strong>
                </div>

                <div v-if="loadingState2" class="d-flex justify-content-center spinnerClass">
                    <div class="spinner-grow text-muted spinner-grow-sm"></div>
                    <div class="spinner-grow text-muted spinner-grow-sm"></div>
                    <div class="spinner-grow text-muted spinner-grow-sm"></div>
                </div>
                <div v-else-if="rooms.length !== 0" class="table-responsive">
                    <DataTable class="table table-striped" id="myTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Capacity</th>
                                <th>Price</th>
                                <th>Photo</th>
                                <th>Category</th>
                                <th>Location</th>
                                <th>Created_at</th>
                                <th>Updated_at</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="room in rooms" :key="room">
                                <td>{{ room.room_type_id }}</td>
                                <td>{{ room.name }}</td>
                                <td>{{ room.capacity }}</td>
                                <td>{{ room.price }}</td>
                                <td>{{ room.photo }}</td>
                                <td>{{ formatCategory(room.category) }}</td>
                                <td>{{ room.location }}</td>
                                <td>{{ formatDate(room.created_at) }}</td>
                                <td>{{ formatDate(room.updated_at) }}</td>
                                <td class="d-flex justify-content-evenly btn_action">
                                    <a href="" class="btn btn-primary btn-sm" @click="viewSpecificRoom(room.room_type_id)" data-bs-toggle="modal" data-bs-target="#viewRoomModal"><i class="bi bi-eye-fill"></i> View</a>
                                    <a href="" class="btn btn-warning btn-sm" @click="getSpecificRoom(room.room_type_id)" data-bs-toggle="modal" data-bs-target="#updateRoomModal"><i class="bi bi-pencil-square"></i> Edit</a>
                                    <a href="" class="btn btn-danger btn-sm" @click="getConfirmDeleteID = room.room_type_id" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal"><i class="bi bi-trash-fill"></i> Delete</a>
                                </td>
                            </tr>
                        </tbody>
                    </DataTable>
                </div>
                <div v-else class="text-center mt-4">
                    <p class="text-muted">No Data</p>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal for Viewing Room -->
    <div class="modal fade" id="viewRoomModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
                <h4 class="modal-title">Room Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <figure><img class="img-fluid rounded mx-auto d-block" :src="photoBaseURL + viewRoom.photo" alt=""></figure>
                <ul class="list-group">
                    <li class="list-group-item">ID: {{ viewRoom.room_type_id }}</li>
                    <li class="list-group-item">Name: {{ viewRoom.name }}</li>
                    <li class="list-group-item">Capacity: {{ viewRoom.capacity }} pax</li>
                    <li class="list-group-item">Price: ${{ viewRoom.price }}</li>
                    <li class="list-group-item">Category: {{ formatCategory(viewRoom.category) }}</li>
                    <li class="list-group-item">Location: {{ viewRoom.price }}</li>
                    <li class="list-group-item">Created At: {{ formatDate(viewRoom.created_at) }}</li>
                </ul>
            </div>

            </div>
        </div>
    </div>

    <!-- Modal for Adding Room -->
    <div class="modal fade" id="addRoomModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-plus-circle-fill"></i> Add New Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div v-if="resultMessage" :class="{'alert': true, 'alert-danger': !resultMessage.isSuccess, 'alert-success': resultMessage.isSuccess}">
                        <strong>{{ resultMessage.message }}</strong>
                    </div>
                    <form>
                        <div class="mb-3 mt-3">
                            <label for="name" class="form-label">Name: <span class="requiredInput">*</span></label>
                            <input type="text" class="form-control" placeholder="Name" v-model="name">
                        </div>
                        <div class="mb-3 mt-3">
                            <div class="d-flex justify-content-between">
                                <section>
                                    <label for="capacity" class="form-label">Capacity: <span class="requiredInput">*</span></label>
                                    <input type="text" class="form-control" placeholder="Capacity" v-model="capacity">
                                </section>
                                <section>
                                    <label for="price" class="form-label">Price: <span class="requiredInput">*</span></label>
                                    <input type="text" class="form-control" placeholder="Price" v-model="price">
                                </section>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category: <span class="requiredInput">*</span></label>
                            <select class="form-control" v-model="category">
                                <option value="">Please select</option>
                                <option v-for="option in categoryOptions" :key="option" :value="option.value">{{ option.label }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="location" class="form-label">Location: <span class="requiredInput">*</span></label>
                            <input type="text" class="form-control" placeholder="Location" v-model="location">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Photo: <span class="requiredInput">*</span></label>
                            <input type="file" class="form-control" @change="handleUpload">
                        </div>
                        <div class="d-grid">
                            <button v-if="loadingState" class="btn btn-primary btn-block" disabled>
                                <span class="spinner-grow spinner-grow-sm"></span>
                                Adding...
                            </button>
                            <button v-else @click.prevent="addRoom" type="submit" class="btn btn-primary btn-block">Add</button>
                        </div>
                    </form> 
                </div>

            </div>
        </div>
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
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" placeholder="Enter name" v-model="editName">
                    </div>
                    <div class="mb-3 mt-3">
                        <div class="d-flex justify-content-between">
                            <section>
                                <label for="capacity" class="form-label">Capacity:</label>
                                <input type="text" class="form-control" placeholder="Enter capacity" v-model="editCapacity">
                            </section>
                            <section>
                                <label for="price" class="form-label">Price:</label>
                                <input type="text" class="form-control" placeholder="Enter price" v-model="editPrice">
                            </section>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Category: <small class="categoryNote">('1 = With Aircon', '0 = Without Aircon')</small></label>
                        <select class="form-control" v-model="editCategory">
                            <option value="1" :selected="editCategory === '1'">With Aircon</option>
                            <option value="0" :selected="editCategory === '0'">Without Aircon</option>
                        </select>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="location" class="form-label">Location:</label>
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

            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
            </div>

            </div>
        </div>
    </div>

    <!-- Modal for Confirm Delete -->
    <div class="modal fade" id="confirmDeleteModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Delete Message</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div v-if="deleteConfirmMessage" :class="{'alert': true, 'alert-danger': !deleteConfirmMessage.isSuccess, 'alert-success': deleteConfirmMessage.isSuccess}">
                        <strong>{{ deleteConfirmMessage.message }}</strong>
                    </div>
                    <p>Are you sure you want to delete?</p>
                </div>

                <div class="modal-footer">
                    <button v-if="loadingState" class="btn btn-primary" disabled>
                        <span class="spinner-grow spinner-grow-sm"></span>
                        Deleting...
                    </button>
                    <button v-else @click.prevent="deleteRoom" type="submit" class="btn btn-primary btn-block">Delete</button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
import axiosRes from '@/main';
import DataTable from 'datatables.net-vue3';
import DataTablesCore from 'datatables.net-bs5';

export default {
    name: 'adminDashboard',
    components: { DataTable, DataTablesCore },
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
        axiosRes.get('/fetchRoom').then(res => {
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
</style>