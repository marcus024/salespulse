$(document).ready(function () { 
    function loadProjects() {
        $.ajax({
            url: './fetchprojects/fetch_project.php',  
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const $select = $('#fetchProjects');

                    // Clear existing options except the first disabled one
                    $select.find('option:not(:disabled)').remove();

                    // Populate the dropdown with project data
                    response.data.forEach(function (item) {
                        const projectId = item.project_unique_id;
                        const companyName = item.company_name;
                        $select.append(
                            `<option value="${escapeHtml(projectId)}">${escapeHtml(companyName)}</option>`
                        );
                    });
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error (fetch projects):', status, error);
                alert('An error occurred while fetching projects.');
            }
        });
    }

    loadProjects();

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }
});
