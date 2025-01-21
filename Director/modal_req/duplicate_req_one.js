
document.addEventListener('DOMContentLoaded', function() {
    // Start at 1 because the first block is "Requirement 1"
    let requirementCount = 1;

    // The container that holds all blocks
    const requirementsContainer = document.getElementById('requirementsContainer');

    // The "Add" button in the first block
    const addBtn = document.getElementById('addRequirement1');

    // 1. ADD functionality
    addBtn.addEventListener('click', function(e) {
        e.preventDefault();

        // Increment the counter
        requirementCount++;

        // Create a new DIV for the next requirement
        const newBlock = document.createElement('div');
        newBlock.classList.add('requirement-block');
        newBlock.dataset.index = requirementCount;

        // Fill in the HTML, including new "Requirement X" title
        // Note that we've removed 'id' attributes (like #addRequirement1) 
        // to avoid duplicates. 
        newBlock.innerHTML = `
            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
                Requirement ${requirementCount}
            </p>

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
                <div class="col-md-2">
                    <!-- We do NOT include another "Add" button here 
                         because we only want one global add button. 
                         If you want each block to have its own Add, 
                         you can copy that markup. -->
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <input name="requirement_one[]" style="width: 100%;" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                </div>
                <div class="col-md-3">
                    <select name="product_one[]" class="form-control custom-select">
                        <option disabled selected>Select</option>
                        <option value="add_new_product">+ Add New Product...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="distributor_one[]" class="form-control custom-select">
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
    });

    // 2. REMOVE functionality
    // We'll use event delegation so any .removeRequirement button 
    // in the container will work (even for newly added blocks).
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
