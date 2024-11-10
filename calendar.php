<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Add jQuery before Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>    
 
 
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Reservation Calendar</title>
</head>
<body style="background-color: #E5D9F2;">
    <div id="app" class="container mt-5">
        <!-- Sidebar -->
        <div class="sidebar">
            <a href="#" class="logo pr">
                <i class='bx bxs-user'></i>
                <div class="logo-name"><span>Customer</span> Dashboard</div>
            </a>

            <ul class="side-menu">
                <li v-for="menuItem in menuItems" :key="menuItem.id" :class="{ 'active-menu-category': menuItem.label === activeMenu }">
                    <a :href="menuItem.link" @click.prevent="menuItem.label === 'Logout' ? redirectToLogin() : switchMenu(menuItem.label)">
                        <i :class="menuItem.iconClass"></i>
                        {{ menuItem.label }}
                    </a>
                </li>
            </ul>
        </div>

        <div class="content">
            <div class="blurred-container" v-if="activeMenu === 'Calendar'">
                <h2 class="text-center">{{ monthName }} {{ currentYear }}</h2>
                <div class="d-flex justify-content-center mb-3">
                    <button class="btn btn-success mx-2" @click="changeMonth(-1)">Previous Month</button>
                    <button class="btn btn-danger mx-2" @click="changeMonth(0)">Current Month</button>
                    <button class="btn btn-primary mx-2" @click="changeMonth(1)">Next Month</button>
                </div>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th class="text-center" v-for="day in daysOfWeek" :key="day">{{ day }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="week in calendar" :key="week">
                            <td v-for="day in week" :key="day.date" :class="{ today: day.isToday }">
                                <div v-if="day.number">
                                    <h4>{{ day.number }}</h4>
                                    <button v-if="day.isPast" class="btn btn-danger btn-xs" disabled>Dated Passed</button>
                                    <button v-else-if="day.isBooked" class="btn btn-danger btn-xs">Already Booked</button>
                                    <a v-else :href="'book_form.php?date=' + day.date" class="btn btn-custom btn-xs">
                                        Book Now
                                    </a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="Recent-Book" v-if="activeMenu === 'Recent Book'">
                <h1><i class='bx bx-book'></i> Recent Bookings</h1>
                <table class="table table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>First Name</th>
                            <th>Surname</th>
                            <th>Package</th>
                            <th>Reservation Date</th>
                            <th>Time</th>
                            <th>Payment Method</th>
                            <th>Proof of Payment</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(booking, index) in recentBookings" :key="index">
                            <td>{{ booking.firstname }}</td>
                            <td>{{ booking.surname }}</td>
                            <td>{{ booking.package }}</td>
                            <td>{{ booking.date }}</td>
                            <td>{{ booking.time }}</td>
                            <td>{{ booking.payment_method }}</td>
                            <td>
                                <img
                                    :src="`${booking.payment_proof}`" 
                                    alt="Proof of Payment"
                                    style="cursor: pointer; width: 50px; height: auto;"
                                    @click="showPaymentProof(booking.payment_proof)"
                                >

                            </td>

                            <td>{{ booking.status }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        new Vue({
            el: '#app',
            data: {
                currentMonth: new Date().getMonth(),
                currentYear: new Date().getFullYear(),
                daysOfWeek: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
                calendar: [],
                bookings: [], // Example booking dates
                recentBookings: [], // New property for recent bookings
                activeMenu: 'Calendar', // Default menu
                menuItems: [
                    { id: 1, label: 'Calendar', link: '', iconClass: 'bx bxs-calendar' },
                    { id: 2, label: 'Recent Book', link: '', iconClass: 'bx bxs-book-alt' },
                    { id: 3, label: 'History', link: '', iconClass: 'bx bxs-book' },
                    { id: 4, label: 'Logout', link: '', iconClass: 'bx bxs-log-out' },
                ],
                totalReservations: 0,
                customerRecords: [],
            },
            computed: {
                monthName() {
                    return new Date(this.currentYear, this.currentMonth).toLocaleString('default', { month: 'long' });
                }
            },
            methods: {
                switchMenu(menuLabel) {
                    // Update the active menu based on the clicked item
                    this.activeMenu = menuLabel;

                    // Logic for switching to Recent Book view
                    if (menuLabel === 'Recent Book') {
                        this.fetchRecentBookings(); // Fetch recent bookings
                    } else if (menuLabel === 'Logout') {
                        this.redirectToLogin();
                    }
                },
                fetchRecentBookings() {
                    fetch('fetch_recent_bookings.php') // Ensure this path is correct
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.error) {
                                console.error(data.error);
                            } else {
                                this.recentBookings = data; // Set the bookings data to the Vue data property
                            }
                        })
                        .catch(error => {
                            console.error('Fetch error:', error);
                        });
                },


                showPaymentProof(paymentProof) {
                    const fullUrl = `${paymentProof}`; // Only reference proof_of_payment once
                    console.log('Fetching image from URL:', fullUrl);

                    Swal.fire({
                        title: 'Proof of Payment',
                        text: 'Here is the proof of payment.',
                        imageUrl: fullUrl, // Correct full URL
                        imageWidth: 300,
                        imageHeight: 600,
                        imageAlt: 'Payment Proof',
                        confirmButtonText: 'Close',
                    });
                },
                removeBooking(bookingId) {
                    // Implement your logic to remove a booking
                    console.log('Removing booking with ID:', bookingId);
                    // Call your backend logic to remove the booking
                },
            
                redirectToLogin() {
                    // Redirect to admin login page (you can replace this with actual logic)
                    window.location.href = 'login.php';
                },
                generateCalendar() {
                    const firstDayOfMonth = new Date(this.currentYear, this.currentMonth, 1);
                    const numberDays = new Date(this.currentYear, this.currentMonth + 1, 0).getDate();
                    const startingDay = firstDayOfMonth.getDay();

                    const weeks = [];
                    let days = [];
                    let currentDay = 1;

                    for (let i = 0; i < startingDay; i++) {
                        days.push({ number: null, date: null, isToday: false });
                    }

                    while (currentDay <= numberDays) {
                        const currentDate = `${this.currentYear}-${String(this.currentMonth + 1).padStart(2, '0')}-${String(currentDay).padStart(2, '0')}`;
                        const isToday = currentDate === new Date().toISOString().split('T')[0];
                        const isBooked = this.bookings.includes(currentDate);
                        const isPast = new Date(currentDate) < new Date().setHours(0, 0, 0, 0);
                        
                        days.push({ number: currentDay, date: currentDate, isToday, isBooked, isPast });

                        if (days.length === 7) {
                            weeks.push(days);
                            days = [];
                        }

                        currentDay++;
                    }

                    while (days.length < 7) {
                        days.push({ number: null, date: null, isToday: false });
                    }
                    weeks.push(days);

                    this.calendar = weeks;
                },
                changeMonth(offset) {
                    const currentDate = new Date(this.currentYear, this.currentMonth + offset);
                    this.currentMonth = currentDate.getMonth();
                    this.currentYear = currentDate.getFullYear();

                    if (offset === 0) {
                        this.currentMonth = new Date().getMonth();
                        this.currentYear = new Date().getFullYear();
                    }

                    this.generateCalendar();
                }
            },
            mounted() {
                this.generateCalendar();
                this.fetchRecentBookings();
            }
        });
    </script>

    <style>
        .blurred-container {
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            margin: 20px auto;
            max-width: 900px;
            background: transparent;
        }

        body {
            background-color: #E5D9F2;
        }

        .btn-custom {
            background-color: #8EACCD;
            color: black;
            border: none;
        }

        .btn-custom:hover {
            background-color: #A3B3E6;
        }

        td {
            padding: 10px;
            text-align: center;
            vertical-align: middle;
        }

        .today {
            background: #eee;
        }

        h4 {
            margin: 0;
        }

        @media only screen and (max-width: 750px) {
            table, thead, tbody, th, td, tr {
                display: block;
            }
        }

        .sidebar {
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

        .sidebar:hover {
            width: 240px;
            transition: 0.5s;
        }

        .sidebar::-webkit-scrollbar {
            display: none;
        }

        .sidebar.close {
            width: 60px;
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

        
        
    </style>
</body>
</html>
