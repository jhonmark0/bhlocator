<!DOCTYPE html>
<html>
<head>
    <title>Edit Boarding House</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <style>
    footer {
        position: relative;
        background-color: #333;
    }
  </style>
</head>
<body>
    <header class="sticky">
        <div class="logo">
            <h1>Owner Dashboard</h1>
        </div>
        <nav>
            <ul>
                <li><a href="bhowner_panel.php">Dashboard</a></li>
                <li><a href="boardinghouses.php">Boarding Houses</a></li>
                <li class="dropdown">
                    <a href="#" class="dropbtn">Menu</a>
                    <div class="dropdown-content">
                        <a href="profile.php">Profile</a>
                        <a href="about.html">About</a>
                        <a href="../index.html">Logout</a>
                    </div>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <div class="dashboard">
            <section class="dashboard-content">
                <h2>Edit Boarding House</h2>
                <!-- Add a form to edit the details of the selected boarding house -->
                <form action="update-boardinghouse.php" method="POST">
                    <label for="name">Boarding House Name:</label>
                    <input type="text" id="name" name="name" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>

                    <button type="submit">Update Boarding House</button>
                </form>
            </section>
        </div>
    </main>
    <footer>
            <div id="footer">
                <div id="main-footer-5">
                    <h3>BHlocator</h3>
                    <p>Copyright 2023 BHlocator | All rights reserved.</p>
                </div>
            </div>
    </footer>
</body>
</html>
