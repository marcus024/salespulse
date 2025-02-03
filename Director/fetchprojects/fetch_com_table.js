 $(document).ready(function() {
        let actualGross = 0;

        // Fetch and display data from the server
        $.ajax({
            url: './dirback/spcome_fetch_table.php',  // The PHP file
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#commission-table').empty(); // Clear previous content

                if (data.length === 0) {
                    showError('No projects found.');
                    return;
                }

                // Sum the gross profits
                data.forEach(project => {
                    actualGross += parseFloat(project.gross_profit) || 0;

                    // Append data rows dynamically
                    $('#commission-table').append(`
                        <div class="d-flex p-3 mb-2" style="background: #292a2f; border-radius: 8px;">
                            <div class="col-2 comRows">${project.project_name}</div>
                            <div class="col-2 comRows">${project.start_date}</div>
                            <div class="col-2 comRows">${project.end_date}</div>
                            <div class="col-2 comRows">Php ${project.net_sales || 0}</div>
                            <div class="col-2 comRows">Php ${project.gross_profit || 0}</div>
                            <div class="col-2 comRows">Php ${project.commission || 0}</div> <!-- Default to 0 if commission is missing -->
                        </div>
                    `);
                });

                // Display the sum of gross profit as actual gross profit
                $('#actualGross').val(actualGross.toFixed(2));
            },
            error: function(xhr, status, error) {
                let errorMessage = 'An error occurred while fetching data.';

                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMessage = xhr.responseJSON.error;
                }

                showError(errorMessage);
                console.error('Error fetching data:', error);
            }
        });

        // Function to display error notifications
        function showError(message) {
            $('#commission-table').html(`
                <div class="alert alert-danger" role="alert">
                    ${message}
                </div>
            `);
        }

        // Trigger the calculation when the Calculate button is clicked
        $('.calcBtn').on('click', function() {
            try {
                // Get actual gross profit and target gross profit values
                let targetGross = parseFloat($('#targetGross').val()) || 0;

                if (isNaN(targetGross) || targetGross <= 0) {
                    alert("Please enter a valid target gross profit.");
                    return;
                }

                let deficit = 0;

                if (actualGross > targetGross) {
                    deficit = 0; // No deficit if actual gross is greater
                } else {
                    deficit = targetGross - actualGross;
                }

                // Calculate the potential commission only if there is a deficit
                let potentialCommission = deficit * 0.05 * 0.70;

                let formattedCommission = potentialCommission.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",");

                // Display the potential commission
                $('#potentialCommission').text(`Php ${formattedCommission}`);

            } catch (error) {
                // Alert to notify if something went wrong
                alert("There was an error in calculating the potential commission. Please try again.");
                console.error(error); // Log the error for debugging purposes
            }
        });
    });

    // Search function to filter rows based on input
function searchTable() {
    let input = document.getElementById("searchInput");
    let filter = input.value.toLowerCase();
    let rows = document.querySelectorAll("#commission-table .d-flex"); // Get all row containers

    rows.forEach(row => {
        let cells = row.querySelectorAll(".comRows"); // Get all cells in the current row
        let rowText = "";
        
        // Concatenate text content of each cell for searching
        cells.forEach(cell => {
            rowText += cell.textContent.toLowerCase(); // Add cell text to rowText
        });

        // Show/hide row based on the search input
        if (rowText.includes(filter)) {
            row.style.display = ""; // Show row
        } else {
            row.style.display = "none"; // Hide row
        }
    });
}
