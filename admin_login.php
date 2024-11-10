<?php include('adminLogin_process.php'); ?>


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

    
    <title>Admin Login</title>
</head>
<body>
    <div id="app">
        <div class="Login">
            <div class="login-container">
                <div class="login-card">
                    <div class="login-header">
                        <h3>Admin Dashboard</h3>
                    </div>
                    <form class="login-card-form" @submit.prevent="login">
                        <div class="input input-with-icon">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input v-model="username" type="text" name="username" placeholder="Username" required>
                        </div>
                        <div class="input input-with-icon">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input v-model="password" type="password" name="password" id="login-password" placeholder="Password" required>
                        </div>
                        <button type="submit">Login</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</body>

<script>
    new Vue({
        el: '#app',
        data() {
            return {
                username: '',
                password: ''
            };
        },
        methods: {
            async login() {
                try {
                    // Implement form validation here
                    if (this.username === '' || this.password === '') {
                        Swal.fire('Error', 'Please fill in both fields', 'error');
                        return;
                    }

                    // Log form data
                    console.log("Username:", this.username);
                    console.log("Password:", this.password);

                    const response = await axios.post('adminLogin_process.php', {
                        username: this.username,
                        password: this.password
                    }, {
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    console.log("Response:", response.data);

                    if (response.data.success) {
                        Swal.fire('Success', 'Logged in successfully!', 'success');
                        // Redirect to another page after successful login
                        window.location.href = 'adminDashboard.php';
                    } else {
                        Swal.fire('Error', response.data.message, 'error');
                    }
                } catch (error) {
                    Swal.fire('Error', 'Something went wrong, please try again', 'error');
                    console.error(error);
                }
            }

        }
    });
</script>





<style scoped>

    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@600&display=swap');

    body{
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

    .login-container {
        display: flex;
        justify-content: space-between;
        opacity: 100;
        
    }



    .login-card, .signup-card, .forgotpassword-card {
        width:450px;
        background: #B9E5E8;
        padding: 2rem;
        border: 2px solid rgba(255, 255, 255, .5);
        border-radius: 20px;
        position: relative;
        height: 10%;
        box-shadow: 0 0 30px rgba(0, 0, 0, .5);
    }


    .logo {
        margin-bottom: 0%;
    }

    .logo img {
        width:200px;
    }

    .logo,
    .login-header,
    .login-footer {
        text-align: center;
    }

    .login-container .card a {
        text-decoration: none;
        color: khaki;
    }

    .login-container .card a:hover {
        text-decoration: underline;
    }

    .forgotpassword-header,
    .login-header,
    .signup-header {
        margin-bottom: 1rem;
    }


    .login-card h1 {
        text-align: center;
        color: black;
    }

    .login-card h4 {
        text-align: center;
        color: white;
    }


    .login-header h3 {
        margin-top: -5px;
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: .5rem;
        color: black;
    }

    .login-header h3 + div {
        font-size: calc(1rem * .8);
        opacity: .8;
        color: white;
    }

    .login-card-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .login-card-form .form-item {
        position: relative;
    }

    .login-card-form .form-item .form-item-icon {
        position: absolute;
        top: .82rem;
        left: 1.4rem;
        font-size: 1.3rem;
        opacity: .4;
    }


    .login-footer {
        margin-top: 1.5rem;
        font-size: calc(1rem * .8);
    }

    .login-card-form input[type="text"],
    .login-card-form input[type="username"],
    .login-card-form input[type="password"] {
        border: none;
        outline: none;
        background: white;
        padding: 1rem 1.5rem;
        padding-left: calc(1rem * 3.5);
        border-radius: 10px;
        width: 70%;
        transition: background .5s;   
        font-family: 'Poppins', sans-serif;
        font-weight: bold; 
    }

    .login-card input:focus {
        background: white;
    }

    .login-card-form button {
        background-color: #7AB2D3;
        color: white;
        padding: 1rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        transition: background .5s;
        width: 200px;
        margin: 0 auto;
        
    }

    .login-card-form button:hover {
        background-color: #4A628A;
    }


    .login-card-form .remember-forgot{
        display: flex;
        justify-content: space-between;
        font-size: 14.5px;
        margin: -14px 0 5px;
    }
    .remember-forgot label input{
        accent-color: #fff;
        margin-right: 3px;

    }
    .remember-forgot a{
        color: rgb(0, 180, 252);
        text-decoration: none;

    }
    .remember-forgot a:hover{
        text-decoration: underline;
    }

    .login-card-form .register-link{
        font-size: 14.5px;
        text-align: center;
        margin: 20px 0 15px;
        margin-top: -5px;

    }

    .register-link p a{
        color: rgb(0, 180, 252);
        text-decoration: none;
        font-weight: 600;
    }
    .register-link p a:hover{
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
