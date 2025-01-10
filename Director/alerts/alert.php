<!-- Custom Popup Modal -->

<style>
    /* Custom Modal Styling */
.custom-modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 1000;
}

.custom-modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
}

.custom-modal-button {
    margin-top: 15px;
    padding: 10px 20px;
    background-color: #36b9cc;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.custom-modal-button:hover {
    background-color: #007b7f;
}

.d-none {
    display: none;
}

</style>
<div id="customAlert" class="custom-modal d-none">
    <div class="custom-modal-content">
        <span id="customAlertMessage"></span>
        <button id="customAlertClose" class="custom-modal-button">OK</button>
    </div>
</div>
<script>
    // Function to show the custom alert
    function showCustomAlert(message, callback = null) {
        const modal = document.getElementById('customAlert');
        const messageElement = document.getElementById('customAlertMessage');
        const closeButton = document.getElementById('customAlertClose');

        // Set the message
        messageElement.textContent = message;

        // Show the modal
        modal.classList.remove('d-none');

        // Close the modal on button click
        closeButton.onclick = () => {
            modal.classList.add('d-none');
            if (callback) callback(); // Execute the callback if provided
        };
    }
</script>