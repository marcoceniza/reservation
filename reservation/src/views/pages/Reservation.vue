<template>
    <Nav />

    <div class="row dash_con">
        <section class="col-2">
            <Tabs />
        </section>
        <section class="col-10">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                    <h5><i class="bi bi-calendar2-plus-fill"></i> Reservation</h5>
                </div>

                <div v-if="deleteMessage" :class="{'alert': true, 'alert-danger': !deleteMessage.isSuccess, 'alert-success': deleteMessage.isSuccess}">
                    <strong>{{ deleteMessage.message }}</strong>
                </div>

                <div v-if="loadingState2" class="d-flex justify-content-center spinnerClass">
                    <div class="spinner-grow text-muted spinner-grow-sm"></div>
                    <div class="spinner-grow text-muted spinner-grow-sm"></div>
                    <div class="spinner-grow text-muted spinner-grow-sm"></div>
                </div>
                <div v-else class="table-responsive">
                    <DataTable class="table table-striped" id="myTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Price</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="schedule in schedules" :key="schedule">
                                <td>{{ schedule.room_type_id }}</td>
                                <td>{{ schedule.name }}</td>
                                <td>{{ formatCategory(schedule.category) }}</td>
                                <td>${{ schedule.price }}</td>
                                <td>{{ formatDate(schedule.start_date) }}</td>
                                <td>{{ formatDate(schedule.end_date) }}</td>
                                <td>{{ formatStatus(schedule.start_date, schedule.end_date) }}</td>
                                <td class="d-flex justify-content-center btn_action">
                                    <a href="" class="btn btn-primary btn-sm" @click="viewSpecificSchedule(schedule.room_type_id, schedule.customer_id)" data-bs-toggle="modal" data-bs-target="#viewReserveRoomModal"><i class="bi bi-eye-fill"></i> View</a>
                                    <a href="" :class="{ btn: true, 'btn-warning': true, 'btn-sm': true, disabled: checkEditHandler(schedule.start_date) }" @click="getUpdateID = schedule.reservation_id" data-bs-toggle="modal" data-bs-target="#createDateScheduleModal"><i class="bi bi-pencil-square"></i> Edit</a>
                                </td>
                            </tr>
                        </tbody>
                    </DataTable>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal for Reserve Room -->
    <div class="modal fade" id="viewReserveRoomModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-list-check"></i> Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <figure><img class="img-fluid rounded mx-auto d-block" :src="photoBaseURL + viewReserve.photo" alt=""></figure>
                <ul class="list-group">
                    <li class="list-group-item">ID: {{ viewReserve.room_type_id }}</li>
                    <li class="list-group-item">Name: {{ viewReserve.name }}</li>
                    <li class="list-group-item">Capacity: {{ viewReserve.capacity }} pax</li>
                    <li class="list-group-item">Price: ${{ viewReserve.price }}</li>
                    <li class="list-group-item">Category: {{ formatCategory(viewReserve.category) }}</li>
                    <li class="list-group-item">Location: {{ viewReserve.location }}</li>
                    <li class="list-group-item">Reserved Date: {{ formatDate(viewReserve.reserved_date) }}</li>
                    <li class="list-group-item">Start Date: {{ formatDate(viewReserve.start_date) }}</li>
                    <li class="list-group-item">End Date: {{ formatDate(viewReserve.end_date) }} </li>
                    <li class="list-group-item">Status: {{ formatStatus(viewReserve.start_date, viewReserve.end_date) }} </li>
                </ul>

                <h5 class="mt-4 mb-3"><i class="bi bi-info-circle-fill"></i> Customer Info</h5>
                <ul class="list-group">
                    <li class="list-group-item">First Name: {{ viewReserve.first_name }}</li>
                    <li class="list-group-item">Last Name: {{ viewReserve.last_name }}</li>
                    <li class="list-group-item">Phone: {{ viewReserve.phone }}</li>
                    <li class="list-group-item">Email: {{ viewReserve.email }}</li>
                </ul>
            </div>

            </div>
        </div>
    </div>

    <!-- Modal for Updating Schedule -->
    <div class="modal fade" id="createDateScheduleModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-calendar-plus-fill"></i> Schedule Date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div v-if="resultMessage" :class="{'alert': true, 'alert-danger': !resultMessage.isSuccess, 'alert-success': resultMessage.isSuccess}">
                        <strong>{{ resultMessage.message }}</strong>
                    </div>
                    <form>
                        <div class="mb-3 mt-3">
                            <div class="d-flex justify-content-between">
                                <section>
                                    <label for="startDate" class="form-label">Start Date: <span class="requiredInput">*</span></label>
                                    <input type="datetime-local" class="form-control" v-model="startDate">
                                </section>
                                <section>
                                    <label for="endDate" class="form-label">End Date: <span class="requiredInput">*</span></label>
                                    <input type="datetime-local" class="form-control" v-model="endDate">
                                </section>
                            </div>
                        </div>
                        <div class="d-grid">
                            <button v-if="loadingState" class="btn btn-primary btn-block" disabled>
                                <span class="spinner-grow spinner-grow-sm"></span>
                                Updating...
                            </button>
                            <button v-else @click.prevent="updateDateSchedule" type="submit" class="btn btn-primary btn-block">Update</button>
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
    name: 'adminReservation',
    components: { DataTable, DataTablesCore, Nav, Tabs },
    data() {
        return {
            loadingState: false,
            loadingState2: true,
            startDate: '',
            endDate: '',
            name: '',
            capacity: '',
            price: '',
            location: '',
            resultMessage: '',
            viewReserve: '',
            roomPhoto: '',
            schedules: '',
            getUpdateID: '',
            getConfirmDeleteID: '',
            photoBaseURL: 'http://localhost:8080/uploads/',
            currentDate: new Date()
        }
    },
    methods: {
        checkEditHandler(sDate) {
            let startDate = new Date(sDate);

            if(this.currentDate >= startDate) return true;
            else return false;
        },
        formatStatus(sDate, eDate) {
            let startDate = new Date(sDate);
            let endDate = new Date(eDate);

            if(this.currentDate < startDate) return 'Comming';
            else if(this.currentDate >= startDate && this.currentDate <= endDate) return 'Ongoing';
            else return 'Done';
        },
        formatCategory(num) {
            let convertToNumber = parseInt(num);
            if(convertToNumber == 1) return num = 'With Aircon';
            else return num = 'Without Aircon';
        },
        viewSpecificSchedule(room_ID, customer_ID) {
            this.schedules.forEach(res => {
                if(res.room_type_id === room_ID && res.customer_id === customer_ID) {
                    this.viewReserve = res;
                }
            });
        },
        updateDateSchedule() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('reserveID', this.getUpdateID);
            formData.append('startDate', this.startDate);
            formData.append('endDate', this.endDate);

            axiosRes.post('/updateSchedule', formData).then(res => {
                this.loadingState = false;
                this.resultMessage = {
                    message: res.data.result,
                    isSuccess: res.data.success ? true : false
                };

                if(res.data.success) {
                    this.startDate = '';
                    this.endDate = '';

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
        axiosRes.get('/fetchSchedule').then(res => {
            this.loadingState2 = false;
            this.schedules = res.data.result;
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
.dash_con section ul li a{display: block; text-decoration: none; padding: 12px 30px; background: #0d6efd; color: #fff; border: 1px solid #adceff;}
.dash_con section ul li a:first-child{border-bottom: none;}
.dash_con section ul li a:hover{opacity: 0.8;}
.dash_con section ul li a i{padding-right: 5px;}
</style>