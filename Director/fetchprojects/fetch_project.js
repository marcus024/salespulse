$(document).ready(function () { 
    function loadProjects() {
        $.ajax({
            url: './dirback/fetch_projects.php',  
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    const $select = $('#fetchProjects');

                    // Clear existing options except the first disabled one
                    $select.find('option:not(:disabled)').remove();

                    // Populate the dropdown with project names
                    response.data.forEach(function (item) {
                        const projectName = item.project_name;
                        $select.append(
                            `<option value="${escapeHtml(projectName)}">${escapeHtml(projectName)}</option>`
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
