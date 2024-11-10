<?php
// Retrieve the date from the URL parameters and format it
$date = isset($_GET['date']) ? date('Y-m-d', strtotime($_GET['date'])) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@48,400,0,0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <title>Booking Form</title>
</head>
<body>
    <div id="app">
        <div class="booking-container">
            <div class="booking-card">
                <div class="booking-header">
                    <h1>Booking Form</h1>
                    <p style="color: green; font-weight: bold; text-align: center;">
                        NOTE THAT WE WILL BE SENDING AN EMAIL WITH THE SUBJECT "APPOINTMENT CONFIRMATION" 
                        TO CONFIRM YOUR BOOKING! MAKE SURE TO SETTLE THE DOWN PAYMENT TO SECURE YOUR SLOT!
                    </p>
                </div>
                <form class="booking-card-form" @submit.prevent="submitBooking" enctype="multipart/form-data">
                    <div class="input">
                        <input v-model="firstName" type="text" placeholder="First Name" required>
                    </div>
                    <div class="input">
                        <input v-model="surname" type="text" placeholder="Surname" required>
                    </div>
                    <div class="input">
                        <input v-model="email" type="email" placeholder="Email" required>
                    </div>
                    <div class="input">
                        <input v-model="socialMedia" type="text" placeholder="Social Media Link" required>
                    </div>
                    <div class="input">
                        <input v-model="phone" type="tel" placeholder="Phone Number" required>
                    </div>
                    <div class="input">
                        <!-- Automatically set the date from the URL -->
                        <input v-model="date" type="date" class="form-control" required readonly>
                    </div>
                    <div class="input"> <!-- Wrap the time select in this div -->
                        <select v-model="time" required>
                            <option disabled value="">Select Time</option>
                            <option v-for="t in availableTimes" :key="t">{{ t }}</option>
                        </select>
                    </div>
                    <div class="input">
                        <select v-model="package" required>
                            <option disabled value="">Select Package</option>
                            <option value="tuwa">Tuwa Package</option>
                            <option value="masaya">Masaya Package</option>
                            <option value="ligaya">Ligaya Package</option>
                        </select>
                    </div>

                    <div class="input">
                        <select v-model="paymentMethod" required>
                            <option disabled value="">Select Payment Method</option>
                            <option value="bdo">BDO</option>
                            <option value="gcash">GCash</option>
                            <option value="maya">Maya</option>
                        </select>
                    </div>
                    <div class="input">
                        <label for="paymentProof" class="file-label">
                            <i class="fas fa-upload"></i> Proof of Payment
                        </label>
                        <input type="file" id="paymentProof" @change="onFileChange" accept="image/*">
                    </div>

                    <div class="submit-btn-container">
                        <button type="submit" class="submit-btn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    firstName: '',
                    surname: '',
                    email: '',
                    phone: '',
                    date: '<?php echo $date; ?>', // Set the date from the URL
                    time: '',
                    package: '',
                    socialMedia: '',
                    paymentMethod: '',
                    paymentProof: null,
                    paymentProofName: '', // For storing the file name
                    availableTimes: ['09:00 AM', '10:00 AM', '11:00 AM', '01:00 PM', '02:00 PM', '03:00 PM']
                };
            },
            watch: {
                paymentMethod(newMethod) {
                    let accountInfo = '';

                    // Display the relevant account information based on payment method
                    if (newMethod === 'bdo') {
                        accountInfo = 'BDO\nGlyza Go - 011490040291';
                    } else if (newMethod === 'gcash') {
                        accountInfo = 'Gcash\nNI***E JO**E D. - 09667014837';
                    } else if (newMethod === 'maya') {
                        accountInfo = 'Maya\nNI***E JO**E D. - 09667014837';
                    }

                    if (accountInfo) {
                        Swal.fire({
                            title: 'Payment Information',
                            text: accountInfo,
                            icon: 'info',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            },
            methods: {
                onFileChange(event) {
                    this.paymentProof = event.target.files[0]; // Capture the selected file
                    console.log('Selected file:', this.paymentProof);
                },
                convertTo24Hour(time) {
                    const [timePart, period] = time.split(' ');
                    let [hour, minute] = timePart.split(':');

                    if (period === 'PM' && hour !== '12') {
                        hour = parseInt(hour, 10) + 12; // Convert PM hour to 24-hour format
                    } else if (period === 'AM' && hour === '12') {
                        hour = '00'; // Midnight case
                    }

                    return `${String(hour).padStart(2, '0')}:${minute}:00`; // Format to HH:MM:SS
                },
                submitBooking() {
                    // Check if the payment proof is attached
                    if (!this.paymentProof) {  
                        Swal.fire({
                            title: 'Error',
                            text: 'Please attach a proof of payment to proceed with the booking.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                        return; // Prevent form submission
                    }

                    // Continue with form submission if the file is attached
                    const formData = new FormData();
                    formData.append('firstName', this.firstName);
                    formData.append('surname', this.surname);
                    formData.append('email', this.email);
                    formData.append('phone', this.phone);
                    formData.append('date', this.date);
                    formData.append('time', this.convertTo24Hour(this.time));
                    formData.append('package', this.package);
                    formData.append('socialMedia', this.socialMedia);
                    formData.append('paymentMethod', this.paymentMethod);
                    formData.append('paymentProof', this.paymentProof);

                    // Check if the email is registered
                    axios.post('check_email.php', { email: this.email })
                        .then(response => {
                            if (response.data.isRegistered) {
                                // Proceed with booking
                                axios.post('book_process.php', formData)
                                    .then(response => {
                                        if (response.data.success) {
                                            Swal.fire({
                                                title: 'Success',
                                                text: response.data.message,
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                window.location.href = 'calendar.php';
                                            });
                                        } else {
                                            Swal.fire('Error', response.data.message, 'error');
                                        }
                                    })
                                    .catch(error => {
                                        Swal.fire('Error', 'There was an error processing your booking. Please try again.', 'error');
                                    });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'The email you entered is not registered. Please use a registered email to book.',
                                    icon: 'error',
                                    confirmButtonText: 'OK'
                                });
                            }
                        })
                        .catch(error => {
                            Swal.fire('Error', 'There was an error checking your email. Please try again later.', 'error');
                        });
                }
            }



        });
    </script>
</body>


<style scoped>
   @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');

    body {
        background-image: url('image/bg2.png');
        background-repeat: no-repeat;
        background-size: cover;
        background-position: center; 
        font-family: 'Poppins', sans-serif;
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .booking-container {
        display: flex;
        justify-content: center;
        opacity: 100;
        padding: 20px;
    }

    .booking-card {
        width: 80%; /* Increased width for landscape */
        max-width: 1200px; /* Set max width for large screens */
        background: #B9E5E8;
        padding: 2rem;
        border: 2px solid rgba(255, 255, 255, .5);
        border-radius: 20px;
        position: relative;
        height: auto;
        box-shadow: 0 0 30px rgba(0, 0, 0, .5);
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
    }

    .booking-header h1 {
        margin-bottom: 1rem;
        color: black;
        text-align: center;
        width: 100%; /* Ensure header is full-width */
    }

    .booking-card-form {
        display: flex;
        flex-wrap: wrap;
        gap: 1.5rem;
        width: 100%;
        justify-content: space-between;
    }

    .input {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 200px; /* Minimum width for input fields */
    }

    .input input, .input select {
        padding: 1rem;
        border: 2px solid #536493;
        border-radius: 10px;
        font-size: 1rem;
        font-family: 'Poppins', sans-serif;
    }

    .submit-btn-container {
        display: flex;
        justify-content: center;
        width: 100%;
    }

    .submit-btn {
        padding: 12px 24px;
        background-color: #4A628A;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        width: 50%;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .submit-btn:hover {
        background-color: #7AB2D3;
    }

    .input input[type="file"] {
        display: none; /* Hide the default file input */
    }

    .file-label {
        display: inline-block;
        padding: 1rem;
        background-color: #9EDF9C;
        color: black;
        border-radius: 10px;
        cursor: pointer;
        font-size: small;
        text-align: center;
        width: 20%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .file-label:hover {
        background-color: #62825D;
    }

    .file-label i {
        margin-right: 0.5rem;
    }

    .file-label:active {
        background-color: #2a4356;
    }

    /* Style adjustments for large screens */
    @media (min-width: 768px) {
        .booking-card {
            width: 60%; /* Adjust width for landscape on tablet */
        }

        .input input, .input select {
            font-size: 1rem;
        }
    }

    /* Ensure proper adjustments for smaller screens */
    @media (max-width: 767px) {
        .booking-card {
            width: 100%;
            padding: 1rem;
        }

        .booking-card-form {
            flex-direction: column;
        }

        .input {
            flex: none;
            width: 100%;
        }
    }

</style>
