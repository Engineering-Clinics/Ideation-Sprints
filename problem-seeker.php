<!-- problem-seeker.php -->

<?php
// Assuming you have a MySQL database connection
$servername = "your_servername";
$username = "your_username";
$password = "your_password";
$dbname = "your_database_name";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch problems from the database
$sql = "SELECT * FROM problems";
$result = $conn->query($sql);

// Store problems data in an array
$problemsData = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $problemsData[] = array(
            'statement' => $row['statement'],
            'numOfPeople' => $row['num_of_people']
        );
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problem Seeker</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="header">
        <div class="credentials">
            <span>Welcome, User123</span>
        </div>
        <div class="help">Help</div>
        <button class="logout">Logout</button>
    </div>
    <div class="container">
        <h1>Problem Seeker</h1>
        <div class="problem-list" id="problemList">
            <!-- Problems will be dynamically added here using JavaScript -->
        </div>

        <script>
            // Inline PHP to pass problems data to JavaScript
            var problemsData = <?php echo json_encode($problemsData); ?>;

            // Function to dynamically add problems to the HTML
            function renderProblems(problemsData) {
                const problemList = document.getElementById('problemList');

                // Create a table element
                const table = document.createElement('table');
                table.classList.add('problem-table');

                // Create table header
                const thead = document.createElement('thead');
                const headerRow = document.createElement('tr');
                const headers = ['Problem Statement', 'No. of People Working'];

                headers.forEach(headerText => {
                    const th = document.createElement('th');
                    th.textContent = headerText;
                    headerRow.appendChild(th);
                });

                thead.appendChild(headerRow);
                table.appendChild(thead);

                // Create table body
                const tbody = document.createElement('tbody');

                problemsData.forEach(problem => {
                    const row = document.createElement('tr');

                    const statementCell = document.createElement('td');
                    statementCell.textContent = problem.statement;

                    const peopleCell = document.createElement('td');
                    peopleCell.textContent = problem.numOfPeople;

                    row.appendChild(statementCell);
                    row.appendChild(peopleCell);

                    tbody.appendChild(row);
                });

                table.appendChild(tbody);
                problemList.appendChild(table);
            }

            // Call the function to render problems
            renderProblems(problemsData);
        </script>
    </div>
</body>
</html>
