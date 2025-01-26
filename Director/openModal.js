    async function openModal(projectId) {
        console.log("Received Project ID:", projectId);
        if (!projectId) {
            console.error("No project ID provided.");
            return;
        }
        
        document.getElementById('project-id-placeholder').textContent = projectId;
        const projectIdPlaceholder = document.getElementById('project-id-placeholder');
        if (projectIdPlaceholder) {
            projectIdPlaceholder.textContent = projectId;
        } else {
            console.error("Element #project-id-placeholder not found.");
        }
        updateProjectIdDisplay(projectId);
        fetch(`./dirback/openModaldata.php?project_id=${projectId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP Error: ${response.status}`);
                }

                return response.json();
                
            })
            .then(data => {
                if (data.status === 'success') {

                    document.getElementById('project-unique-id').value = data.project_id || 'No Data';
                    document.getElementById('client-name').textContent = data.company_name || 'No Data';

                    //Navigate to the current stage
                    const currentStage = data.current_stage;
                    if (currentStage) {
                        const stageNumber = parseInt(currentStage.split(' ')[1]); 
                        currentStep = stageNumber;
                        markCompletedSteps(stageNumber); 
                        showStep(stageNumber); 
                         if (stageNumber === 1) {
                            fetchStageOne(data,projectId);
                        } else if (stageNumber === 2) {
                            fetchStageTwo(data,projectId);
                        } else if (stageNumber === 3) {
                            fetchStageThree(data,projectId);
                        } else if (stageNumber === 4) {
                            fetchStageFour(data,projectId);
                        } else if (stageNumber === 5) {
                            // fetchStageFour(data,projectId);
                            fetchStageFive(data,projectId);
                        }
                    } else {
                        console.warn("No current stage data found.");
                    }
                } else {
                    console.error('Error:', data.message);
                    console.error('API Error:', data.message);
                    alert('No data: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                alert('Project ID is Missing');
            });
    }

    // Function to mark completed steps
    function markCompletedSteps(currentStep) {
        document.querySelectorAll('.step-circle').forEach((circle, index) => {
            const stepNumber = index + 1; 
            if (stepNumber < currentStep) {
                circle.classList.add('completed');
                circle.textContent = '✔';
            } else {
                circle.classList.remove('completed');
                circle.textContent = stepNumber.toString();
            }
        });
    }

    // Function to show a specific step
    function showStep(stepNumber) {
        document.querySelectorAll('.form-step').forEach(step => step.classList.add('d-none'));
        document.querySelectorAll('.step-circle').forEach(circle => circle.classList.remove('active'));
        const stepToShow = document.getElementById(`step${stepNumber}`);
        const circleToActivate = document.getElementById(`step${stepNumber}-circle`);

        if (stepToShow) stepToShow.classList.remove('d-none');
        if (circleToActivate) circleToActivate.classList.add('active');
    }

    // Function to update the project ID in all steps
    function updateProjectIdDisplay(projectId) {
        document.querySelectorAll('.project-id-dis span').forEach(el => {
            el.textContent = projectId || "[Project ID]";
        });
    }

    function fetchStageOne(data,projectId) {
    // Basic Stage One fields
    document.getElementById('start-date-placeholder').value = data.stages.stage_one.start_date || 'No Data';
    document.getElementById('end-date-placeholder').value = data.stages.stage_one.end_date || 'No Data';
    document.getElementById('status-placeholder').value = data.stages.stage_one.status || 'No Data';
    document.getElementById('solution1').value = data.stages.stage_one.solution || 'No Data';
    document.getElementById('dealSize1').value = data.stages.stage_one.deal_size || 'No Data';
    document.getElementById('stageremarks1').value = data.stages.stage_one.remarks || 'No Data';

    // Fetch Technology Select
    const technology1 = document.getElementById('technologySelect');
    const techValue = data.stages.stage_one.technology || 'Select';
    if (technology1) {
        Array.from(technology1.options).forEach(option => {
        option.selected = option.value === techValue;
        });
    }

    // Step 1: Fetch the product and distributor lists using Promise.all
    let productList = [];
    let distributorList = [];

    Promise.all([loadProducts(), loadDistributors()])
        .then(([products, distributors]) => {
        productList = products; // Store fetched product list
        distributorList = distributors; // Store fetched distributor list

        console.log("Products and Distributors fetched successfully.");
        console.log("Product List:", productList);
        console.log("Distributor List:", distributorList);

        // Step 2: Fetch requirements array
        const requirements = (data.stages.stage_one && data.stages.stage_one.requirements) || [];

        // Step 3: Get the container for requirements
        const requirementsContainer = document.getElementById('requirementsContainer');
        if (!requirementsContainer) {
            console.error('#requirementsContainer not found in DOM!');
            return;
        }

        // Step 4: Populate requirements dynamically
        let highestBlockIndex = 0;

        if (requirements.length > 0) {
            requirements.forEach((reqItem, index) => {
            const blockIndex = index + 1;
            highestBlockIndex = Math.max(highestBlockIndex, blockIndex);
            const newBlock = createRequirementBlock(blockIndex, reqItem, productList, distributorList, projectId);
            requirementsContainer.appendChild(newBlock);
            });
        }

        // Calculate the next block index for the existing initial field
        const nextBlockIndex = highestBlockIndex + 1;

        // Update the existing initial requirement field dynamically
        const initialRequirementTitle = document.getElementById('requirement1');
        const initialHiddenInput = document.getElementById('req_1_id');

        if (initialRequirementTitle && initialHiddenInput) {
            initialRequirementTitle.textContent = `Requirement ${nextBlockIndex}`;
            initialHiddenInput.value = `st1rq${nextBlockIndex}`;
        } else {
            console.warn("Initial requirement field not found in the DOM.");
        }

        console.log('Stage One + requirements populated:', requirements);
        })
        .catch(error => {
        console.error("Error fetching Products or Distributors:", error);
        });
    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    function createRequirementBlock(blockIndex, reqItem, productList=[], distributorList=[],projectId) {
        const requirementId = reqItem.requirement_id_1 || `st1rq${blockIndex}`;
        const requirementText = reqItem.requirement_one || '';
        const selectedProduct = reqItem.product_one || '';
        const selectedDistributor = reqItem.distributor_one || '';

        console.log(`Creating Requirement Block ${blockIndex}`);
        console.log('Product List:', productList);
        console.log('Distributor List:', distributorList);
        console.log('Product Selected:', selectedProduct);
        console.log('Distributor Selected:', selectedDistributor);

        // Ensure productList and distributorList are arrays
        if (!Array.isArray(productList)) {
            console.warn('Invalid product list format, defaulting to empty array.');
            productList = [];
        }

        if (!Array.isArray(distributorList)) {
            console.warn('Invalid distributor list format, defaulting to empty array.');
            distributorList = [];
        }

        const newBlock = document.createElement('div');
        newBlock.classList.add('requirement-block', 'p-2', 'rounded', 'shadow-widget');
        newBlock.dataset.index = blockIndex;

        // Populate the block content
        newBlock.innerHTML = `
            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="req_1_id">
            Requirement ${blockIndex}
            </p>
            <input type="hidden" name="requirement_id_1[]" value="${requirementId}" id="req_1_id">
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
                <input name="requirement_one[]" type="text" class="form-control" placeholder="e.g. Sample Requirement" value="${requirementText}">
            </div>
            <div class="col-md-3">
                <select name="product_one[]" class="form-control custom-select productFetch" onchange="console.log('Selected Product:', this.value)">
                    <option disabled ${!selectedProduct ? 'selected' : ''}>Select</option>
                    ${productList.map(product => `
                        <option value="${escapeHtml(product)}" ${product.trim().toLowerCase() === selectedProduct.trim().toLowerCase() ? 'selected' : ''}>
                            ${escapeHtml(product)}
                        </option>
                    `).join('')}
                    ${!productList.some(product => product.trim().toLowerCase() === selectedProduct.trim().toLowerCase()) && selectedProduct
                        ? `<option value="${escapeHtml(selectedProduct)}" selected>${escapeHtml(selectedProduct)}</option>`
                        : ''}
                    <option value="add_new_product">+ Add New Product...</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="distributor_one[]" class="form-control custom-select distributorFetch">
                    <option disabled ${!selectedDistributor ? 'selected' : ''}>Select</option>
                    ${distributorList.map(distributor => `
                        <option value="${escapeHtml(distributor)}" ${distributor.trim().toLowerCase() === selectedDistributor.trim().toLowerCase() ? 'selected' : ''}>
                        ${escapeHtml(distributor)}
                        </option>
                    `).join('')}
                    ${!distributorList.some(distributor => distributor.trim().toLowerCase() === selectedDistributor.trim().toLowerCase()) && selectedDistributor
                        ? `<option value="${escapeHtml(selectedDistributor)}" selected>${escapeHtml(selectedDistributor)}</option>`
                        : ''}
                    <option value="add_new">+ Add New Distributor...</option>
                </select>
            </div>
                <div class="col-md-2">
                    <button type="button"
                            class="btn btn-danger btn-sm"
                            style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                            onclick="deleteRequirement('${requirementId}', this,'${projectId}')">
                    <i class="fas fa-minus"></i>&nbsp;Remove
                    </button>
                </div>
            </div>
        `;

        return newBlock;
    }

    // Function to delete a requirement
    function deleteRequirement(requirementId, button, projectId) {
        if (!confirm('Are you sure you want to delete this requirement?')) {
            return;
        }
        const requirementBlock = button.closest('.requirement-block');

        // Send delete request to the backend
        fetch('./dirback/delete_req1.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ requirementId, project_id: projectId }),
        })
        .then(response => {
        if (!response.ok) {
            throw new Error('Failed to delete requirement.');
        }
        return response.json();
        })
        .then(data => { 
            requirementBlock.remove();
            console.log('Requirement deleted successfully:', data);
        })
        .catch(error => {
            console.error('Error deleting requirement:', error);
        });
    }


    //Fetch Stage Two
    function fetchStageTwo(data,projectId){
        document.getElementById('stage-two-start').value = data.stages.stage_two.start_date || 'No Data';
        document.getElementById('stage-two-end').value = data.stages.stage_two.end_date ||  'No Data';
        document.getElementById('stage-two-status').value = data.stages.stage_two.status ||  'No Data';
        document.getElementById('solution2').value = data.stages.stage_two.solution_two || data.stages.stage_one.solution || 'No Data';
        document.getElementById('deal_size2').value = Number(data.stages.stage_two.deal_size_two) || Number(data.stages.stage_one.deal_size) || 'No Data';
        document.getElementById('stageremarks2').value = data.stages.stage_two.remarks_two || data.stages.stage_one.remarks || 'No Data';

        // Fetch Technology Select
        const technology2 = document.getElementById('technologySelect2');
        const techValue = data.stages.stage_two.technology_two || data.stages.stage_one.technology || 'Select';
        if (technology2) {
            Array.from(technology2.options).forEach(option => {
            option.selected = option.value === techValue;
            });
        }

        // Step 1: Fetch engagement array
        const engagements = (data.stages.stage_two && data.stages.stage_two.engagement_stage_two) || [];
        const engagementContainer = document.getElementById('engagement1Container');

        if (!engagementContainer) {
            console.error('#engagement1Container not found in DOM!');
            return;
        }

        // Step 2: Populate engagements dynamically
        let highestBlockIndex = 0;

        if (engagements.length > 0) {
            engagements.forEach((engagementItem, index) => {
            const blockIndex = index + 1;
            highestBlockIndex = Math.max(highestBlockIndex, blockIndex);

            const newEngagementBlock = createEngagementBlock(blockIndex, engagementItem, projectId);
            engagementContainer.appendChild(newEngagementBlock);
            });
        }

        // Step 3: Update the existing initial engagement field dynamically
        const nextBlockIndex = highestBlockIndex + 1;
        const initialEngagementTitle = document.getElementById('engagement1');
        const initialHiddenInput = document.getElementById('eng_1_id');

        if (initialEngagementTitle && initialHiddenInput) {
            initialEngagementTitle.textContent = `Engagement ${nextBlockIndex}`;
            initialHiddenInput.value = `st2eng${nextBlockIndex}`;
        } else {
            console.warn('Initial engagement field not found in the DOM.');
        }

        console.log('Stage Two + engagements populated:', engagements);
        

        //Fetching of Requirement Stage Two
        // Fetch product and distributor lists
        let productList = [];
        let distributorList = [];

        Promise.all([loadProducts(), loadDistributors()])
            .then(([products, distributors]) => {
            productList = products;
            distributorList = distributors;

            console.log("Products and Distributors fetched successfully for Stage Two.");
            console.log("Product List:", productList);
            console.log("Distributor List:", distributorList);

            // Step 2: Fetch requirements array for Stage Two
            // Correctly fetch requirementsStageTwo with fallback logic
            
            const requirementsStageTwo = 
            Array.isArray(data.stages.stage_two?.requirement_stage_two) && 
            data.stages.stage_two.requirement_stage_two.length > 0 
                ? data.stages.stage_two.requirement_stage_two 
                : data.stages.stage_one?.requirements || [];
                
            console.log('Fetched Stage One requirements:', data.stages.stage_one.requirements);

            // Debugging: Verify the fetched requirements
            console.log('Fetched requirements for Stage Two:', requirementsStageTwo);

            // Get the container for Stage Two requirements
            const requirementsTwoContainer = document.getElementById('requirementtwoContainer');
            if (!requirementsTwoContainer) {
                console.error('#requirementtwoContainer not found in DOM!');
                return;
            }

            // Step 3: Populate requirements dynamically
            let highestBlockIndex = 0;

            if (requirementsStageTwo.length > 0) {
                requirementsStageTwo.forEach((reqItem, index) => {
                const blockIndex = index + 1;
                highestBlockIndex = Math.max(highestBlockIndex, blockIndex);
                const newBlock = createRequirementTwoBlock(blockIndex, reqItem, productList, distributorList, projectId);
                requirementsTwoContainer.appendChild(newBlock);
                });
            }

            // Calculate the next block index for the existing initial field
            const nextBlockIndex = highestBlockIndex + 1;

            // Update the existing initial requirement field dynamically
            const initialRequirementTitle = document.getElementById('requirementstagetwo');
            const initialHiddenInput = document.getElementById('rq_1_id');

            if (initialRequirementTitle && initialHiddenInput) {
                initialRequirementTitle.textContent = `Requirement ${nextBlockIndex}`;
                initialHiddenInput.value = `st2rq${nextBlockIndex}`;
            } else {
                console.warn("Initial requirement field for Stage Two not found in the DOM.");
            }
                console.log('Stage Two requirements populated:', requirementsStageTwo);
            })
            .catch(error => {
                console.error("Error fetching Products or Distributors for Stage Two:", error);
            });

    }

    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;',
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    //Require Stage Two Widget
    function createRequirementTwoBlock(blockIndex, reqItem, productList = [], distributorList = [], projectId) {
        const requirementId = reqItem.requirement_id_2 || `st2rq${blockIndex}`;
        const requirementText = reqItem.requirement_two || reqItem.requirement_one || ''; // Reference Stage One
        const selectedProduct = reqItem.product_two || reqItem.product_one || ''; // Reference Stage One
        const selectedDistributor = reqItem.distributor_two || reqItem.distributor_one || ''; // Reference Stage One
        const requirementDate = reqItem.requirement_date || '';
        const requirementRemarks = reqItem.requirement_remarks || '';

        console.log(`Creating Stage Two Requirement Block ${blockIndex}`);
        console.log('Product List:', productList);
        console.log('Distributor List:', distributorList);

        // Ensure productList and distributorList are arrays
        if (!Array.isArray(productList)) {
            console.warn('Invalid product list format, defaulting to empty array.');
            productList = [];
        }

        if (!Array.isArray(distributorList)) {
            console.warn('Invalid distributor list format, defaulting to empty array.');
            distributorList = [];
        }

        const newBlock = document.createElement('div');
        newBlock.classList.add('requirementtwo-block', 'p-2', 'rounded', 'shadow-widget');
        newBlock.dataset.index = blockIndex;

        // Populate the block content
        newBlock.innerHTML = `
            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="rq_2_id">
            Requirement ${blockIndex}
            </p>
            <input type="hidden" name="requirement_id_2[]" value="${requirementId}" id="rq_2_id">
            <div class="row mb-1">
                <div class="col-md-2">
                    <input name="requirement_two[]" type="text" class="form-control" placeholder="e.g. Sample Requirement" value="${requirementText}">
                </div>
                <div class="col-md-2">
                    <select name="product_two[]" class="form-control custom-select productFetch" onchange="console.log('Selected Product:', this.value)">
                        <option disabled ${!selectedProduct ? 'selected' : ''}>Select</option>
                        ${productList.map(product => `
                            <option value="${escapeHtml(product)}" ${product.trim().toLowerCase() === selectedProduct.trim().toLowerCase() ? 'selected' : ''}>
                                ${escapeHtml(product)}
                            </option>
                        `).join('')}
                        ${!productList.some(product => product.trim().toLowerCase() === selectedProduct.trim().toLowerCase()) && selectedProduct
                            ? `<option value="${escapeHtml(selectedProduct)}" selected>${escapeHtml(selectedProduct)}</option>`
                            : ''}
                        <option value="add_new_product">+ Add New Product...</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="distributor_two[]" class="form-control custom-select distributorFetch">
                        <option disabled ${!selectedDistributor ? 'selected' : ''}>Select</option>
                        ${distributorList.map(distributor => `
                            <option value="${escapeHtml(distributor)}" ${distributor.trim().toLowerCase() === selectedDistributor.trim().toLowerCase() ? 'selected' : ''}>
                            ${escapeHtml(distributor)}
                            </option>
                        `).join('')}
                        ${!distributorList.some(distributor => distributor.trim().toLowerCase() === selectedDistributor.trim().toLowerCase()) && selectedDistributor
                            ? `<option value="${escapeHtml(selectedDistributor)}" selected>${escapeHtml(selectedDistributor)}</option>`
                            : ''}
                        <option value="add_new">+ Add New Distributor...</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input name="requirement_date[]" type="date" class="form-control" value="${requirementDate}">
                </div>
                <div class="col-md-2">
                    <input name="requirement_remarks[]" type="text" class="form-control" placeholder="e.g. Remarks" value="${requirementRemarks}">
                </div>
                <div class="col-md-2">
                    <button type="button"
                            class="btn btn-danger btn-sm"
                            style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                            onclick="deleteRequirementtwo('${requirementId}', this, '${projectId}')">
                    <i class="fas fa-minus"></i>&nbsp;Remove
                    </button>
                </div>
            </div>
        `;

        return newBlock;
    }

    // Function to delete a Stage Two requirement
    function deleteRequirementtwo(requirementId, button, projectId) {
        // Confirm deletion
        if (!confirm('Are you sure you want to delete this requirement?')) {
            return;
        }

        const requirementBlock = button.closest('.requirementtwo-block'); // Find the block to remove

        // Send delete request to the backend
        fetch('./dirback/delete_req2.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ requirementId, project_id: projectId }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete requirement.');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                requirementBlock.remove();
                console.log('Requirement deleted successfully:', data);
                showNotif_bar(`Requirement deleted successfully!`);
            } else {
                alert(data.message || 'Error deleting requirement.');
                console.error('Error:', data);
            }
        })
        .catch(error => {
            console.error('Error deleting requirement:', error);
            alert('An error occurred while deleting the requirement. Please try again.');
        });
    }


    //Engagement Stage Two Widget
    function createEngagementBlock(blockIndex, engagementItem, projectId) {
        const engagementId = engagementItem.engagement_id_2 || `st2eng${blockIndex}`;
        const engagementType = engagementItem.engagement_type || '';
        const engagementDate = engagementItem.engagement_date || '';
        const engagementRemarks = engagementItem.engagement_remarks || '';

        console.log(`Creating Engagement Block ${blockIndex}`);

        const newBlock = document.createElement('div');
        newBlock.classList.add('engagement-block', 'p-2', 'rounded', 'shadow-widget');
        newBlock.dataset.index = blockIndex;

        newBlock.innerHTML = `
            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="engagement${blockIndex}">
            Engagement ${blockIndex}
            </p>
            <input type="hidden" name="engagement_id_2[]" value="${engagementId}" id="eng_${blockIndex}_id">
            <div class="row mb-1">
            <div class="col-md-4">
                <label for="engagement" class="form-label text-white">Type of Engagement</label>
            </div>
            <div class="col-md-2">
                <label for="engagement" class="form-label text-white">Date</label>
            </div>
            <div class="col-md-5">
                <label for="engagement" class="form-label text-white">Remarks</label>
            </div>
            </div>
            <div id="engagement-fields-container">
            <div class="row engagement-fields mb-3">
                <div class="col-md-4">
                <input name="engagement_type[]" type="text" class="form-control" placeholder="e.g. Sample Engagement" value="${engagementType}">
                </div>
                <div class="col-md-2">
                <input name="engagement_date[]" type="date" class="form-control" style="font-size:10px;" value="${engagementDate}">
                </div>
                <div class="col-md-4">
                <input name="engagement_remarks[]" type="text" class="form-control" placeholder="e.g. Sample Remarks" value="${engagementRemarks}">
                </div>
                <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger btn-sm "
                        style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                        onclick="deleteEngagement('${engagementId}', this, '${projectId}')">
                    <i class="fas fa-minus"></i>&nbsp;Remove
                </button>
                </div>
            </div>
            </div>
        `;

        return newBlock;
    }

    function deleteEngagement(engagementId, button, projectId) {
        if (!confirm('Are you sure you want to delete this engagement?')) {
            return;
        }

    const engagementBlock = button.closest('.engagement-block');

    // Send delete request to the backend
    fetch('./dirback/delete_eng2.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ engagementId, project_id: projectId }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete engagement.');
            }
            return response.json();
        })
        .then(data => {
            engagementBlock.remove();
            console.log('Engagement deleted successfully:', data);
            showNotif_bar(`Requirement deleted successfully!`);
        })
        .catch(error => {
            console.error('Error deleting engagement:', error);
        });
    }


    function fetchStageThree(data,projectId){
        document.getElementById('stage-three-start').value  = data.stages.stage_three.start_date || 'No Data';
        document.getElementById('stage-three-end').value    = data.stages.stage_three.end_date   || 'No Data';
        document.getElementById('stage-three-status').value = data.stages.stage_three.status     || 'No Data';
        document.getElementById('deal_size3').value = Number(data.stages.stage_three.deal_size_three) || Number(data.stages.stage_two.deal_size_two) || 'No Data';
        document.getElementById('stageremarks3').value = data.stages.stage_three.remarks_three || data.stages.stage_two.remarks_two || 'No Data';
        // Fetch Technology Select
        const technology3 = document.getElementById('technologySelect3');
        const techValue = data.stages.stage_three.technology_three || data.stages.stage_two.technology_two || 'Select';
        if (technology3) {
            Array.from(technology3.options).forEach(option => {
            option.selected = option.value === techValue;
            });
        }

        const engagements = 
            Array.isArray(data.stages.stage_three?.engagement_stage_three) && 
            data.stages.stage_three.engagement_stage_three.length > 0 
                ? data.stages.stage_three.engagement_stage_three 
                : data.stages.stage_two?.engagement_stage_two || [];

        const engagementContainer = document.getElementById('engagementthreeContainer');

        if (!engagementContainer) {
            console.error('#engagementthreeContainer not found in DOM!');
            return;
        }

        // Step 2: Populate engagement blocks dynamically
        let highestBlockIndex = 0;

        if (engagements.length > 0) {
            engagements.forEach((engagementItem, index) => {
                const blockIndex = index + 1;
                highestBlockIndex = Math.max(highestBlockIndex, blockIndex);

                const newEngagementBlock = createEngagementThreeBlock(blockIndex, engagementItem, projectId);
                engagementContainer.appendChild(newEngagementBlock);
            });
        }

        // Step 3: Update the existing initial engagement field dynamically
        const nextBlockIndex = highestBlockIndex + 1;
        const initialEngagementTitle = document.getElementById('engagementstagethree');
        const initialHiddenInput = document.getElementById('eng_3_id');

        if (initialEngagementTitle && initialHiddenInput) {
            initialEngagementTitle.textContent = `Engagement ${nextBlockIndex}`;
            initialHiddenInput.value = `st3eng${nextBlockIndex}`;
        } else {
            console.warn('Initial engagement field for Stage Three not found in the DOM.');
        }

        console.log('Stage Three + engagements populated:', engagements);


        const requirementsStageThree = 
            Array.isArray(data.stages.stage_three?.requirement_stage_three) && 
            data.stages.stage_three.requirement_stage_three.length > 0 
                ? data.stages.stage_three.requirement_stage_three 
                : data.stages.stage_two?.requirement_stage_two || [];
                
            console.log('Fetched Stage One requirements:', data.stages.stage_two.requirement_stage_two);

            // Debugging: Verify the fetched requirements
            console.log('Fetched requirements for Stage Two:', requirementsStageThree);

        const requirementsThreeContainer = document.getElementById('requirementthreeContainer');

        if (!requirementsThreeContainer) {
            console.error('#requirementthreeContainer not found in DOM!');
            return;
        }


        // Fetch product and distributor lists
        let productList = [];
        let distributorList = [];

        Promise.all([loadProducts(), loadDistributors()])
            .then(([products, distributors]) => {
                productList = products;
                distributorList = distributors;

                console.log('Products and Distributors fetched successfully for Stage Three.');
                console.log('Product List:', productList);
                console.log('Distributor List:', distributorList);

                if (requirementsStageThree.length > 0) {
                    requirementsStageThree.forEach((reqItem, index) => {
                        const blockIndex = index + 1;
                        highestBlockIndex = Math.max(highestBlockIndex, blockIndex);

                        const newBlock = createRequirementThreeBlock(blockIndex, reqItem, productList, distributorList, projectId);
                        requirementsThreeContainer.appendChild(newBlock);
                    });
                }

                // Step 3: Update the existing initial requirement field dynamically
                const nextBlockIndex = highestBlockIndex + 1;
                const initialRequirementTitle = document.getElementById('requirementstagethree');
                const initialHiddenInput = document.getElementById('req_3_id');

                if (initialRequirementTitle && initialHiddenInput) {
                    initialRequirementTitle.textContent = `Requirement ${nextBlockIndex}`;
                    initialHiddenInput.value = `st3req${nextBlockIndex}`;
                } else {
                    console.warn("Initial requirement field for Stage Three not found in the DOM.");
                }

                console.log('Stage Three requirements populated:', requirementsStageThree);
            })
            .catch(error => {
                console.error("Error fetching Products or Distributors for Stage Three:", error);
            });

    }

    // Helper function to create a requirement block for Stage Three
    function createRequirementThreeBlock(blockIndex, reqItem, productList = [], distributorList = [], projectId) {
        const requirementId = reqItem.requirement_id_3 || `st3req${blockIndex}`;
        const requirementText = reqItem.requirement_three || reqItem.requirement_two || ''; 
        const selectedProduct = reqItem.product_three ||reqItem.product_two || ''; 
        const selectedDistributor = reqItem.distributor_three || reqItem.distributor_two || ''; 
        const quantity = reqItem.quantity || '';
        const pricing = reqItem.pricing || '';
        const requirementDate = reqItem.requirement_date || reqItem.requirement_date || '';
        const requirementRemarks = reqItem.requirement_remarks_three || reqItem.requirement_remarks || '';

        console.log(`Creating Stage Three Requirement Block ${blockIndex}`);
        console.log('Product List:', productList);
        console.log('Distributor List:', distributorList);
        
         // Ensure productList and distributorList are arrays
        if (!Array.isArray(productList)) {
            console.warn('Invalid product list format, defaulting to empty array.');
            productList = [];
        }

        if (!Array.isArray(distributorList)) {
            console.warn('Invalid distributor list format, defaulting to empty array.');
            distributorList = [];
        }

        const newBlock = document.createElement('div');
        newBlock.classList.add('requirementthree-block', 'p-2', 'rounded', 'shadow-widget');
        newBlock.dataset.index = blockIndex;

        // Populate the block content
        newBlock.innerHTML = `
            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="requirementstagethree">
                Requirement ${blockIndex}
            </p>
            <input type="hidden" name="requirement_id_3[]" value="${requirementId}" id="req_3_id">
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
            <div class="row mb-1">
                <div class="col-md-4">
                    <input name="requirement_three[]" type="text" class="form-control" placeholder="e.g. Sample Requirement" value="${requirementText}">
                </div>
                <div class="col-md-3">
                    <select name="product_three[]" class="form-control custom-select productFetch" onchange="console.log('Selected Product:', this.value)">
                        <option disabled ${!selectedProduct ? 'selected' : ''}>Select</option>
                        ${productList.map(product => `
                            <option value="${escapeHtml(product)}" ${product.trim().toLowerCase() === selectedProduct.trim().toLowerCase() ? 'selected' : ''}>
                                ${escapeHtml(product)}
                            </option>
                        `).join('')}
                        ${!productList.some(product => product.trim().toLowerCase() === selectedProduct.trim().toLowerCase()) && selectedProduct
                            ? `<option value="${escapeHtml(selectedProduct)}" selected>${escapeHtml(selectedProduct)}</option>`
                            : ''}
                        <option value="add_new_product">+ Add New Product...</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="distributor_three[]" class="form-control custom-select distributorFetch">
                        <option disabled ${!selectedDistributor ? 'selected' : ''}>Select</option>
                        ${distributorList.map(distributor => `
                            <option value="${escapeHtml(distributor)}" ${distributor.trim().toLowerCase() === selectedDistributor.trim().toLowerCase() ? 'selected' : ''}>
                            ${escapeHtml(distributor)}
                            </option>
                        `).join('')}
                        ${!distributorList.some(distributor => distributor.trim().toLowerCase() === selectedDistributor.trim().toLowerCase()) && selectedDistributor
                            ? `<option value="${escapeHtml(selectedDistributor)}" selected>${escapeHtml(selectedDistributor)}</option>`
                            : ''}
                        <option value="add_new">+ Add New Distributor...</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="button"
                            class="btn btn-danger btn-sm"
                            style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                            onclick="deleteRequirementthree('${requirementId}', this, '${projectId}')">
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
                    <label for="requirement" class="form-label text-white">Date</label>
                </div>
                <div class="col-md-3">
                    <label for="requirement" class="form-label text-white">Remarks</label>
                </div>
            </div>
            <div class="row mb-1">
                <div class="col-md-3">
                    <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50" value="${quantity}">
                </div>
                <div class="col-md-2">
                    <input name="pricing[]" type="number" class="form-control" placeholder="e.g. 5000" value="${pricing}">
                </div>
                <div class="col-md-2">
                    <input name="requirement_date[]" type="date" class="form-control" value="${requirementDate}">
                </div>
                <div class="col-md-4">
                    <input name="requirement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks" value="${requirementRemarks}">
                </div>
            </div>
            
        `;

        return newBlock;
    }

    // Helper function to delete a requirement for Stage Three
    function deleteRequirementthree(requirementId, button, projectId) {
        if (!confirm('Are you sure you want to delete this requirement?')) {
            return;
        }

        const requirementBlock = button.closest('.requirementthree-block');

        fetch('./dirback/delete_req3.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ requirementId, project_id: projectId }),
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to delete requirement.');
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    requirementBlock.remove();
                    console.log('Requirement deleted successfully:', data);
                } else {
                    alert(data.message || 'Error deleting requirement.');
                }
            })
            .catch(error => {
                console.error('Error deleting requirement:', error);
                alert('An error occurred while deleting the requirement.');
            });
    }

    // Function to create a new engagement block for Stage Three
    function createEngagementThreeBlock(blockIndex, engagementItem, projectId) {
        const engagementId = engagementItem.engagement_id_3 || `st3eng${blockIndex}`;
        const engagementType = engagementItem.engagement_three || engagementItem.engagement_type || '';
        const engagementDate = engagementItem.engagement_date || engagementItem.engagement_date || '';
        const engagementRemarks = engagementItem.engagement_remarks_three || engagementItem.engagement_remarks || '';

        console.log(`Creating Engagement Block ${blockIndex}`);

        const newBlock = document.createElement('div');
        newBlock.classList.add('engagementthree-block', 'p-2', 'rounded', 'shadow-widget');
        newBlock.dataset.index = blockIndex;

        newBlock.innerHTML = `
            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="engagementstagethree">
                Engagement ${blockIndex}
            </p>
            <input type="hidden" name="engagement_id_3[]" value="${engagementId}" id="eng_3_id_${blockIndex}">
            <div class="row mb-1">
                <div class="col-md-3">
                    <label for="engagement" class="form-label text-white">Type of Engagement</label>
                </div>
                <div class="col-md-3">
                    <label for="engagement" class="form-label text-white">Date</label>
                </div>
                <div class="col-md-4">
                    <label for="engagement" class="form-label text-white">Remarks</label>
                </div>
            </div>
            <div id="engagement-fields-container3">
                <div class="row engagement-fields mb-3">
                    <div class="col-md-3">
                        <input name="engagement_three[]" type="text" class="form-control" placeholder="e.g. Sample Engagement" value="${engagementType}">
                    </div>
                    <div class="col-md-3">
                        <input name="engagement_date[]" type="date" class="form-control" style="font-size:10px;" value="${engagementDate}">
                    </div>
                    <div class="col-md-4">
                        <input name="engagement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks" value="${engagementRemarks}">
                    </div>
                    <div class="col-md-2">
                        <button type="button"
                                class="btn btn-danger btn-sm"
                                style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                                onclick="deleteEngagementThree('${engagementId}', this, '${projectId}')">
                            <i class="fas fa-minus"></i>&nbsp;Remove
                        </button>
                    </div>
                </div>
            </div>
        `;

        return newBlock;
    }

    // Function to delete an engagement block
    function deleteEngagementThree(engagementId, button, projectId) {
        if (!confirm('Are you sure you want to delete this engagement?')) {
            return;
        }

        const engagementBlock = button.closest('.engagementthree-block');

        // Send delete request to the backend
        fetch('./dirback/delete_eng3.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ engagementId, project_id: projectId }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete engagement.');
            }
            return response.json();
        })
        .then(data => {
            engagementBlock.remove();
            console.log('Engagement deleted successfully:', data);
            showNotif_bar(`Requirement deleted successfully!`);
        })
        .catch(error => {
            console.error('Error deleting engagement:', error);
        });
    }

    function fetchStageFour(data,projectId){
        document.getElementById('stage-four-start').value  = data.stages.stage_four.start_date || 'No Data';
        document.getElementById('stage-four-end').value    = data.stages.stage_four.end_date   || 'No Data';
        document.getElementById('stage-four-status').value = data.stages.stage_four.status     || 'No Data';
        document.getElementById('solution4').value = data.stages.stage_four.solution_four || data.stages.stage_three.solution_three || 'No Data';
        document.getElementById('deal_size4').value = Number(data.stages.stage_four.deal_size_four) || Number(data.stages.stage_three.deal_size_three) || 'No Data';
        document.getElementById('stageremarks4').value = data.stages.stage_four.remarks_four || data.stages.stage_three.remarks_three || 'No Data';
        // Fetch Technology Select
        const technology4 = document.getElementById('technologySelect4');
        const techValue = data.stages.stage_four.technology_four || data.stages.stage_three.technology_three || 'Select';
        if (technology4) {
            Array.from(technology4.options).forEach(option => {
            option.selected = option.value === techValue;
            });
        }
                

        const requirementsStageFour = 
        Array.isArray(data.stages.stage_four?.requirement_stage_four) && 
        data.stages.stage_four.requirement_stage_four.length > 0 
            ? data.stages.stage_four.requirement_stage_four 
            : data.stages.stage_three?.requirement_stage_three || [];

        console.log('Fetched Stage Three requirements:', data.stages.stage_three.requirement_stage_three);

        // Debugging: Verify the fetched requirements
        console.log('Fetched requirements for Stage Four:', requirementsStageFour);

    const requirementsFourContainer = document.getElementById('requirementfourContainer');

    if (!requirementsFourContainer) {
        console.error('#requirementfourContainer not found in DOM!');
        return;
    }

    // Fetch product and distributor lists
    let productList = [];
    let distributorList = [];

    Promise.all([loadProducts(), loadDistributors()])
        .then(([products, distributors]) => {
            productList = products;
            distributorList = distributors;

            console.log('Products and Distributors fetched successfully for Stage Four.');
            console.log('Product List:', productList);
            console.log('Distributor List:', distributorList);

            let highestBlockIndex = 0;

            if (requirementsStageFour.length > 0) {
                requirementsStageFour.forEach((reqItem, index) => {
                    const blockIndex = index + 1;
                    highestBlockIndex = Math.max(highestBlockIndex, blockIndex);

                    const newBlock = createRequirementFourBlock(blockIndex, reqItem, productList, distributorList, projectId);
                    requirementsFourContainer.appendChild(newBlock);
                });
            }

            const nextBlockIndex = highestBlockIndex + 1;
            const initialRequirementTitle = document.getElementById('requirementstagefour');
            const initialHiddenInput = document.getElementById('req_4_id');

            if (initialRequirementTitle && initialHiddenInput) {
                initialRequirementTitle.textContent = `Requirement ${nextBlockIndex}`;
                initialHiddenInput.value = `st4req${nextBlockIndex}`;
            } else {
                console.warn("Initial requirement field for Stage Four not found in the DOM.");
            }

            console.log('Stage Four requirements populated:', requirementsStageFour);
        })
        .catch(error => {
            console.error("Error fetching Products or Distributors for Stage Four:", error);
        });
        
    }

    function createRequirementFourBlock(blockIndex, reqItem, productList = [], distributorList = [], projectId) {
    const requirementId = reqItem.requirement_id_4 || `st4req${blockIndex}`;
    const requirementText = reqItem.requirement_four ||  reqItem.requirement_three || '';
    const selectedProduct = reqItem.product_four || reqItem.product_three ||'';
    const selectedDistributor = reqItem.distributor_four || reqItem.distributor_three || '';
    const quantity = reqItem.quantity || reqItem.quantity || '';
    const pricing = reqItem.pricing || reqItem.pricing || '';
    const requirementDate = reqItem.date_required || reqItem.date_required || '';
    const requirementRemarks = reqItem.requirement_remarks_four || reqItem.requirement_remarks_three || '';

     // Ensure productList and distributorList are arrays
    if (!Array.isArray(productList)) {
        console.warn('Invalid product list format, defaulting to empty array.');
        productList = [];
    }

    if (!Array.isArray(distributorList)) {
        console.warn('Invalid distributor list format, defaulting to empty array.');
        distributorList = [];
    }

    const newBlock = document.createElement('div');
    newBlock.classList.add('requirementfour-block', 'p-2', 'rounded', 'shadow-widget');
    newBlock.dataset.index = blockIndex;

    newBlock.innerHTML = `
        <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="requirementstagefour">
            Requirement ${blockIndex}
        </p>
        <input type="hidden" name="requirement_id_4[]" value="${requirementId}" id="req_4_id">
        <div class="row mb-1">
            <div class="col-md-3">
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
                <input name="requirement_four[]" type="text" class="form-control" placeholder="e.g. Sample Requirement" value="${requirementText}">
            </div>
            <div class="col-md-3">
                <select name="product_four[]" class="form-control custom-select productFetch" onchange="console.log('Selected Product:', this.value)">
                    <option disabled ${!selectedProduct ? 'selected' : ''}>Select</option>
                    ${productList.map(product => `
                        <option value="${escapeHtml(product)}" ${product.trim().toLowerCase() === selectedProduct.trim().toLowerCase() ? 'selected' : ''}>
                            ${escapeHtml(product)}
                        </option>
                    `).join('')}
                    ${!productList.some(product => product.trim().toLowerCase() === selectedProduct.trim().toLowerCase()) && selectedProduct
                        ? `<option value="${escapeHtml(selectedProduct)}" selected>${escapeHtml(selectedProduct)}</option>`
                        : ''}
                    <option value="add_new_product">+ Add New Product...</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="distributor_four[]" class="form-control custom-select distributorFetch">
                    <option disabled ${!selectedDistributor ? 'selected' : ''}>Select</option>
                    ${distributorList.map(distributor => `
                        <option value="${escapeHtml(distributor)}" ${distributor.trim().toLowerCase() === selectedDistributor.trim().toLowerCase() ? 'selected' : ''}>
                        ${escapeHtml(distributor)}
                        </option>
                    `).join('')}
                    ${!distributorList.some(distributor => distributor.trim().toLowerCase() === selectedDistributor.trim().toLowerCase()) && selectedDistributor
                        ? `<option value="${escapeHtml(selectedDistributor)}" selected>${escapeHtml(selectedDistributor)}</option>`
                        : ''}
                    <option value="add_new">+ Add New Distributor...</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger btn-sm"
                        style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                        onclick="deleteRequirementFour('${requirementId}', this, '${projectId}')">
                    <i class="fas fa-minus"></i>&nbsp;Remove
                </button>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-md-3">
                <label for="quantity" class="form-label text-white">Quantity</label>
            </div>
            <div class="col-md-2">
                <label for="pricing" class="form-label text-white">Pricing</label>
            </div>
            <div class="col-md-2">
                <label for="date_required" class="form-label text-white">Date Required</label>
            </div>
            <div class="col-md-4">
                <label for="remarks" class="form-label text-white">Remarks</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50" value="${quantity}">
            </div>
            <div class="col-md-2">
                <input name="pricing[]" type="number" class="form-control" placeholder="e.g. 2000" value="${pricing}">
            </div>
            <div class="col-md-2">
                <input name="date_required[]" type="date" class="form-control" value="${requirementDate}">
            </div>
            <div class="col-md-4">
                <input name="requirement_remarks_four[]" type="text" class="form-control" placeholder="e.g. Sample Remarks" value="${requirementRemarks}">
            </div>
        </div>
    `;

    return newBlock;
}

