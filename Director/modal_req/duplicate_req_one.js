
document.addEventListener('DOMContentLoaded', function() {
  /***************************************************************
   * 1) Parse existing requirement_id_1[] to find max "st1rqX"
   ***************************************************************/
   // Function to get the highest "st1rqX" value
    function getMaxSt1rq() {
      let maxNum = 0;
      const inputs = document.querySelectorAll('input[name="requirement_id_1[]"]');
      inputs.forEach(input => {
        const match = input.value.match(/st1rq(\d+)/);
        if (match) {
          maxNum = Math.max(maxNum, parseInt(match[1], 10));
        }
      });
      return maxNum;
    }

  /***************************************************************
   * 2) Determine the initial block's ID
   ***************************************************************/
  let requirementCount = Math.max(getMaxSt1rq(), 1);
  
  // Find the largest existing ID
  const maxFound = getMaxSt1rq();
  // If we found none, remain 1, else set to that max
  if (maxFound > 0) {
    requirementCount = maxFound;
  }

  console.log("Initial requirementCount set to:", requirementCount);

  /***************************************************************
   * 3) Update the initial block (the #requirementTitle and hidden input)
   ***************************************************************/
  const titleEl = document.getElementById('requirementTitle');
  if (titleEl) {
    titleEl.textContent = `Requirement ${requirementCount}`;
  }

  // The initial block's hidden input that you showed in your snippet
  // e.g. <input type="hidden" name="requirement_id_1[]" value="st1rq1">
  // We'll rename it to st1rqN if the largest found was N
  const initialInput = document.querySelector('#requirementsContainer input[name="requirement_id_1[]"]');
  if (initialInput) {
    const newVal = 'st1rq' + requirementCount;
    initialInput.value = newVal; 
    console.log("Set the initial hidden input to:", newVal);
  }

  /***************************************************************
   * 4) Reference to container & "Add" button
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
   * 5) Initialize your product/distributor logic
   ***************************************************************/
  initProductChangeHandler();
  initDistributorChangeHandler();

  // Load the cached arrays so the selects can be populated
  $.when(loadProducts(), loadDistributors()).done(function() {
    console.log("Products & Distributors loaded.");
    // If you want to fill the existing block's product/distributor:
    fillOneProductSelect($('#productSelect'));
    fillOneDistributorSelect($('#distributorSelect'));
  });

  /***************************************************************
   * 6) "Add" button => create new block with next st1rq
   ***************************************************************/
  addBtn.addEventListener('click', function(e) {
    e.preventDefault();

    // Next ID
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

    // Append new block
    requirementsContainer.appendChild(newBlock);

    // Fill product/distributor in the newly created block
    const newProductSelect = newBlock.querySelector('.productFetch');
    if (newProductSelect) {
      fillOneProductSelect($(newProductSelect));
    }
    const newDistributorSelect = newBlock.querySelector('.distributorFetch');
    if (newDistributorSelect) {
      fillOneDistributorSelect($(newDistributorSelect));
    }
  });

  /***************************************************************
   * 7) Remove button (delegated)
   ***************************************************************/
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
