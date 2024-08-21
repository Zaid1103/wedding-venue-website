<?php 
    // Database connection parameters
    $servername = "sci-mysql";
    $username = "coa123wuser";
    $password = "grt64dkh!@2FD";
    $dbname = "coa123wdb";

    // Retrieve form data
    $cateringgrade = $_POST["cateringgrade"];
    $venuename = $_POST["venuename"];
    $minPrice = $_POST["minPrice"];
    $maxPrice = $_POST["maxPrice"];

    // Create an array to hold the fetched data
    $data = array();

    // Create database connection
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Construct SQL query
    $sql = "SELECT v.name AS venue_name, c.grade, c.cost, AVG(r.score) AS average_review_score
            FROM catering c
            JOIN venue v ON c.venue_id = v.venue_id
            LEFT JOIN venue_review_score r ON v.venue_id = r.venue_id
            WHERE 1=1";

    // Add conditions based on form inputs
    if (!empty($cateringgrade)) {
        $sql .= " AND c.grade = " . $cateringgrade;
    }

    if (!empty($venuename)) {
        $sql .= " AND v.name = '" . $venuename . "'";
    }

    if (!empty($minPrice)) {
        $sql .= " AND c.cost >= " . $minPrice;
    }

    if (!empty($maxPrice)) {
        $sql .= " AND c.cost <= " . $maxPrice;
    }

    $sql .= " GROUP BY v.name, c.grade, c.cost";
    
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