// Function to delete a requirement block for Stage Four
function deleteRequirementFour(requirementId, button, projectId) {
    if (!confirm('Are you sure you want to delete this requirement?')) {
        return;
    }

    const requirementBlock = button.closest('.requirementfour-block');

    // Send delete request to the backend
    fetch('./dirback/delete_req4.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ requirementId, project_id: projectId }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete requirement.');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                requirementBlock.remove();
                console.log('Requirement deleted successfully:', data);
            } else {
                alert(data.message || 'Error deleting requirement.');
            }
        })
        .catch(error => {
            console.error('Error deleting requirement:', error);
            alert('An error occurred while deleting the requirement.');
        });
}


    function fetchStageFive(data, projectId) {
    document.getElementById('stage-five-start').value = data.stages.stage_five.start_date || 'No Data';
    document.getElementById('stage-five-end').value = data.stages.stage_five.end_date || 'No Data';
    document.getElementById('stage-five-status').value = data.stages.stage_five.status || 'No Data';
    document.getElementById('stage-five-spr').value = data.stages.stage_five.spr || 'No Data';
    // document.getElementById('contractDuration').value = data.stages.stage_five.contract_duration || 'No Data';
    // document.getElementById('startContract').value = data.stages.stage_five.contractStart || 'No Data';
    // document.getElementById('endContract').value = data.stages.stage_five.contractEnd || 'No Data';
    document.getElementById('billingType').value = data.stages.stage_five.billing_type || 'No Data';
    document.getElementById('solution5').value = data.stages.stage_five.solution_five || data.stages.stage_four.solution_four || 'No Data';
    document.getElementById('deal_size5').value = Number(data.stages.stage_five.deal_size_five) || Number(data.stages.stage_four.deal_size_four) || 'No Data';
    document.getElementById('stageremarks5').value = data.stages.stage_five.remarks_five || data.stages.stage_four.remarks_four || 'No Data';

    // Fetch Technology Select
    const technology5 = document.getElementById('technologySelect5');
    const techValue = data.stages.stage_five.technology_five || data.stages.stage_four.technology_four || 'Select';
    if (technology5) {
        Array.from(technology5.options).forEach(option => {
        option.selected = option.value === techValue;
        });
    }
    // Set values for start and end dates
    const startContractInput = document.getElementById('startContract');
    const endContractInput = document.getElementById('endContract');
    startContractInput.value = data.stages.stage_five.contractStart|| '';
    endContractInput.value = data.stages.stage_five.contractEnd || '';

    // Call updateContractDuration from outside
    updateContractDuration();

     const requirementsStageFive = 
        Array.isArray(data.stages.stage_five?.requirement_stage_five) && 
        data.stages.stage_five.requirement_stage_five.length > 0 
            ? data.stages.stage_five.requirement_stage_five 
            : data.stages.stage_four?.requirement_stage_four || [];
    
    console.log('Fetched Stage Four requirements:', data.stages.stage_four.requirement_stage_four);

    console.log('Fetched Stage Five requirements:', requirementsStageFive);

    const requirementsFiveContainer = document.getElementById('requirementfiveContainer');
    if (!requirementsFiveContainer) {
        console.error('#requirementfiveContainer not found in DOM!');
        return;
    }

    // Fetch product and distributor lists
    let productList = [];
    let distributorList = [];

    Promise.all([loadProducts(), loadDistributors()])
        .then(([products, distributors]) => {
            productList = products;
            distributorList = distributors;

            console.log('Products and Distributors fetched successfully for Stage Five.');
            console.log('Product List:', productList);
            console.log('Distributor List:', distributorList);

            let highestBlockIndex = 0;

            if (requirementsStageFive.length > 0) {
                requirementsStageFive.forEach((reqItem, index) => {
                    const blockIndex = index + 1;
                    highestBlockIndex = Math.max(highestBlockIndex, blockIndex);

                    const newBlock = createRequirementFiveBlock(blockIndex, reqItem, productList, distributorList, projectId);
                    requirementsFiveContainer.appendChild(newBlock);
                });
            }

            const nextBlockIndex = highestBlockIndex + 1;
            const initialRequirementTitle = document.getElementById('requirementstagefive');
            const initialHiddenInput = document.getElementById('req_5_id');

            if (initialRequirementTitle && initialHiddenInput) {
                initialRequirementTitle.textContent = `Requirement ${nextBlockIndex}`;
                initialHiddenInput.value = `st5req${nextBlockIndex}`;
            } else {
                console.warn("Initial requirement field for Stage Five not found in the DOM.");
            }

            console.log('Stage Five requirements populated:', requirementsStageFive);
        })
        .catch(error => {
            console.error("Error fetching Products or Distributors for Stage Five:", error);
        });


        const upsellStageFive = 
        Array.isArray(data.stages.stage_five?.upsell_stage_five) && 
        data.stages.stage_five.upsell_stage_five.length > 0
        ? data.stages.stage_five.upsell_stage_five
        : []; // Use an empty array if no upsell data is available

        console.log('Fetched Upsell data for Stage Five:', upsellStageFive);

        const upsellContainer = document.getElementById('upsellContainer');
        if (!upsellContainer) {
            console.error('#upsellContainer not found in DOM!');
            return;
        }

        let highestBlockIndex = 0;

        // Check if there is any existing upsell data
        if (upsellStageFive.length > 0) {
            upsellStageFive.forEach((upsellItem, index) => {
                const blockIndex = index + 1; // Block index starts from 1
                highestBlockIndex = Math.max(highestBlockIndex, blockIndex);

                const newBlock = createUpsellBlock(blockIndex, upsellItem, projectId);
                upsellContainer.appendChild(newBlock);
            });
        }

        // Update the next upsell block index dynamically
        const nextBlockIndex = highestBlockIndex + 1;

        // Update initial upsell block content (if applicable)
        const initialUpsellTitle = document.getElementById('upsellCon');
        const initialHiddenInput = document.getElementById('upsell_id');
        if (initialUpsellTitle && initialHiddenInput) {
            initialUpsellTitle.textContent = `Upsell ${nextBlockIndex}`;
            initialHiddenInput.value = `upsell${nextBlockIndex}`;
        } else {
            console.warn('Initial upsell block not found in the DOM.');
        }

        console.log('Upsell blocks populated for Stage Five:', upsellStageFive);
}

