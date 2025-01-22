document.addEventListener('DOMContentLoaded', function () {
  /***************************************************************
   * 1) Parse existing requirement_id_1[] and renumber requirements
   ***************************************************************/
  function renumberRequirements() {
    const blocks = document.querySelectorAll('.requirement-block');
    blocks.forEach((block, index) => {
      const newNumber = index + 1; // Sequential numbering starts from 1
      block.dataset.index = newNumber;

      // Update the title
      const title = block.querySelector('p');
      if (title) {
        title.textContent = `Requirement ${newNumber}`;
      }

      // Update the hidden input value
      const hiddenInput = block.querySelector('input[name="requirement_id_1[]"]');
      if (hiddenInput) {
        hiddenInput.value = `st1rq${newNumber}`;
      }
    });
  }

  /***************************************************************
   * 2) Initialize requirement count
   ***************************************************************/
  let requirementCount = document.querySelectorAll('.requirement-block').length;

  /***************************************************************
   * 3) Update the initial block (title and hidden input)
   ***************************************************************/
  const requirementsContainer = document.getElementById('requirementsContainer');
  const addBtn = document.getElementById('addRequirementBtn');

  if (!requirementsContainer) {
    console.error("#requirementsContainer not found in DOM.");
    return;
  }
  if (!addBtn) {
    console.error("#addRequirementBtn not found in DOM.");
    return;
  }

  /***************************************************************
   * 4) Initialize product and distributor logic
   ***************************************************************/
  initProductChangeHandler();
  initDistributorChangeHandler();

  // Load products and distributors
  $.when(loadProducts(), loadDistributors()).done(function () {
    console.log("Products & Distributors loaded.");
    fillOneProductSelect($('.productFetch'));
    fillOneDistributorSelect($('.distributorFetch'));
  });

  /***************************************************************
   * 5) Add Requirement Button Handler
   ***************************************************************/
  addBtn.addEventListener('click', function (e) {
    e.preventDefault();

    // Increment the requirement count
    requirementCount++;
    const newReqId = `st1rq${requirementCount}`;
    const newBlock = document.createElement('div');
    newBlock.classList.add('requirement-block');
    newBlock.dataset.index = requirementCount;

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

    // Append the new block to the container
    requirementsContainer.appendChild(newBlock);

    // Fill product and distributor dropdowns for the new block
    const newProductSelect = newBlock.querySelector('.productFetch');
    const newDistributorSelect = newBlock.querySelector('.distributorFetch');

    if (newProductSelect) {
      fillOneProductSelect($(newProductSelect));
    }
    if (newDistributorSelect) {
      fillOneDistributorSelect($(newDistributorSelect));
    }
  });

  /***************************************************************
   * 6) Remove Requirement Button Handler
   ***************************************************************/
  requirementsContainer.addEventListener('click', function (e) {
    if (e.target.closest('.removeRequirement')) {
      e.preventDefault();
      const blockToRemove = e.target.closest('.requirement-block');
      if (blockToRemove) {
        blockToRemove.remove();
        renumberRequirements(); // Recalculate numbering after removal
        requirementCount = document.querySelectorAll('.requirement-block').length;
      }
    }
  });
});
