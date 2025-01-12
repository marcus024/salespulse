$(document).ready(function () {
    function loadTasks() {
        $.ajax({
            url: "dirback/to-do/load_task.php",
            type: "GET",
            success: function (response) {
                if (response.success) {
                    const taskList = $("#taskList");
                    taskList.empty(); 

                    if (response.tasks.length === 0) {
                        const noTaskHtml = `
                            <div class="text-center p-3">
                                <p style="font-size: 12px; color: #999;">No tasks available.</p>
                            </div>`;
                        taskList.append(noTaskHtml); 
                        return; 
                    }
                    response.tasks.forEach(task => {
                        const taskHtml = `
                            <div class="d-flex flex-column p-2 border rounded" style="height: auto; min-height: 40px;">
                                <div>
                                    <input type="checkbox" id="task${task.todo_id}" style="margin-right: 10px;">
                                    <label for="task${task.todo_id}" style="font-size: 10px;">${task.taskname}</label>
                                </div>
                                <div class="d-flex gap-1 justify-content-end mt-1">
                                    <a href="#" class="edittask" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editTask" 
                                    data-id="${task.todo_id}" 
                                    data-task="${task.taskname}" 
                                    data-assigned="${task.assigned}" 
                                    data-start="${task.starttask}" 
                                    data-end="${task.endtask}">
                                        <i class="fas fa-eye" style="font-size: 12px; color: #36b9cc;"></i>
                                    </a>
                                    <!-- Delete Icon -->
                                    <a href="#" class="deletetask" data-bs-toggle="modal" data-bs-target="#deleteTaskModal" 
                                        data-id="${task.todo_id}">
                                        <i class="fas fa-trash" style="font-size: 12px; color: red;"></i>
                                    </a>
                                </div>
                            </div>`;
                        taskList.append(taskHtml); 
                    });
                } else {
                    alert(response.message || "Failed to load tasks.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Failed to fetch tasks:", error);
                alert("An error occurredvhghgf loading tasks.");
            }
        });
    }

   
    loadTasks();

 $(document).on("click", ".edittask", function (e) {
    e.preventDefault();

    const taskId = $(this).data("id");
    const taskName = $(this).data("task");
    const assignedTo = $(this).data("assigned");
    const startDate = $(this).data("start");
    const endDate = $(this).data("end");

    $("#modalTask").text(taskName);
    $("#modalAssign").text(assignedTo);
    $("#modalstartDate").text(startDate);
    $("#modalendDate").text(endDate);

    $("#editTask").data("taskId", taskId);
    $("#editTask").modal("show");

    console.log({
        taskId,
        taskName,
        assignedTo,
        startDate,
        endDate,
    });
});



$(document).ready(function () {
    $(document).on("click", "#editSaveButton", function () {
        const isEditing = $(this).text().trim() === "Edit";

        if (isEditing) {
            console.log("Switching to Edit Mode");

            // Switch to Edit Mode
            $("#modalTask").addClass("d-none"); // Hide span
            $("#modalTask_edit").removeClass("d-none").val($("#modalTask").text()); // Show input and set value
            
            $("#modalAssign").addClass("d-none"); // Hide span
            $("#modalAssign_edit").removeClass("d-none").val($("#modalAssign").text()); // Show input and set value
            
            $("#modalstartDate").addClass("d-none"); // Hide span
            $("#modalStart_edit").removeClass("d-none").val($("#modalstartDate").text()); // Show input and set value
            
            $("#modalendDate").addClass("d-none"); // Hide span
            $("#modalEnd_edit").removeClass("d-none").val($("#modalendDate").text()); // Show input and set value

            // Change button text to Save
            $(this).text("Save");
        } else {
            console.log("Saving changes");

            // Save Changes
            const taskId = $("#editTask").data("taskId"); // Get taskId stored in modal

            const taskData = {
                todo_id: taskId,
                taskname: $("#modalTask_edit").val(),
                assigned: $("#modalAssign_edit").val(),
                starttask: $("#modalStart_edit").val(),
                endtask: $("#modalEnd_edit").val(),
            };

            console.log("Sending data:", taskData); // Debugging data

            $.ajax({
                url: "dirback/to-do/update_task.php",
                type: "POST",
                data: taskData,
                success: function (response) {
                    console.log("Response:", response); // Debugging response
                    if (response.success) {
                        alert("Task updated successfully.");
                        
                        // Reload tasks and close modal
                        loadTasks();
                        $("#editTask").modal("hide");
                    } else {
                        alert(response.message || "Failed to update task.");
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Failed to update task:", error);
                    alert("An error occurred while updating the task.");
                }
            });

            // Switch back to Edit mode
            $(this).text("Edit");
            
            // Revert to viewing mode
            $("#modalTask").removeClass("d-none").text($("#modalTask_edit").val());
            $("#modalTask_edit").addClass("d-none");
            
            $("#modalAssign").removeClass("d-none").text($("#modalAssign_edit").val());
            $("#modalAssign_edit").addClass("d-none");
            
            $("#modalstartDate").removeClass("d-none").text($("#modalStart_edit").val());
            $("#modalStart_edit").addClass("d-none");
            
            $("#modalendDate").removeClass("d-none").text($("#modalEnd_edit").val());
            $("#modalEnd_edit").addClass("d-none");
        }
    });

    // When an edit task is clicked, populate the modal with task data
    $(document).on("click", ".edittask", function (e) {
        e.preventDefault();

        const taskId = $(this).data("id");
        const taskName = $(this).data("task");
        const assignedTo = $(this).data("assigned");
        const startDate = $(this).data("start");
        const endDate = $(this).data("end");

        // Populate the modal with task details
        $("#modalTask").text(taskName);
        $("#modalAssign").text(assignedTo);
        $("#modalstartDate").text(startDate);
        $("#modalendDate").text(endDate);

        // Store taskId in the modal for later use
        $("#editTask").data("taskId", taskId);

        // Reset button text to Edit (in case it was left as Save)
        $("#editSaveButton").text("Edit");

        // Show the modal
        $("#editTask").modal("show");

        console.log({
            taskId,
            taskName,
            assignedTo,
            startDate,
            endDate,
        });
    });
});






    $(document).on("click", ".deletetask", function (e) {
        e.preventDefault();

        const taskId = $(this).data("id");
        $("#deleteTaskModal").data("todo_id", taskId);

        $("#deleteTaskModal").modal("show");
    });

    $("#deleteTaskModal").on("click", ".btn-danger", function () {
        const taskId = $("#deleteTaskModal").data("todo_id");

        console.log("Deleting Task ID:", taskId);

        $.ajax({
            url: "dirback/to-do/delete_task.php",
            type: "POST",
            data: { id: taskId },
            success: function (response) {
                let jsonResponse;
                try {
                    jsonResponse = typeof response === "string" ? JSON.parse(response) : response;
                } catch (e) {
                    console.error("Failed to parse response as JSON:", response);
                    alert("An unexpected error occurred while processing the response.");
                    return;
                }

                console.log("Delete Task Response:", jsonResponse);

                if (jsonResponse.success) {
                    
                    loadTasks();
                    $("#deleteTaskModal").modal("hide");
                } else {
                    alert(jsonResponse.message || "Failed to delete task.");
                }
            },
            error: function (xhr, status, error) {
                console.error("Failed to delete task:", xhr.responseText || error);
                alert("An error occurred while deleting the task.");
            }
        });
    });``

});