// Function to create an upsell block (dynamically for Stage Five)
function createUpsellBlock(blockIndex, upsellItem, projectId) {
    const upsellId = upsellItem.upsell_id_5 || `upsell${blockIndex}`;
    const upsellText = upsellItem.upsell || '';
    const quantity = upsellItem.quantity_upsell || '';
    const amount = upsellItem.amount_upsell || '';
    const remarks = upsellItem.remarks_upsell || '';

    const newBlock = document.createElement('div');
    newBlock.classList.add('upsell-block');
    newBlock.dataset.index = blockIndex;

    newBlock.innerHTML = `
        <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="upsellCon">
            Upsell ${blockIndex}
        </p>
        <input type="hidden" name="upsell_stage_5[]" value="${upsellId}" id="upsell_id">
        <div class="row mb-1">
            <div class="col-md-2">
                <label for="requirement" class="form-label text-white">Upsell</label>
            </div>
            <div class="col-md-2">
                <label for="quantity" class="form-label text-white">Quantity</label>
            </div>
            <div class="col-md-2">
                <label for="amount" class="form-label text-white">Amount</label>
            </div>
            <div class="col-md-3">
                <label for="remarks" class="form-label text-white">Remarks</label>
            </div>
        </div>
        <div class="row mb-3 upsell-fields">
            <div class="col-md-3">
                <input type="text" class="form-control" name="upsell[]" placeholder="e.g Router 2000" value="${upsellText}">
            </div>
            <div class="col-md-2">
                <input name="quantity_upsell[]" type="number" class="form-control" placeholder="e.g 50" value="${quantity}">
            </div>
            <div class="col-md-2">
                <input name="amount_upsell[]" type="number" class="form-control" placeholder="e.g. 6000" value="${amount}">
            </div>
            <div class="col-md-3">
                <input name="remarks_upsell[]" type="text" class="form-control" placeholder="e.g. Sample Remarks" value="${remarks}">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm removeUpsellRow" style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;">
                    <i class="fas fa-minus"></i>&nbsp;Remove
                </button>
            </div>
        </div>
    `;

    return newBlock;
}

