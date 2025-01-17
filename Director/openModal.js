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
                    console.log(data);
                    document.getElementById('start-date-placeholder').value = data.stages.stage_one.start_date || 'No Data';
                    document.getElementById('end-date-placeholder').value   = data.stages.stage_one.end_date   || 'No Data';
                    document.getElementById('status-placeholder').value     = data.stages.stage_one.status     || 'No Data';
                    document.getElementById('solution1').value = data.stages.stage_one.solution || 'No Data';
                    document.getElementById('dealSize1').value = data.stages.stage_one.deal_size || 'No Data';
                    document.getElementById('stageremarks1').value = data.stages.stage_one.remarks || 'No Data';
                    document.getElementById('distributorSelect').value = data.stages.stage_one.distributor || 'Select';
                    document.getElementById('product1').value = data.stages.stage_one.product || 'No Data';
                    const distributorSelect = document.getElementById('distributorSelect');
                    const distributorValue = data.stages.stage_one.distributor || 'Select';
                    Array.from(distributorSelect.options).forEach(option => {
                        if (option.value === distributorValue) {
                            option.selected = true;
                        }
                    });
                    const technology1 = document.getElementById('technology1');
                    const techValue = data.stages.stage_one.technology || 'Select';
                    Array.from(technology1.options).forEach(option => {
                        if (option.value === techValue) {
                            option.selected = true;
                        }
                    });
                    // Get the container for requirements
                    const requirementContainer = document.getElementById('requirement-container');

                    // Clear only if no existing fields are present
                    if (!requirementContainer.querySelector('.requirement-field')) {
                        const requirements = data.stages.stage_one.requirements || []; // Fetch requirements from data

                        requirements.forEach((requirement) => {
                            // Create a row for each requirement
                            const requirementRow = document.createElement('div');
                            requirementRow.className = 'row align-items-center requirement-field';
                            requirementRow.style.margin = '5px 0 0 0';

                            // Set the HTML content of the row
                            requirementRow.innerHTML = `
                                <div class="col-10 d-flex align-items-center">
                                    <!-- Input field for Requirement -->
                                    <input 
                                        value="${requirement.requirement_one}" 
                                        name="requirement_one[]" 
                                        style="width: 100%;" 
                                        type="text" 
                                        class="form-control" 
                                        data-id="${requirement.requirement_id_one}" 
                                        placeholder="e.g. Sample Requirement"
                                    >
                                </div>
                                <div class="col-2 d-flex justify-content-end align-items-center">
                                    <!-- Delete Button -->
                                    <button type="button" class="btn btn-danger btn-sm" style="margin-left: 5px;">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            `;

                            // Append the row to the container
                            requirementContainer.appendChild(requirementRow);

                            // Add delete functionality to the button
                            const deleteButton = requirementRow.querySelector('button');
                            deleteButton.addEventListener('click', () => {
                                fetch('./dirback/delete_req1.php', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: JSON.stringify({
                                        requirement_id: requirement.requirement_id_one, // Use the requirement ID for deletion
                                        project_id: projectId // Project ID for context
                                    }),
                                })
                                    .then((response) => response.json())
                                    .then((data) => {
                                        if (data.status === 'success') {
                                            // Remove the row from the DOM
                                            requirementRow.remove();

                                            // Optionally update the requirements array
                                            const index = requirements.findIndex(req => req.requirement_id_one === requirement.requirement_id_one);
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



                    document.getElementById('project-unique-id').value = data.project_id || 'No Data';
                    document.getElementById('client-name').textContent = data.company_name || 'No Data';


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

                    //Navigate to the current stage
                    const currentStage = data.current_stage;
                    if (currentStage) {
                        const stageNumber = parseInt(currentStage.split(' ')[1]); // Extract stage number
                        currentStep = stageNumber;
                        markCompletedSteps(stageNumber); // Mark previous steps as completed
                        showStep(stageNumber); // Show the current step
                    } else {
                        console.warn("No current stage data found.");
                    }
                } else {
                    console.error('Error:', data.message);
                    console.error('API Error:', data.message);
                    alert('Waray data: ' + data.message);
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