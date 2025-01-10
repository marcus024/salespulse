let isEditMode = false;

document.addEventListener('DOMContentLoaded', function () {
    const editSaveBtn = document.getElementById('editSaveButton');

    // Toggle between Edit and Save when the button is clicked
    editSaveBtn.addEventListener('click', function () {
        const scheduleModal = document.getElementById('schedModal');
        const scheduleId = scheduleModal.getAttribute('data-sched-id');

        if (!scheduleId) {
            alert("Schedule ID is missing!");
            return;
        }

        if (!isEditMode) {
            enableEditMode();
        } else {
            saveChanges(scheduleId);
        }
    });
});

// Function to set schedule ID and populate the modal
function openScheduleModal(scheduleId, event, date, time, venue) {
    const scheduleModal = document.getElementById('schedModal');
    scheduleModal.setAttribute('data-sched-id', scheduleId);

    // Populate modal fields with existing data
    document.getElementById('modalEvent').textContent = event;
    document.getElementById('modalDate').textContent = date;
    document.getElementById('modalTime').textContent = time;
    document.getElementById('modalVenue').textContent = venue;

    // Reset Edit Mode
    disableEditMode();

    // Show the modal (using Bootstrap's modal API)
    const modalInstance = new bootstrap.Modal(scheduleModal);
    modalInstance.show();
}

function enableEditMode() {
    isEditMode = true;
    document.getElementById('editSaveButton').textContent = 'Save';

    toggleField('modalEvent', 'modalEvent_edit', true);
    toggleField('modalDate', 'modalDate_edit', true);
    toggleField('modalTime', 'modalTime_edit', true);
    toggleField('modalVenue', 'modalVenue_edit', true);
}

function disableEditMode() {
    isEditMode = false;
    document.getElementById('editSaveButton').textContent = 'Edit';

    toggleField('modalEvent', 'modalEvent_edit', false);
    toggleField('modalDate', 'modalDate_edit', false);
    toggleField('modalTime', 'modalTime_edit', false);
    toggleField('modalVenue', 'modalVenue_edit', false);
}

function toggleField(spanId, inputId, direction) {
    const spanEl = document.getElementById(spanId);
    const inputEl = document.getElementById(inputId);

    if (direction) {
        inputEl.value = spanEl.textContent.trim();
        spanEl.classList.add('d-none');
        inputEl.classList.remove('d-none');
    } else {
        spanEl.textContent = inputEl.value.trim();
        inputEl.classList.add('d-none');
        spanEl.classList.remove('d-none');
    }
}

function saveChanges(scheduleId) {
    const updatedEvent = document.getElementById('modalEvent_edit').value.trim();
    const updatedDate = document.getElementById('modalDate_edit').value.trim();
    const updatedTime = document.getElementById('modalTime_edit').value.trim();
    const updatedVenue = document.getElementById('modalVenue_edit').value.trim();

    if (!updatedEvent || !updatedDate || !updatedTime || !updatedVenue) {
        alert("All fields are required!");
        return;
    }

    fetch('dirback/updateSchedule.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
            sched_id: scheduleId,
            event: updatedEvent,
            start: updatedDate,
            time: updatedTime,
            venue: updatedVenue
        })
    })
        .then(resp => resp.json())
        .then(result => {
            console.log("Update response:", result);
            if (result.error) {
                alert("Error saving changes: " + result.message);
            } else {
                disableEditMode(); // Only switch to view mode on success
                alert("Schedule updated!");
                setTimeout(function() {
          window.location.reload(true); // Force reload without using cache
        }, 500);
            }
        })
        .catch(err => {
            console.error("Fetch error:", err);
            alert("An error occurred while saving schedule changes.");
        });
}
