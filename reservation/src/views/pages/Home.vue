<template>
    <div class="container mt-3 mb-3">
        <h2 class="mb-5 text-center">Reservation</h2>
        
        <div class="d-flex justify-content-center">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-bs-toggle="pill" href="#all">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#withAircon">Room w/ Aircon</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="pill" href="#withoutAircon">Room w/o Aircon</a>
                </li>
            </ul>
        </div>

        <div v-if="loadingState2" class="d-flex justify-content-center spinnerClass">
            <div class="spinner-grow text-muted spinner-grow-sm"></div>
            <div class="spinner-grow text-muted spinner-grow-sm"></div>
            <div class="spinner-grow text-muted spinner-grow-sm"></div>
        </div>
        <div v-else-if="rooms.length !== 0" class="tab-content text-center room_content">
            <div id="all" class="container tab-pane active">
                <div class="d-flex justify-content-evenly">
                    <div v-for="room in rooms" :key="room" class="card" style="width:400px; margin: 0 4px;">
                        <img class="card-img-top" :src="photoBaseURL + room.photo" alt="">
                        <div class="card-body">
                            <h4 class="card-title">{{ room.name }}</h4>
                            <p class="card-text">Capacity: {{ room.capacity }} pax</p>
                            <p class="card-text">Price: ${{ room.price }}</p>
                            <p class="card-text">Category: {{ formatCategory(room.category) }}</p>
                            <p class="card-text">Location: {{ room.location }}</p>
                            <a href="#" @click="chooseRoom(room.room_type_id)" data-bs-toggle="modal" data-bs-target="#addCustomerInfoModal" class="btn btn-primary">Reserve Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="withAircon" class="container tab-pane fade">
                <div class="d-flex justify-content-evenly">
                    <div v-for="roomWithAircon in roomWithAircons" :key="roomWithAircon" class="card" style="width:400px; margin: 0 4px;">
                        <img class="card-img-top" :src="photoBaseURL + roomWithAircon.photo" alt="">
                        <div class="card-body">
                            <h4 class="card-title">{{ roomWithAircon.name }}</h4>
                            <p class="card-text">Capacity: {{ roomWithAircon.capacity }} pax</p>
                            <p class="card-text">Price: ${{ roomWithAircon.price }}</p>
                            <p class="card-text">Category: {{ formatCategory(roomWithAircon.category) }}</p>
                            <p class="card-text">Location: {{ roomWithAircon.location }}</p>
                            <a href="#" @click="chooseRoom(roomWithAircon.room_type_id)" data-bs-toggle="modal" data-bs-target="#addCustomerInfoModal" class="btn btn-primary">Reserve Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div id="withoutAircon" class="container tab-pane fade">
                <div class="d-flex justify-content-evenly">
                    <div v-for="roomWithoutAircon in roomWithoutAircons" :key="roomWithoutAircon" class="card" style="width:400px; margin: 0 4px;">
                        <img class="card-img-top" :src="photoBaseURL + roomWithoutAircon.photo" alt="">
                        <div class="card-body">
                            <h4 class="card-title">{{ roomWithoutAircon.name }}</h4>
                            <p class="card-text">Capacity: {{ roomWithoutAircon.capacity }} pax</p>
                            <p class="card-text">Price: ${{ roomWithoutAircon.price }}</p>
                            <p class="card-text">Category: {{ formatCategory(roomWithoutAircon.category) }}</p>
                            <p class="card-text">Location: {{ roomWithoutAircon.location }}</p>
                            <a href="#" @click="chooseRoom(roomWithoutAircon.room_type_id)" data-bs-toggle="modal" data-bs-target="#addCustomerInfoModal" class="btn btn-primary">Reserve Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="text-center mt-4">
            <p class="text-muted">No Data</p>
        </div>
    </div>

    <!-- Modal for Choosen Room and Customer info -->
    <div class="modal fade" id="addCustomerInfoModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title"><i class="bi bi-house-check-fill"></i> Choosen Room</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div v-if="infoMessage" :class="{'alert': true, 'alert-danger': !infoMessage.isSuccess, 'alert-success': infoMessage.isSuccess}">
                        <strong>{{ infoMessage.message }}</strong>
                    </div>

                    <div class="choosenRoom_wrap">
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-success"><figure><img class="rounded d-block mx-auto img-fluid" :src="photoBaseURL + getChooseRoom.photo" alt=""></figure></li>
                            <li class="list-group-item list-group-item-success">Name: {{ getChooseRoom.name }}</li>
                            <li class="list-group-item list-group-item-success">Capacity: {{ getChooseRoom.capacity }} pax</li>
                            <li class="list-group-item list-group-item-success">Price: ${{ getChooseRoom.price }}</li>
                            <li class="list-group-item list-group-item-success">Category: {{ formatCategory(getChooseRoom.category) }}</li>
                            <li class="list-group-item list-group-item-success">Location: {{ getChooseRoom.location }}</li>
                        </ul> 
                    </div>

                    <div class="customerInfo mt-4">
                        <h5><i class="bi bi-info-circle-fill"></i> Customer Info</h5>

                        <hr>

                        <div v-if="addCustomerMessage" :class="{'alert': true, 'alert-danger': !addCustomerMessage.isSuccess, 'alert-success': addCustomerMessage.isSuccess}">
                            <strong>{{ addCustomerMessage.message }}</strong>
                        </div>
                        <form>
                            <div class="mb-3 mt-3">
                                <div class="d-flex justify-content-between">
                                    <section>
                                        <label for="firstname" class="form-label">Firstname: <span class="requiredInput">*</span></label>
                                        <input type="text" class="form-control" placeholder="Frstname" v-model="firstname">
                                    </section>
                                    <section>
                                        <label for="lastname" class="form-label">Lastname: <span class="requiredInput">*</span></label>
                                        <input type="text" class="form-control" placeholder="Lastname" v-model="lastname">
                                    </section>
                                </div>
                            </div>
                            <div class="mb-3 mt-3">
                                <div class="d-flex justify-content-between">
                                    <section>
                                        <label for="email" class="form-label">Email: <span class="requiredInput">*</span></label>
                                        <input type="email" class="form-control" placeholder="Email" v-model="email">
                                    </section>
                                    <section>
                                        <label for="phone" class="form-label">Phone: <span class="requiredInput">*</span></label>
                                        <input type="text" class="form-control" placeholder="Phone" v-model="phone">
                                    </section>
                                </div>
                            </div>
                            <div class="form-check mb-3">
                                <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" v-model="confirmReserve"> <span class="requiredInput">*</span> By clicking this you already review your <strong>choosen room</strong> and <strong>customer info</strong> provided.
                                </label>
                            </div>
                            <div class="d-grid">
                                <button v-if="loadingState" class="btn btn-primary btn-block" disabled>
                                    <span class="spinner-grow spinner-grow-sm"></span>
                                    Loading...
                                </button>
                                <button v-else @click.prevent="addCustomerInfo" type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </form> 
                    </div>
                </div>

            </div>
        </div>
    </div>  

