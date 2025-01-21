// Function to escape HTML
function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

// Function to load all products on page load
function loadProducts() {
  $.ajax({
    url: './dirback/fetchAll_product.php', // This endpoint should return product data
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        const $select = $('#productSelect');
        // Clear all dynamically added options except the default ones
        $select.find('option:not([value="add_new_product"]):not(:disabled)').remove();

        // Loop through the products and add each one as an option before the "add_new" option
        response.data.forEach(function(item) {
          const product = item.product; // Ensure `product` is the correct key in the response
          $select.find('option[value="add_new_product"]').before(
            `<option value="${escapeHtml(product)}">${escapeHtml(product)}</option>`
          );
        });
      } else {
        alert("Error: " + response.message);
      }
    },
    error: function(xhr, status, error) {
      console.error("AJAX Error (fetch products):", status, error);
      alert("An error occurred while fetching products.");
    }
  });
}

// Call loadProducts() when the document is ready
$(document).ready(function() {
  loadProducts();

  // When the select element changes, check if the "add_new_product" option was selected
  $('#productSelect').on('change', function() {
    if ($(this).val() === 'add_new_product') {
      let newProduct = prompt("Enter the new product name:");
      if (newProduct && newProduct.trim() !== "") {
        $.ajax({
          url: './dirback/insert_fetch_product.php', // Endpoint to insert new product
          type: 'POST',
          dataType: 'json',
          data: { product: newProduct.trim() },
          success: function(response) {
            if (response.status === 'success') {
              // Add the new product option before the special "add_new_product" option
              $('#productSelect').find('option[value="add_new_product"]').before(
                `<option value="${escapeHtml(response.product)}">${escapeHtml(response.product)}</option>`
              );
              // Set the newly added option as selected
              $('#productSelect').val(response.product);
              alert(response.message);
            } else {
              alert("Error: " + response.message);
              $('#productSelect').val(""); // Reset the selection if needed
            }
          },
          error: function(xhr, status, error) {
            console.error("AJAX Error (insert product):", status, error);
            alert("An error occurred while adding the product.");
          }
        });
      } else {
        $(this).val(""); // Reset if no valid input is provided
      }
    }
  });
});
