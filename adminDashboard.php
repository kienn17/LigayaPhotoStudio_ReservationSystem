<?php include('adminLogin_process.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <title>Admin Dashboard - Photo Studio</title>
</head>

<body>
    <div id="app">
        <!-- Sidebar -->
        <div class="sidebar">
            <a class="logo pr">
                <i class='bx bxs-user'></i>
                <div class="logo-name"><span>Admin</span> Dashboard</div>
            </a>

            <ul class="side-menu">
            <li v-for="menuItem in menuItems" :key="menuItem.id" :class="{ 'active-menu-category': menuItem.label === activeMenu }">
                <a :href="menuItem.link" @click.prevent="menuItem.label === 'Logout' ? redirectToAdminLogin() : switchMenu(menuItem.label)">
                    <i :class="menuItem.iconClass"></i>
                    {{ menuItem.label }}
                </a>
            </li>
            </ul>
        </div>

        <div class="content">
            <main>
                <!-- Dashboard Overview -->
                <div class="Dashboard" v-if="activeMenu == 'Dashboard'">
                    <div class="header">
                        <div class="left">
                            <h1>Dashboard</h1>
                        </div>

                        <ul class="insights">
                            <li>
                                <i class='bx bxs-calendar-check'></i>
                                <span class="info">
                                    <p>UPCOMING RESERVATIONS</p>
                                    <div>{{ totalReservations }}</div>
                                </span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="Upcoming-Visits" v-if="activeMenu == 'Upcoming Visits'">
                    <h1><i class='bx bx-user'></i> Upcoming Visits</h1>
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>First Name</th>
                                <th>Surname</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Social Media Link</th>
                                <th>Package</th>
                                <th>Reservation Date</th>
                                <th>Time</th>
                                <th>Proof of Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(customer, index) in customerRecords" :key="index">
                                <td>{{ customer.firstname }}</td>
                                <td>{{ customer.surname }}</td>
                                <td>
                                    <a :href="`mailto:${customer.email}`" target="_blank">{{ customer.email }}</a>
                                </td>
                                <td>{{ customer.phone }}</td>
                                <td>{{ customer.socmed_link }}</td>
                                <td>{{ customer.package }}</td>
                                <td>{{ customer.date }}</td>
                                <td>{{ customer.time }}</td>
                                <td>
                                    <img
                                        :src="customer.proof_url ? `proof_of_payment/${customer.proof_url}` : 'default_image.png'"
                                        alt="Proof of Payment"
                                        style="cursor: pointer; width: 50px; height: auto;"
                                        @click="showPaymentProof(customer.proof_url)"
                                    >
                                </td>
                                <td>
                                    <select v-model="customer.status" @change="updateBookingStatus(customer.id, customer.status)">
                                        <option value="Pending">Pending</option>
                                        <option value="Confirmed">Confirmed</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>


                
                <!-- Customer Records -->
                <div class="Customer-Records" v-if="activeMenu == 'Customer Records'">
                    <h1><i class='bx bx-user'></i> Customer Records</h1>

                    <!-- Search and Filter Section -->
                    <div class="filters">
                        <input type="text" v-model="searchQuery" placeholder="Search by name, email, or package" class="form-control" />
                        
                        <select v-model="selectedStatus" class="form-control">
                            <option value="">All Status</option>
                            <option value="Pending">Pending</option>
                            <option value="Successful">Successful</option>
                            <option value="Cancelled">Cancelled</option>
                        </select>
                    </div>

                    <!-- Customer Records Table -->
                    <table class="table table-bordered">
                        <thead class="thead-dark">
                            <tr>
                                <th>First Name</th>
                                <th>Surname</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Social Media Link</th>
                                <th>Package</th>
                                <th>Reservation Date</th>
                                <th>Time</th>
                                <th>Proof of Payment</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(customer, index) in filteredCustomerRecords" :key="index">
                                <td>{{ customer.firstname }}</td>
                                <td>{{ customer.surname }}</td>
                                <td>
                                    <a :href="`mailto:${customer.email}`" target="_blank">
                                        {{ customer.email }}
                                    </a>
                                </td>
                                <td>{{ customer.phone }}</td>
                                <td>{{ customer.socmed_link }}</td>
                                <td>{{ customer.package }}</td>
                                <td>{{ customer.date }}</td>
                                <td>{{ customer.time }}</td>
                                <td>
                                    <img :src="customer.proof_url ? `proof_of_payment/${customer.proof_url}` : 'default_image.png'" 
                                    alt="Proof of Payment" 
                                    style="cursor: pointer; width: 50px; height: auto;" 
                                    @click="showPaymentProof(customer.proof_url)">
                                </td>
                                <td>{{ customer.status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </main>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    searchQuery: '', // To store the search query
                    selectedStatus: '',
                    activeMenu: 'Dashboard', // Default menu
                    menuItems: [
                        { id: 1, label: 'Dashboard', link: '', iconClass: 'bx bx-home' },
                        { id: 2, label: 'Upcoming Visits', link: '', iconClass: 'bx bx-user' },
                        { id: 3, label: 'Customer Records', link: '', iconClass: 'bx bx-user' },
                        { id: 4, label: 'Logout', link: '', iconClass: 'bx bx-log-out' },
                    ],
                    totalReservations: 0,
                    customerRecords: [],
                    upcomingVisits: [], // Separate variable for upcoming visits
                    upcomingReservations: [],
                };
            },
            computed: {
                filteredCustomerRecords() {
                    return this.customerRecords.filter(customer => {
                        // Filter by status
                        const matchesStatus = this.selectedStatus ? customer.status === this.selectedStatus : true;

                        // Filter by search query (case-insensitive)
                        const matchesSearch = customer.firstname.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                            customer.surname.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                            customer.email.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
                                            customer.package.toLowerCase().includes(this.searchQuery.toLowerCase());

                        return matchesStatus && matchesSearch;
                    });
                }
            },
            methods: {
                switchMenu(menu) {
                    this.activeMenu = menu;
                    if (menu === 'Upcoming Visits') {
                        this.fetchUpcomingVisits(); // Fetch only upcoming visits
                    } else if (menu === 'Cancelled Bookings') {
                        this.fetchCancelledBookings();
                    } else if (menu === 'Successful Bookings') {
                        this.fetchSuccessfulBookings();
                    } else if (menu === 'Customer Records') {
                        this.fetchCustomerRecords();
                    } else if (menu === 'Dashboard') {
                        this.fetchUpcomingReservations();
                    }
                },
                redirectToAdminLogin() {
                    window.location.href = 'admin_login.php';
                },
                fetchCustomerRecords() {
                    axios.get('fetch_customers.php') // Backend script for all customer records
                        .then(response => {
                            if (response.data.status === 'success') {
                                this.customerRecords = response.data.records;
                            } else {
                                console.error('Failed to load customer records');
                            }
                        })
                        .catch(error => console.error('Error fetching customer records:', error));
                },
                fetchUpcomingVisits() {
                    axios.get('fetch_upcoming_visits.php') // Backend script for upcoming visits
                        .then(response => {
                            if (response.data.status === 'success') {
                                this.upcomingVisits = response.data.bookings; // Store in 'upcomingVisits'
                            } else {
                                console.error('Failed to load upcoming visits');
                            }
                        })
                        .catch(error => console.error('Error fetching upcoming visits:', error));
                },
                showPaymentProof(proofUrl) {
                    const fullUrl = `proof_of_payment/${proofUrl}`; // Construct full URL to the image
                    Swal.fire({
                        title: 'Proof of Payment',
                        text: 'Here is the proof of payment.',
                        imageUrl: fullUrl, // Use the full URL here
                        imageWidth: 300, // Adjust width as needed
                        imageHeight: 600, // Adjust height as needed
                        imageAlt: 'Payment Proof',
                        confirmButtonText: 'Close',
                    });
                },

                updateBookingStatus(customerId, newStatus) {
                    console.log('Updating booking status...', { customerId, newStatus });

                    axios.post('update_status.php', new URLSearchParams({
                        id: customerId,
                        status: newStatus
                    }), {
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        }
                    })
                    .then(response => {
                        if (response.data.success) {
                            Swal.fire('Success!', 'Booking status updated', 'success');
                            // Refresh the lists after updating status
                            this.fetchUpcomingVisits();
                            this.fetchCancelledBookings();
                        } else {
                            Swal.fire('Error!', response.data.error || 'Failed to update booking status', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating booking status:', error);
                        Swal.fire('Error!', 'There was an issue updating the booking status', 'error');
                    });
                },

                fetchUpcomingReservations() {
                    axios.get('fetch_reservations.php')
                        .then(response => {
                            this.upcomingReservations = response.data;
                            this.totalReservations = this.upcomingReservations.length;
                        })
                        .catch(error => console.error(error));
                },
            },
            mounted() {
                this.fetchUpcomingReservations();
                this.fetchUpcomingVisits(); // Initial fetch for upcoming visits
            },
        });
    </script>

