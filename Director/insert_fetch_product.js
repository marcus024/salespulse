
let allProducts = [];

function escapeHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

function loadProducts() {
  return $.ajax({
    url: './dirback/fetchAll_product.php', 
    type: 'GET',
    dataType: 'json',
    success: function(response) {
      if (response.status === 'success') {
        allProducts = response.data.map(item => item.product);
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

function fillOneProductSelect($select) {
  $select.find('option:not([value="add_new_product"]):not(:disabled)').remove();

  allProducts.forEach(prod => {
    $select.find('option[value="add_new_product"]').before(
      `<option value="${escapeHtml(prod)}">${escapeHtml(prod)}</option>`
    );
  });
}

function initProductChangeHandler() {
  $(document).on('change', '.productFetch', function() {
    if ($(this).val() === 'add_new_product') {
      const newProduct = prompt("Enter the new product name:");
      if (newProduct && newProduct.trim() !== "") {
        $.ajax({
          url: './dirback/insert_fetch_product.php',  
          type: 'POST',
          dataType: 'json',
          data: { product: newProduct.trim() },
          success: (response) => {
            if (response.status === 'success') {
              allProducts.push(response.product);
              $(this).find('option[value="add_new_product"]').before(
                `<option value="${escapeHtml(response.product)}">
                  ${escapeHtml(response.product)}
                 </option>`
              );
              
              $(this).val(response.product);
              alert(response.message);
            } else {
              alert("Error: " + response.message);
              $(this).val(""); 
            }
          },
          error: function(xhr, status, error) {
            console.error("AJAX Error (insert product):", status, error);
            alert("An error occurred while adding the product.");
          }
        });
      } else {
        
        $(this).val("");
      }
    }
  });
}


$(document).ready(function() {

  initProductChangeHandler();
  loadProducts().then(() => {
    
  });
});
