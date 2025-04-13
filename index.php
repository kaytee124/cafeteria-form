<?php
header('Content-Type: text/html; charset=UTF-8');
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once("controller/meal_controller.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Meal Form</title>
</head>
<body>
    <div class="container">
        <div class="main">
            <div class="heading">
                <h2>Meal Form</h2>
            </div>
            <div class="lab-container">
                <form action="../actions/mealaction.php" class="form" id="MealForm">
                    <div class="input-box">
                        <label>Cafeteria Name</label>
                        <select id="cafeteria-id" name="cafeteria-id" required>
                            <option value="">Select Cafeteria</option>
                            <?php
                            $cafeterias = view_cafeterias_controller();
                            if (!empty($cafeterias)) {
                                foreach ($cafeterias as $cafeteria) {
                                    echo "<option value='{$cafeteria['cafeteria_id']}'>{$cafeteria['cafeteria_name']}</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="input-box">
                        <label>Day</label>
                        <select id="meal-day" name="meal-day" required>
                            <option value="">Choose day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                            <option value="Saturday">Saturday</option>
                            <option value="Sunday">Sunday</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <label>Meal Type</label>
                        <select id="meal-type" name="meal-type" required>
                            <option value="">Choose type</option>
                            <option value="Breakfast">Breakfast</option>
                            <option value="Lunch">Lunch</option>
                            <option value="Dinner">Dinner</option>
                        </select>
                    </div>

                    <!-- Meal Container - will hold all meal entries -->
                    <div id="mealContainer">
                        <!-- First meal entry (default) -->
                        <div class="meal-entry">
                            <div class="input-row">
                                <div class="input-box">
                                    <label>Meal Name</label>
                                    <input type="text" name="meals[]" placeholder="Enter meal" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Button to add more meals -->
                    <button type="button" id="addMealBtn" class="add-btn">
                        <i class="fas fa-plus"></i> Add Another Meal
                    </button>
                    
                    <button type="submit" class="request-btn">Submit Form</button>
                </form>
            </div>
        </div>
    </div>
    <script src="js/meal.js"></script>
</body>
</html>