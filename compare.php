<?php
// Database connection parameters
$servername = "sci-mysql";
$username = "coa123wuser";
$password = "grt64dkh!@2FD";
$dbname = "coa123wdb";

// Retrieve form data
$venuename1 = $_POST["venuename1"];
$venuename2 = $_POST["venuename2"];

// Create an array to hold the fetched data
$data = array();

// Create database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Construct SQL query
$sql = "SELECT v.name AS venue_name,
            v.capacity,
            MAX(v.weekend_price) AS max_weekend_price,
            MAX(v.weekday_price) AS max_weekday_price,
            MAX(v.licensed) AS max_licensed,
            c.grade AS catering_grade,
            AVG(c.cost) AS avg_catering_price,
            AVG(s.score) AS average_review_score
        FROM venue v
        LEFT JOIN catering c ON v.venue_id = c.venue_id
        LEFT JOIN venue_review_score s ON v.venue_id = s.venue_id
        WHERE v.name IN ( '$venuename1', '$venuename2' )
        GROUP BY v.name, v.capacity, c.grade;";

// Execute the SQL query
$result = mysqli_query($conn, $sql);

// Fetch the data and store it in the array
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Close the database connection
mysqli_close($conn);

// Return the data as JSON
echo json_encode($data);
?>
