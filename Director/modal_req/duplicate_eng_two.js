document.addEventListener('DOMContentLoaded', function () {
  const engagementContainer = document.getElementById('engagement1Container');
  const addEngagementBtn = document.getElementById('addEngagement1Btn');

  /**
   * Get the next block index for engagement blocks
   * @returns {number} The next available block index
   */
  function getNextEngagementIndex() {
    const allEngagements = engagementContainer.querySelectorAll('input[name="engagement_id_2[]"]');
    const indices = Array.from(allEngagements).map(input => {
      const value = input.value; // e.g., "st2eng3"
      const match = value.match(/st2eng(\d+)/); // Extract number after "st2eng"
      return match ? parseInt(match[1], 10) : 0; // Convert to integer or default to 0
    });

    // Return the next available block index
    return indices.length > 0 ? Math.max(...indices) + 1 : 1;
  }

  /**
   * "Add" button handler for duplicating engagement blocks
   */
  addEngagementBtn.addEventListener('click', function (e) {
    e.preventDefault();

    // Get the next engagement block index
    const nextEngagementIndex = getNextEngagementIndex();

    // Create a new engagement block
    const newEngagementBlock = document.createElement('div');
    newEngagementBlock.classList.add('engagement-block');
    newEngagementBlock.dataset.index = nextEngagementIndex;

    const newEngagementId = `st2eng${nextEngagementIndex}`;

    newEngagementBlock.innerHTML = `
      <p class="text-center  mb-1" style="font-style:'Poppins'; font-weight:bold; color:white;" id="engagement${nextEngagementIndex}">
        Engagement ${nextEngagementIndex}
      </p>
      <input type="hidden" name="engagement_id_2[]" value="${newEngagementId}" id="eng_${nextEngagementIndex}_id">
      <div class="row mb-1">
        <div class="col-md-4">
          <label for="engagement" class="form-label ">Type of Engagement</label>
        </div>
        <div class="col-md-2">
          <label for="engagement" class="form-label ">Date</label>
        </div>
        <div class="col-md-5">
          <label for="engagement" class="form-label ">Remarks</label>
        </div>
      </div>
      <div id="engagement-fields-container">
        <div class="row engagement-fields mb-3">
          <div class="col-md-4">
            <input name="engagement_type[]" type="text" class="form-control" placeholder="e.g. Sample Engagement">
          </div>
          <div class="col-md-2">
            <input name="engagement_date[]" type="date" class="form-control" style="font-size:10px;">
          </div>
          <div class="col-md-4">
            <input name="engagement_remarks[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
          </div>
          <div class="col-md-2">
            <button type="button"
                    class="btn btn-danger btn-sm removeEngagement"
                    style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;">
              <i class="fas fa-minus"></i>&nbsp;Remove
            </button>
          </div>
        </div>
      </div>
    `;

    // Append the new engagement block
    engagementContainer.appendChild(newEngagementBlock);
    console.log(`Added new engagement block: Engagement ${nextEngagementIndex}`);
  });

  /**
   * Delegate remove button functionality for engagement blocks
   */
  engagementContainer.addEventListener('click', function (e) {
    if (e.target.closest('.removeEngagement')) {
      e.preventDefault();
      const blockToRemove = e.target.closest('.engagement-block');
      if (blockToRemove) {
        blockToRemove.remove();
        console.log('Removed an engagement block.');
      }
    }
  });
});
