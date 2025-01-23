
let allDistrubutors = [];  


async function loadDistributors() {
  return $.ajax({
    url: './dirback/fetchAll_distributor.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        allDistrubutors = response.data.map(item => item.distrubutor);

        fillExistingDistributorSelects();
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

function fillExistingDistributorSelects() {
  $('.distributorFetch')
    .find('option:not([value="add_new"]):not(:disabled)')
    .remove();

 
  $('.distributorFetch').each(function() {
    const $thisSelect = $(this);
    allDistrubutors.forEach(d => {
      $thisSelect.find('option[value="add_new"]').before(
        `<option value="${escapeHtml(d)}">${escapeHtml(d)}</option>`
      );
    });
  });
}


function fillOneDistributorSelect($select) {
  $select.find('option:not([value="add_new"]):not(:disabled)').remove();

  allDistrubutors.forEach(d => {
    $select.find('option[value="add_new"]').before(
      `<option value="${escapeHtml(d)}">${escapeHtml(d)}</option>`
    );
  });
}

function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

function initDistributorChangeHandler() {
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
              allDistrubutors.push(response.distributor);

              $(this).find('option[value="add_new"]').before(
                `<option value="${escapeHtml(response.distributor)}">
                   ${escapeHtml(response.distributor)}
                 </option>`
              );
              $(this).val(response.distributor);
              alert(response.message);
            } else {
              alert("Error: " + response.message);
              $(this).val(""); 
            }
          },
          error: function(xhr, status, error) {
            console.error("AJAX Error (insert distributor):", status, error);
            alert("An error occurred while adding the distributor.");
          }
        });
      } else {
        $(this).val("");
      }
    }
  });
}
