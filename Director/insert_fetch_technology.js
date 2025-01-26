let allTechnologies = [];

// Escape HTML to prevent XSS attacks
function escapeHtml(str) {
    if (!str) return '';
    return String(str)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
}

// Load all technologies from the backend
function loadTechnologies() {
    return $.ajax({
        url: './dirback/fetchAll_technology.php', // Backend endpoint to fetch technologies
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                allTechnologies = response.data.map(item => item.technology);
                fillExistingTechnologySelects();
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

// Populate all existing technology selects with options
function fillExistingTechnologySelects() {
    $('.technologyFetch')
        .find('option:not([value="add_new_technology"]):not(:disabled)')
        .remove(); // Clear previous options except the "Add New" option

    $('.technologyFetch').each(function () {
        const $select = $(this);
        allTechnologies.forEach(tech => {
            $select.find('option[value="add_new_technology"]').before(
                `<option value="${escapeHtml(tech)}">${escapeHtml(tech)}</option>`
            );
        });
    });
}

// Populate a specific technology select element
function fillOneTechnologySelect($select) {
    $select.find('option:not([value="add_new_technology"]):not(:disabled)').remove();

    allTechnologies.forEach(tech => {
        $select.find('option[value="add_new_technology"]').before(
            `<option value="${escapeHtml(tech)}">${escapeHtml(tech)}</option>`
        );
    });
}

// Handle the "Add New Technology" option
function initTechnologyChangeHandler() {
    $(document).on('change', '.technologyFetch', function () {
        if ($(this).val() === 'add_new_technology') {
            const newTechnology = prompt('Enter the new Technology:');
            if (newTechnology && newTechnology.trim() !== '') {
                $.ajax({
                    url: './dirback/insert_fetch_technology.php', // Backend endpoint to insert technology
                    type: 'POST',
                    dataType: 'json',
                    data: { technology: newTechnology.trim() },
                    success: (response) => {
                        if (response.status === 'success') {
                            allTechnologies.push(response.technology);
                            $(this).find('option[value="add_new_technology"]').before(
                                `<option value="${escapeHtml(response.technology)}">
                                    ${escapeHtml(response.technology)}
                                 </option>`
                            );

                            $(this).val(response.technology); // Select the newly added option
                            alert(response.message);
                        } else {
                            alert('Error: ' + response.message);
                            $(this).val(''); // Reset the select element
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error (insert technology):', status, error);
                        alert('An error occurred while adding the technology.');
                    }
                });
            } else {
                $(this).val(''); // Reset the select element
            }
        }
    });
}

// Initialize everything
$(document).ready(function () {
    initTechnologyChangeHandler();
    loadTechnologies().then(() => {
        // Technologies loaded successfully, populate selects if needed
    });
});