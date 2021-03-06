<?php
    // load config file
    require_once("../config.php");

    // setup database connection
    require_once(BACKEND_PATH . "/db.php");
    $conn = connectDatabase($db);

    // get POST request data
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $addressL1 = $_POST['addressL1'];
    $addressL2 = $_POST['addressL2'];
    $city = $_POST['city'];
    $country = $_POST['country'];

    // Validate data
    $isValid = true;
    if (!$firstName || !$lastName) $isValid = false;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $isValid = false;
    if (!$password || !$password2 || $password != $password2) $isValid = false;
    if (!$addressL1 || !$addressL2 || !$city || !$country) $isValid = false;

    if ($isValid) 
    {
        // Check whether email exists in the database
        $sqlCheckUser = "SELECT DISTINCT * FROM Users WHERE email='$email'";
        $queryResult = queryDatabase($conn, $sqlCheckUser);

        if (mysqli_num_rows($queryResult))
        {
            echo "exists";
        }
        else
        {
            // add user data to the database
            $sqlCreateUser = "INSERT INTO Users(firstName, lastName, email, passwrd, Address_Line1, Address_Line2, City, Country)
            VALUES('$firstName', '$lastName', '$email', '$password', '$addressL1', '$addressL2', '$city', '$country')";

            if (queryDatabase($conn, $sqlCreateUser)) 
            {
                echo "okay";
            }
            else
            {
                echo "error";
            }                       
        }
    }
    else
    {
        echo "invalid";
    }
?>