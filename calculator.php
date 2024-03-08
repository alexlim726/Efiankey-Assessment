<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date1 = $_POST['date1'];
    $date2 = $_POST['date2'];

    // Validate input dates
    if (!validateDate($date1) || !validateDate($date2)) {
        echo "Please enter valid dates in the format YYYY-MM-DD";
        exit();
    }

    // Calculate the difference in days
    $diff = abs(strtotime($date2) - strtotime($date1));
    $days = floor($diff / (60 * 60 * 24));

    echo "Number of days between $date1 and $date2 is: $days days<br>";

    // Determine if the number of days is odd or even
    echo "The number of days is " . ($days % 2 == 0 ? "even" : "odd");
}

function validateDate($date, $format = 'Y-m-d') {
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
?>


