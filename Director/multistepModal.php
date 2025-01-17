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
                            <h5 class="modal-title" id="client-name" style="font-size: 15px; color:white;"></h5>
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
                            <form id="multiStepForm" >
                                <div class="form-step" id="step1">
                                    <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p id="projectUniqueId" style="color: #36b9cc; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 1 <span hidden style="color:rgba(255, 255, 255, 0.9);" id="project-id-placeholder">[Project ID]</span></p> 
                                            <h4 style="color: #36b9cc; margin-top: 0; font-family: 'Poppins', sans-serif;">Awareness/Prospecting</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #36b9cc;">20%</span></p>
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
                                                            <a href="#" id="addRequiremen" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                                <i class="fas fa-plus"></i> Add Another
                                                            </a>
                                                        </div>
                                                        <!-- Requirement Field with Delete Button -->
                                                        <div class="row align-items-center requirement-field" id="requirement-container" style="margin-top:5px; margin-bottom: 5px;">
                                                            <div class="col-9 d-flex align-items-center">
                                                                <!-- Input field for Requirement -->
                                                                <input  name="requirement_one[]" style="width: 100%;" type="text" class="form-control" id="requirement1" placeholder="e.g. Sample Requirement">
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
                                                        <textarea name="solution" class="form-control" id="solution1" placeholder="e.g. Sample Solution" 
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
                                                    <div class="mb-2">
                                                        <label for="technology" class="form-label text-white">Technology</label>
                                                        <select name="technology" class="form-control custom-select" id="technology1">
                                                            <option disabled>Select</option>
                                                            <option>Artificial Intelligence</option>
                                                            <option>Machine Learning</option>
                                                            <option>Blockchain</option>
                                                            <option>Internet of Things (IoT)</option>
                                                            <option>Cloud Computing</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="dealSize" class="form-label text-white">Deal Size</label>
                                                        <input name="deal_size" type="number" class="form-control" id="dealSize1" placeholder="e.g. 5000">
                                                    </div>
                                                   
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="mb-6">
                                                        <label for="remarks" class="form-label text-white">Stage Remarks</label>
                                                        <textarea name="stage_one_remarks" class="form-control" id="stageremarks1" placeholder="e.g. Sample Remarks" 
                                                                style="height: 300px;"></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="mb-2">
                                                    <label for="distributor" class="form-label text-white">Distributor</label>
                                                    <select name="distributor" id="distributorSelect" class="form-control custom-select">
                                                        <option disabled selected>Select</option>
                                                        <!-- Existing options can be removed or loaded dynamically -->
                                                        <!-- Special option for adding new distributor -->
                                                        <option value="add_new">+ Add New Distributor...</option>
                                                    </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="product" class="form-label text-white">Product</label>
                                                        <input name="product" id="product1" type="text" class="form-control" placeholder="e.g. Cisco" >
                                                    </div>
                                                    <div class="mb-2">
                                                         <div class="mb-2">
                                                        <label for="startDate" class="form-label">Status</label>
                                                        <input  id="status-placeholder" type="text" class="form-control" readonly>
                                                    </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="startDate" class="form-label">Start Date</label>
                                                        <input  id="start-date-placeholder" type="text" class="form-control" readonly>
                                                    </div>
                                                    <div class="mb-2">
                                                        <input name="project_unique_id" id="project-unique-id" type="hidden" value="<?php echo $projectId; ?>" class="form-control" readonly>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label for="endDate" class="form-label">End Date</label>
                                                        <input  id="end-date-placeholder" type="text" class="form-control" readonly>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step2">
                                    <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p class="project-id-dis" style="color: #36b9cc; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 2 <span hidden style="color:rgba(255, 255, 255, 0.9);" id="project-id-placeholder">[Project ID]</span></p>
                                            <h4 style="color: #36b9cc; margin-top: 0; font-family: 'Poppins', sans-serif;">Engagement/Discovery</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #36b9cc;">40%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="stage-two-start" readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input type="text" class="form-control" id="stage-two-end"   readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Status</label>
                                                    <input type="text" class="form-control" id="stage-two-status"   readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="technology" class="form-label text-white">Technology</label>
                                                    <select name="technology" class="form-control custom-select" id="technology2">
                                                        <option disabled>Select</option>
                                                        <option value="Artificial Intelligence" >Artificial Intelligence</option>
                                                        <option value="Machine Learning" >Machine Learning</option>
                                                        <option value="Blockchain" >Blockchain</option>
                                                        <option value="Internet of Things (IoT)" >Internet of Things (IoT)</option>
                                                        <option value="Cloud Computing" >Cloud Computing</option>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="dealSize" class="form-label text-white">Deal Size</label>
                                                    <input name="deal_size" type="number" class="form-control" id="deal_size2" placeholder="e.g. 5000">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="product" class="form-label text-white">Product</label>
                                                    <input name="product" id="product2" type="text" class="form-control" placeholder="e.g. Router">
                                                </div>
                                                <div class="col-md-6">
                                                   <label for="solution" class="form-label text-white">Solution</label>
                                                        <textarea name="solution" class="form-control" id="solution2" placeholder="e.g. Sample Solution" 
                                                        style="height:50px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="engagement" class="form-label text-white">Type of Engagement</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="engagement" class="form-label text-white">Date</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="engagement" class="form-label text-white">Remarks</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- Add Another Button -->
                                                    <a href="#" id="addEngagement" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                        <i class="fas fa-plus"></i> Add Another
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- Container for Engagement Fields -->
                                            <div id="engagement-fields-container">
                                                <div class="row engagement-fields mb-3">
                                                    <div class="col-md-3">
                                                        <input name="engagement_type[]" type="text" id="engtype2" class="form-control" placeholder="e.g. Sample Engagement">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="engagement_date[]" type="date" id="engdate2" class="form-control" style="font-size:10px;">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input name="engagement_remarks[]" type="text" id="engremarks2" class="form-control" placeholder="e.g. Sample Remarks">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <!-- Remove Button -->
                                                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <!-- Header Row -->
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Requirement</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Date</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="requirement" class="form-label text-white">Requirement Remarks</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- Add Another Button -->
                                                    <a href="#" id="addReq" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                        <i class="fas fa-plus"></i> Add Another
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Container for Requirement Fields -->
                                            <div id="requirement-fields-container">
                                                <!-- Initial Requirement Row -->
                                                <div class="row requirement-fields mb-3">
                                                    <div class="col-md-3">
                                                        <input name="requirement_two[]" type="text" id="req2" class="form-control" placeholder="e.g. Sample Requirement">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="requirement_date[]" type="date" id="reqdate2" class="form-control" style="font-size:10px;">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input name="requirement_remarks[]" type="text" id="reqremarks2"class="form-control" placeholder="e.g. Sample Remarks">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <!-- Remove Button -->
                                                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <input name="stage_two_remarks" type="textarea" class="form-control" id="stageremarks2" style="height: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step3">
                                <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p class="project-id-dis" style="color: #36b9cc; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 3 <span hidden style="color:rgba(255, 255, 255, 0.9);" id="project-id-placeholder">[Project ID]</span></p>
                                            <h4 style="color: #36b9cc; margin-top: 0; font-family: 'Poppins', sans-serif;">Presentation/Proposal</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #36b9cc;">60%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input name="" type="text" class="form-control" id="stage-three-start"  readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input name="" type="text" class="form-control" id="stage-three-end"  readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="status" class="form-label text-white">Status</label>
                                                    <input name="" type="text" class="form-control" id="stage-three-status"  readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Technology</label>
                                                    <select name="technology" class="form-control custom-select" id="technology3">
                                                        <option disabled >Select</option>
                                                        <option value="Artificial Intelligence">Artificial Intelligence</option>
                                                        <option value="Machine Learning" >Machine Learning</option>
                                                        <option value="Blockchain">Blockchain</option>
                                                        <option value="Internet of Things (IoT)">Internet of Things (IoT)</option>
                                                        <option value="Cloud Computing">Cloud Computing</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Product</label>
                                                    <input name="product" id="product3" type="text" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="status" class="form-label text-white">Deal Size(Amount)</label>
                                                   <input name="deal_size" type="number" class="form-control" id="deal_size3" placeholder="e.g. 5000">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="status" class="form-label text-white">Solution</label>
                                                   <textarea name="solution" class="form-control" id="solution3" placeholder="e.g. Sample Solution" 
                                                        style="height:50px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row mb-1">
                                                <div class="col-md-3">
                                                    <label for="engagement" class="form-label text-white">Type of Engagement</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="engagement" class="form-label text-white">Date</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="engagement" class="form-label text-white">Remarks</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- Add Another Button -->
                                                    <a href="#" id="addEngagement3" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                        <i class="fas fa-plus"></i> Add Another
                                                    </a>
                                                </div>
                                            </div>
                                            <!-- Container for Engagement Fields -->
                                            <div id="engagement-fields-container3">
                                                <div class="row engagement-fields mb-3">
                                                    <div class="col-md-3">
                                                        <input name="engagement_three[]" type="text" class="form-control" placeholder="e.g. Sample Engagement">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="engagement_date[]" type="date" class="form-control" style="font-size:10px;">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input name="engagement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <!-- Remove Button -->
                                                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <!-- Header Row -->
                                            <div class="row mb-1">
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Requirement</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Quantity</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Bill of Materials</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Pricing</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Remarks</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <!-- Add Another Button -->
                                                    <a href="#" id="addReq_3" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                        <i class="fas fa-plus"></i> Add Another
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Container for Requirement Fields -->
                                            <div id="requirement-fields-container3">
                                                <!-- Initial Requirement Row -->
                                                <div class="row requirement-fields mb-3">
                                                    <div class="col-md-2">
                                                        <input name="requirement_three[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="bill_of_materials[]" type="text" class="form-control" placeholder="e.g. 5000">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="pricing[]" type="number" class="form-control" placeholder="e.g. 5000">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="requirement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <!-- Remove Button -->
                                                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <input name="stage_three_remarks" type="textarea" class="form-control" id="stageremarks3" style="height: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step4">
                                    <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p class="project-id-dis" style="color: #36b9cc; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 4<span hidden style="color:rgba(255, 255, 255, 0.9);" id="project-id-placeholder">[Project ID]</span></p>
                                            <h4 style="color: #36b9cc; margin-top: 0; font-family: 'Poppins', sans-serif;">Negotiation/Commitment</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #36b9cc;">80%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="stage-four-start"  readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input type="text" class="form-control" id="stage-four-end"  readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="status" class="form-label text-white">Status</label>
                                                    <input type="text" class="form-control" id="stage-four-status"  readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Technology</label>
                                                    <select name="technology" class="form-control custom-select" id="technology4">
                                                        <option disabled selected>Select</option>
                                                        <option>Artificial Intelligence</option>
                                                        <option>Machine Learning</option>
                                                        <option>Blockchain</option>
                                                        <option>Internet of Things (IoT)</option>
                                                        <option>Cloud Computing</option>
                                                    </select>
                                                </div>
                                               
                                            </div>
                                            <div class="row mb-3">
                                                 <div class="col-md-3">
                                                    <label for="product" class="form-label text-white">Product</label>
                                                    <input name="product" id="product4" type="text" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                   <label for="dealSize" class="form-label text-white">Deal Size</label>
                                                    <input name="deal_size" type="number" class="form-control" id="deal_size4" placeholder="e.g. 5000">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="status" class="form-label text-white">Solution</label>
                                                    <textarea name="solution" class="form-control" id="solution4" placeholder="e.g. Sample Solution" 
                                                    style="height:50px;"></textarea>
                                                </div>
                                                
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <!-- Fixed Labels Row -->
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Requirement</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="quantity" class="form-label text-white">Quantity</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="bills_of_materials" class="form-label text-white">Bills of Materials</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="pricing" class="form-label text-white">Pricing</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="date_required" class="form-label text-white">Date Required</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <a href="#" id="addRequirement4" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                        <i class="fas fa-plus"></i> Add Another
                                                    </a>
                                                </div>
                                            </div>

                                            <!-- Container for Input Rows -->
                                            <div id="requirement-fields-container4">
                                                <!-- Initial Input Row -->
                                                <div class="row mb-3 requirement-fields">
                                                    <div class="col-md-2">
                                                        <input name="requirement_four[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="quantity[]" type="text" class="form-control" placeholder="e.g. 50">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="bill_of_materials[]" type="text" class="form-control" placeholder="e.g. 5000">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="pricing[]" type="text" class="form-control" placeholder="e.g. 2000">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="date_required[]" type="date" class="form-control" style="font-size:10px;">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-danger btn-sm deleteRequirement">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <input name="stage_four_remarks" type="textarea" class="form-control" id="stageremarks4" style="height: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-step d-none" id="step5">
                                <div class="stage-container" style="display: flex; justify-content: space-between; align-items: center; padding: 0px;">
                                        <div class="stage-title" style="width: 30%; text-align: left; margin-bottom: 0; padding-bottom: 0;">
                                            <p class="project-id-dis" style="color: #36b9cc; margin-bottom: 5px; font-family: 'Poppins', sans-serif;">Stage 5 <span hidden style="color:rgba(255, 255, 255, 0.9);" id="project-id-placeholder">[Project ID]</span></p>
                                            <h4 style="color: #36b9cc; margin-top: 0; font-family: 'Poppins', sans-serif;">Delivery/Follow-up</h4>
                                        </div>
                                        <div class="stage-percentage" style="width: 45%; text-align: right; font-size: 16px; color: #36b9cc;">
                                            <p style="color:#555">Progress: <span  style="font-family: 'Poppins'; color: #36b9cc;">100%</span></p>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px"> 
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="stage-five-start" readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input type="text" class="form-control" id="stage-five-end" readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="status" class="form-label text-white">Status</label>
                                                    <input type="text" class="form-control" id="stage-five-status"  readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Technology</label>
                                                    <select name="technology" class="form-control custom-select" id="technology5">
                                                        <option disabled selected>Select</option>
                                                        <option>Artificial Intelligence</option>
                                                        <option>Machine Learning</option>
                                                        <option>Blockchain</option>
                                                        <option>Internet of Things (IoT)</option>
                                                        <option>Cloud Computing</option>
                                                    </select>
                                                </div>
                                            </div>
                                             <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="product" class="form-label text-white">Product</label>
                                                    <input name="product" id="product5" type="text" class="form-control">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Deal Size(Amount)</label>
                                                    <input name="deal_size" type="text" class="form-control" id="deal_size5" placeholder="e.g. 5000">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="status" class="form-label text-white">Solution</label>
                                                   <textarea name="solution" class="form-control" id="solution5" placeholder="e.g. Sample Solution" 
                                                        style="height:50px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label for="status" class="form-label text-white">SPR Number</label>
                                                    <input type="text" class="form-control" id="stage-five-spr"   placeholder="e.g. SPR1 ">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="requirement" class="form-label text-white">Contract Duration(Days)</label>
                                                    <input name="contract_duration" type="text" class="form-control" id="contract" placeholder="e.g. 6 ">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="billingType" class="form-label text-white">Billing Type</label>
                                                    <select name="billing_type" class="form-control" id="billingType">
                                                        <option value="" disabled selected>Select Billing Type</option>
                                                        <option value="fixed">Fixed</option>
                                                        <option value="hourly">Hourly</option>
                                                        <option value="retainer">Retainer</option>
                                                        <option value="milestone">Milestone</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                                <!-- Fixed Labels Row -->
                                                <div class="row mb-1">
                                                    <div class="col-md-3">
                                                        <label for="requirement" class="form-label text-white">Requirement</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="quantity" class="form-label text-white">Quantity</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="bills_materials" class="form-label text-white">Bills of Materials</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="remarks" class="form-label text-white">Remarks</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="#" id="addRequirement5" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                            <i class="fas fa-plus"></i> Add Another
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Container for Input Rows -->
                                                <div id="requirement-fields-container5">
                                                    <!-- Initial Input Row -->
                                                    <div class="row mb-3 requirement-fields">
                                                        <div class="col-md-3">
                                                            <select name="req_five[]" class="form-control">
                                                                <option value="" disabled >Select Requirement</option>
                                                                <option value="cisco-network">Cisco Network</option>
                                                                <option value="cloud-computing">Cloud Computing</option>
                                                                <option value="cybersecurity">Cybersecurity</option>
                                                                <option value="database-management">Database Management</option>
                                                                <option value="software-development">Software Development</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input name="bills_materials_req[]" type="number" class="form-control" placeholder="e.g. 5000">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input name="remarks_req[]" type="text" class="form-control" placeholder="e.g. Sample Requirement Remarks">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-danger btn-sm deleteRequirement">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                                <!-- Fixed Labels Row -->
                                                <div class="row mb-1">
                                                    <div class="col-md-2">
                                                        <label for="requirement" class="form-label text-white">Upsell</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="bills_materials" class="form-label text-white">Bills of Materials</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="quantity" class="form-label text-white">Quantity</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="remarks" class="form-label text-white">Remarks</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="amount" class="form-label text-white">Amount</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <a href="#" id="addUpsellRow" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                            <i class="fas fa-plus"></i> Add Another
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Container for Input Rows -->
                                                <div id="upsell-fields-container">
                                                    <!-- Initial Input Row -->
                                                    <div class="row mb-3 upsell-fields">
                                                        <div class="col-md-2">
                                                            <input type="text" class="form-control" name="upsell[]" placeholder="e.g Router 2000">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input name="bills_materials_upsell[]" type="number" class="form-control" placeholder="e.g 5000">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input name="quantity_upsell[]" type="number" class="form-control" placeholder="e.g 50">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input name="remarks_upsell[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input name="amount_upsell[]" type="number" class="form-control" placeholder="e.g. 6000">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button" class="btn btn-danger btn-sm deleteUpsellRow">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <input name="remarks_stage_five" type="textarea" class="form-control" id="stageremarks5" style="height: 50px;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                            <style>
                                #saveButton {
                                    transition: all 0.3s ease;
                                }
                                #saveButton:hover {
                                    background-color: #36b9cc;
                                    color: white;
                                    border-color: #fff;
                                    transform: scale(1.1);
                                }
                                #completeButton {
                                    transition: all 0.3s ease;
                                }
                                #completeButton:hover {
                                    background-color: #00796b;
                                    color: white;
                                    transform: scale(1.1); 
                                }
                                #deleteButton {
                                    transition: all 0.3s ease;
                                }
                                #deleteButton:hover {
                                    transform: scale(1.1);
                                }
                                .footer-left {
                                    display: flex;
                                    align-items: center;
                                    margin-right: auto;
                                }
                                #logoPlaceholder {
                                    width: 30px;
                                    height: 30px;
                                    background-color:transparent;
                                    margin-right: 10px;
                                }
                                #salesPulse {
                                    font-weight: 800;
                                    color: #36b9cc;
                                    font-size: 25px;
                                    font-family: 'Poppins', sans-serif;
                                }
                            </style>
                            <div class="modal-footer">
                                <div class="footer-left">
                                    <div >
                                        <img id="logoPlaceholder" src="../images/logo_blue.png" alt="salespulselogo">
                                    </div>
                                    <div id="salesPulse">Sales Pulse</div>
                                </div>
                                <button type="button" class="btn btn-danger " id="deleteButton" style="border-color: red; background-color: #fff; color: red; font-size: 12px;">
                                    <i class="fas fa-trash-alt"></i> Delete
                                </button>
                                <button type="button" class="btn btn-success " id="saveButton" style="border-weight: 5px; border-color: #36b9cc; background-color: #fff; color: #36b9cc; font-size: 12px;">
                                    Save
                                </button>
                                <button type="button" class="btn btn-success " id="completeButton" style="background-color: #36b9cc; color: white; font-size: 12px;">
                                    Complete
                                </button>
                            </div>
                    </div>
                </div>
            </div>
            
