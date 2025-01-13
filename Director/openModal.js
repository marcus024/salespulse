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
        fetch(`./openModaldata.php?project_id=${projectId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP Error: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // Populate modal fields with project data
                    document.getElementById('start-date-placeholder').value = data.stages.stage_one.start_date || 'No Data';
                    document.getElementById('end-date-placeholder').value   = data.stages.stage_one.end_date   || 'No Data';
                    document.getElementById('status-placeholder').value     = data.stages.stage_one.status     || 'No Data';

                    document.getElementById('project-unique-id').value = projectId || 'No Data';
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
                    document.getElementById('stage-five-status').value = data.stages.stage_five.sprNum || 'No Data';
                    document.getElementById('stage-five-spr').value = data.stages.stage_five.sprNum || 'No Data';

                    // Navigate to the current stage
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
                alert('Project ID is not found!');
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