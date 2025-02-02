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

        // Calculate potential commission when form is submitted
        $('#commission-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the form from refreshing the page

            // Get actual gross profit and target gross profit values
            let targetGross = parseFloat($('#targetGross').val()) || 0;

            // Calculate the deficit
            let deficit = targetGross - actualGross;

            // Calculate the potential commission (Deficit * 5% * 70%)
            let potentialCommission = deficit * 0.05 * 0.70;

            // Display the potential commission
            $('#potentialCommission').text(`Php ${potentialCommission.toFixed(2)}`);
        });
    });