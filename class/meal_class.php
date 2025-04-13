<?php
require_once("../settings/db_class.php");

class meal_class extends db_connection {

    // Add meal schedule and items
    public function meal_form($cafeteria_id, $meal_day, $meal_type, $meals) {
        $conn = $this->db_conn();
    
        // Check if connection failed
        if ($conn === false) {
            throw new Exception("Database connection failed.");
        }
    
        // Sanitize inputs
        $cafeteria_id = mysqli_real_escape_string($conn, $cafeteria_id);
        $meal_day = mysqli_real_escape_string($conn, $meal_day);
        $meal_type = mysqli_real_escape_string($conn, $meal_type);
    
        // Start transaction to ensure atomicity
        if (!mysqli_begin_transaction($conn)) {
            throw new Exception("Failed to start transaction: " . mysqli_error($conn));
        }
    
        try {
            // Insert into meal_schedule_table
            $schedule_sql = "INSERT INTO meal_schedule_table (cafeteria_id, meal_day, meal_type) 
                            VALUES ('$cafeteria_id', '$meal_day', '$meal_type')";
            if (!mysqli_query($conn, $schedule_sql)) {
                throw new Exception("Failed to insert meal schedule: " . mysqli_error($conn));
            }
    
            // Get the last inserted schedule ID
            $schedule_id = mysqli_insert_id($conn);
            if ($schedule_id === 0) {
                throw new Exception("Failed to get schedule ID");
            }
    
            // Insert each meal into meal_items_table
            for ($i = 0; $i < count($meals); $i++) {
                $meal_name = mysqli_real_escape_string($conn, trim($meals[$i]));
                if (empty($meal_name)) {
                    continue; // Skip empty meal names
                }
                $item_sql = "INSERT INTO meal_items_table (schedule_id, meal_name) 
                            VALUES ('$schedule_id', '$meal_name')";
                if (!mysqli_query($conn, $item_sql)) {
                    throw new Exception("Failed to insert meal item: " . mysqli_error($conn));
                }
            }
    
            // Commit transaction
            if (!mysqli_commit($conn)) {
                throw new Exception("Failed to commit transaction: " . mysqli_error($conn));
            }
            return true;
        } catch (Exception $e) {
            // Rollback on error
            mysqli_rollback($conn);
            throw $e;
        } finally {
            // Close connection
            mysqli_close($conn);
        }
    }

    // Get all cafeterias for dropdown
    public function get_cafeterias() {
        $conn = $this->db_conn();
        $sql = "SELECT * FROM cafeteria_table";
        $result = mysqli_query($conn, $sql);
        if ($result === false) {
            mysqli_close($conn);
            throw new Exception("Query failed: " . mysqli_error($conn));
        }
        $cafeterias = $this->db_fetch_all($sql);
        mysqli_close($conn);
        return $cafeterias;
    }

    // Get meals for a specific cafeteria
    public function get_cafeteria_meals($cafeteria_id) {
        $conn = $this->db_conn();
        
        // Check if connection failed
        if ($conn === false) {
            throw new Exception("Database connection failed.");
        }

        // Sanitize input
        $cafeteria_id = mysqli_real_escape_string($conn, $cafeteria_id);

        // Query to get meals organized by meal type
        $sql = "SELECT c.cafeteria_name, ms.meal_day, ms.meal_type, mi.meal_name
                FROM cafeteria_table c
                JOIN meal_schedule_table ms ON c.cafeteria_id = ms.cafeteria_id
                JOIN meal_items_table mi ON ms.schedule_id = mi.schedule_id
                WHERE c.cafeteria_id = '$cafeteria_id'
                ORDER BY ms.meal_day, ms.meal_type, mi.meal_name";

        $result = mysqli_query($conn, $sql);
        
        if ($result === false) {
            mysqli_close($conn);
            throw new Exception("Query failed: " . mysqli_error($conn));
        }

        $meals = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $day = $row['meal_day'];
            $type = $row['meal_type'];
            $cafeteria_name = $row['cafeteria_name'];
            
            // Initialize structure if not exists
            if (!isset($meals[$day])) {
                $meals[$day] = [
                    'cafeteria_name' => $cafeteria_name,
                    'Breakfast' => [],
                    'Lunch' => [],
                    'Dinner' => []
                ];
            }
            
            // Add meal to appropriate meal type
            $meals[$day][$type][] = $row['meal_name'];
        }

        mysqli_close($conn);
        return $meals;
    }
}
?>