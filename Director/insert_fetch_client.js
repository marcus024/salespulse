$(document).ready(function () {
  // Function to load all client types on page load
  function loadClientTypes() {
    $.ajax({
      url: './dirback/fetchAll_client.php',
      type: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          const $select = $('#clientTypeSelect');
          $select.find('option:not([value="add_new"]):not(:disabled)').remove();

          // Add client types dynamically
          response.data.forEach(function (item) {
            const clientType = item.client_type;
            $select.find('option[value="add_new"]').before(
              `<option value="${escapeHtml(clientType)}">${escapeHtml(clientType)}</option>`
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

  // Call loadClientTypes() on page load
  loadClientTypes();

  // Add a new client type when "add_new" is selected
  $('#clientTypeSelect').on('change', function () {
    if ($(this).val() === 'add_new') {
      const newClientType = prompt('Enter the new Client Type:');
      if (newClientType && newClientType.trim() !== '') {
        $.ajax({
          url: './dirback/insert_clienttype.php',
          type: 'POST',
          dataType: 'json',
          data: { client_type: newClientType.trim() },
          success: function (response) {
            if (response.status === 'success') {
              $('#clientTypeSelect')
                .find('option[value="add_new"]')
                .before(
                  `<option value="${escapeHtml(response.client_type)}">${escapeHtml(response.client_type)}</option>`
                );
              $('#clientTypeSelect').val(response.client_type);
              alert(response.message);
            } else {
              alert('Error: ' + response.message);
              $('#clientTypeSelect').val(''); // Reset selection
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
