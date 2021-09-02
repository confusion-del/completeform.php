<?php
session_start()
?>


<!doctype html>
<html lang="en">
<head>
    <title>Complete Form</title>
    <style type="text/css">
        .error {
            color: #FF0000;
        }
    </style>
</head>
<body>
<?php
//variables for error messages and users inputs set to empty values
$studentNameErr = $studentEmailErr = $studentWebErr = "";
$studentName = $studentEmail = $studentWeb = "";
//variables for image(multimedia) inouts
//$target_dir = "../uploadImages/"; //storage folder for attachment inputs
//$target_file = $target_dir . basename($_FILES["sPic"]["name"]); //simply the value name of the media
//selected by user
$uploadOk = 1; //comparing variable for if file is uploaded or not
//$imageFileTYpe = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//file extension for image selection

//collecting users data using validation concepts
//first checking has been clicked
if (isset($_POST["submit"])) {
    $target = "../uploadImages/" . basename($_FILES['sPic']['name']);
    //collecting multimedia data
    move_uploaded_file($_FILES['sPic']['tmp_name'], $target);
    if (move_uploaded_file($_FILES['sPic']['tmp_name'], $target)) {
        echo "<script>alert('Image has been moved')</script>";
    }
    #collect data
    //empty checks for the variable
    if (empty($_POST["sName"])) {
        #code
        $studentNameErr = "Student name is required";
    } else {
        $studentName = test_input($_POST["sName"]);
        //checking for white spaces and letters using REGEX pattern

        if (!preg_match("/^[a-zA-Z-' ]*$/", $studentName)) {
            $studentNameErr = "Only letters and white space allowed";
        }
    }
    //email
    if (empty($_POST["studentEmail"])) {
        #code
        $studentEmailErr = "Student Email is required";
    } else {
        $studentEmail = test_input($_POST["sEmail"]);
        //email is well formed
        if (!filter_var($studentEmail, FILTER_VALIDATE_EMAIL)) {
            $studentEmailErr = "Invalid email format";
        }
    }

    //web info
    if (empty($_POST["sWeb"])) {
        #code
        $studentWebErr = "Website cannot be empty";
    } else {
        $studentWeb = test_input($_POST["sWeb"]);
        //check if URL address syntax is valid (this regular
        // expression also allows dashes in the URL)
        if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $studentWeb)) {
            $studentWebErr = "Invalid URL";
        }

    }

}

//function to sanitize data
function test_input($data) {
    $data = trim($data); // trim removes extra whitespaces, tabs or newlines
    $data = stripslashes($data);// striplashes used to remove unecessary backlashes from input
    $data = htmlspecialchars($data);
    return $data;

}
?>
<h3>Student Registration</h3>
<form method="post" action="completeform.php" enctype="multipart/form-data">
    Student Name: <input type="text" name="sName" required="">
    <span class="error"><?php echo $studentNameErr?></span>
    Student Email: <input type="email" name="sEmail">
    <span class="error"><?php echo $studentEmailErr?></span>
    Student Webpage: <input type="text" name="sWeb">
    <span class="error"><?php echo $studentWebErr?></span>
    Student Profile Pic: <input type="file" name="sPic">
    <input type="submit" name="submit" value="Register Student">
</form>
<?php
echo "<h3>Inputs<h3>";
echo $studentName . "<br>";
echo $studentEmail . "<br>";
echo $studentWeb . "<br>";
//session variable
$_SESSION["studentName"] = $studentName;
$_SESSION["studentEmail"] = $studentEmail;
$_SESSION["studentWeb"] = $studentWeb;
?>
</body>
</html>
