$(document).ready(function () {
  function loadSource() {
    $.ajax({
        url: './dirback/fetchAll_source.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response); // Log response to verify data
            if (response.status === 'success') {
                const $select = $('#sourceSelect');
                $select.find('option:not([value="add_new_source"]):not(:disabled)').remove();

                // Add source types dynamically
                response.data.forEach(function (item) {
                    const sourceAdd = item.sourcetype;
                    $select.find('option[value="add_new_source"]').before(
                        `<option  value="${escapeHtml(sourceAdd)}">${escapeHtml(sourceAdd)}</option>`
                    );
                });
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function (xhr, status, error) {
            console.error('AJAX Error (fetch client types):', status, error);
            alert('An error occurred while fetching client types.');
        },
    });
}


  // Call loadSource() on page load
  loadSource();

  // Add a new client type when "add_new_source" is selected
  $('#sourceSelect').on('change', function () {
    if ($(this).val() === 'add_new_source') {
      const newSource = prompt('Enter the new Client Type:');
      if (newSource && newSource.trim() !== '') {
        $.ajax({
          url: './dirback/insert_source.php',
          type: 'POST',
          dataType: 'json',
          data: { added_source: newSource.trim() },
          success: function (response) {
            if (response.status === 'success') {
              $('#sourceSelect')
                .find('option[value="add_new_source"]')
                .before(
                  `<option value="${escapeHtml(response.added_source)}">${escapeHtml(response.added_source)}</option>`
                );
              $('#sourceSelect').val(response.added_source);
              alert(response.message);
            } else {
              alert('Error: ' + response.message);
              $('#sourceSelect').val(''); // Reset selection
            }
          },
          error: function (xhr, status, error) {
            console.error('AJAX Error (insert client type):', status, error);
            alert('An error occurred while adding the Client Type.');
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
