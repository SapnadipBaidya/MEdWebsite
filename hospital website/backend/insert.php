<?php
if (isset($_POST['submit'])) {
    if (
        isset($_POST['name']) &&
        isset($_POST['number'])&&
        isset($_POST['email']) &&
        isset($_POST['doa'])
        ){
        
        $name = $_POST['name'];
        $number = $_POST['number'];
        $email = $_POST['email'];
        $doa = $_POST['doa'];
        $host = "localhost";
        $dbUsername = "root";
        $dbPassword = "";
        $dbName = "nationalhealthcare";
        $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
        if ($conn->connect_error) {
            die('Could not connect to the database.');
        }
        else {
            $Select = "SELECT email FROM appointment WHERE email = ? LIMIT 1";
            $Insert = "INSERT INTO register(name, number, email,doa) values(?, ?, ?, ?)";
            $stmt = $conn->prepare($Select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->bind_result($resultEmail);
            $stmt->store_result();
            $stmt->fetch();
            $rnum = $stmt->num_rows;
            if ($rnum == 0) {
                $stmt->close();
                $stmt = $conn->prepare($Insert);
                $stmt->bind_param("ssssii",$name, $number, $email, $doa);
                if ($stmt->execute()) {
                    echo "New record inserted sucessfully.";
                }
                else {
                    echo $stmt->error;
                }
            }
            else {
                echo "Someone already registers using this email.";
            }
            $stmt->close();
            $conn->close();
        }
    }
    else {
        echo "All field are required.";
        die();
    }
}
else {
    echo "Submit button is not set";
}
?>