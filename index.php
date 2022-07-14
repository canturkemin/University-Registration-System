<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- our login page -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <title>Login</title>
    <style>
        /* some styling attributes */
        body {
            background-color: rgb(255, 255, 255);
            margin: 20px;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        #top {
            /* our top division styling */
            color: #FFFFFF;
            padding: 15px;
            margin-left: 350px;
            margin-right: 350px;
            border-radius: 8px;
        }

        .wrapper {
            position: relative;
        }

        #bottom {
            /* our bottom division styling */
            border: 1px dotted black;
            background-color: rgb(49, 52, 61);
            text-align: center;
            position: fixed;
            left: 350px;
            right: 350px;

            bottom: 20px;
            border-radius: 8px;
        }



        #main {
            margin: 100px 800px;
        }

        #main a {
            color: blue;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <?php
    $message = "";  // creating dynamic message variable to put in it different messages  
    $db = new mysqli("127.0.0.1", "root", "", "eminuni"); // creating mysqli object and connecting to out database
    if (isset($_POST["submit"])) {  //getting login form information via post method
        $uname = $_POST["username"];
        $upass = $_POST["upass"];
        $result = $db->query("SELECT * FROM users WHERE username='$uname' AND upassword='$upass'"); //checking if there is such username password combination
        if ($result->num_rows == 0) { //if there is no such username password combination letting user know that
            $message = "Username or password is wrong!";
        } else { //if there is such username password combination 
            $_SESSION["username"] = $uname;
            $row = $result->fetch_row();
            $userType = $row[6];
            $_SESSION["utype"] = $row[6]; //getting type of user who will log in and store user type in session variable
            $statusofuser = $row[7]; // getting statu of user to if user is deactivated, user can not log in
            if ($statusofuser == "active") { //if our users status is active lets look user type
                if ($userType == "student") { //if user is student sending him to student page
                    header("Location: student/index.php");
                } else if ($userType == "professor") { //if user is professor sending him to professor page
                    header("Location: professor/index.php");
                } else if ($userType == "admin") { //if user is admin sending him to admin page
                    header("Location: administrator/index.php");
                }
            } else {
                $message = "Your account is deactivated. Please contact the Administration Office!"; //if our users status is deactive let him/her know
            }
        }
    }
    ?>
    <div id="top" class="text-center bg-dark">
        <h1>University Registration System</h1>
    </div>
    </div>
    <div class="card text-center border-dark w-25 h-25 mx-auto" style="top: 200px; border-radius: 8px; ">
        <div class="card-header bg-dark text-white">
            Login
        </div>
        <div class="card-body">
            <form action="index.php" method="post">
                <div class="form-group text-left ">
                    <label for="uname">Username</label>
                    <input type="text" class="form-control" id="uname" name="username" aria-describedby="inform" placeholder="Enter username" required>
                    <small id="inform" class="form-text text-muted">Usernames are unique to every user.</small>
                </div>
                <div class="form-group text-left">
                    <label for="InputPassword1">Password</label>
                    <input type="password" class="form-control" id="InputPassword1" name="upass" placeholder="Password" required>
                </div>
                <div class="form-check mb-3">
                    <input type="checkbox" class="form-check-input" id="Check1">
                    <label class="form-check-label ml-2" for="Check1">Check me out</label>
                </div>
                <button type="submit" name="submit" value="LOGIN" class="btn btn-dark">Submit</button>
                <p><?php echo $message; ?></p><!-- showing messages to user in dynamic way -->
            </form>
        </div>
    </div>

    <div id="bottom">
        <p class="text-white pt-3">University</p>
    </div>
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>

</html>