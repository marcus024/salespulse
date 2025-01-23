document.addEventListener('DOMContentLoaded', function () {
  let requirementCount = 1; // Keeps track of the highest requirement number
  const requirementsContainer = document.getElementById('requirementsContainer');
  const addBtn = document.getElementById('addRequirementBtn');

  // Add New Requirement Button Logic
  addBtn.addEventListener('click', function (e) {
    e.preventDefault();

    // Increment the requirement count
    const newRequirementNumber = requirementCount + 1;
    requirementCount = newRequirementNumber;

    // Generate a new widget block
    const newWidget = createRequirementWidget(newRequirementNumber);

    // Append the new widget to the container
    requirementsContainer.appendChild(newWidget);
  });

  // Delegate Remove Button Logic
  requirementsContainer.addEventListener('click', function (e) {
    if (e.target.closest('.removeRequirement')) {
      e.preventDefault();
      const blockToRemove = e.target.closest('.requirement-block');
      if (blockToRemove) {
        blockToRemove.remove();
        renumberRequirements(); // Recalculate numbering for remaining widgets
      }
    }
  });

  /**
   * Creates a new Requirement Widget
   * @param {number} blockNumber - The requirement number to display in the widget
   * @returns {HTMLElement} - The new requirement widget element
   */
  function createRequirementWidget(blockNumber) {
    const newBlock = document.createElement('div');
    newBlock.classList.add('requirement-block', 'p-3', 'rounded', 'shadow-widget');
    newBlock.dataset.index = blockNumber;

    // Generate the block's HTML
    newBlock.innerHTML = `
      <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
        Requirement ${blockNumber}
      </p>
      <input type="hidden" name="requirement_id_1[]" value="st1rq${blockNumber}">
      
      <div class="row mb-3">
        <!-- Requirement Text -->
        <div class="col-md-4">
          <input name="requirement_one[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
        </div>
        <!-- Product Dropdown -->
        <div class="col-md-3">
          <select name="product_one[]" class="form-control custom-select productFetch">
            <option disabled selected>Select</option>
            <option value="add_new_product">+ Add New Product...</option>
          </select>
        </div>
        <!-- Distributor Dropdown -->
        <div class="col-md-3">
          <select name="distributor_one[]" class="form-control custom-select distributorFetch">
            <option disabled selected>Select</option>
            <option value="add_new">+ Add New Distributor...</option>
          </select>
        </div>
        <!-- Remove Button -->
        <div class="col-md-2 text-end">
          <button type="button" class="btn btn-danger btn-sm removeRequirement">
            <i class="fas fa-minus"></i> Remove
          </button>
        </div>
      </div>
    `;

    // Populate dropdowns for products and distributors
    const productSelect = newBlock.querySelector('.productFetch');
    const distributorSelect = newBlock.querySelector('.distributorFetch');
    if (productSelect) fillOneProductSelect($(productSelect));
    if (distributorSelect) fillOneDistributorSelect($(distributorSelect));

    return newBlock;
  }

  /**
   * Renumber existing widgets after a removal
   */
  function renumberRequirements() {
    const blocks = requirementsContainer.querySelectorAll('.requirement-block');
    blocks.forEach((block, index) => {
      const newNumber = index + 1; // Sequential numbering starts from 1
      const title = block.querySelector('p');
      const hiddenInput = block.querySelector('input[name="requirement_id_1[]"]');

      if (title) title.textContent = `Requirement ${newNumber}`;
      if (hiddenInput) hiddenInput.value = `st1rq${newNumber}`;
    });

    // Update the requirementCount to match the current number of blocks
    requirementCount = blocks.length;
  }
});
