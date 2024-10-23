<!DOCTYPE HTML>
<html>
<head>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style type="text/css">
        body {
            margin: 0px;
            padding: 0px;
            font-family: sans-serif;
            font-size: .9em;
            background-image: url('images/images_login.jpg'); 
            background-size: cover; 
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh; /* Ensure body covers the full viewport height */
            overflow: hidden; /* Prevent scrolling */
        }
        img {
            width: 150px;
            display: block;
            margin-left: auto;
            margin-right: auto;
        }
        div {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            -moz-transform: translate(-50%, -50%);
            -webkit-transform: translate(-50%, -50%);
            position: absolute;
            width: 350px;
            background: #fff;
            padding: 10px 20px;
            border-radius: 2px;
            box-shadow: 0px 0px 10px #aaa;
            box-sizing: border-box;
            min-height: 400px; /* Set a minimum height */
        }
        input {
            display: inline-block;
            border: none;
            width: 100%;
            border-radius: 2px;
            margin: 5px 0px;
            padding: 7px;
            box-sizing: border-box;
            box-shadow: 0px 0px 2px #ccc;
        }
        #submit {
            border: none;
            background-color: blue;
            color: white;
            font-size: 1em;
            box-shadow: 0px 0px 3px #777;
            padding: 10px 0px;
        }
        span {
            color: red;
            font-size: 0.75em;
        }
        p {
            text-align: center;
            font-size: 1.75em;
        }
        a {
            text-decoration: none;
            color: blue;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div>
        <form method="post" action="proc_signup.php">
            <img src="images/gov.png" class="center">
            <p><b>Pendaftaran Akaun</b></p>
            <label for="college_uni">Institusi:</label>
            <input type="text" id="college_uni" name="college_uni" required autocomplete="off">
            <br>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required autocomplete="off">
            <br>
            <label for="nama_pegawai">Nama Pegawai:</label>
            <input type="text" id="nama_pegawai" name="nama_pegawai" required autocomplete="off">
            <br>
            <label for="no_phone">Nombor Telefon:</label>
            <input type="tel" id="no_phone" name="no_phone" required autocomplete="off">
            <br>
            <label for="password">Kata Laluan:</label>
            <input type="password" id="password" name="password" required autocomplete="off">
            <br><br>
            <input type="submit" id="submit" value="Daftar">
            <br><br>
        </form>
        Sudah mempunyai akaun? <a href="login.php">Log Masuk</a>.<br><br>
    </div>
</body>
</html>
