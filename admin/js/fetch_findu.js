$(document).ready(function() {
  // Fetch all workpulse data when the page loads
  $.ajax({
    url: 'x-nd/fetch_findu.php', // Ensure the correct path
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        const rows = response.data;
        
        // Clear existing table data
        $('#sessionTable tbody').empty();

        // Populate the table
        rows.forEach(function(row) {
          let htmlRow = `
            <tr>
              <td style="font-size:12px;">${escapeHtml(row.id)}</td>
              <td style="font-size:12px;">${escapeHtml(row.logged_in)}</td>
              <td style="font-size:12px;">${escapeHtml(row.logged_out)}</td>
              <td style="font-size:12px;">${escapeHtml(row.session_status)}</td>
              <td style="font-size:12px;">${escapeHtml(row.current_users)}</td>
              <td style="font-size:12px;">${escapeHtml(row.last_active)}</td>
              <td style="font-size:12px;">${escapeHtml(row.device_id)}</td>
              <td style="font-size:12px;">${escapeHtml(row.active_status)}</td>
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
