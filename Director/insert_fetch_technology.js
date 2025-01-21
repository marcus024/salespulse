$(document).ready(function () {
    // Function to load all technologies on page load
    function loadTechnologies() {
        $.ajax({
            url: './dirback/fetchAll_technology.php',  // Point to your PHP script to fetch data
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const $select = $('#technologySelect');
                    // Remove any options except the default and special "add_new_technology" option
                    $select.find('option:not([value="add_new_technology"]):not(:disabled)').remove();

                    // Add technology types dynamically
                    response.data.forEach(function (item) {
                        const technology = item.technology;
                        $select.find('option[value="add_new_technology"]').before(
                            `<option value="${escapeHtml(technology)}">${escapeHtml(technology)}</option>`
                        );
                    });
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error (fetch technologies):', status, error);
                alert('An error occurred while fetching technologies.');
            }
        });
    }

    // Call loadTechnologies() when the document is ready
    loadTechnologies();

    // Add a new technology when "add_new_technology" is selected
    $('#technologySelect').on('change', function () {
        if ($(this).val() === 'add_new_technology') {
            const newTechnology = prompt('Enter the new Technology:');
            if (newTechnology && newTechnology.trim() !== '') {
                $.ajax({
                    url: './dirback/insert_fetch_technology.php',  // Your PHP script to insert
                    type: 'POST',
                    dataType: 'json',
                    data: { added_technology: newTechnology.trim() },
                    success: function (response) {
                        if (response.status === 'success') {
                            // Add the new technology option before the "add_new_technology" option
                            $('#technologySelect')
                                .find('option[value="add_new_technology"]')
                                .before(
                                    `<option style="color:black;" value="${escapeHtml(response.added_technology)}">${escapeHtml(response.added_technology)}</option>`
                                );
                            $('#technologySelect').val(response.added_technology);  // Select the new option
                            alert(response.message);
                        } else {
                            alert('Error: ' + response.message);
                            $('#technologySelect').val(''); // Reset selection
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error (insert technology):', status, error);
                        alert('An error occurred while adding the technology.');
                    }
                });
            } else {
                $(this).val(''); // Reset if invalid input
            }
        }
    });

    // Function to escape HTML
    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
});
