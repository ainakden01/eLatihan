<!DOCTYPE HTML>
<html>
<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://phosphoricons.com/?q=%22user%22">
    <style type="text/css">
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-image: url('images/images_login.jpg'); 
            background-size: cover; /* Ensure the image covers the entire background */
            background-position: center;
            background-repeat: no-repeat;
        }
        .container {
            width: 350px;
            margin: 100px auto;
            background: rgba(255, 255, 255, 0.9); /* Slight transparency */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .container img {
            width: 150px;
            display: block;
            margin: 0 auto 10px;
        }
        .container p {
            text-align: center;
            font-size: 1.75em;
            font-weight: bold;
            margin-bottom: 1px;
        }
        .container h2 {
            text-align: center;
            font-size: 1em;
            margin-bottom: 20px;
        }
        .container form {
            display: flex;
            flex-direction: column;
        }
        .container label {
            margin-bottom: 5px;
        }
        .container input[type="email"],
        .container input[type="password"] {
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 3px;
            border: 1px solid #ccc;
        }
        .container input[type="submit"] {
            background-color: blue;
            color: #fff;
            border: none;
            padding: 10px;
            border-radius: 3px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .container input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .container a {
            text-decoration: none;
            color: blue;
            font-weight: bold;
        }
        #signup-link {
            font-size: 14px; 
        }
    </style>
    <script>
        function showAlert(message) {
            alert(message);
        }
    </script>
</head> 
<body>
    <div class="container">
        <img src="images/gov.png" alt="Government Logo">
        <p>e-Latihan Industri</p>
        <h2>(Undang-Undang)</h2>
        <form method="post" action="proc_login.php">
            <input type="email" id="email" name="email" autocomplete="off" required placeholder="Email">
            <input type="password" id="password" name="password" autocomplete="off" required placeholder="Kata Laluan">
            <input type="submit" value="Log Masuk">
        </form>
        <p id="signup-link">Belum mempunyai akaun? <a href="signup.php">Daftar</a></p>
    </div>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error')) {
            showAlert("Login failed. Invalid email or password.");
            setTimeout(() => {
                window.location.href = 'login.php';
            }, 2000);
        }
    </script>
</body>
</html>
