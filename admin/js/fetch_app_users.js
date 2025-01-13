
$(document).ready(function() {
  // When the page loads, fetch the app users
  $.ajax({
    url: 'x-nd/fetchAppUsers.php',  // <-- Path to your new PHP script
    type: 'GET', 
    dataType: 'json',
    success: function(response) {
      // Check if our server returned success
      if (response.status === 'success') {
        // The data array is in response.data
        const rows = response.data;

        // Clear any existing rows
        $('#appUserTable tbody').empty();

        // Loop through each row and append to table
        rows.forEach(function(row) {
          let htmlRow = `
            <tr>
              <td>${escapeHtml(row.id)}</td>
              <td>${escapeHtml(row.firstname)}</td>
              <td>${escapeHtml(row.lastname)}</td>
              <td>${escapeHtml(row.company)}</td>
              <td>${escapeHtml(row.user_id_current)}</td>
              <td>${escapeHtml(row.peak_id)}</td>
              <td>${escapeHtml(row.peak_user)}</td>
              <td>${escapeHtml(row.logged_in)}</td>
              <td>${escapeHtml(row.image)}</td>
            </tr>
          `;
          $('#appUserTable tbody').append(htmlRow);
        });

      } else {
        // If status is "error", show the error message
        alert('Error: ' + response.message);
      }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error('AJAX Error:', textStatus, errorThrown);
      alert('An error occurred while fetching app users.');
    }
  });
});

// Basic HTML escaping
function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}
