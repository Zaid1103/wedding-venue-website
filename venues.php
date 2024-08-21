<?php
    // Database connection parameters
    $servername = "sci-mysql";
    $username = "coa123wuser";
    $password = "grt64dkh!@2FD";
    $dbname = "coa123wdb";

    // Retrieve form data
    $venue = $_POST["venuename"];
    $minPrice = $_POST["minPrice"];
    $maxPrice = $_POST["maxPrice"];
    $license = $_POST["license"];
    $minScore = $_POST["minScore"];
    $capacity = $_POST["capacity"];

    // Create an array to hold the fetched data
    $data = array();

    // Create database connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Construct the SQL query based on form inputs
    $sql = "SELECT v.*, AVG(r.score) AS average_score
            FROM venue v
            LEFT JOIN venue_review_score r ON v.venue_id = r.venue_id
            WHERE 1=1";

    if (!empty($venue)) {
        $sql .= " AND v.name = '$venue'";
    }
    if (!empty($minPrice)) {
        $sql .= " AND (v.weekend_price >= '$minPrice' OR v.weekday_price >= '$minPrice')";
    }
    if (!empty($maxPrice)) {
        $sql .= " AND (v.weekend_price <= '$maxPrice' OR v.weekday_price <= '$maxPrice')";
    }
    if (!empty($license)) {
        $licensed = ($license == 'licensed') ? 1 : 0;
        $sql .= " AND v.licensed = '$licensed'";
    }
    if (!empty($capacity)) {
        $sql .= " AND v.capacity >= '$capacity'";
    }

    // Group by venue columns to calculate average review score
    $sql .= " GROUP BY v.venue_id";

    // Filter by minimum score using HAVING clause
    if (!empty($minScore)) {
        $sql .= " HAVING AVG(r.score) >= '$minScore'";
    }

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
