
// ---------------- GLOBAL ARRAY + UTILITY FUNCTION ---------------- //

// We'll store fetched products here after the first AJAX call
let allProducts = [];

/** Escape HTML to prevent injection. */
function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

// -------------- LOADING & CACHING PRODUCTS -------------- //

/**
 * Fetch the list of products from the server (fetchAll_product.php),
 * store them in allProducts, then fill any existing .productFetch selects.
 */
function loadProducts() {
  return $.ajax({
    url: './dirback/fetchAll_product.php',  // Must return: {status:"success", data:[ {product:"ABC"}, ... ] }
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        // Convert the response into an array of product strings
        // e.g. response.data = [ { product: 'ABC' }, { product: 'XYZ' } ... ]
        allProducts = response.data.map(item => item.product);

        // Fill any existing .productFetch selects in the page
        fillExistingProductSelects();
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

/**
 * Fill all existing .productFetch selects with the cached products.
 * We remove previous dynamic <option> items (except 'add_new_product') 
 * and then insert the items from allProducts.
 */
function fillExistingProductSelects() {
  $('.productFetch')
    .find('option:not([value="add_new_product"]):not(:disabled)')
    .remove();

  $('.productFetch').each(function() {
    const $select = $(this);
    allProducts.forEach(prod => {
      $select.find('option[value="add_new_product"]').before(
        `<option value="${escapeHtml(prod)}">${escapeHtml(prod)}</option>`
      );
    });
  });
}

/**
 * Fill only one newly created .productFetch <select>.
 */
function fillOneProductSelect($select) {
  $select.find('option:not([value="add_new_product"]):not(:disabled)').remove();

  allProducts.forEach(prod => {
    $select.find('option[value="add_new_product"]').before(
      `<option value="${escapeHtml(prod)}">${escapeHtml(prod)}</option>`
    );
  });
}

// -------------- "ADD NEW PRODUCT" EVENT DELEGATION -------------- //

/**
 * Initialize the change handler on .productFetch selects.
 * If user selects "add_new_product", prompt for a name,
 * then insert it in the DB (insert_fetch_product.php),
 * push to allProducts, and insert into that <select>.
 */
function initProductChangeHandler() {
  $(document).on('change', '.productFetch', function() {
    if ($(this).val() === 'add_new_product') {
      const newProduct = prompt("Enter the new product name:");
      if (newProduct && newProduct.trim() !== "") {
        $.ajax({
          url: './dirback/insert_fetch_product.php',  // Endpoint to insert new product
          type: 'POST',
          dataType: 'json',
          data: { product: newProduct.trim() },
          success: (response) => {
            if (response.status === 'success') {
              // Add this new product to our cached array
              allProducts.push(response.product);

              // Insert this new option before "add_new_product"
              // in THIS select only (so we don't reset old selects)
              $(this).find('option[value="add_new_product"]').before(
                `<option value="${escapeHtml(response.product)}">
                  ${escapeHtml(response.product)}
                 </option>`
              );
              // Select the newly inserted option
              $(this).val(response.product);
              alert(response.message);
            } else {
              alert("Error: " + response.message);
              $(this).val(""); // Reset the selection if needed
            }
          },
          error: function(xhr, status, error) {
            console.error("AJAX Error (insert product):", status, error);
            alert("An error occurred while adding the product.");
          }
        });
      } else {
        // User canceled or typed empty
        $(this).val("");
      }
    }
  });
}

// -------------- DOCUMENT READY -------------- //
$(document).ready(function() {
  // 1) Initialize the delegated "Add New Product" logic
  initProductChangeHandler();

  // 2) Load products once, populate any .productFetch selects
  loadProducts().then(() => {
    // If you have an "add row" button for new fields, 
    // see next example for how to call fillOneProductSelect(...) 
    // on the newly added select.
  });

  // 3) If you have an Add button for dynamic rows:
  // Example minimal approach:
  // $('#addRequirementBtn').on('click', function(e) {
  //   e.preventDefault();
  //   // create new row with <select class="productFetch">...
  //   // append it to the DOM
  //   // then fill that new .productFetch:
  //   // const $newSelect = newlyCreatedRow.find('.productFetch');
  //   // fillOneProductSelect($newSelect);
  // });
});
