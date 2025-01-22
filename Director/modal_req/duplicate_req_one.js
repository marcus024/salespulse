
document.addEventListener('DOMContentLoaded', function() {
    // Start at 1 because the initial block is "Requirement 1" / st1rq1
    let requirementCount = 1;

    // Container that holds all blocks
    const requirementsContainer = document.getElementById('requirementsContainer');

    // "Add" button in the first block
    const addBtn = document.getElementById('addRequirementBtn');

    // ADD functionality
    addBtn.addEventListener('click', function(e) {
        e.preventDefault();

        // Increment the counter
        requirementCount++;

        // Create a new DIV
        const newBlock = document.createElement('div');
        newBlock.classList.add('requirement-block');
        newBlock.dataset.index = requirementCount;

        // Build the "st1rqX" format for the hidden ID
        const newReqId = 'st1rq' + requirementCount;

        newBlock.innerHTML = `
            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
                Requirement ${requirementCount}
            </p>
            <!-- Unique hidden ID field -->
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
                <div class="col-md-2">
                    <!-- We only keep one Add button in the first block, 
                         so no Add button here. 
                         If you want each row to have an Add, 
                         you can replicate it. -->
                </div>
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
                    <select name="product_one[]" class="form-control custom-select" id="productSelect">
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
    });

    // REMOVE functionality with event delegation
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