</body>

    
    <style type="text/css">
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');


        :root {
            --light: #f6f6f9;
            --primary: #1976D2;
            --light-primary: #CFE8FF;
            --grey: #eee;
            --dark-grey: #AAAAAA;
            --dark: #363949;
            --danger: #D32F2F;
            --light-danger: #FECDD3;
            --warning: #FBC02D;
            --light-warning: #FFF2C6;
            --success: #388E3C;
            --light-success: #BBF7D0;
        }

        *{
            margin: 0;
            padding: 0;
            outline: none;
            text-decoration: none;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        .product-upload-img {
            height: 350px !important;
            width: 350px !important;
            margin: 0 auto; /* Center horizontally */
            border: 5px solid grey;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .product-upload-img img {
            height: 350px !important;
            width: 350px !important;
            padding: 5px;
        }
    
        .custom-file-input::before {
            display: inline-block;
            background: linear-gradient(to bottom, #f9f9f9, #e3e3e3);
            border: 1px solid #ccc;
            border-radius: 3px;
            padding: 5px 20px;
            outline: none;
            white-space: nowrap;
            cursor: pointer;
        }

        .modal-backdrop {
            z-index: 1040; /* Backdrop behind the modal */
        }

        .modal {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%); /* Center the modal */
            z-index: 1050;
        }

        .filters {
            display: flex;
            justify-content: flex-start;
            gap: 20px; /* Space between the search bar and dropdown */
            margin-bottom: 20px;
        }

        .filter-search, .filter-status {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 4px;
            width: 150px; /* Adjust the width of the input and select */
        }

        .filter-search:focus, .filter-status:focus {
            border-color: #007bff;
            outline: none;
        }


        .bx{
            font-size: 1.7rem;
        }

        .a {
            text-decoration: none;
        }

        .li {
            list-style: none;
        }

        .html {
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        .body.dark{
            --light: #181a18;
            --grey: #25252c;
            --dark: #fbfbfb;
        }


        .body {
            background: rgb(219, 219, 219);
            height: 100%;
            margin: 0;
            overflow: hidden;
        }

        .sidebar{
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background: rgb(40, 40, 43);
            box-shadow: 0 0 30px rgba(0, 0, 0, .5);
            width: 70px;
            height: 100vh;
            z-index: 1000;
            overflow-x: hidden;
            scrollbar-width: none;
            transition: width 0.2s linear;
            color: var(--leonardo-ai-colors-secondary-inactive);
        }

        .sidebar:hover{
            width: 240px;
            transition: 0.5s;
        }

        .sidebar::-webkit-scrollbar{
            display: none;
        }

        .sidebar.close{
            width: 60px;
        }
        .create-item i {
            color: #5db54c !important;
        }
        
        .btn-product-icon {
            font-size: 20px;
        }
        .add-product:hover,
        .add-cashier:hover,
        .update-button:hover,
        .create-item:hover {
            background-color: #e6e6e6 !important; 
        }
        .delete-button:hover {
            background-color: red !important;
        }

        .sidebar .logo{
            font-size: 18px;
            font-weight: 700;
            height: 56px; /* Adjust the height to fit */
            display: flex;
            align-items: center; /* Center the content vertically */
            color: rgb(221, 176, 121);
            z-index: 500;
            padding: 0 10px; /* Adjust padding to fit better */
            box-sizing: content-box;
            color: white;
            transition: all 0.5s ease;
            pointer-events: none;
            margin-bottom: 20px; /* Add space below logo */
        }

        .sidebar .logo .logo-name span{
            color: white;
            pointer-events: none;
        }

        .sidebar .logo .bx{
            min-width: 60px;
            display: flex;
            justify-content: center;
            font-size: 2rem;
            color: white;
        }

        .sidebar .side-menu{
            height: 88%;
            position: relative;
            list-style: none;
            padding: 0;
        }

        .sidebar .side-menu li{
            padding: 1rem;
            margin: 8px 0;
            border-radius: 8px;
            transition: all 0.5s ease;
        }

        .sidebar .side-menu li.active{
            color: white;
            background: black;
            position: relative;
        }

        .sidebar .side-menu li.active::before{
            content: "";
            position: absolute;
            width: 40px;
            height: 40px;
            /* border-radius: 50%; */
            top: -40px;
            right: 0;
            box-shadow: whitesmoke;
            z-index: -1;
            
        }

        .sidebar .side-menu li.active::after{
            content: "";
            position: absolute;
            width: 40px;
            height: 40px;
            /* border-radius: 50%; */
            bottom: -40px;
            right: 0;
            box-shadow: 20px -20px 0 var(--grey);
            z-index: -1;
            transition: all 0.3s ease;
            
        }

        .sidebar .side-menu li a{
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center; 
            font-size: 15px;
            color: white;
            white-space: nowrap;
            overflow-x: hidden;
            transition: all 0.3s ease;
            
            
        }

        .sidebar .side-menu li.active a{
            color: var(--success);
        }

        .sidebar.close .side-menu li a{
            width: calc(48px - (4px * 2));
            transition: all 0.3s ease;
        }

        .sidebar .side-menu li a .bx{
            min-width: calc(60px - ((4px + 6px) * 2));
            display: flex;
            font-size: 1.6rem;
            justify-content: center;
        }

        .sidebar .side-menu li a.logout{
            color: var(--danger);
        }

        .content {
            height: 2000px;
            padding: 20px;
            z-index: 100;
            position: relative;
            left: 230px;
            background: #fff;
            flex: 1;
            box-sizing: border-box;
        }

        .content main{
            width: 85%;
            padding: 36px 24px;
            max-height: calc(100vh - 56px);
            overflow-y: scroll;
            background-color: #8EACCD;
            border-radius: 20px;
            flex: 1;
        }

        .content main .header h1{
            display: flex;
            align-items: center;
            justify-content: space-between;
            grid-gap: 16px;
            flex-wrap: wrap;
        }

        .content main .header .left h1{
            font-size: 36px;
            font-weight: 600;
            margin-bottom: 10px;
            color: white;
        }

        .content main .header{
            height: 36px;
            padding: 0 16px;
            display: flex;
            grid-gap: 10px;
            font-weight: 500;
            background: #8EACCD;
            height: fit-content;
        }

        .content main .insights{
            display: grid;
            grid-template-columns: auto auto auto;
            grid-gap: 24px;
            margin-top: 36px;
            padding: 30px;
            
        }

        .insights li {
            padding: 24px;
            background: var(--light);
            border-radius: 20px;
            display: flex;
            align-items: center;
            grid-gap: 50px;
            cursor: pointer;
            margin-bottom: 20px; /* Adjust as needed */
        }

        .insights .info {
            flex: 1;
        }

        .insights .material-symbols-outlined {
            font-size: 40px;
            color: #3498db; /* Set your desired color */
        }

        .insights p {
            margin-bottom: 10px;
            color: #3498db;
            font-weight: bold;
        }


        .recent-orders-table-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .completed-card,
        .transaction-card,
        .inventory-card,
        .cashier-card,
        .recent-order-card{
            background: #F9F6EE;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            padding: 1rem;
            text-align: left;
            border-radius: 10px;
        }
        

        .tableofrecentorder h3{
            padding: 16px;
            margin-top: -200px;
            
        }

        .inventoryTable,
        .completed-table,
        .voided-table,
        .cashier-table,
        .recent-orders-table{
            padding: 1rem;
            text-align: left;
            
        }

        .inventoryTable th,
        .inventoryTable td,
        .voided-table th,
        .voided-table td,
        .cashier-table th,
        .cashier-table td,
        .recent-orders-table th,
        .recent-orders-table td{
            padding: 1rem;
            font-size: 15px;
            font-size: 13px;
           
            
        }

        .completed-table th,
        .completed-table td{
            padding: 1rem;
            font-size: 15px;
            font-size: 13px;
            

        }


        .Transaction-Log h1,
        .Product-Management h1 {
            font-size: 24px;
            margin-bottom: 30px; 
           
        }

        .Transaction-Log h3{
            margin-bottom: 20px;
            color: black;
        }

        .Transaction-Log .Completed-Transaction-Log h3 {
            margin-top: 50px;
            margin-bottom: 20px;
            color: black;
        }

        .add-product,
        .add-cashier,
        .update-button,
        .delete-button,
        .create-item {
            background-color: black;
            color: white;
            padding: 10px 20px;
            
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: background .5s;
            cursor: pointer;
            font-size: 10px;
            margin-bottom: 30px;
        }
        
        .cashier-action-button {
            background-color: black;
            color: white;
            padding: 10px 20px;
            
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: background .5s;
            cursor: pointer;
            font-size: 10px;
        }

        .action-button-inv {
            background-color: black;
            color: white;
            padding: 10px 20px;
            
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: background .5s;
            cursor: pointer;
            font-size: 10px;
        }


        .menu-list {
            padding: 0 20px 20px;
            display: grid;
            grid-template-columns: repeat(4, 1fr); /* Adjust the column width as needed */
            column-gap: 10px;
            row-gap: 10px;
            font-size: 12px;
        }

        .menu-list .item {
            text-align: center;
            background-color: whitesmoke;
            padding: 10px;
            letter-spacing: 1px;
        }

        .menu-list .item .img img {
            max-height: 80px; /* Adjust the max height as needed */
        }

        .menu-list .item h4 {
            font-weight: 600;
        }

        
        .input-container label {
            margin-bottom: 5px;
        }

        /* Style for the table */
        table {
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            border: 1px solid #fff;
        }

        

        .edit-form {
            display: none;
        }


        /* Edit Dialog Styles */
        .addnewitem,
        .updateitem {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #fff;
            padding: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .addnewitem p,
        .updateitem p {
            margin-top: 10px;
            margin-bottom: 10px;
        }

        /* Input Styles */

        .addnewinput input,
        .input input {
            display: block;
            margin-bottom: 10px;
            padding: 5px;
            width: 100%;
        }

        /* Button Styles */

        .addnewitem button,
        button {
            margin-right: 10px;
            padding: 5px 10px;
            font-size: 16px;
            cursor: pointer;
        }
        .active-menu-category,  .active-menu-category a{
            background-color: rgb(112, 128, 144) !important;
            
        }
          /* Overlay styles */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5); /* Semi-transparent black overlay */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999; /* Ensure it's above other content */
            visibility: hidden; /* Initially hidden */
            opacity: 0; /* Initially transparent */
            transition: opacity 0.5s ease, visibility 0.5s ease;
        }

        
    </style>
</body>

</html>

