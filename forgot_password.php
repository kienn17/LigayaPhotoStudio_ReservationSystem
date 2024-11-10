<?php
include('db.php');
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

    <title>Reset Password Process</title>
</head>
<body>
    <div id="app">
        <div class="forgot-password">
            <div class="forgotpassword-container">
                <div class="forgotpassword-card">
                    <div class="forgotpassword-header">
                        <h3 v-if="step === 1">Enter Your Email and Username</h3>
                        <h3 v-else-if="step === 2">Reset Your Password</h3>
                    </div>
                    <form class="forgotpassword-card-form" @submit.prevent="handleSubmit">
                        <!-- Step 1: Enter Email and Username -->
                        <div v-if="step === 1">
                            <div class="input input-with-icon">
                                <span class="form-item-icon material-symbols-rounded">email</span>
                                <input type="email" v-model="email" required placeholder="Enter your email" />
                            </div>
                            <br>
                            <div class="input input-with-icon">
                                <span class="form-item-icon material-symbols-rounded">person</span>
                                <input type="text" v-model="username" required placeholder="Enter your username" />
                            </div>
                            <br>
                            <button type="submit">Submit</button>
                        </div>
                        
                        <!-- Step 2: Enter New Password -->
                        <div v-if="step === 2">
                            <div class="input input-with-icon">
                                <span class="form-item-icon material-symbols-rounded">lock</span>
                                <input v-model="password" type="password" placeholder="New Password" required>
                            </div>
                            <br>
                            <div class="input input-with-icon">
                                <span class="form-item-icon material-symbols-rounded">lock</span>
                                <input v-model="confirmPassword" type="password" placeholder="Confirm Password" required>
                            </div>
                            <br>
                            <button type="submit">Reset Password</button>
                        </div>

                        <!-- Back to login -->
                        <div class="back-to-login" v-if="step === 1 || step === 2">
                            <p>Remembered your password? <a href="login.php">Log In</a></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                step: 1,
                email: '',
                username: '',
                password: '',
                confirmPassword: ''
            },
            methods: {
                validateUser() {
                    axios.post('reset_password_process.php', { email: this.email, username: this.username })
                        .then(response => {
                            if (response.data.success) {
                                this.step = 2; // Move to the next step
                                Swal.fire('Success!', response.data.message, 'success');
                            } else {
                                Swal.fire('Error!', response.data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire('Error!', 'An error occurred while validating user.', 'error');
                        });
                },
                resetPassword() {
                    if (this.password !== this.confirmPassword) {
                        Swal.fire('Error!', 'Passwords do not match.', 'error');
                        return;
                    }

                    axios.post('reset_password_process.php', { email: this.email, password: this.password })
                        .then(response => {
                            if (response.data.success) {
                                Swal.fire('Success!', response.data.message, 'success').then(() => {
                                    window.location.href = 'login.php'; // Redirect to login after successful reset
                                });
                            } else {
                                Swal.fire('Error!', response.data.message, 'error');
                            }
                        })
                        .catch(error => {
                            console.error(error);
                            Swal.fire('Error!', 'An error occurred while resetting your password.', 'error');
                        });
                },
                handleSubmit() {
                    if (this.step === 1) {
                        this.validateUser(); // Call validateUser
                    } else if (this.step === 2) {
                        this.resetPassword(); // Call resetPassword
                    }
                }
            }
        });
    </script>

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

        .forgotpassword-container {
            display: flex;
            justify-content: space-between;
        }

        .forgotpassword-card {
            width: 450px;
            background: #B9E5E8;
            padding: 2rem;
            border: 2px solid rgba(255, 255, 255, .5);
            border-radius: 20px;
            box-shadow: 0 0 30px rgba(0, 0, 0, .5);
        }

        .forgotpassword-header h3 {
            font-size: 2rem;
            font-weight: 500;
            color: black;
            text-align: center;
            margin-bottom: 1rem;
        }

        .forgotpassword-card-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .forgotpassword-card-form .input-with-icon {
            position: relative;
            display: flex;
            align-items: center;
        }

        .forgotpassword-card-form .input-with-icon .form-item-icon {
            font-size: 1.3rem;
            opacity: .8;
            margin-right: 0.8rem; /* Adjust space between icon and input */
            color: black;
            font-weight: bold;
        }

        .forgotpassword-card-form input {
            border: none;
            outline: none;
            background: white;
            padding: 1rem 1.5rem;
            padding-left: 1.5rem; /* Adjusted padding to make room for the icon */
            border-radius: 10px;
            width: 70%;
            transition: background .5s;
        }


        .forgotpassword-card-form input:focus {
            background: white;
        }

        .forgotpassword-card-form button {
            display: block;
            margin: 0 auto;
            background-color: #7AB2D3;
            color: white;
            padding: 1rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            transition: background .5s;
            width: 200px;
            margin-top: 20px;
        }

        .forgotpassword-card-form button:hover {
            background-color: #4A628A;
        }

        .back-to-login {
            text-align: center;
            margin-top: 5px;
        }

        .back-to-login p a {
            color: rgb(0, 180, 252);
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</body>
</html>