// Create Requirement Block for Stage Five
function createRequirementFiveBlock(blockIndex, reqItem, productList = [], distributorList = [], projectId) {
    const requirementId = reqItem.requirement_id_5 || `st5req${blockIndex}`;
    const requirementText = reqItem.req_five || reqItem.requirement_four || '';
    const selectedProduct = reqItem.product_five || reqItem.product_four || '';
    const selectedDistributor = reqItem.distributor_five || reqItem.distributor_four || '';
    const quantity = reqItem.quantity || reqItem.quantity || '';
    const pricing = reqItem.pricing || reqItem.pricing || '';
    const requirementDate = reqItem.date_required || reqItem.date_required || '';
    const requirementRemarks = reqItem.remarks_req || reqItem.requirement_remarks_four || '';

    // Ensure productList and distributorList are arrays
    if (!Array.isArray(productList)) {
        console.warn('Invalid product list format, defaulting to empty array.');
        productList = [];
    }

    if (!Array.isArray(distributorList)) {
        console.warn('Invalid distributor list format, defaulting to empty array.');
        distributorList = [];
    }

    const newBlock = document.createElement('div');
    newBlock.classList.add('requirementfive-block', 'p-2', 'rounded', 'shadow-widget');
    newBlock.dataset.index = blockIndex;

    newBlock.innerHTML = `
        <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="requirementstagefive">
            Requirement ${blockIndex}
        </p>
        <input type="hidden" name="requirement_id_5[]" value="${requirementId}" id="req_5_id">
        <div class="row mb-1">
            <div class="col-md-3">
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
                <input name="req_five[]" type="text" class="form-control" placeholder="e.g. Sample Requirement" value="${requirementText}">
            </div>
            <div class="col-md-3">
                <select name="product_five[]" class="form-control custom-select productFetch">
                    <option disabled ${!selectedProduct ? 'selected' : ''}>Select</option>
                    ${productList.map(product => `
                        <option value="${escapeHtml(product)}" ${product.trim().toLowerCase() === selectedProduct.trim().toLowerCase() ? 'selected' : ''}>
                            ${escapeHtml(product)}
                        </option>
                    `).join('')}
                    ${!productList.some(product => product.trim().toLowerCase() === selectedProduct.trim().toLowerCase()) && selectedProduct
                        ? `<option value="${escapeHtml(selectedProduct)}" selected>${escapeHtml(selectedProduct)}</option>`
                        : ''}
                    <option value="add_new_product">+ Add New Product...</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="distributor_five[]" class="form-control custom-select distributorFetch">
                    <option disabled ${!selectedDistributor ? 'selected' : ''}>Select</option>
                    ${distributorList.map(distributor => `
                        <option value="${escapeHtml(distributor)}" ${distributor.trim().toLowerCase() === selectedDistributor.trim().toLowerCase() ? 'selected' : ''}>
                            ${escapeHtml(distributor)}
                        </option>
                    `).join('')}
                    ${!distributorList.some(distributor => distributor.trim().toLowerCase() === selectedDistributor.trim().toLowerCase()) && selectedDistributor
                        ? `<option value="${escapeHtml(selectedDistributor)}" selected>${escapeHtml(selectedDistributor)}</option>`
                        : ''}
                    <option value="add_new">+ Add New Distributor...</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button"
                        class="btn btn-danger btn-sm"
                        style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                        onclick="deleteRequirementFive('${requirementId}', this, '${projectId}')">
                    <i class="fas fa-minus"></i>&nbsp;Remove
                </button>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-md-3">
                <label for="quantity" class="form-label text-white">Quantity</label>
            </div>
            <div class="col-md-2">
                <label for="pricing" class="form-label text-white">Pricing</label>
            </div>
            <div class="col-md-2">
                <label for="date_required" class="form-label text-white">Date Required</label>
            </div>
            <div class="col-md-4">
                <label for="remarks" class="form-label text-white">Remarks</label>
            </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50" value="${quantity}">
            </div>
            <div class="col-md-2">
                <input name="pricing[]" type="number" class="form-control" placeholder="e.g. 2000" value="${pricing}">
            </div>
            <div class="col-md-2">
                <input name="date_required[]" type="date" class="form-control" value="${requirementDate}">
            </div>
            <div class="col-md-4">
                <input name="remarks_req[]" type="text" class="form-control" placeholder="e.g. Sample Remarks" value="${requirementRemarks}">
            </div>
        </div>
    `;

    return newBlock;
}

