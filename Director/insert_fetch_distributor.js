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
        // For each .distributorFetch select, remove old dynamic options
        $('.distributorFetch')
          .find('option:not([value="add_new"]):not(:disabled)')
          .remove();

        // Insert new distributor options
        response.data.forEach(function(item) {
          // Use item.distributor (correct spelling) from your PHP
          const distributor = item.distrubutor;

          // Insert this option before the "add_new" option for each .distributorFetch
          $('.distributorFetch').each(function() {
            $(this).find('option[value="add_new"]').before(
              `<option value="${escapeHtml(distributor)}">${escapeHtml(distributor)}</option>`
            );
          });
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

  // Delegate change event to any .distributorFetch (including newly cloned selects)
  $(document).on('change', '.distributorFetch', function() {
    if ($(this).val() === 'add_new') {
      const newDistributor = prompt("Enter the new distributor:");
      if (newDistributor && newDistributor.trim() !== "") {
        $.ajax({
          url: './dirback/insert_fetch_distributor.php',
          type: 'POST',
          dataType: 'json',
          data: { distributor: newDistributor.trim() },
          success: (response) => {
            if (response.status === 'success') {
              // Add the new distributor option before the "add_new" option
              // in THIS specific select that triggered the event
              $(this).find('option[value="add_new"]').before(
                `<option value="${escapeHtml(response.distributor)}">
                   ${escapeHtml(response.distributor)}
                 </option>`
              );
              // Select the newly inserted option
              $(this).val(response.distributor);
              alert(response.message);
            } else {
              alert("Error: " + response.message);
              $(this).val(""); // Reset selection on error
            }
          },
          error: function(xhr, status, error) {
            console.error("AJAX Error (insert distributor):", status, error);
            alert("An error occurred while adding the distributor.");
          }
        });
      } else {
        // If user canceled or provided empty input, reset select
        $(this).val("");
      }
    }
  });
});
