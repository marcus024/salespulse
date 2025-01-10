            <style>
                .step {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }
                .step-circle {
                    width: 50px;
                    height: 50px;
                    border-radius: 50%;
                    background: white;
                    color: #36b9cc;
                    font-size: 20px;
                    font-family: 'Poppins';
                    font-weight : 700px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border: 2px solid #36b9cc;
                }
                .step-line {
                    flex: 1;
                    height: 2px;
                    background: #ddd;
                }
                .step-circle.active {
                    background: #36b9cc;
                    color: #fff;
                    border-color: #36b9cc;
                }
                .step-line.active {
                    background: #36b9cc;
                }
                .step-circle.completed {
                    background: #36b9cc;
                    color: #fff;
                    border-color: #36b9cc;
                    font-size: 24px; /* Adjust the font size for the check mark */
                }
                .form-label, .btn {
                    font-size: 12px;
                    color:white;
                    font-family: 'Poppins'
                }
                .modal-title{
                    color:black;
                    font-size: 15px;
                    font-weight: 600px;
                    font-family: 'Poppins'
                }
                input, select {
                    font-size: 12px;
                    color:#555;
                    font-family: 'Poppins';
                }
                #multiStepModal .modal-dialog {
                    max-width: 800px; /* Increased width */
                }
                #multiStepModal .form-container {
                    background-color: #009393;
                    padding: 20px;
                    border-radius: 8px;
                }
                #multiStepModal .stage-title {
                    font-size: 1.5rem;
                    font-weight: bold;
                    color: #fff;
                    margin-bottom: 20px;
                    text-align: center;
                    font-family: 'Poppins';
                }
                #multiStepModal .sales-pulse {
                    position: absolute;
                    bottom: 10px;
                    left: 10px;
                    font-size: 1rem;
                    color: #555;
                }
            </style>
            <div class="modal fade" id="multiStepModal" tabindex="-1" aria-labelledby="multiStepModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content" class="modal-content" style="background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(2px); border-radius: 5px;">
                        <div class="modal-header" style="background-color:#36b9cc; height: 50px;">
                            <h5 class="modal-title" id="addProjectModalLabel" style="font-size: 15px; color:white;">Client Name</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body position-relative">
                            <div class="d-flex justify-content-between align-items-center mb-4 step">
                                <div class="step-circle" id="step1-circle">1</div>
                                <div class="step-line" id="line1"></div>
                                <div class="step-circle" id="step2-circle">2</div>
                                <div class="step-line" id="line2"></div>
                                <div class="step-circle" id="step3-circle">3</div>
                                <div class="step-line" id="line3"></div>
                                <div class="step-circle" id="step4-circle">4</div>
                                <div class="step-line" id="line4"></div>
                                <div class="step-circle" id="step5-circle">5</div>
                            </div>
                            <form id="multiStepForm" method="POST">
                                <div class="form-step" id="step1">
                                    <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p id="projectUniqueId" style="color: #36b9cc; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 1 - <span id="project-id-placeholder">[Project ID]</span></p> 
                                            <h4 style="color: #36b9cc; margin-top: 0; font-family: 'Poppins', sans-serif;">Awareness/Prospecting</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #36b9cc;">70%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="mb-2">
                                                        <!-- Container for the Label and Add Requirement Button -->
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <label for="requirement" class="form-label text-white">Requirement</label>
                                                            <!-- Clickable label for adding another field -->
                                                            <a href="#" id="addRequirement" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                                <i class="fas fa-plus"></i> Add Another
                                                            </a>
                                                        </div>
                                                        <!-- Requirement Field with Delete Button -->
                                                        <div class="row align-items-center requirement-field" id="requirement-container" style="margin-top:5px; margin-bottom: 5px;">
                                                            <div class="col-9 d-flex align-items-center">
                                                                <!-- Input field for Requirement -->
                                                                <input  style="width: 100%;" type="text" class="form-control" id="requirement" placeholder="e.g. Sample Requirement">
                                                            </div>
                                                            <div class="col-2 d-flex justify-content-end align-items-center">
                                                                <!-- Delete Button -->
                                                                <button type="button" class="btn btn-danger btn-sm" style="margin-left: 5px;" id="deleteRequirement">
                                                                    <i class="fas fa-minus"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="solution" class="form-label text-white">Solution</label>
                                                        <textarea name="solution" class="form-control" id="remarks" placeholder="e.g. Sample Solution" 
                                                                style="height:100px;"></textarea>
                                                    </div>
                                                    <style>
                                                        .custom-select {
                                                            appearance: none; 
                                                            -moz-appearance: none;
                                                            -webkit-appearance: none;
                                                            background: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23555555"%3E%3Cpath d="M7 10l5 5 5-5z"/%3E%3C/svg%3E') no-repeat right 10px center;
                                                            background-color: #fff;
                                                            background-size: 12px 12px;
                                                            padding-right: 30px; 
                                                        }
                                                        .custom-select-dark {
                                                            background: url('data:image/svg+xml;charset=UTF-8,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="%23ffffff"%3E%3Cpath d="M7 10l5 5 5-5z"/%3E%3C/svg%3E') no-repeat right 10px center;
                                                            background-color: #343a40;
                                                            color: white;
                                                            padding-right: 30px;
                                                        }
                                                    </style>
                                                   
                                                   
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-6">
                                                        <label for="remarks" class="form-label text-white">Remarks</label>
                                                        <textarea name="stage_one_remarks" class="form-control" id="remarks" placeholder="e.g. Sample Remarks" 
                                                                style="height: 300px;"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step2">
                                    <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                             <p id="projectUniqueIdStage2" style="color: #36b9cc; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 2 - <span id="project-id-placeholder-stage2">[Project ID]</span></p>

                                            <h4 style="color: #36b9cc; margin-top: 0; font-family: 'Poppins', sans-serif;">Engagement/Discovery</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #36b9cc;">70%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px"> 
                                       
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Type of Engagement</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Date</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="requirement" class="form-label text-white">Remarks</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="#" id="addEngagement" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                        <i class="fas fa-plus"></i> Add Another
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step3">
                                <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p id="projectUniqueIdStage2" style="color: #36b9cc; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 3 - <span id="project-id-placeholder-stage2">[Project ID]</span></p>

                                            <h4 style="color: #36b9cc; margin-top: 0; font-family: 'Poppins', sans-serif;">Presentation/Proposal</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #36b9cc;">70%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                
                                               
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <input type="textarea" class="form-control" id="requirement"style="height: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step4">
                                    <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p style="color: #36b9cc; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 4</p>
                                            <h4 style="color: #36b9cc; margin-top: 0; font-family: 'Poppins', sans-serif;">Negotiation/Commitment</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #36b9cc;">70%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="requirement" placeholder="Auto-generated" readonly>
                                                </div>
                                                
                                               
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step5">
                                <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p style="color: #36b9cc; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 5</p>
                                            <h4 style="color: #36b9cc; margin-top: 0; font-family: 'Poppins', sans-serif;">Delivery/Follow-up</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #36b9cc;">70%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px"> 
                                       
                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                        <label for="requirement" class="form-label text-white">SPR</label>
                                                        <input type="text" class="form-control" id="requirement" placeholder="e.g. SPR">
                                                    </div>
                                                    
                                                </div>
                                             
                                            </div>
                                        </div>
                                       
                                    </div>
                                </div>
                        </div>
                            <div class="modal-footer">
                                <div class="footer-left">
                                    <div id="logoPlaceholder"></div>
                                    <div id="salesPulse">Sales Pulse</div>
                                </div>
                                <button type="button" class="btn btn-danger" id="deleteButton" style="border-color: red; background-color: #fff; color: red; font-size: 12px;">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                <button type="button" class="btn btn-success" id="saveButton" style="border-weight: 5px; border-color: #36b9cc; background-color: #fff; color: #36b9cc; font-size: 12px;">
                                    Save
                                </button>
                                <button type="button" class="btn btn-success" id="completeButton" style="background-color: #36b9cc; color: white; font-size: 12px;">
                                    Complete
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        <script>
            let currentStep = 1;
            const totalSteps = 5;

            // Save Button Logic
            document.getElementById('saveButton').addEventListener('click', () => {
                const projectId = document.getElementById('project-unique-id').value;

                if (projectId) {
                    alert(`Project ID fetched: ${projectId}`); 

                    if (confirm('Do you want to save changes?')) {
                        let formData = new FormData();
                        formData.append('project_id', projectId);
                        formData.append('current_step', currentStep);

                        // Get form fields specific to the current step
                        const currentStepFields = document.querySelectorAll(`#step${currentStep} input`);
                        currentStepFields.forEach(field => {
                            formData.append(field.name, field.value);
                        });

                        const saveUrl = `dirback/save/save_stage${currentStep}.php`; 
                        fetch(saveUrl, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => response.json()) 
                        .then(data => {
                            if (data.success) {
                                alert('Data saved successfully! Your changes have been applied.');
                            } else {
                                alert('Error: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error during fetch:', error);
                            alert('An error occurred while saving. Please try again.');
                        });
                    }
                } else {
                    alert('Error: Project ID is missing.');
                }
            });

            // Complete Button Logic
            document.getElementById('completeButton').addEventListener('click', () => {
                const projectId = document.getElementById('project-unique-id').value;

                if (projectId) {
                    const stages = document.querySelectorAll('[id^="project-id-placeholder-stage"]');
                    stages.forEach((stage) => {
                        stage.textContent = projectId;
                    });

                    alert(`Project ID fetched and displayed across all stages: ${projectId}`);

                    passProjectToNextStage(projectId, currentStep);
                } else {
                    alert('Error: Project ID is missing.');
                }
            });

            // Function to handle the transition between stages
            function passProjectToNextStage(projectId, currentStep) {
                if (!projectId) {
                    alert('Error: Project ID is missing.');
                    return;
                }

                // Confirm the transition
                if (!confirm(`Do you want to complete stage ${currentStep} and proceed to stage ${currentStep + 1}?`)) {
                    return;
                }

                let formData = new FormData();
                formData.append('project_id', projectId);
                formData.append('current_step', currentStep);

                // Get form fields specific to the current step
                const currentStepFields = document.querySelectorAll(`#step${currentStep} input`);
                currentStepFields.forEach(field => {
                    formData.append(field.name, field.value);
                });

                const saveUrl = `dirback/complete/complete_stage${currentStep}.php`;

                fetch(saveUrl, {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(`Stage ${currentStep} completed. Moving to stage ${currentStep + 1}.`);

                        // Update UI for stage completion
                        document.getElementById(`step${currentStep}-circle`).classList.add('completed');
                        document.getElementById(`step${currentStep}-circle`).textContent = '✔';
                        document.getElementById(`line${currentStep}`).classList.add('active');

                        // Populate the next stage details
                        if (data.next_stage_details) {
                            const nextStep = currentStep + 1;
                            document.getElementById(`requirementStartDate${nextStep}`).value = data.next_stage_details.start_date;
                            document.getElementById(`requirementEndDate${nextStep}`).value = data.next_stage_details.end_date;
                            document.getElementById(`requirementStatus${nextStep}`).value = data.next_stage_details.status;
                        }

                        // Proceed to the next step
                        currentStep++;
                        if (currentStep <= totalSteps) {
                            showStep(currentStep);
                        } else {
                            alert('All stages completed!');
                        }
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error during fetch:', error);
                    alert('An error occurred while completing the stage. Please try again.');
                });
            }

            // Delete Button Logic
            document.getElementById('deleteButton').addEventListener('click', () => {
                const projectId = document.getElementById('project-unique-id').value;
                if (!projectId) {
                    alert('Project ID is missing. Please try again.');
                    return;
                }
                if (confirm('Are you sure you want to cancel this project? This action cannot be undone.')) {
                    const deleteUrl = `dirback/delete/delete_stage1.php`; 
                    const formData = new FormData();
                    formData.append('project_id', projectId); 
                    fetch(deleteUrl, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json()) 
                    .then(data => {
                        if (data.success) {
                            alert('Project and stage statuses updated to "Cancelled" successfully.');
                            window.location.reload(); 
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error during cancellation:', error);
                        alert('An error occurred while cancelling the project. Please try again.');
                    });
                }
            });

            // Show the current step and hide others
            function showStep(step) {
                for (let i = 1; i <= totalSteps; i++) {
                    document.getElementById(`step${i}`).classList.add('d-none');
                }
                document.getElementById(`step${step}`).classList.remove('d-none');
            }

            // Reset steps if the form is deleted or reset
            function resetSteps() {
                for (let i = 1; i <= totalSteps; i++) {
                    document.getElementById(`step${i}-circle`).classList.remove('active', 'completed');
                    document.getElementById(`step${i}-circle`).textContent = i;
                    document.getElementById(`line${i}`).classList.remove('active');
                }
                currentStep = 1;
                showStep(currentStep); 
            }
   </script>