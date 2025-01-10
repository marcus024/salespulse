function showDetails(stageNumber, projectId) {
    console.log("Stage:", stageNumber, "Project ID:", projectId);

    // Hide the table view and show the details view
    const tableView = document.getElementById("table-view");
    const detailsView = document.getElementById("details-view");
    tableView.style.display = "none";
    detailsView.style.display = "block";

    // Clear previous content and display a loading message
    detailsView.innerHTML = "<p>Loading details...</p>";

    // Fetch backend data for the selected stage
    fetch(`dirback/stageDetails.php?stage=${stageNumber}&project_id=${projectId}`)
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            // Handle any errors from the backend
            if (data.error) {
                console.error("Backend Error:", data.error);
                detailsView.innerHTML = `<p>Error: ${data.error}</p>`;
                return;
            }

            // Display the data based on the stage
            let detailsHTML = `<button onclick="goBack()" class="btn btn-secondary mb-2">← Back to Table</button>`;
            console.log("Received Data:", data);

            switch (stageNumber) {
                case 1:
    if (data.stage_one) {
        detailsHTML += `
            <div class="container" style="background-color:white; padding: 10px; border-radius: 20px"> 
                <div class="container" style="background-color:white; padding: 10px; border-radius: 20px">
                    <div class="row">
                        <div class="col-md-5">
                            <div class="mb-2">
                                <label style="font-size:12px; color:#555" for="requirement" class="form-label">Requirement</label>
                            </div>
                            <div class="mb-2">
                                <label style="font-size:12px; color:#555" for="solution" class="form-label">Solution</label>
                                <textarea class="form-control" id="solution1" style="font-size:12px; color:#555" readonly></textarea>
                            </div>
                            <div class="mb-2">
                                <label style="font-size:12px; color:#555" for="technology" class="form-label">Technology</label>
                                <input readonly style="font-size:12px; color:#555" type="text" class="form-control" id="technology1" readonly>
                            </div>
                            <div class="mb-2">
                                <label style="font-size:12px; color:#555" for="dealSize" class="form-label">Deal Size</label>
                                <input readonly style="font-size:12px; color:#555" type="number" class="form-control" id="dealSize1" readonly>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-6">
                                <label style="font-size:12px; color:#555" for="remarks" class="form-label">Stage Remarks</label>
                                <textarea name="stage_one_remarks" class="form-control" id="remarks1" style="font-size:12px; color:#555" readonly></textarea>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-2">
                                <label style="font-size:12px; color:#555" for="distributor" class="form-label">Distributor</label>
                                <input readonly style="font-size:12px; color:#555" name="distributor" type="text" class="form-control" id="distributor1" readonly>
                            </div>
                            <div class="mb-2">
                                <label style="font-size:12px; color:#555" for="product" class="form-label">Product</label>
                                <input readonly style="font-size:12px; color:#555" name="product" type="text" class="form-control" id="product1" readonly>
                            </div>
                            <div class="mb-2">
                                <label style="font-size:12px; color:#555" for="status" class="form-label">Status</label>
                                <input readonly style="font-size:12px; color:#555" id="status1" type="text" class="form-control" readonly>
                            </div>
                            <div class="mb-2">
                                <label style="font-size:12px; color:#555" for="startDate" class="form-label">Start Date</label>
                                <input readonly style="font-size:12px; color:#555" id="start-date1" type="text" class="form-control" readonly>
                            </div>
                            <div class="mb-2">
                                <label style="font-size:12px; color:#555" for="endDate" class="form-label">End Date</label>
                                <input readonly style="font-size:12px; color:#555" id="end-date1" type="text" class="form-control" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
        // Assign the generated HTML to detailsView
        detailsView.innerHTML = detailsHTML;

        // Dynamically set the input and textarea values
        document.getElementById("solution1").value = data.stage_one.status || "No Solution Available";
        document.getElementById("technology1").value = data.stage_one.technology || "N/A";
        document.getElementById("dealSize1").value = data.stage_one.deal_size || 0;
        document.getElementById("remarks1").value = data.stage_one.remarks || "No Remarks Available";
        document.getElementById("distributor1").value = data.stage_one.distributor || "N/A";
        document.getElementById("product1").value = data.stage_one.product || "N/A";
        document.getElementById("status1").value = data.stage_one.status_stage || "N/A";
        document.getElementById("start-date1").value = data.stage_one.start_date || "N/A";
        document.getElementById("end-date1").value = data.stage_one.end_date || "N/A";
    } else {
        detailsHTML += "<p>Stage 1 details not available.</p>";
        detailsView.innerHTML = detailsHTML;
    }
    break;

                case 2:
                    if (data.stage_two) {
                        detailsHTML += `
                            <div class="container" style="background-color: white; padding: 10px; border-radius: 20px"> 
                                <div class="container" style="background-color: white; padding: 5px; border-radius: 20px">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Start Date</label>
                                            <input style="font-size:12px; color:#555" type="text" class="form-control" id="stage-two-start" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">End Date</label>
                                            <input  style="font-size:12px; color:#555" type="text" class="form-control" id="stage-two-end"   readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Status</label>
                                            <input  style="font-size:12px; color:#555" type="text" class="form-control" id="stage-two-status"   readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="technology" class="form-label ">Technology</label>
                                            <input style="font-size:12px; color:#555" name="deal_size" type="number" class="form-control" id="dealSize" readonly >
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="dealSize" class="form-label ">Deal Size</label>
                                            <input style="font-size:12px; color:#555" name="deal_size" type="number" class="form-control" id="dealSize" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="product" class="form-label ">Product</label>
                                            <input style="font-size:12px; color:#555" name="deal_size" type="number" class="form-control" id="dealSize" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label style="font-size:12px; color:#555" for="solution" class="form-label ">Solution</label>
                                                <textarea name="solution" class="form-control" id="remarks" 
                                                style="font-size:12px; color:#555" readonly></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="container" style="background-color: white; padding: 5px; border-radius: 20px">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="engagement" class="form-label ">Type of Engagement</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="engagement" class="form-label ">Date</label>
                                        </div>
                                        <div class="col-md-5">
                                            <label style="font-size:12px; color:#555" for="engagement" class="form-label ">Remarks</label>
                                        </div>
                                        
                                    </div>
                                    <!-- Container for Engagement Fields -->
                                    <div id="engagement-fields-container">
                                        <div class="row engagement-fields mb-3">
                                            <div class="col-md-3">
                                                <input style="font-size:12px; color:#555" name="engagement_type[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <input style="font-size:12px; color:#555" name="engagement_date[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <input  style="font-size:12px; color:#555" name="engagement_remarks[]" type="text" class="form-control" readonly>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="container" style="background-color: white; padding: 5px; border-radius: 20px">
                                    <!-- Header Row -->
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Requirement</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Date</label>
                                        </div>
                                        <div class="col-md-5">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Requirement Remarks</label>
                                        </div>
                                        
                                    </div>

                                    <!-- Container for Requirement Fields -->
                                    <div id="requirement-fields-container">
                                        <!-- Initial Requirement Row -->
                                        <div class="row requirement-fields mb-3">
                                            <div class="col-md-3">
                                                <input style="font-size:12px; color:#555" name="requirement_two[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="requirement_date[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <input style="font-size:12px; color:#555" name="requirement_remarks[]" type="text" class="form-control" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container" style="background-color: white; padding: 10px; border-radius: 20px">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Stage Remarks</label>
                                            <input style="font-size:12px; color:#555" name="stage_two_remarks" type="textarea" class="form-control" id="stageremarks" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        detailsHTML += "<p>Stage 2 details not available.</p>";
                    }
                    break;
                case 3:
                    if (data.stage_three) {
                        detailsHTML += `
                            <div class="container" style="background-color:white; padding: 10px; border-radius: 20px"> 
                                <div class="container" style="background-color:white; padding: 5px; border-radius: 20px">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Start Date</label>
                                            <input style="font-size:12px; color:#555" name="" type="text" class="form-control" id="stage-three-start"  readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">End Date</label>
                                            <input style="font-size:12px; color:#555" name="" type="text" class="form-control" id="stage-three-end"  readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="status" class="form-label ">Status</label>
                                            <input style="font-size:12px; color:#555" name="" type="text" class="form-control" id="stage-three-status"  readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Technology</label>
                                            <input style="font-size:12px; color:#555" readonly name="contract_duration" type="text" class="form-control" id="contract" readonly>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Product</label>
                                            <input style="font-size:12px; color:#555" readonly name="contract_duration" type="text" class="form-control" id="contract" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="status" class="form-label ">Deal Size(Amount)</label>
                                            <input style="font-size:12px; color:#555" name="deal_size" type="number" class="form-control" id="dealSize3" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label style="font-size:12px; color:#555" for="status" class="form-label ">Solution</label>
                                            <textarea name="solution" class="form-control" id="solution"  
                                                style="font-size:12px; color:#555" readonly ></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="container" style="background-color:white; padding: 5px; border-radius: 20px">
                                    <div class="row mb-1">
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="engagement" class="form-label ">Type of Engagement</label>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="engagement" class="form-label ">Date</label>
                                        </div>
                                        <div class="col-md-5">
                                            <label style="font-size:12px; color:#555" for="engagement" class="form-label ">Remarks</label>
                                        </div>
                                       
                                    </div>
                                    <!-- Container for Engagement Fields -->
                                    <div id="engagement-fields-container3">
                                        <div class="row engagement-fields mb-3">
                                            <div class="col-md-3">
                                                <input style="font-size:12px; color:#555" name="engagement_three[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <input style="font-size:12px; color:#555" name="engagement_date[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <input style="font-size:12px; color:#555" name="engagement_remarks_three[]" type="text" class="form-control" readonly>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="container" style="background-color:white; padding: 5px; border-radius: 20px">
                                    <!-- Header Row -->
                                    <div class="row mb-1">
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Requirement</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Quantity</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Bill of Materials</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Pricing</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Remarks</label>
                                        </div>
                                        
                                    </div>

                                    <!-- Container for Requirement Fields -->
                                    <div id="requirement-fields-container3">
                                        <!-- Initial Requirement Row -->
                                        <div class="row requirement-fields mb-3">
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="requirement_three[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="quantity[]" type="number" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="bill_of_materials[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="pricing[]" type="number" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="requirement_remarks_three[]" type="text" class="form-control" readonly>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="container" style="background-color:white; padding: 10px; border-radius: 20px">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Stage Remarks</label>
                                            <input style="font-size:12px; color:#555" name="stage_three_remarks" type="textarea" class="form-control" id="requirement"style="height: 50px;" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        detailsHTML += "<p>Stage 3 details not available.</p>";
                    }
                    break;
                case 4:
                    if (data.stage_four) {
                        detailsHTML += `
                             <div class="container" style="background-color:white; padding: 10px; border-radius: 20px"> 
                                <div class="container" style="background-color:white; padding: 5px; border-radius: 20px">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Start Date</label>
                                            <input style="font-size:12px; color:#555" type="text" class="form-control" id="stage-four-start"  readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">End Date</label>
                                            <input style="font-size:12px; color:#555" type="text" class="form-control" id="stage-four-end"  readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="status" class="form-label ">Status</label>
                                            <input style="font-size:12px; color:#555" type="text" class="form-control" id="stage-four-status"  readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Technology</label>
                                            <input style="font-size:12px; color:#555" readonly name="contract_duration" type="text" class="form-control" id="contract" readonly>
                                        </div>
                                        
                                    </div>
                                    <div class="row mb-3">
                                            <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="product" class="form-label ">Product</label>
                                            <input style="font-size:12px; color:#555" readonly name="contract_duration" type="text" class="form-control" id="contract" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="dealSize" class="form-label ">Deal Size</label>
                                            <input style="font-size:12px; color:#555" name="deal_size" type="number" class="form-control" id="dealSize" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label style="font-size:12px; color:#555" for="status" class="form-label ">Solution</label>
                                            <textarea name="solution" class="form-control" id="solution"  
                                                style="font-size:12px; color:#555" readonly></textarea>
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="container" style="background-color:white; padding: 5px; border-radius: 20px">
                                    <!-- Fixed Labels Row -->
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Requirement</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="quantity" class="form-label ">Quantity</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="bills_of_materials" class="form-label ">Bills of Materials</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="pricing" class="form-label ">Pricing</label>
                                        </div>
                                        <div class="col-md-2">
                                            <label style="font-size:12px; color:#555" for="date_required" class="form-label ">Date Required</label>
                                        </div>
                                        
                                    </div>

                                    <!-- Container for input Rows -->
                                    <div id="requirement-fields-container4">
                                        <!-- Initial input Row -->
                                        <div class="row mb-3 requirement-fields">
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="requirement_four[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="quantity[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="bill_of_materials[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="pricing[]" type="text" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-2">
                                                <input style="font-size:12px; color:#555" name="date_required[]" type="text" class="form-control" readonly>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="container" style="background-color:white; padding: 10px; border-radius: 20px">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Stage Remarks</label>
                                            <input style="font-size:12px; color:#555" name="stage_four_remarks" type="textarea" class="form-control" id="requirement"style="height: 50px;" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        detailsHTML += "<p>Stage 4 details not available.</p>";
                    }
                    break;
                case 5:
                    if (data.stage_five) {
                        detailsHTML += `
                           <div class="container" style="background-color:white; padding: 10px; border-radius: 20px"> 
                                <div class="container" style="background-color:white; padding: 5px; border-radius: 20px">
                                    <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Start Date</label>
                                            <input style="font-size:12px; color:#555" type="text" class="form-control" id="stage-five-start" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">End Date</label>
                                            <input style="font-size:12px; color:#555" type="text" class="form-control" id="stage-five-end" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="status" class="form-label ">Status</label>
                                            <input style="font-size:12px; color:#555" type="text" class="form-control" id="stage-five-status"  readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Technology</label>
                                            <input style="font-size:12px; color:#555" readonly name="contract_duration" type="text" class="form-control" id="contract" readonly>
                                        </div>
                                    </div>
                                        <div class="row mb-3">
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="product" class="form-label ">Product</label>
                                            <input style="font-size:12px; color:#555" readonly name="contract_duration" type="text" class="form-control" id="contract" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Deal Size(Amount)</label>
                                            <input style="font-size:12px; color:#555" name="deal_size" type="text" class="form-control" id="dealSize5" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label style="font-size:12px; color:#555" for="status" class="form-label ">Solution</label>
                                            <textarea name="solution" class="form-control" id="solution"  
                                                style="font-size:12px; color:#555" readonly></textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label style="font-size:12px; color:#555" for="status" class="form-label ">SPR Number</label>
                                            <input style="font-size:12px; color:#555" readonly type="text" class="form-control" id="stage-five-spr"  readonly">
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Contract Duration(Days)</label>
                                            <input style="font-size:12px; color:#555" readonly name="contract_duration" type="text" class="form-control" id="contract" readonly>
                                        </div>
                                        <div class="col-md-4">
                                            <label style="font-size:12px; color:#555" for="billingType" class="form-label ">Billing Type</label>
                                            <input style="font-size:12px; color:#555" readonly name="contract_duration" type="text" class="form-control" id="contract" readonly>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color:white; padding: 5px; border-radius: 20px">
                                        <!-- Fixed Labels Row -->
                                        <div class="row mb-1">
                                            <div class="col-md-3">
                                                <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Requirement</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label style="font-size:12px; color:#555" for="quantity" class="form-label ">Quantity</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label style="font-size:12px; color:#555" for="bills_materials" class="form-label ">Bills of Materials</label>
                                            </div>
                                            <div class="col-md-3">
                                                <label style="font-size:12px; color:#555" for="remarks" class="form-label ">Remarks</label>
                                            </div>
                                        </div>
                                        <!-- Container for input readonly Rows -->
                                        <div id="requirement-fields-container5">
                                            <!-- Initial input readonly Row -->
                                            <div class="row mb-3 requirement-fields">
                                                <div class="col-md-3">
                                                    <input style="font-size:12px; color:#555" readonly name="quantity[]" type="number" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <input style="font-size:12px; color:#555" readonly name="quantity[]" type="number" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <input style="font-size:12px; color:#555" readonly name="bills_materials_req[]" type="number" class="form-control" >
                                                </div>
                                                <div class="col-md-3">
                                                    <input style="font-size:12px; color:#555" readonly name="remarks_req[]" type="text" class="form-control">
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="container" style="background-color:white; padding: 5px; border-radius: 20px">
                                        <!-- Fixed Labels Row -->
                                        <div class="row mb-1">
                                            <div class="col-md-2">
                                                <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Upsell</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label style="font-size:12px; color:#555" for="bills_materials" class="form-label ">Bills of Materials</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label style="font-size:12px; color:#555" for="quantity" class="form-label ">Quantity</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label style="font-size:12px; color:#555" for="remarks" class="form-label ">Remarks</label>
                                            </div>
                                            <div class="col-md-2">
                                                <label style="font-size:12px; color:#555" for="amount" class="form-label ">Amount</label>
                                            </div>
                                            
                                        </div>

                                        <!-- Container for input readonly Rows -->
                                        <div id="upsell-fields-container">
                                            <!-- Initial input readonly Row -->
                                            <div class="row mb-3 upsell-fields">
                                                <div class="col-md-2">
                                                    <input style="font-size:12px; color:#555" readonly type="text" class="form-control" name="upsell[]" >
                                                </div>
                                                <div class="col-md-2">
                                                    <input style="font-size:12px; color:#555" readonly name="bills_materials_upsell[]" type="number" class="form-control" >
                                                </div>
                                                <div class="col-md-2">
                                                    <input style="font-size:12px; color:#555" readonly name="quantity_upsell[]" type="number" class="form-control" >
                                                </div>
                                                <div class="col-md-2">
                                                    <input style="font-size:12px; color:#555" readonly name="remarks_upsell[]" type="text" class="form-control">
                                                </div>
                                                <div class="col-md-2">
                                                    <input style="font-size:12px; color:#555" readonly name="amount_upsell[]" type="number" class="form-control" >
                                                </div>
                                               
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container" style="background-color:white; padding: 10px; border-radius: 20px">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label style="font-size:12px; color:#555" for="requirement" class="form-label ">Stage Remarks</label>
                                            <input style="font-size:12px; color:#555" readonly name="remarks_stage_five" type="textarea" class="form-control" id="requirement"style="height: 50px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    } else {
                        detailsHTML += "<p>Stage 5 details not available.</p>";
                    }
                    break;
                default:
                    detailsHTML += "<p>Invalid stage selected.</p>";
                    break;
            }

            // Inject the generated HTML into the details view
            detailsView.innerHTML = detailsHTML;
        })
        .catch((error) => {
            console.error("Error fetching stage details:", error);
            detailsView.innerHTML = "<p>Failed to load stage details. Please try again later.</p>";
        });
}

// Helper to go back to the table view
function goBack() {
    document.getElementById("details-view").style.display = "none";
    document.getElementById("table-view").style.display = "block";
}
