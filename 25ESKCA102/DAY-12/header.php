<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MY WEBSITE</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-image: url("bg.jpg");
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
        }

        main {
            flex: 1;
        }

        header {
            background: linear-gradient(90deg, #ff7a59, #4f46e5);
            color: white;
            padding: 15px 0;
        }



        footer {
            background-color: #333;
            /* Dark background */
            color: #ecdfdf;
            /* White text */
            padding: 15px;
            text-align: center;
        }

        body {
            color: white;
        }
    </style>

</head>

<body>
    <header>
        <div class="container">
            <div class="d-flex flex-wrap justify-content-center align-items-center py-3 ">
                
                 <img src="logo.JPG" alt="logo" width="80">
                <nav class="navbar navbar-expand-lg navbar-dark bg-transparent py-3">
                    <ul class="nav">
                        <li class="nav-item"><a href="home.php" class="nav-link text-dark">Home</a></li>
                        <li class="nav-item"><a href="about.php" class="nav-link text-dark">About</a></li>
                        <li class="nav-item"><a href="contact.php" class="nav-link text-dark">Contact</a></li>
                    </ul>
                </nav>

                <button type="button" class="btn btn-translucent ms-auto"><a href="updateprofile.php"
                        class="text-decoration-none text-white">Update Profile</a></button>
                <button type="button" class="btn btn-translucent ms-auto"><a href="login.php"
                        class="text-decoration-none text-white">Login</a></button>
                <button type="button" class="btn btn-translucent ms-auto"><a href="update.php"
                        class="text-decoration-none text-white">Update Password</a></button>
            </div>

        </div>
    </header>
    <main>