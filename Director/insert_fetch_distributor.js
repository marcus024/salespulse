// A global array to store the list of distributors
let allDistrubutors = [];  // spelled "distrubutor" per your code

// 1. Load the distributor list ONCE, store in array
function loadDistributors() {
  return $.ajax({
    url: './dirback/fetchAll_distributor.php',
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        // store them in the array
        // e.g. response.data = [ {distrubutor: "ABC"}, {distrubutor: "XYZ"} ... ]
        allDistrubutors = response.data.map(item => item.distrubutor);

        // Fill the existing .distributorFetch elements (the initial ones in HTML)
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

// Fill any existing .distributorFetch with the cached array
function fillExistingDistributorSelects() {
  // For each .distributorFetch, remove old dynamic options EXCEPT "add_new"
  $('.distributorFetch')
    .find('option:not([value="add_new"]):not(:disabled)')
    .remove();

  // Then re-insert from allDistrubutors
  $('.distributorFetch').each(function() {
    const $thisSelect = $(this);
    allDistrubutors.forEach(d => {
      $thisSelect.find('option[value="add_new"]').before(
        `<option value="${escapeHtml(d)}">${escapeHtml(d)}</option>`
      );
    });
  });
}

// Fill a SINGLE new <select> with the same data, without touching existing ones
function fillOneDistributorSelect($select) {
  // Remove old dynamic options from just this one
  $select.find('option:not([value="add_new"]):not(:disabled)').remove();

  // Insert the cached data
  allDistrubutors.forEach(d => {
    $select.find('option[value="add_new"]').before(
      `<option value="${escapeHtml(d)}">${escapeHtml(d)}</option>`
    );
  });
}

// Reusable function to escape HTML
function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

// 2. Insert logic for "Add New" distributor
function initDistributorChangeHandler() {
  // Use delegated event so newly created selects also trigger
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
              // Add the new distributor to our cache array
              allDistrubutors.push(response.distributor);

              // Insert it right before "add_new" in THIS specific select
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
              $(this).val(""); // Reset selection
            }
          },
          error: function(xhr, status, error) {
            console.error("AJAX Error (insert distributor):", status, error);
            alert("An error occurred while adding the distributor.");
          }
        });
      } else {
        // If user canceled or typed empty, reset
        $(this).val("");
      }
    }
  });
}
