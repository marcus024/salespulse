document.addEventListener('DOMContentLoaded', function() {
  const requirementsContainer = document.getElementById('requirementsContainer');
  const addBtn = document.getElementById('addRequirementBtn');
  
  
  // Initialize the "Add New" logic for both product & distributor
  initProductChangeHandler();
  initDistributorChangeHandler();

   $.when( loadProducts(), loadDistributors() ).done(function() {
    // If needed, do something after both are loaded
  });

  // Function to calculate the highest block index dynamically
  function updateRequirementCount() {
    const allRequirements = requirementsContainer.querySelectorAll('input[name="requirement_id_1[]"]');
    let highestIndex = 0;

    allRequirements.forEach(input => {
      const value = input.value; // e.g., "st1rq3"
      const match = value.match(/st1rq(\d+)/); // Extract number after "st1rq"
      if (match) {
        const index = parseInt(match[1], 10); // Convert to integer
        highestIndex = Math.max(highestIndex, index); // Update the highest index
      }
    });

    // Update the initial requirement block (requirement1)
    const requirementTitle = document.getElementById('requirement1');
    const requirementHiddenInput = document.getElementById('req_1_id');

    if (requirementTitle && requirementHiddenInput) {
      const nextBlockIndex = highestIndex + 1;

      // Update the title and hidden input value
      requirementTitle.textContent = `Requirement ${nextBlockIndex}`;
      requirementHiddenInput.value = `st1rq${nextBlockIndex}`;
      console.log(`Updated initial requirement block to: Requirement ${nextBlockIndex} (st1rq${nextBlockIndex})`);
    } else {
      console.warn('Initial requirement block elements not found in the DOM.');
    }
  }


  // "Add" button to clone a new requirement block
  addBtn.addEventListener('click', function(e) {
    e.preventDefault();

    // Ensure requirementCount is up-to-date
    updateRequirementCount();

    // Get the next block index dynamically
    const allRequirements = requirementsContainer.querySelectorAll('input[name="requirement_id_1[]"]');
    let highestIndex = 0;

    allRequirements.forEach(input => {
      const value = input.value;
      const match = value.match(/st1rq(\d+)/);
      if (match) {
        const index = parseInt(match[1], 10);
        highestIndex = Math.max(highestIndex, index);
      }
    });

    const nextBlockIndex = highestIndex + 1;

    const newBlock = document.createElement('div');
    newBlock.classList.add('requirement-block');
    newBlock.dataset.index = nextBlockIndex;

    const newReqId = `st1rq${nextBlockIndex}`;

    newBlock.innerHTML = `
      <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
        Requirement ${nextBlockIndex}
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
     const newProductSelect = newBlock.querySelector('.productFetch');
    if (newProductSelect) {
      fillOneProductSelect($(newProductSelect));
    }

    // 2) Fill *this* new distributor select from cached array
    const newDistributorSelect = newBlock.querySelector('.distributorFetch');
    if (newDistributorSelect) {
      fillOneDistributorSelect($(newDistributorSelect));
    }
    // Update requirement count after adding
    updateRequirementCount();
  });



  // Delegate remove button functionality
  requirementsContainer.addEventListener('click', function(e) {
    if (e.target.closest('.removeRequirement')) {
      e.preventDefault();
      const blockToRemove = e.target.closest('.requirement-block');
      if (blockToRemove) {
        blockToRemove.remove();
        updateRequirementCount(); // Recalculate after removal
      }
    }
  });
});

