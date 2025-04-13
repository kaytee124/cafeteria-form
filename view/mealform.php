<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Meal Form</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background-color: #f5f5f5;
            padding: 20px;
        }
        
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
        }
        
        .heading {
            text-align: center;
            margin-bottom: 30px;
        }
        
        .heading h2 {
            color: #333;
            font-size: 28px;
        }
        
        .form {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        
        .input-box {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }
        
        .input-box label {
            font-weight: 600;
            color: #444;
            font-size: 16px;
        }
        
        .input-box input,
        .input-box select {
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border 0.3s;
        }
        
        .input-box input:focus,
        .input-box select:focus {
            outline: none;
            border-color: #4a90e2;
        }
        
        .meal-entry {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid #eee;
        }
        
        .input-row {
            display: flex;
            gap: 20px;
        }
        
        .add-btn, .request-btn {
            padding: 12px 20px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        .add-btn {
            background-color: #6c757d;
            margin-bottom: 20px;
        }
        
        .add-btn:hover {
            background-color: #5a6268;
        }
        
        .request-btn {
            background-color: #28a745;
        }
        
        .request-btn:hover {
            background-color: #218838;
        }
        
        #mealContainer {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }
            
            .input-row {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<?php
require_once("../controller/meal_controller.php");
?>
<body>
    <div class="container">
        <div class="main">
            <div class="heading">
                <h2>Meal Form</h2>
            </div>
            <div class="lab-container">
                <form action="#" class="form" id="MealForm">
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
    <script src="../js/meal.js"></script>
</body>
</html>