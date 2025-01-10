$(document).ready(function () {
    $(".todo-save").on("click", function (e) {
        e.preventDefault();

        // Collect field values
        let taskName = $("#taskName").val().trim();
        let assignedTo = $("#assignedTo").val().trim();
        let startDate = $("#startTask").val();
        let endDate = $("#endTask").val();

        // Log field values
        console.log("Task Name:", taskName);
        console.log("Assigned To:", assignedTo);
        console.log("Start Date:", startDate);
        console.log("End Date:", endDate);

        // Validate fields
        if (!taskName || !assignedTo || !startDate || !endDate) {
            alert("Please fill in all required fields.");
            return;
        }

        // AJAX request to backend
        $.ajax({
            url: "dirback/to-do/insert_task.php",
            type: "POST",
            data: {
                taskname: taskName,
                assigned: assignedTo,
                starttask: startDate,
                endtask: endDate
            },
            success: function (response) {
                console.log("Server Response:", response);
                
                    alert("Task added successfully!");
                    location.reload(); // Refresh page after success
                
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", error);
                alert("Failed to save the task. Please try again.");
            }
        });
    });
});
