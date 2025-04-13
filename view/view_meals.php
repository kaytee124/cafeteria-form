<?php
require_once("../controller/meal_controller.php");

// Fetch all cafeterias for display
$cafeterias = view_cafeterias_controller();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafeteria Meals</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .cafeteria-card {
            transition: transform 0.3s ease-in-out;
            cursor: pointer;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border: none;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .cafeteria-card:hover {
            transform: scale(1.05);
        }
        .modal-content {
            border-radius: 10px;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        .modal-body {
            max-height: 60vh;
            overflow-y: auto;
        }
        .day-section {
            margin-bottom: 20px;
        }
        .meal-type {
            font-weight: bold;
            color: #343a40;
            margin-top: 10px;
        }
        .meal-list {
            list-style-type: none;
            padding-left: 0;
        }
        .meal-list li {
            padding: 5px 0;
            border-bottom: 1px solid #eee;
        }
        .meal-list li:last-child {
            border-bottom: none;
        }
        .no-meals {
            color: #6c757d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="text-center mb-5">Cafeteria Meals</h1>
        <div class="row">
            <?php foreach ($cafeterias as $cafeteria): ?>
                <div class="col-md-4">
                    <div class="cafeteria-card bg-primary text-white rounded" 
                         data-cafeteria-id="<?php echo htmlspecialchars($cafeteria['cafeteria_id']); ?>" 
                         data-cafeteria-name="<?php echo htmlspecialchars($cafeteria['cafeteria_name']); ?>">
                        <h3><?php echo htmlspecialchars($cafeteria['cafeteria_name']); ?></h3>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Modal for displaying meals -->
    <div class="modal fade" id="mealsModal" tabindex="-1" aria-labelledby="mealsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mealsModalLabel">Meals</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="meals-content">
                        <!-- Meal content will be loaded here via AJAX -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Custom JavaScript -->
    <script>
        $(document).ready(function() {
            // Handle card click
            $('.cafeteria-card').on('click', function() {
                const cafeteriaId = $(this).data('cafeteria-id');
                const cafeteriaName = $(this).data('cafeteria-name');

                // Update modal title
                $('#mealsModalLabel').text(`${cafeteriaName} Meals`);

                // Show loading state
                $('#meals-content').html('<p>Loading meals...</p>');

                // Fetch meals via AJAX
                $.ajax({
                    url: '../action/view_meal_action.php',
                    type: 'POST',
                    data: { 'cafeteria-id': cafeteriaId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            let html = '';
                            const meals = response.data;

                            if (Object.keys(meals).length === 0) {
                                html = '<p class="no-meals">No meals found for this cafeteria.</p>';
                            } else {
                                // Iterate through each day
                                for (const day in meals) {
                                    html += `<div class="day-section"><h4>${day}</h4>`;

                                    // Breakfast
                                    html += '<div class="meal-type">Breakfast</div>';
                                    if (meals[day].Breakfast.length > 0) {
                                        html += '<ul class="meal-list">';
                                        meals[day].Breakfast.forEach(meal => {
                                            html += `<li>${meal}</li>`;
                                        });
                                        html += '</ul>';
                                    } else {
                                        html += '<p class="no-meals">No breakfast meals available.</p>';
                                    }

                                    // Lunch
                                    html += '<div class="meal-type">Lunch</div>';
                                    if (meals[day].Lunch.length > 0) {
                                        html += '<ul class="meal-list">';
                                        meals[day].Lunch.forEach(meal => {
                                            html += `<li>${meal}</li>`;
                                        });
                                        html += '</ul>';
                                    } else {
                                        html += '<p class="no-meals">No lunch meals available.</p>';
                                    }

                                    // Dinner
                                    html += '<div class="meal-type">Dinner</div>';
                                    if (meals[day].Dinner.length > 0) {
                                        html += '<ul class="meal-list">';
                                        meals[day].Dinner.forEach(meal => {
                                            html += `<li>${meal}</li>`;
                                        });
                                        html += '</ul>';
                                    } else {
                                        html += '<p class="no-meals">No dinner meals available.</p>';
                                    }

                                    html += '</div>';
                                }
                            }

                            $('#meals-content').html(html);
                        } else {
                            $('#meals-content').html(`<p class="text-danger">${response.message}</p>`);
                        }

                        // Show the modal
                        $('#mealsModal').modal('show');
                    },
                    error: function() {
                        $('#meals-content').html('<p class="text-danger">Error loading meals. Please try again.</p>');
                        $('#mealsModal').modal('show');
                    }
                });
            });
        });
    </script>
</body>
</html>