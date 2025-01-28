document.addEventListener('DOMContentLoaded', function () {
    const requirementsContainer = document.getElementById('requirementthreeContainer');
    const addBtn = document.getElementById('addRequirement3Btn');

    // Initialize the "Add New" logic for both product & distributor (if needed)
    initProductChangeHandler();
    initDistributorChangeHandler();

    /**
     * Calculate the highest block index dynamically from the current requirements
     * @returns {number} The next block index
     */
    function getNextBlockIndex() {
        const allRequirements = requirementsContainer.querySelectorAll('input[name="requirement_id_3[]"]');
        const indices = Array.from(allRequirements).map(input => {
            const value = input.value; // e.g., "st3req3"
            const match = value.match(/st3req(\d+)/); // Extract number after "st3req"
            return match ? parseInt(match[1], 10) : 0; // Convert to integer or default to 0
        });

        // Return the next available block index
        return indices.length > 0 ? Math.max(...indices) + 1 : 1;
    }

    /**
     * Update the initial requirement block (requirementstagethree)
     * to match the correct numbering dynamically
     */
    function updateInitialRequirementBlock() {
        const requirementTitle = document.getElementById('requirementstagethree');
        const requirementHiddenInput = document.getElementById('req_3_id');

        if (requirementTitle && requirementHiddenInput) {
            const currentIndex = requirementHiddenInput.value.match(/st3req(\d+)/)?.[1] || 1;

            // Ensure the title and hidden input value match
            requirementTitle.textContent = `Requirement ${currentIndex}`;
            requirementHiddenInput.value = `st3req${currentIndex}`;
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
        newBlock.classList.add('requirementthree-block');
        newBlock.dataset.index = nextBlockIndex;

        const newReqId = `st3req${nextBlockIndex}`;

        newBlock.innerHTML = `
            <p class="text-center  mb-1" style="font-style:'Poppins'; font-weight:bold;">
                Requirement ${nextBlockIndex}
            </p>
            <input type="hidden" name="requirement_id_3[]" value="${newReqId}">
            <div class="row mb-1">
                <div class="col-md-4">
                    <label for="requirement" class="form-label ">Requirement</label>
                </div>
                <div class="col-md-3">
                    <label for="product" class="form-label ">Product</label>
                </div>
                <div class="col-md-3">
                    <label for="distributor" class="form-label ">Distributor</label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <input name="requirement_three[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                </div>
                <div class="col-md-3">
                    <select name="product_three[]" class="form-control custom-select productFetch">
                        <option disabled selected>Select</option>
                        <option value="add_new_product">+ Add New Product...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="distributor_three[]" class="form-control custom-select distributorFetch">
                        <option disabled selected>Select</option>
                        <option value="add_new">+ Add New Distributor...</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button"
                            class="btn btn-danger btn-sm removeRequirementThree"
                            style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;">
                        <i class="fas fa-minus"></i>&nbsp;Remove
                    </button>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-md-3">
                    <label for="requirement" class="form-label ">Quantity</label>
                </div>
                <div class="col-md-2">
                    <label for="requirement" class="form-label ">Pricing</label>
                </div>
                <div class="col-md-2">
                    <label for="requirement" class="form-label ">Date</label>
                </div>
                <div class="col-md-3">
                    <label for="requirement" class="form-label ">Remarks</label>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-3">
                    <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50">
                </div>
                <div class="col-md-2">
                    <input name="pricing[]" type="number" class="form-control" placeholder="e.g. 5000">
                </div>
                <div class="col-md-2">
                    <input name="requirement_date[]" type="date" id="reqdate3" class="form-control" style="font-size:10px;">
                </div>
                <div class="col-md-4">
                    <input name="requirement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
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
        if (e.target.closest('.removeRequirementThree')) {
            e.preventDefault();
            const blockToRemove = e.target.closest('.requirementthree-block');
            if (blockToRemove) {
                blockToRemove.remove();
                console.log('Removed a requirement block.');
            }
        }
    });
});
