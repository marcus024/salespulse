document.addEventListener('DOMContentLoaded', function () {
    const requirementsContainer = document.getElementById('requirementfiveContainer');
    const addBtn = document.getElementById('addRequirement5Btn');

    // Initialize the "Add New" logic for both product & distributor (if needed)
    initProductChangeHandler();
    initDistributorChangeHandler();

    /**
     * Calculate the highest block index dynamically from the current requirements
     * @returns {number} The next block index
     */
    function getNextBlockIndex() {
        const allRequirements = requirementsContainer.querySelectorAll('input[name="requirement_id_5[]"]');
        const indices = Array.from(allRequirements).map(input => {
            const value = input.value; // e.g., "st5req3"
            const match = value.match(/st5req(\d+)/); // Extract number after "st5req"
            return match ? parseInt(match[1], 10) : 0; // Convert to integer or default to 0
        });

        // Return the next available block index
        return indices.length > 0 ? Math.max(...indices) + 1 : 1;
    }

    /**
     * Update the initial requirement block (requirementstagefive)
     * to match the correct numbering dynamically
     */
    function updateInitialRequirementBlock() {
        const requirementTitle = document.getElementById('requirementstagefive');
        const requirementHiddenInput = document.getElementById('req_5_id');

        if (requirementTitle && requirementHiddenInput) {
            const currentIndex = requirementHiddenInput.value.match(/st5req(\d+)/)?.[1] || 1;

            // Ensure the title and hidden input value match
            requirementTitle.textContent = `Requirement ${currentIndex}`;
            requirementHiddenInput.value = `st5req${currentIndex}`;
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
        newBlock.classList.add('requirementfive-block');
        newBlock.dataset.index = nextBlockIndex;

        const newReqId = `st5req${nextBlockIndex}`;

        newBlock.innerHTML = `
            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
                Requirement ${nextBlockIndex}
            </p>
            <input type="hidden" name="requirement_id_5[]" value="${newReqId}">
            <div class="row mb-1">
                <div class="col-md-4">
                    <label for="requirement" class="form-label text-white">Requirement</label>
                </div>
                <div class="col-md-3">
                    <label for="product" class="form-label text-white">Product</label>
                </div>
                <div class="col-md-3">
                    <label for="distributor" class="form-label text-white">Distributor</label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <input name="req_five[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                </div>
                <div class="col-md-3">
                    <select name="product_five[]" class="form-control custom-select productFetch">
                        <option disabled selected>Select</option>
                        <option value="add_new_product">+ Add New Product...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="distributor_five[]" class="form-control custom-select distributorFetch">
                        <option disabled selected>Select</option>
                        <option value="add_new">+ Add New Distributor...</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button"
                            class="btn btn-danger btn-sm removeRequirementFive"
                            style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;">
                        <i class="fas fa-minus"></i>&nbsp;Remove
                    </button>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-md-3">
                    <label for="requirement" class="form-label text-white">Quantity</label>
                </div>
                <div class="col-md-2">
                    <label for="requirement" class="form-label text-white">Pricing</label>
                </div>
                <div class="col-md-2">
                    <label for="requirement" class="form-label text-white">Date Required</label>
                </div>
                <div class="col-md-4">
                    <label for="requirement" class="form-label text-white">Remarks</label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50">
                </div>
                <div class="col-md-2">
                    <input name="pricing[]" type="number" class="form-control" placeholder="e.g. 2000">
                </div>
                <div class="col-md-2">
                    <input name="date_required[]" type="date" class="form-control" style="font-size:10px;">
                </div>
                <div class="col-md-4">
                    <input name="remarks_req[]" type="text" class="form-control" placeholder="e.g. Sample Requirement Remarks">
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

        console.log(`Added new block: Requirement ${nextBlockIndex}`);
    });

    // Delegate remove button functionality
    requirementsContainer.addEventListener('click', function (e) {
        if (e.target.closest('.removeRequirementFive')) {
            e.preventDefault();
            const blockToRemove = e.target.closest('.requirementfive-block');
            if (blockToRemove) {
                blockToRemove.remove();
                console.log('Removed a requirement block.');
            }
        }
    });
});
