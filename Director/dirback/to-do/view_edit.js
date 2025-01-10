document.addEventListener("DOMContentLoaded", () => {
    const editSaveButton = document.getElementById("editSaveButton");

   document.querySelectorAll(".edittask").forEach(button => {
    button.addEventListener("click", async (event) => {
        const taskId = button.getAttribute("data-id");
        try {
            // Fetch task data
            const response = await fetch(`dirback/to-do/view.php?id=${taskId}`);
            const result = await response.json();

            if (result.status === 'success') {
                const task = result.data;

                console.log(task); // Debugging: Check the returned object structure

                // Populate modal with fetched data
                document.getElementById("modalTask").innerText = task.taskname;
                document.getElementById("modalAssign").innerText = task.assigned; // Use correct DB column
                document.getElementById("modalstartDate").innerText = task.starttask; // Use correct DB column
                document.getElementById("modalendDate").innerText = task.endtask; // Use correct DB column

                // Populate hidden inputs for editing
                document.getElementById("modalTask_edit").value = task.taskname;
                document.getElementById("modalAssign_edit").value = task.assigned; // Use correct DB column
                document.getElementById("modalStart_edit").value = task.starttask; // Use correct DB column
                document.getElementById("modalEnd_edit").value = task.endtask; // Use correct DB column

                // Reset to View Mode
                toggleEditMode(false);
            } else {
                alert(result.message || "Failed to fetch task data.");
            }
        } catch (error) {
            console.error("Error fetching task:", error);
        }
    });
});


    editSaveButton.addEventListener("click", async () => {
        const isEditMode = editSaveButton.innerText === "Save";
        const taskId = document.querySelector(".edittask[data-id]").getAttribute("data-id");

        if (isEditMode) {
            // Save edited values
            const updatedTask = {
                id: taskId,
                taskname: document.getElementById("modalTask_edit").value,
                assigned_to: document.getElementById("modalAssign_edit").value,
                start_date: document.getElementById("modalStart_edit").value,
                end_date: document.getElementById("modalEnd_edit").value,
            };

            try {
                const response = await fetch("dirback/to-do/edit.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/json" },
                    body: JSON.stringify(updatedTask),
                });
                const result = await response.json();

                if (result.status === "success") {
                    alert("Task updated successfully!");
                    toggleEditMode(false);
                } else {
                    alert(result.message || "Failed to update task.");
                }
            } catch (error) {
                console.error("Error updating task:", error);
            }
        } else {
            // Enable Edit Mode
            toggleEditMode(true);
        }
    });

    function toggleEditMode(enable) {
        document.getElementById("modalTask").classList.toggle("d-none", enable);
        document.getElementById("modalTask_edit").classList.toggle("d-none", !enable);

        document.getElementById("modalAssign").classList.toggle("d-none", enable);
        document.getElementById("modalAssign_edit").classList.toggle("d-none", !enable);

        document.getElementById("modalstartDate").classList.toggle("d-none", enable);
        document.getElementById("modalStart_edit").classList.toggle("d-none", !enable);

        document.getElementById("modalendDate").classList.toggle("d-none", enable);
        document.getElementById("modalEnd_edit").classList.toggle("d-none", !enable);

        editSaveButton.innerText = enable ? "Save" : "Edit";
    }
});
