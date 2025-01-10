<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step-by-Step Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .step {
            display: none;
        }
        .step.active {
            display: block;
        }
        .step-header {
            font-size: 1.5em;
            margin-bottom: 10px;
        }
        .step-content {
            margin-bottom: 20px;
        }
        .step-indicators {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .step-indicator {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            color: #fff;
        }
        .step-indicator.active {
            background-color: #4CAF50;
        }
        .step-line {
            height: 4px;
            width: 100%;
            background-color: #ddd;
            margin: 10px 0;
        }
        .step-line.active {
            background-color: #4CAF50;
        }
        .button-container {
            display: flex;
            justify-content: space-between;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 1em;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="step-indicators">
        <div id="step1-circle" class="step-indicator">1</div>
        <div id="line1" class="step-line"></div>
        <div id="step2-circle" class="step-indicator">2</div>
        <div id="line2" class="step-line"></div>
        <div id="step3-circle" class="step-indicator">3</div>
        <div id="line3" class="step-line"></div>
        <div id="step4-circle" class="step-indicator">4</div>
        <div id="line4" class="step-line"></div>
        <div id="step5-circle" class="step-indicator">5</div>
    </div>

    <div id="step1" class="step active">
        <div class="step-header">Step 1</div>
        <div class="step-content">This is the first step. Fill in the details.</div>
    </div>
    <div id="step2" class="step">
        <div class="step-header">Step 2</div>
        <div class="step-content">This is the second step. Confirm your data.</div>
    </div>
    <div id="step3" class="step">
        <div class="step-header">Step 3</div>
        <div class="step-content">This is the third step. Review your choices.</div>
    </div>
    <div id="step4" class="step">
        <div class="step-header">Step 4</div>
        <div class="step-content">This is the fourth step. Finalize the information.</div>
    </div>
    <div id="step5" class="step">
        <div class="step-header">Step 5</div>
        <div class="step-content">This is the final step. Submit the form.</div>
    </div>

    <div class="button-container">
        <button id="saveButton">Save Changes</button>
        <button id="completeButton">Complete Step</button>
    </div>
</div>

<script>
    let currentStep = 1;
    const totalSteps = 5;

    document.getElementById('saveButton').addEventListener('click', () => {
        if (confirm('Do you want to save changes?')) {
            alert('Changes saved.');
        }
    });

    document.getElementById('completeButton').addEventListener('click', () => {
        if (confirm('Are you sure you want to complete this step? This action cannot be undone.')) {
            document.getElementById(`step${currentStep}-circle`).classList.add('active');
            if (currentStep < totalSteps) {
                document.getElementById(`line${currentStep}`).classList.add('active');
                currentStep++;
                showStep(currentStep);
            } else {
                alert('Form completed!');
            }
        }
    });

    function showStep(step) {
        for (let i = 1; i <= totalSteps; i++) {
            document.getElementById(`step${i}`).classList.add('d-none');
        }
        document.getElementById(`step${step}`).classList.remove('d-none');
    }
</script>

</body>
</html>
