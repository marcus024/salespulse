<style>
    #notificationBar {
    display: none;
    position: fixed;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    background-color: #36b9cc;
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    font-size: 14px;
    text-align: center;
    z-index: 9999;
}

#notificationIcon {
    margin-right: 10px;
}

</style>
<!-- Notification Bar (Initially Hidden) -->
<div id="notificationBar" style="display: none; position: absolute; top: 10px; left: 50%; transform: translateX(-50%); background-color: #36b9cc; color: white; padding: 10px 20px; border-radius: 5px; font-size: 14px; text-align: center;">
    <i id="notificationIcon" class="fas fa-check-circle" style="margin-right: 10px;"></i>
    <span id="notificationMessage">Action completed successfully!</span>
</div>
<script>
    function showNotification(message, isSuccess) {
    const notificationBar = document.getElementById('notificationBar');
    const notificationMessage = document.getElementById('notificationMessage');
    const notificationIcon = document.getElementById('notificationIcon');

    // Set the message and icon based on the success or failure of the action
    notificationMessage.textContent = message;
    if (isSuccess) {
        notificationIcon.classList.remove('fa-times-circle');
        notificationIcon.classList.add('fa-check-circle');
    } else {
        notificationIcon.classList.remove('fa-check-circle');
        notificationIcon.classList.add('fa-times-circle');
    }

    // Show the notification bar
    notificationBar.style.display = 'block';

    // Hide the notification after 5 seconds
    setTimeout(() => {
        notificationBar.style.display = 'none';
    }, 5000);
}

</script>