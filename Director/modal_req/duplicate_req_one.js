document.addEventListener('DOMContentLoaded', function() {
  // Start at 1 because the initial block is "Requirement 1"
  let requirementCount = 1;
  const requirementsContainer = document.getElementById('requirementsContainer');
  const addBtn = document.getElementById('addRequirementBtn');

  // Initialize the "Add New" logic once
  initDistributorChangeHandler();

  // Load distributors once, fill the initial
  loadDistributors().then(() => {
    // the initial .distributorFetch is now populated
  });

  // ADD functionality
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
        <div class="col-md-2">
          <!-- no Add button here -->
        </div>
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

    requirementsContainer.appendChild(newBlock);

    // Now fill ONLY this new .distributorFetch from the cached array
    const newDistributorSelect = newBlock.querySelector('.distributorFetch');
    if (newDistributorSelect) {
      fillOneDistributorSelect($(newDistributorSelect));
    }

    // If you have a separate approach for product, do similarly for .productFetch
    // const newProductSelect = newBlock.querySelector('.productFetch');
    // fillOneProductSelect($(newProductSelect));
  });

  // REMOVE event (delegated)
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
