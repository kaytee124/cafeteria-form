<?php
include("../controller/meal_controller.php");

$response = array("success" => false, "message" => "");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $cafeteria_id = sanitize_input($_POST['cafeteria-id']);
        $meal_day = sanitize_input($_POST['meal-day']);
        $meal_type = sanitize_input($_POST['meal-type']);
        $meals = $_POST['meals'] ?? [];

        if (empty($meals)) {
            throw new Exception("At least one meal is required.");
        }

        $result = meal_controller($cafeteria_id, $meal_day, $meal_type, $meals);

        if ($result) {
            $response["success"] = true;
            $response["message"] = "Meals submitted successfully.";
        } else {
            $response["success"] = false;
            $response["message"] = "Error: Unable to submit meals. Please try again.";
        }
    } catch (Exception $e) {
        $response["success"] = false;
        $response["message"] = $e->getMessage();
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>