$(document).ready(function() {
  // Fetch all workpulse data when the page loads
  $.ajax({
    url: 'x-nd/fetch_work_time.php', // Ensure the correct path
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        const rows = response.data;
        
        // Clear existing table data
        $('#workPulse tbody').empty();

        // Populate the table
        rows.forEach(function(row) {
          let htmlRow = `
            <tr>
              <td>${escapeHtml(row.work_id)}</td>
              <td>${escapeHtml(row.project)}</td>
              <td>${escapeHtml(row.roles)}</td>
              <td>${escapeHtml(row.start_time)}</td>
              <td>${escapeHtml(row.end_time)}</td>
              <td>${escapeHtml(row.time)}</td>
            </tr>
          `;
          $('#workPulse tbody').append(htmlRow);
        });
      } else {
        alert('Error: ' + response.message);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error('AJAX Error:', textStatus, errorThrown);
      alert('An error occurred while fetching time tracker data.');
    }
  });
});

// Function to escape HTML (Prevent XSS)
function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}
