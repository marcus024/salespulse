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
                    max-width: 1000px; /* Increased width */
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="modalCloseButton"></button>
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
                                            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
                                            Project Profile
                                            </p>
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="startDate" class="form-label">Status</label>
                                                    <input  id="status-placeholder" type="text" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="startDate" class="form-label">Start Date</label>
                                                    <input  id="start-date-placeholder" type="text" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="endDate" class="form-label">End Date</label>
                                                    <input  id="end-date-placeholder" type="text" class="form-control" readonly>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="technology" class="form-label text-white">Technology</label>
                                                    <select name="technology" id="technologySelect" class="form-control custom-select" >
                                                        <option disabled selected>Select technology</option>
                                                        <option value="add_new_technology">+ Add New Technology...</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="dealSize" class="form-label text-white">Deal Size</label>
                                                    <input name="deal_size" type="number" class="form-control" id="dealSize1" placeholder="e.g. 5000">
                                                </div>
                                            </div>
                                            <input name="project_unique_id" id="project-unique-id" type="hidden" value="<?php echo $projectId; ?>" class="form-control" readonly>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="solution" class="form-label text-white">Solution</label>
                                                    <textarea name="solution" class="form-control" id="solution1" placeholder="e.g. Sample Solution" 
                                                    style="height:100px;"></textarea>
                                                </div>
                                            </div>
                                            <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div>
                                            <div id="requirementsContainer">
                                                <div class="requirement-block" data-index="1">
                                                   <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="requirement1">
                                                    Requirement 1
                                                    </p>
                                                    <input type="hidden" name="requirement_id_1[]" value="st1rq1" id="req_1_id">

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
                                                    <!-- <div class="col-md-2">
                                                        <button type="button"
                                                                class="btn btn-primary btn-sm"
                                                                style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                                                                id="addRequirementBtn">
                                                        <i class="fas fa-plus"></i>&nbsp;Add
                                                        </button>
                                                    </div> -->
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
                                                        <select name="product_one[]" class="form-control custom-select productFetch" >
                                                        <option disabled selected>Select</option>
                                                        <option value="add_new_product">+ Add New Product...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="distributor_one[]" class="form-control custom-select distributorFetch" >
                                                        <option disabled selected>Select</option>
                                                        <option value="add_new">+ Add New Distributor...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button"
                                                                class="btn btn-primary btn-sm"
                                                                style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                                                                id="addRequirementBtn">
                                                        <i class="fas fa-plus"></i>&nbsp;Add
                                                        </button>
                                                    </div>
                                                    <!-- <div class="col-md-2">
                                                        <button type="button"
                                                                class="btn btn-danger btn-sm removeRequirement"
                                                                style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;">
                                                        <i class="fas fa-minus"></i>&nbsp;Remove
                                                        </button>
                                                    </div> -->
                                                    </div>
                                                </div> 
                                            </div> 
                                            <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 
                                            <div class="row mb-4">
                                                <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
                                                Stage Remarks
                                                </p>
                                                <div class="mb-6">
                                                    <textarea name="stage_one_remarks" class="form-control" id="stageremarks1" placeholder="e.g. Sample Remarks" 
                                                    style="height: 100px;"></textarea>
                                                </div>
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
                                            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
                                            Project Profile
                                            </p>
                                            <div class="row mb-3">
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Status</label>
                                                    <input type="text" class="form-control" id="stage-two-status"   readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input type="text" class="form-control" id="stage-two-end"   readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="stage-two-start" readonly>
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
                                                <div class="col-md-3">
                                                    <label for="dealSize" class="form-label text-white">Deal Size</label>
                                                    <input name="deal_size" type="number" class="form-control" id="deal_size2" placeholder="e.g. 5000">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                   <label for="solution" class="form-label text-white">Solution</label>
                                                    <textarea name="solution" class="form-control" id="solution2" placeholder="e.g. Sample Solution" 
                                                    style="height:100px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 

                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div id="engagement1Container">
                                                <div class="engagement-block" data-index="1">
                                                   <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="engagement1">
                                                    Engagement 1
                                                    </p>
                                                    <input type="hidden" name="engagement_id_2[]" value="st2eng1" id="eng_1_id">
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
                                                        <!-- <div class="col-md-1">
                                                            <a href="#" id="addEngagement" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                                <i class="fas fa-plus"></i> Add
                                                            </a>
                                                        </div> -->
                                                    </div>
                                                    <div id="engagement-fields-container">
                                                        <div class="row engagement-fields mb-3">
                                                            <div class="col-md-4">
                                                                <input name="engagement_type[]" type="text" id="engtype2" class="form-control" placeholder="e.g. Sample Engagement">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input name="engagement_date[]" type="date" id="engdate2" class="form-control" style="font-size:10px;">
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input name="engagement_remarks[]" type="text" id="engremarks2" class="form-control" placeholder="e.g. Sample Remarks">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button"
                                                                        class="btn btn-primary btn-sm"
                                                                        style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                                                                        id="addEngagement1Btn">
                                                                <i class="fas fa-plus"></i>&nbsp;Add
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 
                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div id="requirementtwoContainer">
                                                <div class="requirementtwo-block" data-index="1">
                                                    <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="requirementstagetwo">
                                                    Requirement 1
                                                    </p>
                                                    <input type="hidden" name="requirement_id_2[]" value="st2rq1" id="rq_1_id">
                                                    <div class="row mb-3">
                                                        <div class="col-md-2">
                                                            <label for="requirement" class="form-label text-white">Requirement</label>
                                                        </div>
                                                        <div class="col-md-2">
                                                        <label for="product" class="form-label text-white">Product</label>
                                                        </div>
                                                        <div class="col-md-2">
                                                        <label for="distributor" class="form-label text-white">Distributor</label>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label for="requirement" class="form-label text-white">Date</label>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label for="requirement" class="form-label text-white">Requirement Remarks</label>
                                                        </div>
                                                    </div>
                                                    <div >
                                                        <div class="row requirement-fields mb-3">
                                                            <div class="col-md-2">
                                                                <input name="requirement_two[]" type="text" id="req2" class="form-control" placeholder="e.g. Sample Requirement">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="product_two[]" class="form-control custom-select productFetch" >
                                                                    <option disabled selected>Select</option>
                                                                    <option value="add_new_product">+ Add New Product...</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <select name="distributor_two[]" class="form-control custom-select distributorFetch" >
                                                                    <option disabled selected>Select</option>
                                                                    <option value="add_new">+ Add New Distributor...</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input name="requirement_date[]" type="date" id="reqdate2" class="form-control" style="font-size:10px;">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <input name="requirement_remarks[]" type="text" id="reqremarks2"class="form-control" placeholder="e.g. Sample Remarks">
                                                            </div>
                                                            <div class="col-md-2">
                                                                <button type="button"
                                                                        class="btn btn-primary btn-sm"
                                                                        style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;"
                                                                        id="addRequirement2Btn">
                                                                <i class="fas fa-plus"></i>&nbsp;Add
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 
                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;" id="engagement1">
                                            Stage Remarks
                                            </p>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <textarea name="stage_two_remarks" class="form-control" id="stageremarks2" placeholder="e.g. Sample Solution" 
                                                    style="height:100px;"></textarea>
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
                                                <div class="col-md-2">
                                                    <label for="status" class="form-label text-white">Status</label>
                                                    <input name="" type="text" class="form-control" id="stage-three-status"  readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input name="" type="text" class="form-control" id="stage-three-end"  readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input name="" type="text" class="form-control" id="stage-three-start"  readonly>
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
                                                <div class="col-md-3">
                                                    <label for="status" class="form-label text-white">Deal Size(Amount)</label>
                                                   <input name="deal_size" type="number" class="form-control" id="deal_size3" placeholder="e.g. 5000">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="status" class="form-label text-white">Solution</label>
                                                    <textarea name="solution" class="form-control" id="solution3" placeholder="e.g. Sample Solution" 
                                                    style="height:100px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 

                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row mb-1">
                                                <div class="col-md-3">
                                                    <label for="engagement" class="form-label text-white">Type of Engagement</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="engagement" class="form-label text-white">Date</label>
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="engagement" class="form-label text-white">Remarks</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="#" id="addEngagement3" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                        <i class="fas fa-plus"></i> Add
                                                    </a>
                                                </div>
                                            </div>
                                            <div id="engagement-fields-container3">
                                                <div class="row engagement-fields mb-3">
                                                    <div class="col-md-3">
                                                        <input name="engagement_three[]" type="text" class="form-control" placeholder="e.g. Sample Engagement">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input name="engagement_date[]" type="date" class="form-control" style="font-size:10px;">
                                                    </div>
                                                    <div class="col-md-5">
                                                        <input name="engagement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 

                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row mb-1">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Requirement</label>
                                                </div>
                                                <div class="col-md-3">
                                                   <label for="requirement" class="form-label text-white">Product</label>
                                                </div>
                                                <div class="col-md-3">
                                                   <label for="distributor" class="form-label text-white">Distributor</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Date</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="#" id="addReq_3" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                        <i class="fas fa-plus"></i> Add 
                                                    </a>
                                                </div>
                                            </div>
                                            <div id="requirement-fields-container-3">
                                                <div class="row requirement-fields mb-3">
                                                    <div class="col-md-3">
                                                        <input name="requirement_three[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input name="product" id="product3" type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="distributor[]" id="distributorSelect" class="form-control custom-select">
                                                            <option disabled selected>Select</option>
                                                            <option value="add_new">+ Add New Distributor...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="requirement_date[]" type="date" id="reqdate2" class="form-control" style="font-size:10px;">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Quantity</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">BOM</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Pricing</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Remarks</label>
                                                </div>
                                            </div>
                                            <div id="requirement-fields-container-3">
                                                <div class="row requirement-fields mb-3">
                                                    <div class="col-md-3">
                                                        <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="bill_of_materials[]" type="text" class="form-control" placeholder="e.g. 5000">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="pricing[]" type="number" class="form-control" placeholder="e.g. 5000">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input name="requirement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 

                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <textarea name="stage_three_remarks" class="form-control" id="stageremarks3" placeholder="e.g. Sample Remarks" 
                                                    style="height:100px;"></textarea>
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
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="stage-four-start"  readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input type="text" class="form-control" id="stage-four-end"  readonly>
                                                </div>
                                                <div class="col-md-2">
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
                                                <div class="col-md-3">
                                                   <label for="dealSize" class="form-label text-white">Deal Size</label>
                                                    <input name="deal_size" type="number" class="form-control" id="deal_size4" placeholder="e.g. 5000">
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="status" class="form-label text-white">Solution</label>
                                                    <textarea name="solution" class="form-control" id="solution4" placeholder="e.g. Sample Solution" 
                                                    style="height:100px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 

                                        <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                            <div class="row mb-1">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Requirement</label>
                                                </div>
                                                <div class="col-md-3">
                                                   <label for="requirement" class="form-label text-white">Product</label>
                                                </div>
                                                <div class="col-md-3">
                                                   <label for="distributor" class="form-label text-white">Distributor</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Date Required</label>
                                                </div>
                                                <div class="col-md-1">
                                                    <a href="#" id="addReq_3" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                        <i class="fas fa-plus"></i> Add 
                                                    </a>
                                                </div>
                                            </div>
                                            <div id="requirement-fields-container-3">
                                                <div class="row requirement-fields mb-3">
                                                    <div class="col-md-3">
                                                        <input name="requirement_four[]" type="text" class="form-control" placeholder="e.g. Sample Requirement">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <input name="product" id="product4" type="text" class="form-control">
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select name="distributor[]" id="distributorSelect" class="form-control custom-select">
                                                            <option disabled selected>Select</option>
                                                            <option value="add_new">+ Add New Distributor...</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="date_required[]" type="date" class="form-control" style="font-size:10px;">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-1">
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Quantity</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">BOM</label>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Pricing</label>
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Remarks</label>
                                                </div>
                                            </div>
                                            <div id="requirement-fields-container-3">
                                                <div class="row requirement-fields mb-3">
                                                    <div class="col-md-3">
                                                        <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="bill_of_materials[]" type="text" class="form-control" placeholder="e.g. 5000">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <input name="pricing[]" type="number" class="form-control" placeholder="e.g. 2000">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input name="requirement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 

                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <textarea name="stage_four_remarks" class="form-control" id="stageremarks4" placeholder="e.g. Sample Remarks" 
                                                    style="height:100px;"></textarea>
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
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">Start Date</label>
                                                    <input type="text" class="form-control" id="stage-five-start" readonly>
                                                </div>
                                                <div class="col-md-2">
                                                    <label for="requirement" class="form-label text-white">End Date</label>
                                                    <input type="text" class="form-control" id="stage-five-end" readonly>
                                                </div>
                                                <div class="col-md-2">
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
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Deal Size(Amount)</label>
                                                    <input name="deal_size" type="text" class="form-control" id="deal_size5" placeholder="e.g. 5000">
                                                </div>
                                            </div>
                                             <div class="row mb-3">
                                                <div class="col-md-12">
                                                    <label for="status" class="form-label text-white">Solution</label>
                                                    <textarea name="solution" class="form-control" id="solution5" placeholder="e.g. Sample Solution" 
                                                    style="height:100px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-3">
                                                    <label for="status" class="form-label text-white">SPR Number</label>
                                                    <input type="text" class="form-control" id="stage-five-spr"  name="SPR_number" placeholder="e.g. SPR1 ">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Contract Duration</label>
                                                    <input name="contract_duration" type="text" class="form-control" id="contract" placeholder="e.g. 6 days">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Pricing</label>
                                                    <input name="pricing" type="text" class="form-control" id="pricing" placeholder="e.g. 6 ">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="billingType" class="form-label text-white">Billing Type</label>
                                                    <select name="billing_type" class="form-control custom-select" id="billingType">
                                                        <option   disabled selected>Select Billing Type</option>
                                                        <option value="fixed">Fixed</option>
                                                        <option value="hourly">Hourly</option>
                                                        <option value="retainer">Retainer</option>
                                                        <option value="milestone">Milestone</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 

                                            <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                                <!-- Header Row -->
                                                <div class="row mb-1">
                                                    <div class="col-md-3">
                                                        <label for="requirement" class="form-label text-white">Requirement</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <label for="requirement" class="form-label text-white">Product</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <label for="distributor" class="form-label text-white">Distributor</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="requirement" class="form-label text-white">Date Required</label>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <!-- Add Another Button -->
                                                        <a href="#" id="addReq_3" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                            <i class="fas fa-plus"></i> Add 
                                                        </a>
                                                    </div>
                                                </div>
                                                <!-- Container for Requirement Fields -->
                                                <div id="requirement-fields-container-3">
                                                    <!-- Initial Requirement Row -->
                                                    <div class="row requirement-fields mb-3">
                                                        <div class="col-md-3">
                                                            <select name="req_five[]" class="form-control">
                                                                <option  disabled selected >Select Requirement</option>
                                                                <option value="cisco-network">Cisco Network</option>
                                                                <option value="cloud-computing">Cloud Computing</option>
                                                                <option value="cybersecurity">Cybersecurity</option>
                                                                <option value="database-management">Database Management</option>
                                                                <option value="software-development">Software Development</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input name="product" id="product4" type="text" class="form-control">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <select name="distributor[]" id="distributorSelect" class="form-control custom-select">
                                                                <option disabled selected>Select</option>
                                                                <!-- Existing options can be removed or loaded dynamically -->
                                                                <!-- Special option for adding new distributor -->
                                                                <option value="add_new">+ Add New Distributor...</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input name="date_required[]" type="date" class="form-control" style="font-size:10px;">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <!-- Remove Button -->
                                                            <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row mb-1">
                                                    <div class="col-md-3">
                                                        <label for="requirement" class="form-label text-white">Quantity</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="requirement" class="form-label text-white">BOM</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="requirement" class="form-label text-white">Pricing</label>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="requirement" class="form-label text-white">Remarks</label>
                                                    </div>
                                                </div>
                                                <!-- Container for Requirement Fields -->
                                                <div id="requirement-fields-container-3">
                                                    <!-- Initial Requirement Row -->
                                                    <div class="row requirement-fields mb-3">
                                                        <div class="col-md-3">
                                                            <input name="quantity[]" type="number" class="form-control" placeholder="e.g. 50">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input name="bills_materials_req[]" type="number" class="form-control" placeholder="e.g. 5000">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <input name="pricing[]" type="number" class="form-control" placeholder="e.g. 2000">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <input name="remarks_req[]" type="text" class="form-control" placeholder="e.g. Sample Requirement Remarks">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 

                                            <div class="container" style="background-color: #36b9cc; padding: 5px; border-radius: 20px">
                                                <!-- Fixed Labels Row -->
                                                <div class="row mb-1">
                                                    <div class="col-md-2">
                                                        <label for="requirement" class="form-label text-white">Upsell</label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="bills_materials" class="form-label text-white">Bill of Materials</label>
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
                                                    <div class="col-md-1">
                                                        <a href="#" id="addUpsellRow" class="form-label text-white" style="font-size:10px; cursor: pointer;">
                                                            <i class="fas fa-plus"></i> Add
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
                                                            <input name="amount_upsell[]" type="number" class="form-control" placeholder="e.g. 6000">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <input name="remarks_upsell[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-danger btn-sm deleteUpsellRow">
                                                                <i class="fas fa-minus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="border-top: 1px solid rgba(255, 255, 255, 0.5); margin: 20px 0;"></div> 

                                        <div class="container" style="background-color: #36b9cc; padding: 10px; border-radius: 20px">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <label for="requirement" class="form-label text-white">Stage Remarks</label>
                                                    <textarea name="remarks_stage_five" class="form-control" id="stageremarks5" placeholder="e.g. Sample Remarks" 
                                                    style="height:100px;"></textarea>
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
                                <!-- Notification Bar -->
                                <div id="notif_bar_r" style="
                                    display: none;
                                    position: absolute;
                                    left: 10px;
                                    bottom: 10px;
                                    background-color: #d4edda;
                                    color: #155724;
                                    padding: 10px 15px;
                                    border-radius: 5px;
                                    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
                                    font-size: 14px;
                                    align-items: center;
                                    gap: 8px;
                                ">
                                    <i class="fas fa-check-circle" style="color: #28a745; font-size: 16px;"></i>
                                    <span id="notificationMessage"></span>
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

    <!-- javascript -->
    <script src="modal_req/duplicate_req_one.js"></script>
    <script src="modal_req/duplicate_eng_two.js"></script>
    <script src="modal_req/duplicate_req1_st2.js"></script>
    <script>
      function showNotif_bar(message = "Operation completed successfully!", duration = 3000) {
    const notif_bar_r = document.getElementById('notif_bar_r');
    const notificationMessage = document.getElementById('notificationMessage');

    if (!notif_bar_r || !notificationMessage) {
        console.error("Notification bar elements are missing in the DOM.");
        return;
    }

    // Debug: Ensure the notification is starting hidden
    console.log("Notification bar initial display:", window.getComputedStyle(notif_bar_r).display);

    // Set the message and show the notification
    notificationMessage.textContent = message;
    notif_bar_r.style.display = 'flex';

    // Hide the notification after the specified duration
    setTimeout(() => {
        console.log("Hiding notification bar after duration.");
        notif_bar_r.style.display = 'none';
    }, duration);
}


    </script>
                
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

        function updateProjectId() {
            if (currentStep === 1) {
                const projectIdElement = document.getElementById('project-id-placeholder');
                if (projectIdElement) {
                    projectId = projectIdElement.textContent.trim();
                    console.log("Project ID retrieved:", projectId); 
                }
            }
            document.querySelectorAll('.project-id-display span').forEach(el => {
                el.textContent = projectId || "[Project ID]";
            });
            console.log("Updated Project ID in all displays:", projectId);
        }

        
        document.getElementById('completeButton').addEventListener('click', async () => {
        const userConfirmed = confirm(`Are you sure you want to complete Step ${currentStep}?`);
        if (!userConfirmed) {
            console.log("Completion canceled by user.");
            return;
        }

        const projectIdInput = document.getElementById('project-unique-id');
        const projectId = projectIdInput ? projectIdInput.value.trim() : null;

        if (!projectId) {
            alert("Project ID is missing. Cannot complete step.");
            console.error("Error: Project ID not found.");
            return;
        }

        // Collect all fields for the current step
        const currentStepFields = document.querySelectorAll(
            `#step${currentStep} input, #step${currentStep} textarea, #step${currentStep} select`
        );

        const inputValues = {};

        currentStepFields.forEach(field => {
            const name = field.name || field.id;

            // Handle fields with array-like names (e.g., "requirement_one[]")
            if (name.endsWith('[]')) {
                const key = name.replace('[]', '');
                if (!inputValues[key]) {
                    inputValues[key] = [];
                }
                inputValues[key].push(field.value.trim());
            } else {
                inputValues[name] = field.value.trim(); // Single-value field
            }
        });

        console.log("Collected input values:", inputValues);

        const dataToSend = {
            step: currentStep,
            project_unique_id: projectId,
            data: inputValues,
        };

        console.log("Data to send:", dataToSend);

        try {
            const response = await fetch('complete.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(dataToSend),
            });

            const responseText = await response.text();
            if (!response.ok) {
                console.error("HTTP Error:", response.status, responseText);
                throw new Error(`HTTP Error ${response.status}: ${response.statusText}`);
            }

            let result;
            try {
                result = JSON.parse(responseText);
            } catch (jsonError) {
                console.error("Error parsing JSON:", jsonError, "Raw Response:", responseText);
                throw new Error("The server returned an invalid JSON response.");
            }

            console.log("Backend response:", result);

            if (result.message === `Step ${currentStep} data processed successfully`) {
                // alert(`Step ${currentStep} completed successfully!`);
                showNotif_bar(`Step ${currentStep} completed successfully!`);
                const currentStepCircle = document.getElementById(`step${currentStep}-circle`);
                if (currentStepCircle) {
                    currentStepCircle.classList.add('completed');
                    currentStepCircle.textContent = '✔';
                }
                if (currentStep < totalSteps) {
                    currentStep++;
                    showStep(currentStep);  
                    updateProjectId();
                } else {
                    alert('All steps completed!');
                }
                if (currentStep !== 5) {
                    openModal(projectId);
                }
            } else {
                alert(`Unexpected response: ${result.message}`);
            }
        } catch (error) {
            console.error("Error in fetch operation:", error);
            alert(`An error occurred while completing Step ${currentStep}: ${error.message}`);
        }
    });

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
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });

                if (!response.ok) {
                    
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }
                const result = await response.json();
                console.log("Backend response:", result);
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); 
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
    const userConfirmed = confirm(`Are you sure you want to save the current data of Step ${currentStep}?`);
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

    // Get all fields for the current step (inputs, textareas, selects)
    const currentStepFields = document.querySelectorAll(
        `#step${currentStep} input, #step${currentStep} textarea, #step${currentStep} select`
    );

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
        // Single-value field
        inputValues[name] = field.value.trim();
    }
    });
    console.log("Collected input values:", inputValues);

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

        const responseText = await response.text();
        if (!response.ok) {
            console.error("HTTP Error:", response.status, responseText);
            throw new Error(`HTTP Error ${response.status}: ${response.statusText}`);
        }

        let result;
        try {
            result = JSON.parse(responseText);
        } catch (jsonError) {
            console.error("Error parsing JSON:", jsonError, "Raw Response:", responseText);
            throw new Error("The server returned an invalid JSON response.");
        }
        console.log("Backend response:", result);

        if (result.message === `Step ${currentStep} data processed successfully`) {
            // alert(`Step ${currentStep} saved successfully!`);
            showNotif_bar(`Step ${currentStep} saved successfully!`);
        } else {
            alert(`Unexpected response: ${result.message}`);
        }
    } catch (error) {
        console.error("Error in fetch operation:", error);
        alert(`An error occurred while saving Step ${currentStep}: ${error.message}`);
    }
});




    document.addEventListener('DOMContentLoaded', () => {
        showStep(currentStep);
        updateProjectId();
    });
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
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });
                if (!response.ok) {
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }
                const result = await response.json();
                console.log("Backend response:", result);
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); 
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
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });
                if (!response.ok) {
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }
                const result = await response.json();
                console.log("Backend response:", result);
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); 
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
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });
                if (!response.ok) {
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }
                const result = await response.json();
                console.log("Backend response:", result);
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload();
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
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });

                if (!response.ok) {
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }
                const result = await response.json();
                console.log("Backend response:", result);
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); 
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
                const response = await fetch('delete.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ project_unique_id: projectId }),
                });
                if (!response.ok) {
                    console.error("HTTP Error:", response.status, response.statusText);
                    alert("Failed to cancel the project. Please try again.");
                    return;
                }
                const result = await response.json();
                console.log("Backend response:", result);
                if (result.success) {
                    alert("The project has been successfully canceled.");
                    location.reload(); 
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
                const engagementFieldsContainer = document.getElementById('engagement-fields-container');
                const addEngagementButton = document.getElementById('addEngagement');
                addEngagementButton.addEventListener('click', (event) => {
                    event.preventDefault(); 
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'engagement-fields', 'mb-3');
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
                    engagementFieldsContainer.appendChild(newRow);
                });
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
                const requirementFieldsContainer = document.getElementById('requirement-fields-container');
                const addRequirementButton = document.getElementById('addReq');
                addRequirementButton.addEventListener('click', (event) => {
                    event.preventDefault(); 
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'requirement-fields', 'mb-3');
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
                    requirementFieldsContainer.appendChild(newRow);
                });
                requirementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        requirementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script>
        <!-- <script>
            document.addEventListener('DOMContentLoaded', () => {
                const addRequirementBtn = document.getElementById('addRequiremen');
                const requirementContainer = document.getElementById('requirement-container').parentNode;
                addRequirementBtn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const newFieldContainer = document.createElement('div');
                    newFieldContainer.classList.add('row', 'align-items-center', 'requirement-field');
                    newFieldContainer.style.marginTop = '5px';
                    newFieldContainer.style.marginBottom = '5px';
                    const inputFieldCol = document.createElement('div');
                    inputFieldCol.classList.add('col-9', 'd-flex', 'align-items-center');
                    const inputField = document.createElement('input');
                    inputField.name = 'requirement_one[]';
                    inputField.type = 'text';
                    inputField.classList.add('form-control');
                    inputField.placeholder = 'e.g. Sample Requirement';
                    inputField.style.width = '100%';
                    inputFieldCol.appendChild(inputField);
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
                    newFieldContainer.appendChild(inputFieldCol);
                    newFieldContainer.appendChild(deleteButtonCol);
                    requirementContainer.appendChild(newFieldContainer);
                });
                const initialDeleteBtn = document.getElementById('deleteRequirement');
                if (initialDeleteBtn) {
                    initialDeleteBtn.addEventListener('click', () => {
                        initialDeleteBtn.closest('.requirement-field').remove();
                    });
                }
            });
        </script> -->
         <script>
            document.addEventListener('DOMContentLoaded', () => {
                const engagementFieldsContainer = document.getElementById('engagement-fields-container3');
                const addEngagementButton = document.getElementById('addEngagement3');
                addEngagementButton.addEventListener('click', (event) => {
                    event.preventDefault(); 
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'engagement-fields', 'mb-3');
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
                    engagementFieldsContainer.appendChild(newRow);
                });
                engagementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        engagementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script>
        <!-- <script>
            document.addEventListener('DOMContentLoaded', () => {
                const requirementFieldsContainer = document.getElementById('requirement-fields-container3');
                const addRequirementButton = document.getElementById('addReq_3');
                addRequirementButton.addEventListener('click', (event) => {
                    event.preventDefault(); 
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'requirement-fields', 'mb-3');
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
                     
                        <button type="button" class="btn btn-danger btn-sm deleteRequirement" style="margin-left: 5px;">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                                             
                    `;
                    requirementFieldsContainer.appendChild(newRow);
                });
                requirementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        requirementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script> -->
        <!-- <script>
            document.addEventListener('DOMContentLoaded', () => {
                const requirementFieldsContainer = document.getElementById('requirement-fields-container4');
                const addRequirementButton = document.getElementById('addRequirement4');
                addRequirementButton.addEventListener('click', (event) => {
                    event.preventDefault(); 
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'mb-3', 'requirement-fields');
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
                    requirementFieldsContainer.appendChild(newRow);
                });
                requirementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        requirementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script> -->
        <!-- <script>
            document.addEventListener('DOMContentLoaded', () => {
                const requirementFieldsContainer = document.getElementById('requirement-fields-container5');
                const addRequirementButton = document.getElementById('addRequirement5');
                addRequirementButton.addEventListener('click', (event) => {
                    event.preventDefault(); 
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'mb-3', 'requirement-fields');
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
                    requirementFieldsContainer.appendChild(newRow);
                });
                requirementFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteRequirement')) {
                        const rowToDelete = event.target.closest('.row');
                        requirementFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script> -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const upsellFieldsContainer = document.getElementById('upsell-fields-container');
                const addUpsellRowButton = document.getElementById('addUpsellRow');
                addUpsellRowButton.addEventListener('click', (event) => {
                    event.preventDefault(); 
                    const newRow = document.createElement('div');
                    newRow.classList.add('row', 'mb-3', 'upsell-fields');
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
                    upsellFieldsContainer.appendChild(newRow);
                });
                upsellFieldsContainer.addEventListener('click', (event) => {
                    if (event.target.closest('.deleteUpsellRow')) {
                        const rowToDelete = event.target.closest('.row');
                        upsellFieldsContainer.removeChild(rowToDelete);
                    }
                });
            });
        </script>
        <script>
            // Function to refresh the page when the modal is closed
            function refreshPage() {
                location.reload(); // Reload the current page
            }

            // Attach the refresh function to the modal close event
            const modalCloseButton = document.getElementById('modalCloseButton');
            if (modalCloseButton) {
                modalCloseButton.addEventListener('click', function() {
                    refreshPage(); // Refresh the page when the modal is closed
                });
            }

        </script>
        
 

