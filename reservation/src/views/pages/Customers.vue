<template>
    <Nav />

    <div class="row dash_con">
        <section class="col-2">
            <Tabs />
        </section>
        <section class="col-10">
            <div class="container-fluid">
                <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
                    <h5><i class="bi bi-people-fill"></i> Customers</h5>
                </div>

                <div v-if="deleteMessage" :class="{'alert': true, 'alert-danger': !deleteMessage.isSuccess, 'alert-success': deleteMessage.isSuccess}">
                    <strong>{{ deleteMessage.message }}</strong>
                </div>

                <div v-if="loadingState2" class="d-flex justify-content-center spinnerClass">
                    <div class="spinner-grow text-muted spinner-grow-sm"></div>
                    <div class="spinner-grow text-muted spinner-grow-sm"></div>
                    <div class="spinner-grow text-muted spinner-grow-sm"></div>
                </div>
                <div v-else-if="customers.length !== 0" class="table-responsive">
                    <DataTable class="table table-striped" id="myTable">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Firstname</th>
                                <th>Lastname</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="customer in customers" :key="customer">
                                <td>{{ customer.customer_id }}</td>
                                <td>{{ customer.first_name }}</td>
                                <td>{{ customer.last_name }}</td>
                                <td>{{ customer.email }}</td>
                                <td>{{ customer.phone }}</td>
                                <td class="d-flex justify-content-evenly btn_action">
                                    <a href="" class="btn btn-warning btn-sm" @click="getUpdateData(customer.customer_id)" data-bs-toggle="modal" data-bs-target="#updateRoomModal"><i class="bi bi-pencil-square"></i> Edit</a>
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

    <!-- Modal for Updating Room -->
    <div class="modal fade" id="updateRoomModal">
        <div class="modal-dialog">
            <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square"></i> Update Customer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div v-if="updateMessage" :class="{'alert': true, 'alert-danger': !updateMessage.isSuccess, 'alert-success': updateMessage.isSuccess}">
                    <strong>{{ updateMessage.message }}</strong>
                </div>
                <form>
                    <div class="mb-3 mt-3">
                        <div class="d-flex justify-content-between">
                            <section>
                                <label for="firstname" class="form-label">Firstname: <span class="requiredInput">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter firstname" v-model="editFirstname">
                            </section>
                            <section>
                                <label for="lastname" class="form-label">Lastname: <span class="requiredInput">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter lastname" v-model="editLastname">
                            </section>
                        </div>
                    </div>
                    <div class="mb-3 mt-3">
                        <div class="d-flex justify-content-between">
                            <section>
                                <label for="email" class="form-label">Email: <span class="requiredInput">*</span></label>
                                <input type="email" class="form-control" placeholder="Enter email" v-model="editEmail">
                            </section>
                            <section>
                                <label for="phone" class="form-label">Phone: <span class="requiredInput">*</span></label>
                                <input type="text" class="form-control" placeholder="Enter phone" v-model="editPhone">
                            </section>
                        </div>
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
    name: 'adminCustomers',
    components: { DataTable, DataTablesCore, Nav, Tabs },
    data() {
        return {
            loadingState: false,
            loadingState2: true,
            editFirstname: '',
            editLastname: '',
            editEmail: '',
            editPhone: '',
            updateMessage: '',
            customers: '',
            customerID: ''
        }
    },
    methods: {
        getUpdateData(updateID) {
            this.customers.forEach(res => {
                if(res.customer_id == updateID) {
                    this.customerID = res.customer_id;
                    this.editFirstname = res.first_name;
                    this.editLastname = res.last_name;
                    this.editEmail = res.email;
                    this.editPhone = res.phone;
                }
            });
        },
        updateRoom() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('customerID', this.customerID);
            formData.append('firstname', this.editFirstname);
            formData.append('lastname', this.editLastname);
            formData.append('email', this.editEmail);
            formData.append('phone', this.editPhone);

            axiosRes.post('/updateCustomers', formData).then(res => {
                console.log(this.editCategory);
                this.loadingState = false;
                this.updateMessage = {
                    message: res.data.result,
                    isSuccess: res.data.success ? true : false
                };

                if(res.data.success) {
                    this.editFirstname = '';
                    this.editLastname = '';
                    this.editEmail = '';
                    this.editPhone = '';

                    setTimeout(() => {
                        window.location.reload();
                    }, 2000);
                }
            });
        }
    },
    mounted() {
        axiosRes.get('/fetchCustomers').then(res => {
            this.loadingState2 = false;
            this.customers = res.data.result;
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