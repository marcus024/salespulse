// Function to load sources into the select dropdown
function loadSources() {
    $.ajax({
        url: './dirback/fetchAll_source.php',  // The backend PHP endpoint that fetches the sources
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                const $select = $('#sourceSelect');
                $select.find('option:not([value="add_new_source"]):not(:disabled)').remove(); // Remove all other options except "Add New"

                // Add existing sources to the select dropdown
                response.data.forEach(function(item) {
                    const source = item.sourcetype;  // Assuming the source is stored under 'sourcetype'
                    $select.find('option[value="add_new_source"]').before(
                        `<option style="color:black;" value="${source}">${source}</option>`
                    );
                });
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error (fetch sources):', status, error);
            alert('An error occurred while fetching sources.');
        }
    });
}

// Event listener for adding a new source
$('#sourceSelect').change(function() {
    const selectedValue = $(this).val();

    // If "Add New Source" is selected, prompt the user to input a new source
    if (selectedValue === 'add_new_source') {
        const newSource = prompt('Please enter the new source:');
        if (newSource) {
            insertNewSource(newSource); // Call the function to insert the new source
        }
    }
});

// Function to insert the new source into the database
function insertNewSource(source) {
    const projectId = document.querySelector("#project-id-placeholder strong").textContent.trim();  // Assuming you're getting the project ID

    $.ajax({
        url: './dirback/insert_source.php',  // Backend PHP file for inserting the new source
        type: 'POST',
        dataType: 'json',
        data: {
            project_id: projectId,
            source: source
        },
        success: function(response) {
            if (response.status === 'success') {
                alert('New source added successfully!');
                loadSources(); // Reload the dropdown with updated sources
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error (insert source):', status, error);
            alert('An error occurred while adding the new source.');
        }
    });
}
