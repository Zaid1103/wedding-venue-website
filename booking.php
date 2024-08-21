<?php
// Database connection parameters
$servername = "sci-mysql";
$username = "coa123wuser";
$password = "grt64dkh!@2FD";
$dbname = "coa123wdb";

// Retrieve form data
$venuename = $_POST["venuename"];
$bookingDate = $_POST["bookingDate"];
$capacity = $_POST["capacity"];

// Create an array to hold the fetched data
$data = array();

// Create database connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Construct SQL query
$sql = "SELECT 
            '$capacity' AS user_capacity,
            v.name AS venue_name,
            v.capacity,
            v.weekend_price,
            v.weekday_price,
            c.grade AS catering_grade,
            c.cost AS catering_cost,
            (v.weekday_price + c.cost * '$capacity') AS total_weekday_cost,
            (v.weekend_price + c.cost * '$capacity') AS total_weekend_cost
        FROM 
        venue AS v
        JOIN 
        catering AS c ON v.venue_id = c.venue_id
        LEFT JOIN 
        venue_booking AS b ON v.venue_id = b.venue_id AND b.booking_date = '$bookingDate'
        WHERE 
        v.name = '$venuename'
        AND b.venue_id IS NULL
        AND v.capacity >= '$capacity';";

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