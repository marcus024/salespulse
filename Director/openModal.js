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
                    
                    fetchStageOne(data);
                    // fetchStageTwo(data);
                    // fetchStageThree(data);
                    // fetchStageFour(data);
                    // fetchStageFive(data);

                    // fetch products and distributors

                    

                    //Navigate to the current stage
                    const currentStage = data.current_stage;
                    if (currentStage) {
                        const stageNumber = parseInt(currentStage.split(' ')[1]); // Extract stage number
                        currentStep = stageNumber;
                        markCompletedSteps(stageNumber); // Mark previous steps as completed
                        showStep(stageNumber); // Show the current step
                        //  if (stageNumber === 1) {
                        //     fetchStageOne(data);
                        // } else if (stageNumber === 2) {
                        //     // fetchStageOne(data,projectId);
                        //     // fetchStageTwo(data,projectId);
                        // } else if (stageNumber === 3) {
                        //     // fetchStageTwo(data,projectId);
                        //     // fetchStageThree(data,projectId);
                        // } else if (stageNumber === 4) {
                        //     // fetchStageThree(data,projectId);
                        //     // fetchStageFour(data,projectId);
                        // } else if (stageNumber === 5) {
                        //     // fetchStageFour(data,projectId);
                        //     // fetchStageFive(data,projectId);
                        // }
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
        // Loop through all step circles
        document.querySelectorAll('.step-circle').forEach((circle, index) => {
            const stepNumber = index + 1; // Step numbers are 1-based
            if (stepNumber < currentStep) {
                // Mark previous steps as completed
                circle.classList.add('completed');
                circle.textContent = '✔';
            } else {
                // Reset any future steps
                circle.classList.remove('completed');
                circle.textContent = stepNumber.toString();
            }
        });
    }

    // Function to show a specific step
    function showStep(stepNumber) {
        // Hide all steps
        document.querySelectorAll('.form-step').forEach(step => step.classList.add('d-none'));

        // Remove 'active' state from all step circles
        document.querySelectorAll('.step-circle').forEach(circle => circle.classList.remove('active'));

        // Show the selected step and mark its circle as active
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

 function fetchStageOne(data) {
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

  // Step 1: Fetch the product and distributor lists
  let productList = [];
  let distributorList = [];
  $.when(
    loadProducts().then(products => {
      productList = products; // Store fetched product list
    }),
    loadDistributors().then(distributors => {
      distributorList = distributors; // Store fetched distributor list
    })
  ).done(() => {
    console.log("Products and Distributors fetched successfully.");
  }).fail(() => {
    console.error("Error fetching Products or Distributors.");
  });

  // Step 2: Fetch requirements array
  const requirements = (data.stages.stage_one && data.stages.stage_one.requirements) || [];

  // Step 3: Get the container for requirements
  const requirementsContainer = document.getElementById('requirementsContainer');
  if (!requirementsContainer) {
    console.error('#requirementsContainer not found in DOM!');
    return;
  }

//   requirementsContainer.innerHTML = ''; 

  // Step 4: Populate requirements dynamically
  if (requirements.length > 0) {
    requirements.forEach((reqItem, index) => {
      const blockIndex = index + 1;
      const newBlock = createRequirementBlock(blockIndex, reqItem, productList, distributorList);
      requirementsContainer.appendChild(newBlock);
    });
  } else {
    // If no requirements exist, add a default requirement block
    const newBlock = createRequirementBlock(1, {}, productList, distributorList);
    requirementsContainer.appendChild(newBlock);
  }

  console.log('Stage ss + requirements populated:', requirements);
}

function createRequirementBlock(blockIndex, reqItem, productList, distributorList) {
  const requirementId = reqItem.requirement_id_1 || `st1rq${blockIndex}`;
  const requirementText = reqItem.requirement_one || '';
  const selectedProduct = reqItem.product_one || '';
  const selectedDistributor = reqItem.distributor_one || '';

  console.log(`Creating Requirement Block ${blockIndex}`);
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
  newBlock.classList.add('requirement-block', 'p-2', 'rounded', 'shadow-widget');
  newBlock.dataset.index = blockIndex;

  // Populate the block content
  newBlock.innerHTML = `
    <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
      Requirement ${blockIndex}
    </p>
    <input type="hidden" name="requirement_id_1[]" value="${requirementId}">

    <div class="row mb-3">
      <div class="col-md-4">
        <input name="requirement_one[]" type="text" class="form-control" placeholder="e.g. Sample Requirement" value="${requirementText}">
      </div>
      <div class="col-md-3">
        <select name="product_one[]" class="form-control custom-select productFetch">
          <option disabled ${!selectedProduct ? 'selected' : ''}>Select</option>
          ${productList.map(product => `
            <option value="${escapeHtml(product)}" ${product === selectedProduct ? 'selected' : ''}>
              ${escapeHtml(product)}
            </option>
          `).join('')}
          <option value="add_new_product">+ Add New Product...</option>
        </select>
      </div>
      <div class="col-md-3">
        <select name="distributor_one[]" class="form-control custom-select distributorFetch">
          <option disabled ${!selectedDistributor ? 'selected' : ''}>Select</option>
          ${distributorList.map(distributor => `
            <option value="${escapeHtml(distributor)}" ${distributor === selectedDistributor ? 'selected' : ''}>
              ${escapeHtml(distributor)}
            </option>
          `).join('')}
          <option value="add_new">+ Add New Distributor...</option>
        </select>
      </div>
      <div class="col-md-2 text-end">
        <button type="button" class="btn btn-danger btn-sm removeRequirement">
          <i class="fas fa-minus"></i> Remove
        </button>
      </div>
    </div>
  `;

  return newBlock;
}

    function fetchStageTwo(data,projectId){
        document.getElementById('stage-two-start').value = data.stages.stage_two.start_date || 'No Data';
        document.getElementById('stage-two-end').value = data.stages.stage_two.end_date ||  'No Data';
        document.getElementById('stage-two-status').value = data.stages.stage_two.status ||  'No Data';
        document.getElementById('solution2').value = data.stages.stage_two.solution_two || data.stages.stage_one.solution || 'No Data';
        document.getElementById('deal_size2').value = Number(data.stages.stage_two.deal_size_two) || Number(data.stages.stage_one.deal_size) || 'No Data';

        document.getElementById('stageremarks2').value = data.stages.stage_two.remarks_two || data.stages.stage_one.remarks || 'No Data';
        document.getElementById('product2').value = data.stages.stage_two.product_two || data.stages.stage_one.product || 'No Data';

        const technology2 = document.getElementById('technology2');
        const techValue2 = data.stages.stage_two.technology_two || data.stages.stage_one.technology || 'Select';
        Array.from(technology2.options).forEach(option => {
            if (option.value === techValue2) {
                option.selected = true;
            }
        });

        // Get the container for requirements
        const requirementTwoContainer = document.getElementById('requirement-fields-container');

        // Clear the container before rendering
        // requirementTwoContainer.innerHTML = '';

        const requirementsTwo = data.stages.stage_two.requirement_stage_two || []; // Fetch requirements from data

        requirementsTwo.forEach((requirement2) => {
            // Create a row for each requirement
            const requirementRow = document.createElement('div');
            requirementRow.className = 'row align-items-center requirement-fields mb-3';

            // Set the HTML content of the row
            requirementRow.innerHTML = `
                <div class="col-md-3">
                    <input 
                        value="${requirement2.requirement_two || ''}" 
                        name="requirement_two[]" 
                        type="text" 
                        id="req2" 
                        class="form-control" 
                        placeholder="e.g. Sample Requirement"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${requirement2.requirement_date || ''}" 
                        name="requirement_date[]" 
                        type="date" 
                        id="reqdate2" 
                        class="form-control" 
                        style="font-size:10px;"
                    >
                </div>
                <div class="col-md-5">
                    <input 
                        value="${requirement2.requirement_remarks || ''}" 
                        name="requirement_remarks[]" 
                        type="text" 
                        id="reqremarks2" 
                        class="form-control" 
                        placeholder="e.g. Sample Remarks"
                    >
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            `;

            // Append the row to the container
            requirementTwoContainer.appendChild(requirementRow);

            // Add delete functionality to the button
            const deleteButton = requirementRow.querySelector('.deleteRequirement');
            deleteButton.addEventListener('click', () => {
                fetch('./dirback/delete_req2.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        requirement_id: requirement2.requirement_id_two, // Use the requirement ID for deletion
                        project_id: projectId // Project ID for context
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status === 'success') {
                            // Remove the row from the DOM
                            requirementRow.remove();

                            // Optionally update the requirements array
                            const index = requirementsTwo.findIndex(req => req.requirement_id_two === requirement2.requirement_id_two);
                            if (index > -1) {
                                requirementsTwo.splice(index, 1);
                            }
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Error deleting requirement:', error);
                        alert('Failed to delete requirement. Please try again.');
                    });
            });
        });

        // Get the container for engagements
        const engagementFieldsContainer = document.getElementById('engagement-fields-container');

        // Clear the container before rendering
        // engagementFieldsContainer.innerHTML = '';

        // Fetch engagements from stage_two
        const engagements = data.stages.stage_two.engagement_stage_two || [];

        engagements.forEach((engagement) => {
            // Create a row for each engagement
            const engagementRow = document.createElement('div');
            engagementRow.className = 'row align-items-center engagement-fields mb-3';

            // Set the HTML content of the row
            engagementRow.innerHTML = `
                <div class="col-md-3">
                    <input 
                        value="${engagement.engagement_type || ''}" 
                        name="engagement_type[]" 
                        type="text" 
                        id="engtype2" 
                        class="form-control" 
                        placeholder="e.g. Sample Engagement"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${engagement.engagement_date || ''}" 
                        name="engagement_date[]" 
                        type="date" 
                        id="engdate2" 
                        class="form-control" 
                        style="font-size:10px;"
                    >
                </div>
                <div class="col-md-5">
                    <input 
                        value="${engagement.engagement_remarks || ''}" 
                        name="engagement_remarks[]" 
                        type="text" 
                        id="engremarks2" 
                        class="form-control" 
                        placeholder="e.g. Sample Remarks"
                    >
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm deleteEngagement" style="margin-left: 5px;">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            `;

            // Append the row to the container
            engagementFieldsContainer.appendChild(engagementRow);

            // Add delete functionality to the button
            const deleteButton = engagementRow.querySelector('.deleteEngagement');
            deleteButton.addEventListener('click', () => {
                fetch('./dirback/delete_eng2.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        engagement_id: engagement.engagement_id_two, // Use the engagement ID for deletion
                        project_id: projectId // Project ID for context
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status === 'success') {
                            // Remove the row from the DOM
                            engagementRow.remove();

                            // Optionally update the engagements array
                            const index = engagements.findIndex(e => e.engagement_id_two === engagement.engagement_id_two);
                            if (index > -1) {
                                engagements.splice(index, 1);
                            }
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Error deleting engagement:', error);
                        alert('Failed to delete engagement. Please try again.');
                    });
            });
        });

    }

    function fetchStageThree(data,projectId){
        document.getElementById('stage-three-start').value  = data.stages.stage_three.start_date || 'No Data';
        document.getElementById('stage-three-end').value    = data.stages.stage_three.end_date   || 'No Data';
        document.getElementById('stage-three-status').value = data.stages.stage_three.status     || 'No Data';
        document.getElementById('solution3').value = data.stages.stage_three.solution_three || data.stages.stage_two.solution_two || 'No Data';
        document.getElementById('deal_size3').value = Number(data.stages.stage_three.deal_size_three) || Number(data.stages.stage_two.deal_size_two) || 'No Data';
        document.getElementById('stageremarks3').value = data.stages.stage_three.remarks_three || data.stages.stage_two.remarks_two || 'No Data';
        document.getElementById('product3').value = data.stages.stage_three.product_three || data.stages.stage_two.product_two || 'No Data';
        const technology3 = document.getElementById('technology3');
        const techValue3 = data.stages.stage_three.technology_three || data.stages.stage_two.technology_two || 'Select';
        Array.from(technology3.options).forEach(option => {
            if (option.value === techValue3) {
                option.selected = true;
            }
        });
        // Get the container for engagement fields
        const engagementFieldsContainer3 = document.getElementById('engagement-fields-container3');

        // Clear the container before rendering
        // engagementFieldsContainer3.innerHTML = '';

        // Fetch engagement data from stage_three
        const engagements3 = data.stages.stage_three.engagement_stage_three || [];

        engagements3.forEach((engagement) => {
            // Create a row for each engagement
            const engagementRow3 = document.createElement('div');
            engagementRow3.className = 'row align-items-center engagement-fields mb-3';

            // Set the HTML content of the row
            engagementRow3.innerHTML = `
                <div class="col-md-3">
                    <input 
                        value="${engagement.engagement_three || ''}" 
                        name="engagement_three[]" 
                        type="text" 
                        id="engtype3" 
                        class="form-control" 
                        placeholder="e.g. Sample Engagement"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${engagement.engagement_date || ''}" 
                        name="engagement_date[]" 
                        type="date" 
                        id="engdate3" 
                        class="form-control" 
                        style="font-size:10px;"
                    >
                </div>
                <div class="col-md-5">
                    <input 
                        value="${engagement.engagement_remarks_three || ''}" 
                        name="engagement_remarks_three[]" 
                        type="text" 
                        id="engremarks3" 
                        class="form-control" 
                        placeholder="e.g. Sample Remarks"
                    >
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm deleteEngagement3" style="margin-left: 5px;">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            `;

            // Append the row to the container
            engagementFieldsContainer3.appendChild(engagementRow3);

            // Add delete functionality to the button
            const deleteButton3 = engagementRow3.querySelector('.deleteEngagement3');
            deleteButton3.addEventListener('click', () => {
                fetch('./dirback/delete_eng3.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        engagement_id: engagement.engagement_id_three, // Use the engagement ID for deletion
                        project_id: projectId // Project ID for context
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status === 'success') {
                            // Remove the row from the DOM
                            engagementRow3.remove();

                            // Optionally update the engagements3 array
                            const index = engagements3.findIndex(e => e.engagement_id_three === engagement.engagement_id_three);
                            if (index > -1) {
                                engagements3.splice(index, 1);
                            }
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Error deleting engagement:', error);
                        alert('Failed to delete engagement. Please try again.');
                    });
            });
        });

        // Get the container for requirement fields
        const requirementFieldsContainer3 = document.getElementById('requirement-fields-container3');

        // Clear the container before rendering
        requirementFieldsContainer3.innerHTML = '';

        // Fetch requirement data from stage_three
        const requirements3 = data.stages.stage_three.requirement_stage_three || [];

        console.log(requirements3); // Log the requirements to ensure data is fetched

        requirements3.forEach((requirement) => {
            console.log(requirement); // Log each requirement to ensure it is processed correctly

            // Create a row for each requirement
            const requirementRow3 = document.createElement('div');
            requirementRow3.className = 'row align-items-center requirement-fields mb-3';

            // Set the HTML content of the row
            requirementRow3.innerHTML = `
                <div class="col-md-2">
                    <input 
                        value="${requirement.requirement_three || ''}" 
                        name="requirement_three[]" 
                        type="text" 
                        id="req3" 
                        class="form-control" 
                        placeholder="e.g. Sample Requirement"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${requirement.quantity || ''}" 
                        name="quantity[]" 
                        type="number" 
                        id="quantity3" 
                        class="form-control" 
                        placeholder="e.g. 50"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${requirement.bill_of_materials || ''}" 
                        name="bill_of_materials[]" 
                        type="text" 
                        id="bom3" 
                        class="form-control" 
                        placeholder="e.g. 5000"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${requirement.pricing || ''}" 
                        name="pricing[]" 
                        type="number" 
                        id="pricing3" 
                        class="form-control" 
                        placeholder="e.g. 5000"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${requirement.requirement_remarks_three || ''}" 
                        name="requirement_remarks_three[]" 
                        type="text" 
                        id="reqremarks3" 
                        class="form-control" 
                        placeholder="e.g. Sample Remarks"
                    >
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm deleteRequirement3" style="margin-left: 5px;">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            `;

            // Append the row to the container
            requirementFieldsContainer3.appendChild(requirementRow3);

            // Add delete functionality to the button
            const deleteButton3 = requirementRow3.querySelector('.deleteRequirement3');
            deleteButton3.addEventListener('click', () => {
                fetch('./dirback/delete_req3.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        requirement_id: requirement.requirement_id_three, // Use the requirement ID for deletion
                        project_id: projectId // Project ID for context
                    }),
                })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status === 'success') {
                            // Remove the row from the DOM
                            requirementRow3.remove();

                            // Optionally update the requirements3 array
                            const index = requirements3.findIndex(req => req.requirement_id_three === requirement.requirement_id_three);
                            if (index > -1) {
                                requirements3.splice(index, 1);
                            }
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Error deleting requirement:', error);
                        alert('Failed to delete requirement. Please try again.');
                    });
            });
        });
    }

    function fetchStageFour(data,projectId){
        document.getElementById('stage-four-start').value  = data.stages.stage_four.start_date || 'No Data';
        document.getElementById('stage-four-end').value    = data.stages.stage_four.end_date   || 'No Data';
        document.getElementById('stage-four-status').value = data.stages.stage_four.status     || 'No Data';
        document.getElementById('solution4').value = data.stages.stage_four.solution_four || data.stages.stage_three.solution_three || 'No Data';
        document.getElementById('deal_size4').value = Number(data.stages.stage_four.deal_size_four) || Number(data.stages.stage_three.deal_size_three) || 'No Data';
        document.getElementById('stageremarks4').value = data.stages.stage_four.remarks_four || data.stages.stage_three.remarks_three || 'No Data';
        document.getElementById('product4').value = data.stages.stage_four.product_four || data.stages.stage_three.product_three || 'No Data';
        const technology4 = document.getElementById('technology4');
        const techValue4 = data.stages.stage_four.technology_four || data.stages.stage_three.technology_three || 'Select';
        Array.from(technology4.options).forEach(option => {
            if (option.value === techValue4) {
                option.selected = true;
            }
        });
        const requirements = data.stages.stage_four.requirement_stage_four || [];

        // Log the data to ensure it’s being received
        console.log('Fetched Requirements:', requirements);

        // Get the container for requirement fields
        const requirementFieldsContainer4 = document.getElementById('requirement-fields-container4');

        // Clear the container before rendering
        requirementFieldsContainer4.innerHTML = ''; // Clear existing rows

        // Check if requirements is empty or not
        if (requirements.length === 0) {
            console.log("No requirements available to display.");
        } else {
            requirements.forEach((requirement) => {
                console.log('Requirement:', requirement); // Log each requirement to ensure data is correct

                const requirementRow4 = document.createElement('div');
                requirementRow4.className = 'row mb-3 requirement-fields';

                // Set the HTML content of the row with requirement data
                requirementRow4.innerHTML = `
                    <div class="col-md-2">
                        <input 
                            value="${requirement.requirement_four || ''}" 
                            name="requirement_four[]" 
                            type="text" 
                            class="form-control" 
                            placeholder="e.g. Sample Requirement"
                        >
                    </div>
                    <div class="col-md-2">
                        <input 
                            value="${requirement.quantity || ''}" 
                            name="quantity[]" 
                            type="text" 
                            class="form-control" 
                            placeholder="e.g. 50"
                        >
                    </div>
                    <div class="col-md-2">
                        <input 
                            value="${requirement.bill_of_materials || ''}" 
                            name="bill_of_materials[]" 
                            type="text" 
                            class="form-control" 
                            placeholder="e.g. 5000"
                        >
                    </div>
                    <div class="col-md-2">
                        <input 
                            value="${requirement.pricing || ''}" 
                            name="pricing[]" 
                            type="text" 
                            class="form-control" 
                            placeholder="e.g. 2000"
                        >
                    </div>
                    <div class="col-md-2">
                        <input 
                            value="${requirement.date_required || ''}" 
                            name="date_required[]" 
                            type="date" 
                            class="form-control" 
                            style="font-size:10px;"
                        >
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" data-id="${requirement.requirement_id_four}">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                `;

                // Append the row to the container
                requirementFieldsContainer4.appendChild(requirementRow4);

                // Add delete functionality to the button
                const deleteButton4 = requirementRow4.querySelector('.deleteRequirement');
                deleteButton4.addEventListener('click', () => {
                    fetch('./dirback/delete_req4.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            requirement_id: requirement.requirement_id_four, // Use the requirement ID for deletion
                            project_id: projectId // Project ID for context
                        }),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status === 'success') {
                            // Remove the row from the DOM
                            requirementRow4.remove();

                            // Optionally update the requirements array
                            const index = requirements.findIndex(req => req.requirement_id_four === requirement.requirement_id_four);
                            if (index > -1) {
                                requirements.splice(index, 1);
                            }
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Error deleting requirement:', error);
                        alert('Failed to delete requirement. Please try again.');
                    });
                });
            });
        }
    }

    function fetchStageFive(data,projectId){
        document.getElementById('stage-five-start').value = data.stages.stage_five.start_date || 'No Data';
        document.getElementById('stage-five-end').value = data.stages.stage_five.end_date || 'No Data';
        document.getElementById('stage-five-status').value = data.stages.stage_five.status || 'No Data';
        document.getElementById('stage-five-spr').value = data.stages.stage_five.spr || 'No Data';
        document.getElementById('contract').value = data.stages.stage_five.contract_duration || 'No Data';
        document.getElementById('billingType').value = data.stages.stage_five.billing_type || 'No Data';
        document.getElementById('pricing').value = data.stages.stage_five.pricing || 'No Data';
        document.getElementById('solution5').value = data.stages.stage_five.solution_five || data.stages.stage_four.solution_four || 'No Data';
        document.getElementById('deal_size5').value = Number(data.stages.stage_five.deal_size_five) || Number(data.stages.stage_four.deal_size_four) || 'No Data';
        document.getElementById('stageremarks5').value = data.stages.stage_five.remarks_five || data.stages.stage_four.remarks_four || 'No Data';
        document.getElementById('product5').value = data.stages.stage_five.product_five || data.stages.stage_four.product_four || 'No Data';
        const technology5 = document.getElementById('technology5');
        const techValue5 = data.stages.stage_five.technology_five || data.stages.stage_four.technology_four || 'Select';
        Array.from(technology5.options).forEach(option => {
            if (option.value === techValue5) {
                option.selected = true;
            }
        });

        // Fetch upsell data for stage five
        const upsellData = data.stages.stage_five.upsell_stage_five || [];
        const upsellFieldsContainer = document.getElementById('upsell-fields-container');
        upsellFieldsContainer.innerHTML = ''; // Clear existing rows

        upsellData.forEach((upsell) => {
            const upsellRow = document.createElement('div');
            upsellRow.className = 'row mb-3 upsell-fields';

            // Set the HTML content of the row with upsell data
            upsellRow.innerHTML = `
                <div class="col-md-2">
                    <input 
                        value="${upsell.upsell || ''}" 
                        name="upsell[]" 
                        type="text" 
                        class="form-control" 
                        placeholder="e.g Router 2000"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${upsell.bills_materials_upsell || ''}" 
                        name="bills_materials_upsell[]" 
                        type="number" 
                        class="form-control" 
                        placeholder="e.g 5000"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${upsell.quantity_upsell || ''}" 
                        name="quantity_upsell[]" 
                        type="number" 
                        class="form-control" 
                        placeholder="e.g 50"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${upsell.remarks_upsell || ''}" 
                        name="remarks_upsell[]" 
                        type="text" 
                        class="form-control" 
                        placeholder="e.g. Sample Remarks"
                    >
                </div>
                <div class="col-md-2">
                    <input 
                        value="${upsell.amount_upsell || ''}" 
                        name="amount_upsell[]" 
                        type="number" 
                        class="form-control" 
                        placeholder="e.g. 6000"
                    >
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm deleteUpsellRow" data-id="${upsell.upsell_id_five}">
                        <i class="fas fa-minus"></i>
                    </button>
                </div>
            `;

            // Append the row to the container
            upsellFieldsContainer.appendChild(upsellRow);

            // Add delete functionality to the button
            const deleteButton = upsellRow.querySelector('.deleteUpsellRow');
            deleteButton.addEventListener('click', () => {
                fetch('./dirback/delete_upsell.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        upsell_id: upsell.upsell_id_five, // Use the upsell ID for deletion
                        project_id: projectId // Project ID for context
                    }),
                })
                .then((response) => response.json())
                .then((data) => {
                    if (data.status === 'success') {
                        // Remove the row from the DOM
                        upsellRow.remove();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch((error) => {
                    console.error('Error deleting upsell:', error);
                    alert('Failed to delete upsell. Please try again.');
                });
            });
        });

        // Fetch requirement data for stage five
        const requirementData = data.stages.stage_five.requirement_stage_five || [];
        const requirementFieldsContainer = document.getElementById('requirement-fields-container5');
        requirementFieldsContainer.innerHTML = ''; // Clear existing rows

        // If no data is found, log it
        if (requirementData.length === 0) {
            console.log("No requirement data available.");
        } else {
            // Loop through each requirement and render a row
            requirementData.forEach((requirement) => {
                console.log('Requirement Item:', requirement); // Log the requirement item to ensure it's correct

                const requirementRow = document.createElement('div');
                requirementRow.className = 'row mb-3 requirement-fields';

                // Create and set the HTML content of the row with requirement data
                requirementRow.innerHTML = `
                    <div class="col-md-3">
                        <select name="req_five[]" class="form-control">
                            <option disabled selected>Select Requirement</option>
                            <option value="cisco-network" ${requirement.req_five === 'cisco-network' ? 'selected' : ''}>Cisco Network</option>
                            <option value="cloud-computing" ${requirement.req_five === 'cloud-computing' ? 'selected' : ''}>Cloud Computing</option>
                            <option value="cybersecurity" ${requirement.req_five === 'cybersecurity' ? 'selected' : ''}>Cybersecurity</option>
                            <option value="database-management" ${requirement.req_five === 'database-management' ? 'selected' : ''}>Database Management</option>
                            <option value="software-development" ${requirement.req_five === 'software-development' ? 'selected' : ''}>Software Development</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input 
                            value="${requirement.quantity || ''}" 
                            name="quantity[]" 
                            type="number" 
                            class="form-control" 
                            placeholder="e.g. 50"
                        >
                    </div>
                    <div class="col-md-2">
                        <input 
                            value="${requirement.bills_materials_req || ''}" 
                            name="bills_materials_req[]" 
                            type="number" 
                            class="form-control" 
                            placeholder="e.g. 5000"
                        >
                    </div>
                    <div class="col-md-3">
                        <input 
                            value="${requirement.remarks_req || ''}" 
                            name="remarks_req[]" 
                            type="text" 
                            class="form-control" 
                            placeholder="e.g. Sample Requirement Remarks"
                        >
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" data-id="${requirement.requirement_id_five}">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                `;

                // Append the row to the container
                requirementFieldsContainer.appendChild(requirementRow);

                // Add delete functionality to the button
                const deleteButton = requirementRow.querySelector('.deleteRequirement');
                deleteButton.addEventListener('click', () => {
                    fetch('./dirback/delete_req5.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            requirement_id: requirement.requirement_id_five, // Use the requirement ID for deletion
                            project_id: projectId // Project ID for context
                        }),
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.status === 'success') {
                            // Remove the row from the DOM
                            requirementRow.remove();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch((error) => {
                        console.error('Error deleting requirement:', error);
                        alert('Failed to delete requirement. Please try again.');
                    });
                });
            });
        }

    }