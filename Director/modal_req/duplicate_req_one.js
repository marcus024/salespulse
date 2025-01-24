document.addEventListener('DOMContentLoaded', function () {
  const requirementsContainer = document.getElementById('requirementsContainer');
  const addBtn = document.getElementById('addRequirementBtn');

  // Initialize the "Add New" logic for both product & distributor
  initProductChangeHandler();
  initDistributorChangeHandler();

  // Load products and distributors and cache them
  $.when(loadProducts(), loadDistributors()).done(function () {
    console.log("Products and distributors loaded.");
  });

  /**
   * Get the next available block index to avoid gaps in numbering
   * @returns {number} The next available block index
   */
  function getNextBlockIndex() {
    const allRequirements = requirementsContainer.querySelectorAll('input[name="requirement_id_1[]"]');
    const existingIndices = Array.from(allRequirements).map(input => {
      const value = input.value; // e.g., "st1rq3"
      const match = value.match(/st1rq(\d+)/); // Extract number after "st1rq"
      return match ? parseInt(match[1], 10) : null;
    }).filter(index => index !== null); // Filter out invalid values

    if (existingIndices.length === 0) {
      return 1; // Start with 1 if no requirements exist
    }

    // Sort indices and find the first missing number
    existingIndices.sort((a, b) => a - b);
    for (let i = 1; i <= existingIndices.length + 1; i++) {
      if (!existingIndices.includes(i)) {
        return i; // Return the first missing index
      }
    }
  }

  /**
   * Update the initial requirement block (requirement1)
   */
  function updateInitialRequirementBlock() {
    const requirementTitle = document.getElementById('requirement1');
    const requirementHiddenInput = document.getElementById('req_1_id');

    if (requirementTitle && requirementHiddenInput) {
      const nextBlockIndex = getNextBlockIndex();

      // Update the title and hidden input value
      requirementTitle.textContent = `Requirement ${nextBlockIndex}`;
      requirementHiddenInput.value = `st1rq${nextBlockIndex}`;
      console.log(`Updated initial requirement block to: Requirement ${nextBlockIndex} (st1rq${nextBlockIndex})`);
    } else {
      console.warn('Initial requirement block elements not found in the DOM.');
    }
  }

  // Run the initial update to synchronize the block index on page load
  updateInitialRequirementBlock();

  // "Add" button to clone a new requirement block
  addBtn.addEventListener('click', function (e) {
    e.preventDefault();

    // Get the next block index
    const nextBlockIndex = getNextBlockIndex();

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

    // Fill product and distributor selects for the new block
    const newProductSelect = newBlock.querySelector('.productFetch');
    if (newProductSelect) {
      fillOneProductSelect($(newProductSelect));
    }

    const newDistributorSelect = newBlock.querySelector('.distributorFetch');
    if (newDistributorSelect) {
      fillOneDistributorSelect($(newDistributorSelect));
    }

    // Update the initial requirement block after adding a new block
    updateInitialRequirementBlock();
  });

  // Delegate remove button functionality
  requirementsContainer.addEventListener('click', function (e) {
    if (e.target.closest('.removeRequirement')) {
      e.preventDefault();
      const blockToRemove = e.target.closest('.requirement-block');
      if (blockToRemove) {
        blockToRemove.remove();

        // Update the initial requirement block after removal
        updateInitialRequirementBlock();
      }
    }
  });
});
