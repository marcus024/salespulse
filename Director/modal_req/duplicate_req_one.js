
document.addEventListener('DOMContentLoaded', function() {
  let requirementCount = 1;
  const requirementsContainer = document.getElementById('requirementsContainer');
  const addBtn = document.getElementById('addRequirementBtn');

  // Initialize the "Add New" logic for both product & distributor
  initProductChangeHandler();
  initDistributorChangeHandler();

  
  $.when( loadProducts(), loadDistributors() ).done(function() {
    
  });

  // "Add" button to clone a new requirement block
  addBtn.addEventListener('click', function(e) {
    e.preventDefault();
    requirementCount++;

    const newBlock = document.createElement('div');
    newBlock.classList.add('requirement-block');
    newBlock.dataset.index = requirementCount;

    const newReqId = 'st1rq' + requirementCount;

    newBlock.innerHTML = `
      <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
        Requirement ${requirementCount}
      </p>
      <input type="hidden" name="requirement_id_1[]" value="${newReqId}">
      <div class="row mb-2">
        <div class="col-md-4">
          <label class="form-label text-white">Requirement</label>
        </div>
        <div class="col-md-3">
          <label class="form-label text-white">Product</label>
        </div>
        <div class="col-md-3">
          <label class="form-label text-white">Distributor</label>
        </div>
        <div class="col-md-2"></div>
      </div>

      <div class="row mb-3">
        <div class="col-md-4">
          <input name="requirement_one[]" 
                 style="width: 100%;" 
                 type="text" 
                 class="form-control" 
                 placeholder="e.g. Sample Requirement">
        </div>
        <div class="col-md-3">
          <select name="product_one[]" class="form-control custom-select productFetch">
            <option disabled selected>Select</option>
            <option value="add_new_product">+ Add New Product...</option>
          </select>
        </div>
        <div class="col-md-3">
          <select name="distributor_one[]" class="form-control custom-select distributorFetch">
            <option disabled selected>Select</option>
            <option value="add_new">+ Add New Distributor...</option>
          </select>
        </div>
        <div class="col-md-2">
          <button type="button"
                  class="btn btn-danger btn-sm removeRequirement"
                  style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;">
            <i class="fas fa-minus"></i>&nbsp;Remove
          </button>
        </div>
      </div>
    `;

    // Append the new block
    requirementsContainer.appendChild(newBlock);

    // 1) Fill *this* new product select from cached array
    const newProductSelect = newBlock.querySelector('.productFetch');
    if (newProductSelect) {
      fillOneProductSelect($(newProductSelect));
    }

    // 2) Fill *this* new distributor select from cached array
    const newDistributorSelect = newBlock.querySelector('.distributorFetch');
    if (newDistributorSelect) {
      fillOneDistributorSelect($(newDistributorSelect));
    }
  });

  // Delegate remove button
  requirementsContainer.addEventListener('click', function(e) {
    if (e.target.closest('.removeRequirement')) {
      e.preventDefault();
      const blockToRemove = e.target.closest('.requirement-block');
      if (blockToRemove) {
        blockToRemove.remove();
      }
    }
  });
});
