<?php

    $Username = $_POST['Username'];
    $Password = $_POST['Password'];
    //No idea how to increment Userid

    // Probably something along the lines of
    // $Userid = $inData["Userid"];
    // $Userid = incrementer++;
    // we would need to store $incrementer somewhere

    $conn = new mysqli("poosddb.ckbkojoxqly0.us-east-1.rds.amazonraws.com", "poosdAdmin", "DontForgetThis321", "poosdDB");
	if ($conn->connect_error) 
	{
		returnWithError( $conn->connect_error );
	} 
	else
	{
        $test = "SELECT Username FROM User where Username='" . $Username . "'";
        $result = mysqli_query($conn, $test);

        if (mysqli_num_rows($result) > 0 ) 
        {
            $conn->close();
            returnWithError( "Username already exists" );
        }
        else
        {
            $hash = password_hash($Password, PASSWORD_DEFAULT);
            $timestamp = date("F j, Y \a\t g:ia");
            $sql = "INSERT INTO User (Username,Password,DateCreated,LastLogin) VALUES ('" . $Username . "','" . $hash . "', '" . $timestamp . "','" . $timestamp . "')";
        }
    }

	function sendResultInfoAsJson( $obj )
	{
		header('Content-type: application/json');
		echo $obj;
	}
	
	function returnWithError( $err )
	{
		$retValue = '{"error":"' . $err . '"}';
		sendResultInfoAsJson( $retValue );
	}