<script>
    let currentStep = 1;
    const totalSteps = 5;
    let projectId = ""; // Variable to hold the Project ID

    // Function to display the correct step
    function showStep(step) {
        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById(`step${i}`).classList.add('d-none');
        }
        document.getElementById(`step${step}`).classList.remove('d-none');
    }

    // Store and update the Project ID from Step 1
    function updateProjectId() {
        // Retrieve the Project ID when on Step 1
        if (currentStep === 1) {
            const projectIdElement = document.getElementById('project-id-placeholder');
            if (projectIdElement) {
                projectId = projectIdElement.textContent.trim();
                console.log("Project ID retrieved:", projectId); // Debugging log
            }
        }

        // Update the Project ID display in all relevant elements
        document.querySelectorAll('.project-id-display span').forEach(el => {
            el.textContent = projectId || "[Project ID]";
        });

        // Debugging log to ensure the Project ID updates properly
        console.log("Updated Project ID in all displays:", projectId);
    }

    // Event Listener for Complete Button
    document.getElementById('completeButton').addEventListener('click', async () => {
        // Ask for confirmation before proceeding
        if (!confirm(`Are you sure you want to complete Step ${currentStep}?`)) {
            return; // If user cancels, do nothing
        }

        // Retrieve the Project ID from the hidden input field
        const projectIdInput = document.getElementById('project-unique-id');
        const projectIdValue = projectIdInput ? projectIdInput.value.trim() : null;

        if (!projectIdValue) {
            alert("Project ID is missing. Cannot proceed.");
            console.error("Error: Project ID not found.");
            return;
        }

        // Get all the input elements within the current step only
        const currentStepFields = document.querySelectorAll(
            `#step${currentStep} input, #step${currentStep} textarea, #step${currentStep} select`
        );

        // Collect values from the inputs within this step
        const inputValues = {};

        currentStepFields.forEach(field => {
            const name = field.name || field.id;
            if (name.endsWith('[]')) {
                const key = name.replace('[]', '');
                if (!inputValues[key]) {
                    inputValues[key] = [];
                }
                inputValues[key].push(field.value.trim());
            } else {
                inputValues[name] = field.value.trim();
            }
        });

        // Prepare the data to be sent
        const dataToSend = {
            step: currentStep,
            project_unique_id: projectIdValue,
            data: inputValues,
        };

        console.log("Data to send:", dataToSend);

        try {
            const response = await fetch('complete.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dataToSend),
            });

            if (!response.ok) {
                // Handle HTTP errors
                const errorText = await response.text(); // Get the raw response for debugging
                console.error("HTTP Error:", response.status, errorText);
                alert(`Failed to complete Step ${currentStep}: ${response.statusText}`);
                return;
            }

            // Parse the JSON response
            let result;
            try {
                result = await response.json();
            } catch (jsonError) {
                const rawResponse = await response.text();
                console.error("Error parsing JSON:", jsonError, "Raw Response:", rawResponse);
                throw new Error("The server returned an invalid JSON response.");
            }

            console.log("Backend response:", result);

            // Handle success or failure based on the backend response
            if (result.message === `Step ${currentStep} data processed successfully`) {
                alert(`Step ${currentStep} completed successfully!`);

                // Mark the current step as completed visually
                const currentStepCircle = document.getElementById(`step${currentStep}-circle`);
                if (currentStepCircle) {
                    currentStepCircle.classList.add('completed');
                    currentStepCircle.textContent = '✔';
                }

                // Navigate to the next step, if there is one
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);  // Show the UI for the next step
                    updateProjectId();      // Update Project ID display if necessary
                } else {
                    alert('All steps completed!');
                }
                openModal(projectIdValue);
            } else {
                alert(`Unexpected response: ${result.message}`);
            }
        } catch (error) {
            console.error("Error in fetch operation:", error);
            alert(`An error occurred while completing Step ${currentStep}: ${error.message}`);
        }
    });

   function refreshModal() {
    // Get the modal element
    const modal = document.getElementById('multiStepModal');

    // Trigger a "refresh" by updating the modal content
    // For example, you can clear and re-load the modal's content if necessary
    // Here, we assume you have a function that fetches the updated content.
    
    // Example: Re-set or update the modal content dynamically
    const modalContent = document.querySelector('#multiStepModal .modal-content');
    
    // Add logic to update the modal's content (this could be fetching data or resetting specific values)
    // This could be as simple as re-adding or updating HTML content
    modalContent.innerHTML = modalContent.innerHTML; // This "refreshes" the content
  
}



    document.getElementById('deleteButton').addEventListener('click', async () => {
        if (confirm('Are you sure you want to cancel this process? This action cannot be undone.')) {
            const projectIdInput = document.getElementById('project-unique-id');
            const projectId = projectIdInput ? projectIdInput.value.trim() : null;

            if (!projectId) {
                alert("Project ID is missing. Cannot proceed with cancellation.");
                console.error("Error: Project ID not found.");
                return;
            }

            try {
                // Send the request to update the status in the backend
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });

                if (!response.ok) {
                    // Log and alert if the HTTP status is not OK
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }

                // Parse the JSON response
                const result = await response.json();

                // Log the backend response
                console.log("Backend response:", result);

                // Handle the backend response
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); // Refresh the page
                } else {
                    alert(`Failed to cancel the project: ${result.message}`);
                }
            } catch (error) {
                console.error("Error in fetch operation:", error);
                alert(`An error occurred while canceling the project: ${error.message}`);
            }
        }
    });

    document.getElementById('saveButton').addEventListener('click', async () => {
     // Display a confirmation dialog with Yes (OK) and No (Cancel)
    const userConfirmed = confirm(`Are you sure you want to save the current data of Step ${currentStep}?`);

    // If the user clicks "No" (Cancel), stop further execution
    if (!userConfirmed) {
        console.log("Save canceled by user.");
        return;
    }
    const projectIdInput = document.getElementById('project-unique-id');
    const projectId = projectIdInput ? projectIdInput.value.trim() : null;

    if (!projectId) {
        alert("Project ID is missing. Cannot save data.");
        console.error("Error: Project ID not found.");
        return;
    }

    // Get all the input elements within the current step
    const currentStepFields = document.querySelectorAll(
        `#step${currentStep} input, #step${currentStep} textarea, #step${currentStep} select`
    );

    // Collect values from the inputs within this step
    const inputValues = {};

    currentStepFields.forEach(field => {
        const name = field.name || field.id;
        if (name.endsWith('[]')) {
            const key = name.replace('[]', '');
            if (!inputValues[key]) {
                inputValues[key] = [];
            }
            inputValues[key].push(field.value.trim());
        } else {
            inputValues[name] = field.value.trim();
        }
    });

    console.log("Collected input values:", inputValues);

    // Prepare the data to be sent
    const dataToSend = {
        step: currentStep,
        project_unique_id: projectId,
        data: inputValues,
    };

    console.log("Data to send:", dataToSend);

    try {
        const response = await fetch('save.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dataToSend),
        });

        // Store the raw response to ensure the body is read only once
        const responseText = await response.text();

        // Check if the response status is OK
        if (!response.ok) {
            console.error("HTTP Error:", response.status, responseText);
            throw new Error(`HTTP Error ${response.status}: ${response.statusText}`);
        }

        // Parse the response JSON
        let result;
        try {
            result = JSON.parse(responseText);
        } catch (jsonError) {
            console.error("Error parsing JSON:", jsonError, "Raw Response:", responseText);
            throw new Error("The server returned an invalid JSON response.");
        }

        console.log("Backend response:", result);

        // Handle success based on the backend response
        if (result.message === `Step ${currentStep} data processed successfully`) {
            alert(`Step ${currentStep} saved successfully!`);
        } else {
            alert(`Unexpected response: ${result.message}`);
        }
    } catch (error) {
        // Handle errors (network issues, server issues, etc.)
        console.error("Error in fetch operation:", error);
        alert(`An error occurred while saving Step ${currentStep}: ${error.message}`);
    }
});

    // Initialize on DOMContentLoaded
    document.addEventListener('DOMContentLoaded', () => {
        showStep(currentStep);
        updateProjectId();
    });


    // Stages Delete
    document.getElementById('deleteButtons1').addEventListener('click', async () => {
        if (confirm('Are you sure you want to cancel this process? This action cannot be undone.')) {
            const projectId = document
            .getElementById('deleteButtons1')
            .getAttribute('data-project-id');

            if (!projectId) {
                alert("Project ID is missing. Cannot proceed with cancellation.");
                console.error("Error: Project ID not found.");
                return;
            }

            try {
                // Send the request to update the status in the backend
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });

                if (!response.ok) {
                    // Log and alert if the HTTP status is not OK
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }

                // Parse the JSON response
                const result = await response.json();

                // Log the backend response
                console.log("Backend response:", result);

                // Handle the backend response
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); // Refresh the page
                } else {
                    alert(`Failed to cancel the project: ${result.message}`);
                }
            } catch (error) {
                console.error("Error in fetch operation:", error);
                alert(`An error occurred while canceling the project: ${error.message}`);
            }
        }
    });

    document.getElementById('deleteButtons2').addEventListener('click', async () => {
        if (confirm('Are you sure you want to cancel this process? This action cannot be undone.')) {
            const projectId = document
            .getElementById('deleteButtons2')
            .getAttribute('data-project-id');

            if (!projectId) {
                alert("Project ID is missing. Cannot proceed with cancellation.");
                console.error("Error: Project ID not found.");
                return;
            }

            try {
                // Send the request to update the status in the backend
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });

                if (!response.ok) {
                    // Log and alert if the HTTP status is not OK
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }

                // Parse the JSON response
                const result = await response.json();

                // Log the backend response
                console.log("Backend response:", result);

                // Handle the backend response
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); // Refresh the page
                } else {
                    alert(`Failed to cancel the project: ${result.message}`);
                }
            } catch (error) {
                console.error("Error in fetch operation:", error);
                alert(`An error occurred while canceling the project: ${error.message}`);
            }
        }
    });
    document.getElementById('deleteButtons3').addEventListener('click', async () => {
        if (confirm('Are you sure you want to cancel this process? This action cannot be undone.')) {
            const projectId = document
            .getElementById('deleteButtons3')
            .getAttribute('data-project-id');

            if (!projectId) {
                alert("Project ID is missing. Cannot proceed with cancellation.");
                console.error("Error: Project ID not found.");
                return;
            }

            try {
                // Send the request to update the status in the backend
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });

                if (!response.ok) {
                    // Log and alert if the HTTP status is not OK
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }

                // Parse the JSON response
                const result = await response.json();

                // Log the backend response
                console.log("Backend response:", result);

                // Handle the backend response
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); // Refresh the page
                } else {
                    alert(`Failed to cancel the project: ${result.message}`);
                }
            } catch (error) {
                console.error("Error in fetch operation:", error);
                alert(`An error occurred while canceling the project: ${error.message}`);
            }
        }
    });
    document.getElementById('deleteButtons4').addEventListener('click', async () => {
        if (confirm('Are you sure you want to cancel this process? This action cannot be undone.')) {
            const projectId = document
            .getElementById('deleteButtons5')
            .getAttribute('data-project-id');

            if (!projectId) {
                alert("Project ID is missing. Cannot proceed with cancellation.");
                console.error("Error: Project ID not found.");
                return;
            }

            try {
                // Send the request to update the status in the backend
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });

                if (!response.ok) {
                    // Log and alert if the HTTP status is not OK
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }

                // Parse the JSON response
                const result = await response.json();

                // Log the backend response
                console.log("Backend response:", result);

                // Handle the backend response
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); // Refresh the page
                } else {
                    alert(`Failed to cancel the project: ${result.message}`);
                }
            } catch (error) {
                console.error("Error in fetch operation:", error);
                alert(`An error occurred while canceling the project: ${error.message}`);
            }
        }
    });
    document.getElementById('deleteButtons5').addEventListener('click', async () => {
        if (confirm('Are you sure you want to cancel this process? This action cannot be undone.')) {
            const projectId = document
            .getElementById('deleteButtons5')
            .getAttribute('data-project-id');

            if (!projectId) {
                alert("Project ID is missing. Cannot proceed with cancellation.");
                console.error("Error: Project ID not found.");
                return;
            }

            try {
                // Send the request to update the status in the backend
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });

                if (!response.ok) {
                    // Log and alert if the HTTP status is not OK
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }

                // Parse the JSON response
                const result = await response.json();

                // Log the backend response
                console.log("Backend response:", result);

                // Handle the backend response
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); // Refresh the page
                } else {
                    alert(`Failed to cancel the project: ${result.message}`);
                }
            } catch (error) {
                console.error("Error in fetch operation:", error);
                alert(`An error occurred while canceling the project: ${error.message}`);
            }
        }
    });
