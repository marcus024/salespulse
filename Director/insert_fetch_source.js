$(document).ready(function () {
  // Load the sources when the page loads
  function loadSource() {
    $.ajax({
        url: './dirback/fetchAll_source.php',  // Backend PHP endpoint to fetch sources
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response); // Log response to verify data
            if (response.status === 'success') {
                const $select = $('#sourceSelect');
                // Clear the existing options, but keep the "Add New Source" option
                $select.find('option:not([value="add_new_source"]):not(:disabled)').remove();

                // Add source types dynamically
                response.data.forEach(function (item) {
                    const sourceAdd = item.sourcetype;
                    $select.find('option[value="add_new_source"]').before(
                        `<option value="${escapeHtml(sourceAdd)}">${escapeHtml(sourceAdd)}</option>`
                    );
                });
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error (fetch sources):', status, error);
            alert('An error occurred while fetching sources.');
        },
    });
  }

  // Call loadSource() on page load
  loadSource();

  // Add a new source when "add_new_source" is selected
  $('#sourceSelect').on('change', function () {
    if ($(this).val() === 'add_new_source') {
      const newSource = prompt('Enter the new Source:');
      if (newSource && newSource.trim() !== '') {
        $.ajax({
          url: './dirback/insert_source.php',  // Backend PHP file for inserting the new source
          type: 'POST',
          dataType: 'json',
          data: { added_source: newSource.trim() },
          success: function (response) {
            if (response.status === 'success') {
              alert(response.message);
              loadSource(); // Reload the sources to include the newly added one
              $('#sourceSelect').val(response.source_type);  // Set the newly added source as the selected value
            } else {
              alert('Error: ' + response.message);
              $('#sourceSelect').val(''); // Reset selection if error occurs
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX Error (insert source):', status, error);
            alert('An error occurred while adding the source.');
          },
        });
      } else {
        $(this).val(''); // Reset if invalid input
      }
    }
  });

  // Function to escape HTML
  function escapeHtml(str) {
    if (!str) return '';
    return String(str)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;');
  }
});
