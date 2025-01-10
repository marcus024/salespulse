let scheduleIdToDelete = null;

// Set the schedule ID to delete
function setDeleteScheduleId(scheduleId) {
    scheduleIdToDelete = scheduleId;
}

// Delete the schedule
function deleteSchedule() {
    if (!scheduleIdToDelete) {
        alert("No schedule ID selected for deletion.");
        return;
    }

    // Send request to backend to delete schedule
    fetch(`dirback/schedule/deleteSchedule.php?schedule_id=${scheduleIdToDelete}`, {
        method: 'DELETE',
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert("Schedule deleted successfully!");
                // Reload or update the schedule list
                location.reload();
            } else {
                alert("Failed to delete schedule: " + data.error);
            }
        })
        .catch(error => {
            console.error("Error:", error);
            alert("An error occurred while deleting the schedule.");
        });
}