// Function to delete a requirement block for Stage Five
function deleteRequirementFive(requirementId, button, projectId) {
    if (!confirm('Are you sure you want to delete this requirement?')) {
        return;
    }

    const requirementBlock = button.closest('.requirementfive-block');

    // Send delete request to the backend
    fetch('./dirback/delete_req5.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ requirementId, project_id: projectId }),
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Failed to delete requirement.');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                requirementBlock.remove();
                console.log('Requirement deleted successfully:', data);
            } else {
                alert(data.message || 'Error deleting requirement.');
            }
        })
        .catch(error => {
            console.error('Error deleting requirement:', error);
            alert('An error occurred while deleting the requirement.');
        });
}


/**
 * Function to calculate and update contract duration
 */
function updateContractDuration() {
    const startContractInput = document.getElementById('startContract');
    const endContractInput = document.getElementById('endContract');
    const contractDurationInput = document.getElementById('contractDuration');

    // Convert input values to Date objects
    const startDate = new Date(startContractInput.value);
    const endDate = new Date(endContractInput.value);

    // Validate if both start and end dates are valid dates
    if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
        contractDurationInput.value = 'Invalid Dates';
        return;
    }

    // Calculate the difference in time between the two dates
    const durationInMilliseconds = endDate - startDate;
    const durationInDays = durationInMilliseconds / (1000 * 60 * 60 * 24); // Convert milliseconds to days

    // Ensure duration is non-negative
    if (durationInDays >= 0) {
        contractDurationInput.value = `${Math.ceil(durationInDays)} days`; // Round up if needed
    } else {
        contractDurationInput.value = 'Invalid Range'; // If the end date is earlier than start date
    }
}


// Call the function from outside
document.getElementById('startContract').addEventListener('change', updateContractDuration);
document.getElementById('endContract').addEventListener('change', updateContractDuration);