</script>

        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Container for Engagement Fields
                const engagementFieldsContainer = document.getElementById('engagement-fields-container');

                // Add Another Button
                const addEngagementButton = document.getElementById('addEngagement');

                // Add Another Event
                addEngagementButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent the default link action

                    // Create a new row for engagement fields
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'engagement-fields', 'mb-3');

                    // Add the fields dynamically
                    newRow.innerHTML = `
                        <div class="col-md-3">
                            <input name="engagement_type[]" type="text" class="form-control" placeholder="e.g. Sample Engagement">
                        </div>
                        <div class="col-md-2">
                            <input name="engagement_date[]" type="date" class="form-control" style="font-size:10px;">
                        </div>
                        <div class="col-md-5">
                            <input name="engagement_remarks[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    `;

                    // Append the new row to the container
                    engagementFieldsContainer.appendChild(newRow);
                });

                // Event Delegation for Remove Button
                engagementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        engagementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Container for Requirement Fields
                const requirementFieldsContainer = document.getElementById('requirement-fields-container');

                // Add Another Button
                const addRequirementButton = document.getElementById('addReq');

                // Add Another Event
                addRequirementButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent the default link action

                    // Create a new row for requirement fields
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'requirement-fields', 'mb-3');

                    // Add the fields dynamically
                    newRow.innerHTML = `
                        <div class="col-md-3">
                            <input name="requirement_two[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                        </div>
                        <div class="col-md-2">
                            <input name="requirement_date[]" type="date" class="form-control" style="font-size:10px;">
                        </div>
                        <div class="col-md-5">
                            <input name="requirement_remarks[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    `;

                    // Append the new row to the container
                    requirementFieldsContainer.appendChild(newRow);
                });

                // Event Delegation for Remove Button
                requirementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        requirementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const addRequirementBtn = document.getElementById('addRequiremen');
                const requirementContainer = document.getElementById('requirement-container').parentNode;

                // Function to add another requirement field
                addRequirementBtn.addEventListener('click', (e) => {
                    e.preventDefault();

                    // Create a new field container
                    const newFieldContainer = document.createElement('div');
                    newFieldContainer.classList.add('row', 'align-items-center', 'requirement-field');
                    newFieldContainer.style.marginTop = '5px';
                    newFieldContainer.style.marginBottom = '5px';

                    // Create input field container
                    const inputFieldCol = document.createElement('div');
                    inputFieldCol.classList.add('col-9', 'd-flex', 'align-items-center');
                    const inputField = document.createElement('input');
                    inputField.name = 'requirement_one[]';
                    inputField.type = 'text';
                    inputField.classList.add('form-control');
                    inputField.placeholder = 'e.g. Sample Requirement';
                    inputField.style.width = '100%';
                    inputFieldCol.appendChild(inputField);

                    // Create delete button container
                    const deleteButtonCol = document.createElement('div');
                    deleteButtonCol.classList.add('col-2', 'd-flex', 'justify-content-end', 'align-items-center');
                    const deleteButton = document.createElement('button');
                    deleteButton.type = 'button';
                    deleteButton.classList.add('btn', 'btn-danger', 'btn-sm');
                    deleteButton.style.marginLeft = '5px';
                    deleteButton.innerHTML = '<i class="fas fa-minus"></i>';
                    deleteButton.addEventListener('click', () => {
                        newFieldContainer.remove();
                    });
                    deleteButtonCol.appendChild(deleteButton);

                    // Append the input field and delete button to the new field container
                    newFieldContainer.appendChild(inputFieldCol);
                    newFieldContainer.appendChild(deleteButtonCol);

                    // Append the new field container to the parent container
                    requirementContainer.appendChild(newFieldContainer);
                });

                // Handle the delete button for the existing requirement field
                const initialDeleteBtn = document.getElementById('deleteRequirement');
                if (initialDeleteBtn) {
                    initialDeleteBtn.addEventListener('click', () => {
                        initialDeleteBtn.closest('.requirement-field').remove();
                    });
                }
            });
        </script>
        <!-- Add Engagement and Requirement 3 -->
         <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Container for Engagement Fields
                const engagementFieldsContainer = document.getElementById('engagement-fields-container3');

                // Add Another Button
                const addEngagementButton = document.getElementById('addEngagement3');

                // Add Another Event
                addEngagementButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent the default link action

                    // Create a new row for engagement fields
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'engagement-fields', 'mb-3');

                    // Add the fields dynamically
                    newRow.innerHTML = `
                        <div class="col-md-3">
                            <input name="engagement_three[]" type="text" class="form-control" placeholder="e.g. Sample Engagement">
                        </div>
                        <div class="col-md-2">
                            <input name="engagement_date[]" type="date" class="form-control" style="font-size:10px;">
                        </div>
                        <div class="col-md-5">
                            <input name="engagement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    `;

                    // Append the new row to the container
                    engagementFieldsContainer.appendChild(newRow);
                });

                // Event Delegation for Remove Button
                engagementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        engagementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Container for Requirement Fields
                const requirementFieldsContainer = document.getElementById('requirement-fields-container3');

                // Add Another Button
                const addRequirementButton = document.getElementById('addReq_3');

                // Add Another Event
                addRequirementButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent the default link action

                    // Create a new row for requirement fields
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'requirement-fields', 'mb-3');

                    // Add the fields dynamically
                    newRow.innerHTML = `
                       
                    <div class="col-md-2">
                        <input name="requirement_three[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                    </div>
                    <div class="col-md-2">
                        <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50">
                    </div>
                    <div class="col-md-2">
                        <input name="bill_of_materials[]" type="text" class="form-control" placeholder="e.g. 5000">
                    </div>
                    <div class="col-md-2">
                        <input name="pricing[]" type="number" class="form-control" placeholder="e.g. 5000">
                    </div>
                    <div class="col-md-2">
                        <input name="requirement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                    </div>
                    <div class="col-md-2">
                        <!-- Remove Button -->
                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                                             
                    `;

                    // Append the new row to the container
                    requirementFieldsContainer.appendChild(newRow);
                });

                // Event Delegation for Remove Button
                requirementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        requirementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Container for input rows
                const requirementFieldsContainer = document.getElementById('requirement-fields-container4');

                // Add Another Button
                const addRequirementButton = document.getElementById('addRequirement4');

                // Add New Row Event
                addRequirementButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent default link behavior

                    // Create a new input row
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'mb-3', 'requirement-fields');

                    // Add the fields dynamically
                    newRow.innerHTML = `
                        <div class="col-md-2">
                            <input name="requirement_four[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                        </div>
                        <div class="col-md-2">
                            <input name="quantity[]" type="text" class="form-control" placeholder="e.g. 50">
                        </div>
                        <div class="col-md-2">
                            <input name="bill_of_materials[]" type="text" class="form-control" placeholder="e.g. 5000">
                        </div>
                        <div class="col-md-2">
                            <input name="pricing[]" type="text" class="form-control" placeholder="e.g. 2000">
                        </div>
                        <div class="col-md-2">
                            <input name="date_required[]" type="date" class="form-control" style="font-size:10px;">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm deleteRequirement">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    `;

                    // Append the new row to the container
                    requirementFieldsContainer.appendChild(newRow);
                });

                // Remove Row Event
                requirementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        requirementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Container for Input Rows
                const requirementFieldsContainer = document.getElementById('requirement-fields-container5');

                // Add Another Button
                const addRequirementButton = document.getElementById('addRequirement5');

                // Add New Row Event
                addRequirementButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent default link behavior

                    // Create a new input row
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'mb-3', 'requirement-fields');

                    // Add the fields dynamically
                    newRow.innerHTML = `
                        <div class="col-md-3">
                            <select name="req_five[]" class="form-control">
                                <option value="" disabled selected>Select Requirement</option>
                                <option value="cisco-network">Cisco Network</option>
                                <option value="cloud-computing">Cloud Computing</option>
                                <option value="cybersecurity">Cybersecurity</option>
                                <option value="database-management">Database Management</option>
                                <option value="software-development">Software Development</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50">
                        </div>
                        <div class="col-md-2">
                            <input name="bills_materials_req[]" type="number" class="form-control" placeholder="e.g. 5000">
                        </div>
                        <div class="col-md-3">
                            <input name="remarks_req[]" type="text" class="form-control" placeholder="e.g. 6">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm deleteRequirement">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    `;

                    // Append the new row to the container
                    requirementFieldsContainer.appendChild(newRow);
                });

                // Remove Row Event
                requirementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        requirementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Container for Upsell Rows
                const upsellFieldsContainer = document.getElementById('upsell-fields-container');

                // Add Another Button
                const addUpsellRowButton = document.getElementById('addUpsellRow');

                // Add New Row Event
                addUpsellRowButton.addEventListener('click', (event) => {
                    event.preventDefault(); // Prevent default link behavior

                    // Create a new input row
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'mb-3', 'upsell-fields');

                    // Add the fields dynamically
                    newRow.innerHTML = `
                        <div class="col-md-2">
                            <input type="text" class="form-control" name="upsell[]" placeholder="e.g Router 2000">
                        </div>
                        <div class="col-md-2">
                            <input name="bills_materials_upsell[]" type="number" class="form-control" placeholder="e.g 5000">
                        </div>
                        <div class="col-md-2">
                            <input name="quantity_upsell[]" type="number" class="form-control" placeholder="e.g 50">
                        </div>
                        <div class="col-md-2">
                            <input name="remarks_upsell[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                        </div>
                        <div class="col-md-2">
                            <input name="amount_upsell[]" type="number" class="form-control" placeholder="e.g. 6000">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-danger btn-sm deleteUpsellRow">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    `;

                    // Append the new row to the container
                    upsellFieldsContainer.appendChild(newRow);
                });

                // Remove Row Event
                upsellFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteUpsellRow')) {
                        const rowToDelete = event.target.closest('.row');
                        upsellFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script>
        
 

