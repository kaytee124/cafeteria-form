<?php
include("../controller/meal_controller.php");

$response = array("success" => false, "message" => "", "data" => []);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $cafeteria_id = sanitize_input($_POST['cafeteria-id']);

        if (empty($cafeteria_id)) {
            throw new Exception("Cafeteria ID is required.");
        }

        $meals = view_cafeteria_meals_controller($cafeteria_id);

        if ($meals) {
            $response["success"] = true;
            $response["message"] = "Meals retrieved successfully.";
            $response["data"] = $meals;
        } else {
            $response["success"] = true;
            $response["message"] = "No meals found for this cafeteria.";
            $response["data"] = [];
        }
    } catch (Exception $e) {
        $response["success"] = false;
        $response["message"] = $e->getMessage();
        $response["data"] = [];
    }
} else {
    $response["message"] = "Invalid request method.";
}

header('Content-Type: application/json');
echo json_encode($response);
exit();
?>