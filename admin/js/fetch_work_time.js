$(document).ready(function() {
  // Fetch time-tracking data when the page loads
  $.ajax({
    url: 'x-nd/fetch_work_time.php', // Ensure the correct path
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        const rows = response.data;
        
        // Clear any existing rows
        $('#workPulse tbody').empty();

        // Populate the table with fetched data
        rows.forEach(function(row) {
          let htmlRow = `
            <tr>
              <td>${escapeHtml(row.work_id)}</td>
              <td>${escapeHtml(row.auxiliary)}</td>
              <td>${escapeHtml(row.start_time)}</td>
              <td>${escapeHtml(row.end_time)}</td>
              <td>${escapeHtml(row.duration)}</td>
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
