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
        fetch(`./dirback/openModaldata.php?project_id=${projectId}`)
  .then(response => {
    console.log("HTTP status:", response.status);
    // If not in 2xx range
    if (!response.ok) {
      throw new Error(`HTTP Error: ${response.status}`);
    }
    return response.text(); // <-- get raw text
  })
  .then(rawText => {
    console.log("Raw response text:", rawText);
    // If you see HTML, that’s the root cause
    try {
      const data = JSON.parse(rawText); // parse manually
      console.log("Parsed data:", data);
    } catch (parseErr) {
      console.error("JSON parse error:", parseErr);
    }
  })
  .catch(error => {
    console.error("Caught error:", error);
    alert("Something went wrong: " + error.message);
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