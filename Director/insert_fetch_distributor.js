
// Function to escape HTML
function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

// Function to load all distributors on page load
function loadDistributors() {
  $.ajax({
    url: './dirback/fetchAll_distributor.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        // Get the select element and clear all dynamic options (but keep the default and special option)
        const $select = $('#distributorSelect');
        // Remove any dynamically added options that are not the special ones
        $select.find('option:not([value="add_new"]):not(:disabled)').remove();
        
        // Loop through each distributor and add as an option before the "add_new" option
        response.data.forEach(function(item) {
          // item.distrubutor is expected from the query
          const distributor = item.distrubutor;
          $select.find('option[value="add_new"]').before(
            `<option value="${escapeHtml(distributor)}">${escapeHtml(distributor)}</option>`
          );
        });
      } else {
        alert("Error: " + response.message);
      }
    },
    error: function(xhr, status, error) {
      console.error("AJAX Error (fetch distributors):", status, error);
      alert("An error occurred while fetching distributors.");
    }
  });
}

// Call loadDistributors() when the document is ready
$(document).ready(function() {
  loadDistributors();
  
  // When the select element changes, check if the "add_new" option was selected
  $('#distributorSelect').on('change', function() {
    if ($(this).val() === 'add_new') {
      let newDistributor = prompt("Enter the new distributor:");
      if (newDistributor && newDistributor.trim() !== "") {
        $.ajax({
          url: './dirback/insert_fetch_distributor.php',
          type: 'POST',
          dataType: 'json',
          data: { distributor: newDistributor.trim() },
          success: function(response) {
            if (response.status === 'success') {
              // Add the new distributor option before the special "add_new" option
              $('#distributorSelect').find('option[value="add_new"]').before(
                `<option value="${escapeHtml(response.distributor)}">${escapeHtml(response.distributor)}</option>`
              );
              // Set the new option as selected
              $('#distributorSelect').val(response.distributor);
              alert(response.message);
            } else {
              alert("Error: " + response.message);
              $('#distributorSelect').val(""); // Reset selection if needed
            }
          },
          error: function(xhr, status, error) {
            console.error("AJAX Error (insert distributor):", status, error);
            alert("An error occurred while adding the distributor.");
          }
        });
      } else {
        $(this).val(""); // Reset if nothing valid is provided
      }
    }
  });
});
