// Run this code when the page loads or whenever you want to fetch the projects
  $(document).ready(function() {
    $.ajax({
      url: 'x-nd/fetch_project_table.php',  // The server-side script we created
      method: 'GET',                       // or 'POST' if needed
      dataType: 'json',
      success: function(response) {
        if (response.status === 'success') {
          // Clear existing rows
          $('#appUserTable tbody').empty();
          
          // Loop through each project record
          response.data.forEach(function(project) {
            // Build a table row
            let rowHtml = `
            <tr>
                <td>${escapeHtml(project.project_unique_id)}</td>
                <td>${escapeHtml(project.client_name)}</td>
                <td>${escapeHtml(project.account_manager)}</td>
                <td>${escapeHtml(project.product_type)}</td>
                <td>${escapeHtml(project.source)}</td>
                <td>${escapeHtml(project.current_stage)}</td>
                <td>${escapeHtml(project.start_date)}</td>
                <td>${escapeHtml(project.end_date)}</td>
                <!-- Use the helper to get color for the 'status' cell -->
                <td style="color:${getStatusColor(project.status)}">
                    ${escapeHtml(project.status)}
                </td>
                <td>${escapeHtml(project.duration)}</td>
            </tr>
            `;
            $('#appUserTable tbody').append(rowHtml);
          });

        } else {
          alert("Error: " + response.message);
          console.error("Server error:", response.message);
        }
      },
      error: function(xhr, status, error) {
        console.error("AJAX Error:", status, error);
        alert("An error occurred while fetching project data.");
      }
    });
  });

  // A basic HTML-escape function to prevent potential XSS
  function escapeHtml(str) {
    if (!str) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }

  function getStatusColor(status) {
  switch (status) {
    case 'Completed':
      return 'green';
    case 'Ongoing':
      return 'blue';
    case 'Cancelled':
      return 'red';
    case 'Not yet Started':
      return 'gray';
    default:
      return '#000'; // fallback (black)
  }
}