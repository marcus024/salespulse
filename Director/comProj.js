function completeProject(projectId) {
    if (!confirm("Are you sure you want to mark this project as completed?")) {
        return; // If user cancels, do nothing
    }
    
    // Use Fetch API or XMLHttpRequest to POST to complete_project.php
    fetch('dirback/comProj.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: new URLSearchParams({ project_id: projectId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert("Error completing project: " + data.message);
        } else {
            alert("Project marked as completed!");
            // Optionally reload page or update UI
            window.location.reload();
        }
    })
    .catch(err => {
        console.error("Fetch error:", err);
        alert("An error occurred while completing the project.");
    });
}
