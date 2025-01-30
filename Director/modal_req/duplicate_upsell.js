document.addEventListener('DOMContentLoaded', function () {
    const upsellContainer = document.getElementById('upsellContainer');
    const addBtn = document.getElementById('addUpsellBtn'); // Add button inside the upsell block

    /**
     * Calculate the next upsell block index dynamically
     * @returns {number} The next upsell block index
     */
    function getNextUpsellBlockIndex() {
        const allUpsellBlocks = upsellContainer.querySelectorAll('input[name="upsell_stage_5[]"]');
        const indices = Array.from(allUpsellBlocks).map(input => {
            const value = input.value; // e.g., "upsell1"
            const match = value.match(/upsell(\d+)/); // Extract number after "upsell"
            return match ? parseInt(match[1], 10) : 0; // Convert to integer or default to 0
        });

        // Return the next available block index
        return indices.length > 0 ? Math.max(...indices) + 1 : 1;
    }

    /**
     * "Add" button click handler to create a new upsell block
     */
    addBtn.addEventListener('click', function (e) {
        e.preventDefault();

        // Get the next upsell block index
        const nextBlockIndex = getNextUpsellBlockIndex();

        const newBlock = document.createElement('div');
        newBlock.classList.add('upsell-block');
        newBlock.dataset.index = nextBlockIndex;

        const newUpsellId = `upsell${nextBlockIndex}`;

        newBlock.innerHTML = `
            <p class="text-center  mb-1" style="font-style:'Poppins'; font-weight:bold; color:white;" id="upsellCon ">
                Upsell ${nextBlockIndex}
            </p>
            <input type="hidden" name="upsell_stage_5[]" value="${newUpsellId}" id="upsell_id">
            <div class="row mb-1">
                <div class="col-md-2">
                    <label for="requirement" class="form-label ">Upsell</label>
                </div>
                <div class="col-md-2">
                    <label for="quantity" class="form-label ">Quantity</label>
                </div>
                <div class="col-md-2">
                    <label for="amount" class="form-label ">Amount</label>
                </div>
                <div class="col-md-3">
                    <label for="remarks" class="form-label ">Remarks</label>
                </div>
            </div>
            <div class="row mb-3 upsell-fields">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="upsell[]" placeholder="e.g Router 2000">
                </div>
                <div class="col-md-2">
                    <input name="quantity_upsell[]" type="number" class="form-control" placeholder="e.g 50">
                </div>
                <div class="col-md-2">
                    <input name="amount_upsell[]" type="number" class="form-control" placeholder="e.g. 6000">
                </div>
                <div class="col-md-3">
                    <input name="remarks_upsell[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm removeUpsellRow" style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;">
                        <i class="fas fa-minus"></i>&nbsp;Remove
                    </button>
                </div>
            </div>
        `;

        // Append the new upsell block to the container
        upsellContainer.appendChild(newBlock);

        console.log(`Added new upsell block: Upsell ${nextBlockIndex}`);
    });

    // Delegate remove button functionality
    upsellContainer.addEventListener('click', function (e) {
        if (e.target.closest('.removeUpsellRow')) {
            e.preventDefault();
            const blockToRemove = e.target.closest('.upsell-block');
            if (blockToRemove) {
                blockToRemove.remove();
                console.log('Removed an upsell block.');
            }
        }
    });
});
