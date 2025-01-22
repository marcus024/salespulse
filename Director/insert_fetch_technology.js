$(document).ready(function () {
    
    function loadTechnologies() {
        $.ajax({
            url: './dirback/fetchAll_technology.php',  
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const $select = $('#technologySelect');
                    
                    $select.find('option:not([value="add_new_technology"]):not(:disabled)').remove();

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

    loadTechnologies();

    $('#technologySelect').on('change', function () {
        if ($(this).val() === 'add_new_technology') {
            const newTechnology = prompt('Enter the new Technology:');
            if (newTechnology && newTechnology.trim() !== '') {
                $.ajax({
                    url: './dirback/insert_fetch_technology.php', 
                    type: 'POST',
                    dataType: 'json',
                    data: { added_technology: newTechnology.trim() },
                    success: function (response) {
                        if (response.status === 'success') {
                            
                            $('#technologySelect')
                                .find('option[value="add_new_technology"]')
                                .before(
                                    `<option style="color:black;" value="${escapeHtml(response.added_technology)}">${escapeHtml(response.added_technology)}</option>`
                                );
                            $('#technologySelect').val(response.added_technology);  
                            alert(response.message);
                        } else {
                            alert('Error: ' + response.message);
                            $('#technologySelect').val(''); 
                        }
                    },
                    error: function (xhr, status, error) {
                        console.error('AJAX Error (insert technology):', status, error);
                        alert('An error occurred while adding the technology.');
                    }
                });
            } else {
                $(this).val(''); 
            }
        }
    });

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
});
