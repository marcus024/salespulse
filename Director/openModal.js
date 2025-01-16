 function openModal(projectId) {
        // Check if projectId is valid before proceeding
        console.log("Received Project ID:", projectId);
        if (!projectId) {
            console.error("No project ID provided.");
            return;
        }

        // Set the project unique ID in the modal and globally
        document.getElementById('project-id-placeholder').textContent = projectId;
        const projectIdPlaceholder = document.getElementById('project-id-placeholder');
        if (projectIdPlaceholder) {
            projectIdPlaceholder.textContent = projectId;
        } else {
            console.error("Element #project-id-placeholder not found.");
        }

        // Update the display in all steps
        updateProjectIdDisplay(projectId);

        // Fetch project details, including current stage, from the backend
        fetch(`./dirback/openModaldata.php?project_id=${projectId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP Error: ${response.status}`);
                }
                // alert("Successfully fetched data from server!");
                return response.json();
                
            })
            .then(data => {
                if (data.status === 'success') {
                    // alert("Successful Fetch");
                    //Populate modal fields with project data
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
                    const requirementContainer = document.getElementById('requirement-container');
                    requirementContainer.innerHTML = ''; // Clear existing fields

                    const requirements = data.stages.stage_one.requirement1 || [];
                    requirements.forEach((requirement) => {
                        const requirementRow = document.createElement('div');
                        requirementRow.className = 'row align-items-center requirement-field';
                        requirementRow.style.margin = '5px 0';

                        requirementRow.innerHTML = `
                            <div class="col-9 d-flex align-items-center">
                                <input name="requirement_one[]" style="width: 100%;" type="text" class="form-control" 
                                    value="${requirement}" placeholder="e.g. Sample Requirement">
                            </div>
                            <div class="col-2 d-flex justify-content-end align-items-center">
                                <button type="button" class="btn btn-danger btn-sm" style="margin-left: 5px;" onclick="removeRequirement(this)">
                                    <i class="fas fa-minus"></i>
                                </button>
                            </div>
                        `;

                        requirementContainer.appendChild(requirementRow);
                    });





                    document.getElementById('project-unique-id').value = data.project_id || 'No Data';
                    document.getElementById('client-name').textContent = data.company_name || 'No Data';

                    // Populate all stage data
                    document.getElementById('stage-two-start').value  = data.stages.stage_two.start_date || 'No Data';
                    document.getElementById('stage-two-end').value    = data.stages.stage_two.end_date   || 'No Data';
                    document.getElementById('stage-two-status').value = data.stages.stage_two.status     || 'No Data';

                    document.getElementById('stage-three-start').value  = data.stages.stage_three.start_date || 'No Data';
                    document.getElementById('stage-three-end').value    = data.stages.stage_three.end_date   || 'No Data';
                    document.getElementById('stage-three-status').value = data.stages.stage_three.status     || 'No Data';

                    document.getElementById('stage-four-start').value  = data.stages.stage_four.start_date || 'No Data';
                    document.getElementById('stage-four-end').value    = data.stages.stage_four.end_date   || 'No Data';
                    document.getElementById('stage-four-status').value = data.stages.stage_four.status     || 'No Data';

                    document.getElementById('stage-five-start').value = data.stages.stage_five.start_date || 'No Data';
                    document.getElementById('stage-five-end').value = data.stages.stage_five.end_date || 'No Data';
                    document.getElementById('stage-five-status').value = data.stages.stage_five.status || 'No Data';
                    document.getElementById('stage-five-spr').value = data.stages.stage_five.sprNum || 'No Data';

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