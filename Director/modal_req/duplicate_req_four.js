document.addEventListener('DOMContentLoaded', function () {
    const requirementsContainer = document.getElementById('requirementfourContainer');

    /**
     * Calculate the highest block index dynamically from the current requirements
     * @returns {number} The next block index
     */
    function getNextBlockIndex() {
        const allRequirements = requirementsContainer.querySelectorAll('input[name="requirement_id_4[]"]');
        const indices = Array.from(allRequirements).map(input => {
            const value = input.value; // e.g., "st4req3"
            const match = value.match(/st4req(\d+)/); // Extract number after "st4req"
            return match ? parseInt(match[1], 10) : 0; // Convert to integer or default to 0
        });

        // Return the next available block index
        return indices.length > 0 ? Math.max(...indices) + 1 : 1;
    }

    /**
     * Update the initial requirement block (requirementstagefour)
     * to match the correct numbering dynamically
     */
    function updateInitialRequirementBlock() {
        const requirementTitle = document.getElementById('requirementstagefour');
        const requirementHiddenInput = document.getElementById('req_4_id');

        if (requirementTitle && requirementHiddenInput) {
            const currentIndex = requirementHiddenInput.value.match(/st4req(\d+)/)?.[1] || 1;

            // Ensure the title and hidden input value match
            requirementTitle.textContent = `Requirement ${currentIndex}`;
            requirementHiddenInput.value = `st4req${currentIndex}`;
        } else {
            console.warn('Initial requirement block elements not found in the DOM.');
        }
    }

    // Run the initial update to synchronize the block index on page load
    updateInitialRequirementBlock();

    // Function to remove a Stage Four requirement block
    requirementsContainer.addEventListener('click', function (e) {
        if (e.target.closest('.removeRequirementFour')) {
            e.preventDefault();
            const blockToRemove = e.target.closest('.requirementfour-block');
            if (blockToRemove) {
                blockToRemove.remove();
                console.log('Removed a requirement block.');
            }
        }
    });

    /**
     * Create a new requirement block dynamically for Stage Four
     * @param {number} blockIndex - The index of the new block
     */
    function createRequirementFourBlock(blockIndex) {
        const newReqId = `st4req${blockIndex}`;
        const newBlock = document.createElement('div');
        newBlock.classList.add('requirementfour-block', 'p-2', 'rounded', 'shadow-widget');
        newBlock.dataset.index = blockIndex;

        newBlock.innerHTML = `
            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
                Requirement ${blockIndex}
            </p>
            <input type="hidden" name="requirement_id_4[]" value="${newReqId}">
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
                    <input name="requirement_four[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                </div>
                <div class="col-md-3">
                    <select name="product_four[]" class="form-control custom-select productFetch">
                        <option disabled selected>Select</option>
                        <option value="add_new_product">+ Add New Product...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="distributor_four[]" class="form-control custom-select distributorFetch">
                        <option disabled selected>Select</option>
                        <option value="add_new">+ Add New Distributor...</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button"
                            class="btn btn-danger btn-sm removeRequirementFour"
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
                    <input name="requirement_remarks_four[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                </div>
            </div>
        `;

        return newBlock;
    }
});
