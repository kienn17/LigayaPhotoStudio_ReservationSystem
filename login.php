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

    <title>Login</title>
</head>
<body>
    <div id="app">
        <div class="Login">
            <div class="login-container">
                <div class="login-card">
                    <div class="login-header">
                        <h3>Log In</h3>
                    </div>
                    <form class="login-card-form" @submit.prevent="login">
                        <div class="input input-with-icon">
                            <span class="form-item-icon material-symbols-rounded">person</span>
                            <input v-model="email" type="text" name="email" placeholder="Email" required>
                        </div>
                        <div class="input input-with-icon">
                            <span class="form-item-icon material-symbols-rounded">lock</span>
                            <input v-model="password" type="password" name="password" id="login-password" placeholder="Password" required>
                        </div>
                        <div class="remember-forgot">
                            <a href="forgot_password.php" class="forgot-password-link">Forgot Password</a>
                        </div>
                        <button type="submit">Login</button>
                        <div class="register-link">
                            <p class="no-account-text">Don't have an account?</p>
                            <a href="signup.php" class="register-link-text">Register</a>
                        </div>
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
                email: '',
                password: ''
            };
        },
        methods: {
            async login() {
                try {
                    // Implement form validation here
                    if (this.email === '' || this.password === '') {
                        Swal.fire('Error', 'Please fill in both fields', 'error');
                        return;
                    }

                    // Log form data
                    console.log("Email:", this.email);
                    console.log("Password:", this.password);

                    const response = await axios.post('login_process.php', {
                        email: this.email,
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
                        window.location.href = 'calendar.php';
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

    .login-card {
        width: 450px;
        background: #B9E5E8;
        padding: 2rem;
        border: 2px solid rgba(255, 255, 255, .5);
        border-radius: 20px;
        position: relative;
        height: 10%;
        box-shadow: 0 0 30px rgba(0, 0, 0, .5);
    }

    .login-header {
        text-align: center;
    }

    .login-header h3 {
        margin-top: -5px;
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: .5rem;
        color: black;
    }

    .login-card-form {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .login-card-form input[type="text"],
    .login-card-form input[type="email"],
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
        margin-top: 10px;
    }

    .remember-forgot a {
        color: rgb(0, 180, 252);
        text-decoration: none;
    }

    .remember-forgot a:hover {
        text-decoration: none; /* No underline */
    }

    .register-link {
        font-size: 14.5px;
        text-align: center;
        margin-top: 20px;
        display: flex;
        justify-content: center;
        align-items: center;  /* Align items vertically */
        gap: 5px;  /* Add space between the elements */
    }

    .register-link p.no-account-text {
        color: black;
        margin: 0; /* Ensure no extra margins */
    }

    .register-link .register-link-text {
        color: rgb(0, 180, 252);
        font-weight: 600;
        text-decoration: none;
    }

    .register-link .register-link-text:hover {
        text-decoration: underline;
    }

    /* Styling for the Forgot Password link */
    .forgot-password-link {
        color: rgb(0, 180, 252);
        text-decoration: none;
    }

    .forgot-password-link:hover {
        text-decoration: none; /* Remove underline */
    }
</style>
</html>
