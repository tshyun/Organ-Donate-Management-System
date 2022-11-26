

<html>
    <head>
        <title>CPSC 304 Group Project Team 68</title>
        <link href="style.css" rel="stylesheet" />
    </head>

    <body>
        <h1>Hello Administrator!</h1>
        <h1>What's the task for today?</h1>
        <br>
        <h2>Add a new patient to the waiting list (Insert)</h2>
        <form method="POST" action="projectTest.php">
            <!-- if you want another page to load after the button is clicked, you have to specify that page in the action parameter -->
            <input type="hidden" id="addtoWLRequest" name="addtoWLRequest">
            Name: <input type="text" name="patientName"> &nbsp &nbsp
            Organ Needed: <input type="text" name="neededOrgan"> <br /><br />
            Age: <input type="text" name="patientAge"> &nbsp &nbsp
            Blood Type: <input type="text" name="patientBloodType"> <br /><br />

            <input type="submit" value="Add Waiting Patient" name="addWLSubmit"></p>
        </form>



        <h2>Delete A Waiting Patient (Delete)</h2>
        <form method="POST" action="projectTest.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="deletePatientRequest" name="deletePatientRequest">
        Waiting Patient ID: <input type="text" name="deletePatientID"> <br /><br />

        <input type="submit" value="Delete Patient From Waiting List" name="deletePatientSubmit"></p>
        </form>



        <h2>Update Donor Information (Update)</h2>
        <form method="POST" action="projectTest.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="updateDonorRequest" name="updateDonorRequest">
        Donor phn: <input type="text" name="Donorphn"> <br /><br />
        Status: <input type="text" name="patienStatus"> <br /><br />

        <input type="submit" value="Update Donor Status" name="updateDonorSubmit"></p>
        </form>



        <h2>Match Suitable Waiting Patient</h2>
        <h5>Filter Waiting Patients By Needed Organ (Selection)</h5>
        <form method="GET" action="projectTest.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="filterByOrganRequest" name="filterByOrganRequest">
        Needed Organ: <input type="text" name="filterOrgan"> <br /><br />

        <input type="submit" value="Filter Waiting Patients" name="filterByOrganSubmit"></p>
        </form>



       <h2>View Status/Donated Organ/Blood Type of all donors (Projection)</h2>
       <form method="GET" action="projectTest.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="viewDonorRequest" name="viewDonorRequest">
        <label for="DonorRows"> Select the attributes of donors:</label>
        <select name="DonorRows" id="DonorRows">
            <option value="DonorOrgan">Donor Organ</option>
            <option value="donorStatus">Donor Status</option>
            <option value="bloodType">Donor Blood Type</option>
        </select><br /><br />

        <input type="submit" value="View" name="viewDonorAttribute"></p>
        </form>



        <h2>Find Donor Family Information (Join)</h2>
        <form method="GET" action="projectTest.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="joinDonorAndFamilyRequest" name="joinDonorAndFamilyRequest">
        Donor #phn: <input type="number" name="Donorphn"> <br /><br />
        <label for="donorFamilyAttribute"> Select Donar Family Attribute:</label>
        <select name="donorFamilyAttribute" id="donorFamilyAttribute">
            <option value="familyEmail">Family Email</option>
            <option value="familyName">Family Name</option>
            <option value="familyPhone">Family Phone</option>
            <option value="familyPhn">Family Phn</option>
        </select><br /><br />
        

        <input type="submit" value="Show Donor Family Information" name="showDonorFamilyInformationSubmit"></p >
        </form>



        <h2>Find some experienced hospitals</h2>
        <h5>at least two recipient operated in (Having)</h5>
        <form method="GET" action="projectTest.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="HavingRecipientRequest" name="HavingRecipientRequest">
        
        <input type="submit" value="Find hospitals" name="HavingRecipient"></p>
        </form>



        <h2>Find Donors Who Donate All Types of Organ (Division)</h2>
        <form method="GET" action="projectTest.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="findDonateAllRequest" name="findDonateAllRequest">

        <input type="submit" value="View" name="findDonateAllSubmit"></p>
        </form>



        <h2>Find the most shortage organ type</h2>
        <h5>Find the type of organ with least number of donors registed to donate (Nested aggregation)</h5>
        <form method="GET" action="projectTest.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="findLeastDonateRequest" name="findLeastDonateRequest">

        <input type="submit" value="View" name="findLeastDonateSubmit"></p>
        </form>



        <h2>Show the Max Waiting Time for Each Type of Organ (Group By)</h2>
        <form method="GET" action="projectTest.php">
        <!--refresh page when submitted-->
        <input type="hidden" id="showMaxWaitingTimeRequest" name="showMaxWaitingTimeRequest">
        <input type="submit" value="View" name="viewSubmit"></p >
        </form>



        
        


        <?php
		//this tells the system that it's no longer just parsing html; it's now parsing PHP

        $success = True; //keep track of errors so it redirects the page only if there are no errors
        $db_conn = NULL; // edit the login credentials in connectToDB()
        $show_debug_alert_messages = False; // set to True if you want alerts to show you which methods are being triggered (see how it is used in debugAlertMessage())

        function debugAlertMessage($message) {
            global $show_debug_alert_messages;

            if ($show_debug_alert_messages) {
                echo "<script type='text/javascript'>alert('" . $message . "');</script>";
            }
        }

        function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
            //echo "<br>running ".$cmdstr."<br>";
            global $db_conn, $success;

            $statement = OCIParse($db_conn, $cmdstr);
            //There are a set of comments at the end of the file that describe some of the OCI specific functions and how they work

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn); // For OCIParse errors pass the connection handle
                echo htmlentities($e['message']);
                $success = False;
            }

            $r = OCIExecute($statement, OCI_DEFAULT);
            if (!$r) {
                echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
                echo htmlentities($e['message']);
                $success = False;
            }

			return $statement;
		}

        function executeBoundSQL($cmdstr, $list) {
            /* Sometimes the same statement will be executed several times with different values for the variables involved in the query.
		In this case you don't need to create the statement several times. Bound variables cause a statement to only be
		parsed once and you can reuse the statement. This is also very useful in protecting against SQL injection.
		See the sample code below for how this function is used */

			global $db_conn, $success;
			$statement = OCIParse($db_conn, $cmdstr);

            if (!$statement) {
                echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
                $e = OCI_Error($db_conn);
                echo htmlentities($e['message']);
                $success = False;
            }

            foreach ($list as $tuple) {
                foreach ($tuple as $bind => $val) {
                    //echo $val;
                    //echo "<br>".$bind."<br>";
                    OCIBindByName($statement, $bind, $val);
                    unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
				}

                $r = OCIExecute($statement, OCI_DEFAULT);
                if (!$r) {
                    echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
                    $e = OCI_Error($statement); // For OCIExecute errors, pass the statementhandle
                    echo htmlentities($e['message']);
                    echo "<br>";
                    $success = False;
                }
            }
        }

        function printResult($result) { //prints results from a select statement
            echo "<br>Retrieved data from table demoTable:<br>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Name</th></tr>";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NAME"] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        function connectToDB() {
            global $db_conn;

            // Your username is ora_(CWL_ID) and the password is a(student number). For example,
			// ora_platypus is the username and a12345678 is the password.
            $db_conn = OCILogon("ora_abhong02", "a99385726", "dbhost.students.cs.ubc.ca:1522/stu");

            if ($db_conn) {
                debugAlertMessage("Database is Connected");
                return true;
            } else {
                debugAlertMessage("Cannot connect to Database");
                $e = OCI_Error(); // For OCILogon errors pass no handle
                echo htmlentities($e['message']);
                return false;
            }
        }

        function disconnectFromDB() {
            global $db_conn;

            debugAlertMessage("Disconnect from Database");
            OCILogoff($db_conn);
        }

        function printWaitingTrans() {
        global $db_conn;

        $result = executePlainSQL("SELECT * FROM WaitingTransplantation");

        echo "<br>";
        echo "WaitingTransplantation";
        echo "<table>";
        echo "<tr><th>ID</th><th>patientAge</th><th>patientBloodType</th><th>waitingTime</th><th>neededOrgan</th><th>name</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] .
            "</td></tr>"; //or just use "echo $row[0]"
        }

        echo "</table>";

        }
        function printDonor() {
            global $db_conn;

        $result = executePlainSQL("SELECT * FROM Donor");
        echo "<br>";
        echo "Donor";
        echo "<table>";
        echo "<tr><th>Phn</th><th>bloodType</th><th>Status</th><th>phoneNumber</th><th>Name</th><th>Age</th><th>Address</th></tr>";
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</td><td>" . $row[4] . "</td><td>" . $row[5] .
            "</td><td>" . $row[6] . "</td></tr>"; //or just use "echo $row[0]"
        }
        echo "</table>";

        }


        function handleInsertRequest() {
            global $db_conn;

            //Getting the values from user and insert data into the table
            $tuple = array (
                ":bind1" => $_POST['patientAge'],
                ":bind2" => $_POST['patientBloodType'],
                ":bind3" => $_POST['neededOrgan'],
                ":bind4" => $_POST['patientName']
            );
            $transplantationID = hexdec(uniqid());
            $waitingTime = 0;
            $alltuples = array (
                $tuple
            );

            executeBoundSQL("insert into WaitingTransplantation values ($transplantationID, :bind1, :bind2, $waitingTime, :bind3, :bind4)", $alltuples);
            printWaitingTrans();
            OCICommit($db_conn);
        }

        function handleUpdateRequest() {
            global $db_conn;

            $donor_phn = $_POST['Donorphn'];
            $donor_newstatus = $_POST['patienStatus'];
            $result = executePlainSQL("SELECT * FROM Donor WHERE donorPhn = '$donor_phn' ");
            if (oci_fetch_row($result)[0] != 0) {
                executePlainSQL("UPDATE Donor SET donorStatus = '$donor_newstatus' WHERE donorPhn = '$donor_phn'");
            } else {
                echo "Please enter a valid";
            }
            // print method needed for donor
            printDonor();
            OCICommit($db_conn);
        }

        function handleDeletePatientRequest() {
            global $db_conn;
            $patientID = $_POST['deletePatientID'];
            $result_1 = executePlainSQL("SELECT Count(*) FROM WaitingTransplantation WHERE transplantationID = '$patientID'");
            
            if (($row = oci_fetch_row($result_1))[0] != 0) {
                executePlainSQL("DELETE FROM WaitingTransplantation WHERE transplantationID = '$patientID'");
            } else {
                echo "Waiting Patient ID does not exist";
            }
    
            printWaitingTrans();
            OCICommit($db_conn);
        }


        function hanleProjectionRequest() {
            global $db_conn;

            $choice = $_GET['DonorRows'];
            if ($choice == 'DonorOrgan') {
                $result = executePlainSQL("SELECT organType From Donor, DonateOrgan WHERE Donor.donorPhn = DonateOrgan.donorPhn");
                echo "<table>";
                echo "<tr><th>organType</th></tr>";
            } else {
                $result = executePlainSQL("SELECT $choice, donorName From Donor");
                echo "<table>";
                echo "<tr><th>$choice</th><th>Donor Name</th></tr>";
            }
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
            
        }

        function handelHavingRequest() {
            global $db_conn;
            $result = executePlainSQL("SELECT Hospital.hospitalName From Hospital, IndividualRecipientOperation WHERE Hospital.hospital_id = IndividualRecipientOperation.hospital_id 
                                       GROUP BY  Hospital.hospitalName HAVING COUNT(IndividualRecipientOperation.recipientId) > 1");
            echo "<table>";
            echo "<tr><th>Name</th></tr>";
            // $result2 = executePlainSQL("SELECT * From IndividualRecipientOperation");
            // echo "$result2";

            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td></tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";

        }


        function handleFindDonateAllRequest() {
            global $db_conn;
    
            $result = executePlainSQL("SELECT Distinct D.donorPhn, D.donorName 
                                    FROM Donor D
                                    WHERE NOT EXISTS(
                                    (SELECT OTI.organType FROM OrganTypeInfo OTI)
                                    MINUS
                                    (SELECT DO.organType
                                    FROM DonateOrgan DO
                                    WHERE DO.donorPhn = D.donorPhn))");
                                
    
            echo "Division Query";
            echo "<table>";
            echo "<tr><th>Donor PHN</th><th>Donor Name</th></tr>";
    
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; 
            }
    
            echo "</table>";
        }


        function handleFindLeastDonateRequest() {
            global $db_conn;
    
            $result = executePlainSQL("SELECT organType, count(*) 
                                        FROM DonateOrgan 
                                        GROUP BY organType 
                                        HAVING count(*) <= all (SELECT count(*)
                                        FROM DonateOrgan D
                                        GROUP BY D.organType)");
    
            echo "Nested Aggregation With Group By";
            echo "<table>";
            echo "<tr><th>Organ Type</th><th>Number of Regiested Donor </th></tr>";
    
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; //or just use "echo $row[0]"
            }
    
            echo "</table>";
        }

        // Handle filter by organ request
        function handleFilterByOrganRequest() {
            global $db_conn;

            $neededOrgan = $_GET['filterOrgan'];
            $result = executePlainSQL("SELECT WT.transplantationID, WT.patientName, WT.patientBloodType, WT.neededOrgan, WT.waitingTime
            FROM WaitingTransplantation WT WHERE WT.neededOrgan = '$neededOrgan' ORDER BY WT.waitingTime DESC");

            echo "Selection Query";
            echo "<table>";
            echo "<tr><th>Patient ID</th><th>Patient Name</th><th>Blood Type</th><th>Needed Organ</th></tr>";
    
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
               echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td><td>" . $row[2] . "</td><td>" . $row[3] . "</tr>"; //or just use "echo $row[0]"
            }

            echo "</table>";
        }

        // Handle join patient and family request
        function handlejoinDonorAndFamilyRequest() {
            global $db_conn;

            $donarPhn = $_GET['Donorphn'];
            $attribute = $_GET['donorFamilyAttribute'];
            echo "Join Query For Donar Phn Is #$donarPhn";
            echo "<table>";
            
            if ($attribute == 'familyEmail') {
                $result = executePlainSQL("SELECT DonorFamilyContactPerson.email FROM Donor, Has, DonorFamilyContactPerson 
                WHERE Donor.donorPhn = '$donarPhn' AND Donor.donorPhn = Has.donorPhn AND Has.contactPhn = DonorFamilyContactPerson.contactPhn");
                echo "<tr><th>Family Contact Email</th></tr>";
            } else if ($attribute == 'familyName') {
                $result = executePlainSQL("SELECT DonorFamilyContactPerson.contactName FROM Donor, Has, DonorFamilyContactPerson 
                WHERE Donor.donorPhn = '$donarPhn' AND Donor.donorPhn = Has.donorPhn AND Has.contactPhn = DonorFamilyContactPerson.contactPhn");
                echo "<tr><th>Family Contact Name</th></tr>";
            } else if ($attribute == 'familyPhone') {
                $result = executePlainSQL("SELECT DonorFamilyContactPerson.contactPhone FROM Donor, Has, DonorFamilyContactPerson 
                WHERE Donor.donorPhn = '$donarPhn' AND Donor.donorPhn = Has.donorPhn AND Has.contactPhn = DonorFamilyContactPerson.contactPhn");
                echo "<tr><th>Family Contact Phone</th></tr>";
            } else if ($attribute == 'familyPhn') {
                $result = executePlainSQL("SELECT DonorFamilyContactPerson.contactPhn FROM Donor, Has, DonorFamilyContactPerson 
                WHERE Donor.donorPhn = '$donarPhn' AND Donor.donorPhn = Has.donorPhn AND Has.contactPhn = DonorFamilyContactPerson.contactPhn");
                echo "<tr><th>Family Contact Phn</th></tr>";
            }
            
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td></tr>"; 
            }
    
            echo "</table>";
        }

        // Handle show max waiting time request
        function handleShowMaxWaitingTimeRequest() {
            global $db_conn;

            $result = executePlainSQL("SELECT MAX(WaitingTransplantation.waitingTime), WaitingTransplantation.neededOrgan FROM WaitingTransplantation
            GROUP BY WaitingTransplantation.neededOrgan");

            echo "Group By Query";
            echo "<table>";
            echo "<tr><th>Max Waiting Time(in day)</th><th>Need Organ</th></tr>";
            
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
                echo "<tr><td>" . $row[0] . "</td><td>" . $row[1] . "</td></tr>"; 
            }

            echo "</table>";
        }




        // HANDLE ALL POST ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handlePOSTRequest() {
            if (connectToDB()) {
                if (array_key_exists('deletePatientRequest', $_POST)) {
                    handleDeletePatientRequest();
                } else if (array_key_exists('updateDonorRequest', $_POST)) {
                    handleUpdateRequest();
                } else if (array_key_exists('addtoWLRequest', $_POST)) {
                    handleInsertRequest();
                }

                disconnectFromDB();
            }
        }

        // HANDLE ALL GET ROUTES
	// A better coding practice is to have one method that reroutes your requests accordingly. It will make it easier to add/remove functionality.
        function handleGETRequest() {
            if (connectToDB()) {
                if (array_key_exists('findDonateAllRequest', $_GET)) {
                    handleFindDonateAllRequest();
                } else if (array_key_exists('viewDonorRequest', $_GET)) {
                    hanleProjectionRequest();
                } else if (array_key_exists('HavingRecipientRequest', $_GET)) {
                    handelHavingRequest();
                } else if (array_key_exists('findLeastDonateRequest', $_GET)) {
                    handleFindLeastDonateRequest();
                } else if (array_key_exists('filterByOrganRequest', $_GET)) {
                    handleFilterByOrganRequest();
                } else if (array_key_exists('joinDonorAndFamilyRequest', $_GET)) {
                    handlejoinDonorAndFamilyRequest();
                } else if (array_key_exists('showMaxWaitingTimeRequest', $_GET)) {
                    handleShowMaxWaitingTimeRequest();
                }

                disconnectFromDB();
            }
        }

		if (isset($_POST['addWLSubmit']) || isset($_POST['updateDonorSubmit']) || isset($_POST['deletePatientSubmit'])) {
            handlePOSTRequest();
        } else if (isset($_GET['findDonateAllSubmit']) || isset($_GET['viewDonorAttribute']) || isset($_GET['HavingRecipient'])
        || isset($_GET['findLeastDonateSubmit']) || isset($_GET['filterByOrganSubmit']) || isset($_GET['showDonorFamilyInformationSubmit']) || isset($_GET['viewSubmit'])) {
            handleGETRequest();
        }
		?>
	</body>
</html>
