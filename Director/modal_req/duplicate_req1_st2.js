document.addEventListener('DOMContentLoaded', function () {
  const requirementsContainer = document.getElementById('requirementtwoContainer');
  const addBtn = document.getElementById('addRequirement2Btn');

  /**
   * Calculate the highest block index dynamically from the current requirements
   * @returns {number} The next block index
   */
  function getNextBlockIndex() {
    const allRequirements = requirementsContainer.querySelectorAll('input[name="requirement_id_2[]"]');
    let highestIndex = 0;

    allRequirements.forEach(input => {
      const value = input.value; // e.g., "st2rq3"
      const match = value.match(/st2rq(\d+)/); // Extract the number after "st2rq"
      if (match) {
        const index = parseInt(match[1], 10); // Convert to integer
        highestIndex = Math.max(highestIndex, index); // Update the highest index
      }
    });

    return highestIndex + 1; // Return the next available block index
  }

  /**
   * Update the initial requirement block dynamically
   */
  function updateInitialRequirementBlock() {
    const initialRequirementTitle = document.getElementById('requirementstagetwo');
    const initialHiddenInput = document.getElementById('rq_1_id');

    if (initialRequirementTitle && initialHiddenInput) {
      const nextBlockIndex = getNextBlockIndex();

      // Update the title and hidden input value
      initialRequirementTitle.textContent = `Requirement ${nextBlockIndex}`;
      initialHiddenInput.value = `st2rq${nextBlockIndex}`;
      console.log(`Updated initial requirement block to: Requirement ${nextBlockIndex} (st2rq${nextBlockIndex})`);
    } else {
      console.warn('Initial requirement block elements not found in the DOM.');
    }
  }

  // Initial update for the requirement block
  updateInitialRequirementBlock();

  // "Add" button to clone a new requirement block
  addBtn.addEventListener('click', function (e) {
    e.preventDefault();

    // Get the next block index
    const nextBlockIndex = getNextBlockIndex();

    const newBlock = document.createElement('div');
    newBlock.classList.add('requirementtwo-block');
    newBlock.dataset.index = nextBlockIndex;

    const newReqId = `st2rq${nextBlockIndex}`;

    newBlock.innerHTML = `
      <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
        Requirement ${nextBlockIndex}
      </p>
      <input type="hidden" name="requirement_id_2[]" value="${newReqId}">
      <div class="row mb-3">
        <div class="col-md-2">
          <input name="requirement_two[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
        </div>
        <div class="col-md-2">
          <select name="product_two[]" class="form-control custom-select productFetch">
            <option disabled selected>Select</option>
            <option value="add_new_product">+ Add New Product...</option>
          </select>
        </div>
        <div class="col-md-2">
          <select name="distributor_two[]" class="form-control custom-select distributorFetch">
            <option disabled selected>Select</option>
            <option value="add_new">+ Add New Distributor...</option>
          </select>
        </div>
        <div class="col-md-2">
          <input name="requirement_date[]" type="date" class="form-control" style="font-size:10px;">
        </div>
        <div class="col-md-2">
          <input name="requirement_remarks[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
        </div>
        <div class="col-md-2">
          <button type="button"
                  class="btn btn-danger btn-sm removeRequirement2"
                  style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;">
            <i class="fas fa-minus"></i>&nbsp;Remove
          </button>
        </div>
      </div>
    `;

    // Append the new block
    requirementsContainer.appendChild(newBlock);

    // Update the initial block after adding a new one
    updateInitialRequirementBlock();
  });

  // Delegate remove button functionality
  requirementsContainer.addEventListener('click', function (e) {
    if (e.target.closest('.removeRequirement2')) {
      e.preventDefault();
      const blockToRemove = e.target.closest('.requirementtwo-block');
      if (blockToRemove) {
        blockToRemove.remove();

        // Update the initial block after removing one
        updateInitialRequirementBlock();
      }
    }
  });
});
