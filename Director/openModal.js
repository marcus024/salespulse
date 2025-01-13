function openModal(projectId) {
  console.log("Received Project ID:", projectId);
  if (!projectId) {
    console.error("No project ID provided.");
    return;
  }

  // This is optional but sets an element’s text
  document.getElementById('project-id-placeholder').textContent = projectId;

  // Actually open the modal (Bootstrap 5 example)
  const modalElement = new bootstrap.Modal(document.getElementById('multiStepModal'));
  modalElement.show();

  fetch(`./dirback/openModaldata.php?project_id=${projectId}`)
    .then(response => {
      if (!response.ok) {
        throw new Error(`HTTP Error: ${response.status}`);
      }
      alert("Successfully fetched data from server!");
      return response.json();
    })
    .then(data => {
      if (data.status === 'success') {
        alert("Successful Fetch");
        // ... fill in your modal fields here ...
      } else {
        alert('Waray data: ' + data.message);
      }
    })
    .catch(error => {
      console.error('Error fetching data:', error);
      alert('Project ID is Missing');
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