</template>

<script>
import axiosRes from '@/main';

export default {
    name: 'home',
    data() {
        return {
            loadingState: false,
            loadingState2: true,
            rooms: '',
            roomWithAircons: [],
            roomWithoutAircons: [],
            infoMessage: '',
            photoBaseURL: 'http://localhost:8080/uploads/',
            getChooseRoom: '',
            firstname: '',
            lastname: '',
            email: '',
            phone: '',
            addCustomerMessage: '',
            confirmReserve: ''
        }
    },
    methods: {
        addCustomerInfo() {
            this.loadingState = true;
            const formData = new FormData();
            formData.append('roomID', this.getChooseRoom.room_type_id);
            formData.append('first_name', this.firstname);
            formData.append('last_name', this.lastname);
            formData.append('email', this.email);
            formData.append('phone', this.phone);
            formData.append('confirm', this.confirmReserve);

            axiosRes.post('/reserveRoom', formData).then(res => {
                this.loadingState = false;
                this.addCustomerMessage = {
                    message: res.data.result,
                    isSuccess: res.data.success ? true : false
                };

                if(res.data.success) {
                    this.firstname = '';
                    this.lastname = '';
                    this.email = '';
                    this.phone = '';
                    this.confirmSelection = '';

                    setTimeout(() => { window.location.reload() }, 2000);
                }
            });
        },
        chooseRoom(id) {
            this.rooms.forEach(res => {
                if(res.room_type_id == id) {
                    this.getChooseRoom = res;
                }
            });
        },
        formatCategory(num) {
            let convertToNumber = parseInt(num);
            if(convertToNumber == 1) return num = 'w/ Aircon';
            else return num = 'w/o Aircon';
        },
    },
    mounted() {
        axiosRes.get('/').then(res => {
            this.loadingState2 = false;
            this.rooms = res.data.result;
  
            res.data.result.forEach(res => {
                if(res.category == 1) {
                    this.roomWithAircons.push(res);
                }else {
                    this.roomWithoutAircons.push(res);
                }
            });
        });
    }
}
</script>

<style scoped>
.card-img-top{width: 100%; min-height: 280px; object-fit: cover;}
.nav-pills li{margin: 0 4px;}
.nav-pills li a{display: block; width: 200px; text-align: center; border-radius: 30px !important; border: 1px solid; max-width: 100%;}
.spinnerClass{margin-top: 50px;}
.spinnerClass div{margin: 0 4px;}
.room_content{margin-top: 40px;}
.d-flex section, .address{margin: 0 4px;}
.requiredInput{color: #f70e0e;}
.choosenRoom_wrap img{width: 300px;}
.alert{text-align: center;}
</style>