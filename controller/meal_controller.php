<?php
require("../class/meal_class.php");

function sanitize_input($input) {
    return htmlspecialchars(stripslashes(trim($input)));
}

// Function to add new meal schedule
function meal_controller($cafeteria_id, $meal_day, $meal_type, $meals) {
    $meal = new meal_class();
    return $meal->meal_form($cafeteria_id, $meal_day, $meal_type, $meals);
}

// Function to view all cafeterias (for form dropdown)
function view_cafeterias_controller() {
    $meal = new meal_class();
    return $meal->get_cafeterias();
}
?>