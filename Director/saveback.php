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