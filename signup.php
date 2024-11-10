<?php include('signup_process.php'); ?>



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
    <title>Sign Up</title>
    
</head>
<body>
    <div id="app">
        <div class="SignUp">
            <div class="signup-container">
                <div class="signup-card">
                    <div class="signup-header">
                        <h3>Sign Up</h3>
                    </div>
                    <form class="signup-card-form" @submit.prevent="signup">
                        <div class="input input-with-icon">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input v-model="fullName" type="text" name="FullName" placeholder="Full Name" required>
                        </div>
                        <div class="input input-with-icon">
                            <span class="form-item-icon material-symbols-rounded">mail</span>
                            <input v-model="email" type="email" name="Email" placeholder="Email Address" required>
                        </div>
                        <div class="input input-with-icon">
                            <span class="form-item-icon material-symbols-rounded">phone</span>
                            <input v-model="phone" type="tel" name="Phone" placeholder="Phone Number" required>
                        </div>
                        <div class="input input-with-icon">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input v-model="userName" type="text" name="UserName" placeholder="Username" required>
                        </div>
                        <div class="input input-with-icon">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input v-model="password" type="password" name="Password" id="signup-password" placeholder="Password" required>
                            <span class="toggle-password"></span>
                        </div>
                        <div class="input input-with-icon">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input v-model="confirmPassword" type="password" name="ConfirmPassword" id="signup-confirm-password" placeholder="Confirm Password" required>
                            <span class="toggle-password"></span>
                        </div>
                        
                        <button type="submit" name="signup">Sign Up</button>
                        <div class="login-link">
                            <p>Already have an account? <a href="login.php">Log In</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data() {
                return {
                    fullName: '',
                    email: '',
                    phone: '',
                    userName: '',
                    password: '',
                    confirmPassword: ''
                };
            },
            methods: {
                signup() {
                    // Check if passwords match
                    if (this.password !== this.confirmPassword) {
                        Swal.fire('Error', 'Passwords do not match!', 'error');
                        return;
                    }

                    // Prepare the data to send to the server
                    const formData = new FormData();
                    formData.append('FullName', this.fullName);
                    formData.append('Email', this.email);
                    formData.append('Phone', this.phone);
                    formData.append('Username', this.userName);
                    formData.append('Password', this.password);
                    formData.append('ConfirmPassword', this.confirmPassword);

                    // Send the form data to the server via axios
                    axios.post('signup.php', formData)
                        .then(response => {
                            Swal.fire('Success', 'Sign up completed successfully!', 'success');
                            // Optionally redirect to login page
                            window.location.href = 'login.php';
                        })
                        .catch(error => {
                            Swal.fire('Error', 'There was an error signing up. Please try again.', 'error');
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

    .signup-container {
        display: flex;
        justify-content: space-between;
        opacity: 100;
    }

    .signup-card {
        width: 450px;
        background: #B9E5E8;
        padding: 2rem;
        border: 2px solid rgba(255, 255, 255, .5);
        border-radius: 20px;
        position: relative;
        height: auto; /* Adjusted height */
        box-shadow: 0 0 30px rgba(0, 0, 0, .5);
    }

    .signup-header h3 {
        margin-top: -5px;
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: .5rem;
        color: black;
        text-align: center;
        
    }

    .signup-header h3 + div {
        font-size: calc(1rem * .8);
        opacity: .8;
        color: white;
    }

    .signup-card-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .signup-card-form .form-item {
        position: relative;
    }

    .signup-card-form .form-item .form-item-icon {
        position: absolute;
        top: .82rem;
        left: 1.4rem;
        font-size: 1.3rem;
        opacity: .4;
    }

    .signup-card-form input[type="text"],
    .signup-card-form input[type="email"],
    .signup-card-form input[type="tel"],
    .signup-card-form input[type="password"] {
        border: none;
        outline: none;
        background: white;
        padding: 1rem 1.5rem;
        padding-left: calc(1rem * 3.5);
        border-radius: 10px;
        width: 70%; /* Full width */
        transition: background .5s; 
        font-family: 'Poppins', sans-serif;  

    }

    .signup-card input:focus {
        background: white;
    }

    .signup-card-form button {
        background-color: #7AB2D3;
        color: white;
        padding: 1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: background .5s;
        width: 200px;
        margin: 0 auto;
    }

    .signup-card-form button:hover {
        background-color: #4A628A;
    }

    .signup-card-form .login-link {
        font-size: 14.5px;
        text-align: center;
        margin: 20px 0 15px;
        margin-top: -10px;
        font-family: 'Poppins', sans-serif;
    }

    .login-link p a {
        color: rgb(0, 180, 252);
        text-decoration: none;
        font-weight: 600;
        font-style: 'Poppins';
    }

    .login-link p a:hover {
        text-decoration: underline;
    }

    .toggle-password {
        position: relative;
        top: .82rem;
        right: 1.4rem;
        font-size: 1.3rem;
        opacity: 0.4;
        cursor: pointer;
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

    /* Loader styles (centered) */
    .loader {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        text-align: center; /* Center the text horizontally */
    }

    /* Show the overlay and loader when needed */
    .show-overlay {
        visibility: visible;
        opacity: 1;
    }
</style>
</html>
