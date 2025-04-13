<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Cafeteria System</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .welcome-container {
            text-align: center;
            padding: 40px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 500px;
        }
        .welcome-container h1 {
            color: #343a40;
            margin-bottom: 20px;
        }
        .welcome-container p {
            color: #6c757d;
            margin-bottom: 30px;
        }
        .btn-view-cafeterias {
            padding: 10px 30px;
            font-size: 1.1rem;
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <h1>Welcome to Our Cafeteria System</h1>
        <p>Explore delicious meals available at our various cafeterias. Click below to view all cafeterias and their menus.</p>
        <a href="view/view_meals.php" class="btn btn-primary btn-view-cafeterias">View Cafeterias</a>
    </div>

    <!-- Bootstrap JS (optional, included for consistency) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>