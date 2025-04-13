document.addEventListener('DOMContentLoaded', function() {
    const mealContainer = document.getElementById('mealContainer');
    const addMealBtn = document.getElementById('addMealBtn');
    const form = document.getElementById('MealForm');
    
    // Add new meal entry
    addMealBtn.addEventListener('click', function() {
        const newEntry = document.createElement('div');
        newEntry.className = 'meal-entry';
        newEntry.innerHTML = `
            <div class="input-row">
                <div class="input-box">
                    <label>Meal Name</label>
                    <input type="text" name="meals[]" placeholder="Enter meal" required>
                </div>
                <button type="button" class="remove-btn">
                    <i class="fas fa-trash"></i> Remove
                </button>
            </div>
        `;
        
        mealContainer.appendChild(newEntry);
        
        // Add event listener to the new remove button
        newEntry.querySelector('.remove-btn').addEventListener('click', function() {
            mealContainer.removeChild(newEntry);
        });
    });
    
    // Form submission with AJAX
    form.addEventListener('submit', function(e) {
        e.preventDefault(); // Prevent default form submission
        
        const formData = new FormData(form); // Collect all form data, including arrays
        const submitButton = form.querySelector('.request-btn');
        
        // Disable button to prevent multiple submissions
        submitButton.disabled = true;
        submitButton.textContent = 'Submitting...';

        fetch('action/meal_form_action.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Parse JSON response from PHP
        .then(data => {
            if (data.success) {
                // Show success message
                alert(data.message); // Or use a custom UI element
                form.reset(); // Clear the form
                mealContainer.innerHTML = `
                    <div class="meal-entry">
                        <div class="input-row">
                            <div class="input-box">
                                <label>Meal Name</label>
                                <input type="text" name="meals[]" placeholder="Enter meal" required>
                            </div>
                        </div>
                    </div>
                `; // Reset to one meal entry
            } else {
                // Show error message
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while submitting the meals.');
        })
        .finally(() => {
            // Re-enable the submit button
            submitButton.disabled = false;
            submitButton.textContent = 'Submit Form';
        });
    });
});