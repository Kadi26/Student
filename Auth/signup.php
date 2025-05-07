<?php

include '../Database/db.php';

if(isset($_POST['submit'])){

    $name = $_POST['name'];
    $email = $_POST['email'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT); // Hash the password

    // id, name, email, password, created_at
    $sql ="INSERT INTO users(name, email, password) VALUES('$name','$email','$pass')";

    $result = mysqli_query($conn, $sql);

    if($result){
        echo"<script>alert('User Registered Successfully!')</script>";
    }else{
        echo"<script>alert('There was an error kindly try again')</script>";
    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
    <style>
        /* Light Mode Styles (Default) */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("../assets/img/back2.jpg"); /* Path to the Kenya logo */
            background-size: cover; /* Ensures the logo covers the entire background */
            background-position: center; /* Centers the logo */
            background-repeat: no-repeat; /* Prevents the logo from repeating */
            height: 100vh; /* Full viewport height */
            color: #333;
            transition: background-color 0.3s, color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        .container {
            max-width: 400px;
            margin: auto;
            background:rgba(255, 255, 255, 0.9); /* Slightly transparent white background */
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, color 0.3s;
        }

        h1 {
            text-align: center;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input {
            width: 95%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4cae4c;
        }

        .mode-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edu track signup </h1>
        <form action="signup.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="id-number">ID Number:</label>
            <input type="text" id="id-number" name="id" required>

            <label for="address">Email Address:</label>
            <input type="text" id="address" name="email" required>

            <label for="password">Create Password:</label>
            <input type="password" id="password" name="pass" required>

            <label for="confirm-password">Confirm Password:</label>
            <input type="password" id="confirm-password" name="confirm" required>

            <button type="submit" name="submit">Sign In</button>
        </form>
    </div>
</body>
</html>