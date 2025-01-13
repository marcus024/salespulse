
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
            console.error("AJAX Error:", status, error);
            alert("An error occurred while adding the distributor.");
          }
        });
      } else {
        $(this).val(""); // Reset if nothing valid is provided
      }
    }
  });

  // Basic HTML-escaping function
  function escapeHtml(str) {
    if (!str) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }
