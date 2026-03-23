<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IOE Faculty Login</title>
    <style>
        <?php include('css/register.css'); ?>
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <div class="viewport-wrapper">
        <div class="login-card">
            <div class="campus-logo">
                <div class="logo-text">IOE</div>
            </div>
            
            <h2 class="title">Register Page</h2>
            <p class="subtitle">Please enter your credentials to register</p>

            <div class="form-container">
                <div class="input-block">
                    <label for="n">Name</label>
                    <input type="text" id="n" autocomplete="off" placeholder="Enter Full Name">
                </div>
                <div class="input-block">
                    <label for="un">Username</label>
                    <input type="text" id="un" autocomplete="off" placeholder="Enter Username">
                </div>
                <div class="input-block">
                    <label for="email">College Mail Id</label>
                    <input type="email" id="email" placeholder="balendra@ioepc.edu.np">
                </div>

                <div class="input-block">
                    <label for="pw">Password</label>
                    <input type="password" id="pw" placeholder="Enter Password">
                </div>
                <select id="department">
                    <option value="">Select Department</option>
                    <option value="BCT">Computer</option>
                    <option value="BCE">Civil</option>
                    <option value="BME">Mechanical</option>
                    <option value="BEE">Electrical</option>
                    <option value="BAG">Agriculture</option>
                </select>
                    <button id="register" class="registerButton">Register</button>
                    <button id="redirect" class="redirect">Go to Login Page</button>


                
            </div>

            <div class="footer-note">
                © 2026 Engineering Campus Attendance
            </div>
        </div>
    </div>

    <script src="js/jquery.js"></script>
    <script>
        <?php include('js/register.js'); ?>
    </script>
</body>
</html>
</body>
</html>