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
              <td style="font-size:12px;">${escapeHtml(row.work_id)}</td>
              <td style="font-size:12px;">${escapeHtml(row.full_name)}</td>
              <td style="font-size:12px;">${escapeHtml(row.auxiliary)}</td>
              <td style="font-size:12px;">${escapeHtml(row.roles)}</td>
              <td style="font-size:12px;">${escapeHtml(row.start_time)}</td>
              <td style="font-size:12px;">${escapeHtml(row.end_time)}</td>
              <td style="font-size:12px;">${escapeHtml(row.duration)}</td>
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
