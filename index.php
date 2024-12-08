<?php

include 'db/connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Boshoes!</title>
    <link rel="stylesheet" href="style/index.css">
</head>
<body>
    
    <header class="header">

        <nav class="navbar">
            <a href="home.php" class="logo"><img src="img/logo.png" alt="Logo"></a>
        </nav>

    </header>

    <main class="main">
        <div class="container">
            <div class="content">
                <h1>WELCOME TO <span>BOSHOES!</span></h1>
                <p>Borrow the Quality of Shoes</p>
                <button><a href="auth/register.php">Get Started</a></button>
            </div>
        </div>
    </main>

</body>
</html>