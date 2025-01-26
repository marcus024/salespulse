document.addEventListener('DOMContentLoaded', function () {
  const engagementContainer = document.getElementById('engagementthreeContainer');
  const addEngagementBtn = document.getElementById('addEngagement3Btn');

  /**
   * Calculate the highest block index dynamically from the current engagement blocks
   * @returns {number} The next block index
   */
  function getNextEngagementIndex() {
    const allEngagements = engagementContainer.querySelectorAll('input[name="engagement_id_3[]"]');
    const indices = Array.from(allEngagements).map(input => {
      const value = input.value; // e.g., "st3eng1"
      const match = value.match(/st3eng(\d+)/); // Extract number after "st3eng"
      return match ? parseInt(match[1], 10) : 0; // Convert to integer or default to 0
    });

    // Return the next available block index
    return indices.length > 0 ? Math.max(...indices) + 1 : 1;
  }

  /**
   * Update the initial engagement block (engagementstagethree) to match the correct numbering dynamically
   */
  function updateInitialEngagementBlock() {
    const engagementTitle = document.getElementById('engagementstagethree');
    const engagementHiddenInput = document.getElementById('eng_3_id');

    if (engagementTitle && engagementHiddenInput) {
      const currentIndex = engagementHiddenInput.value.match(/st3eng(\d+)/)?.[1] || 1;

      // Ensure the title and hidden input value match
      engagementTitle.textContent = `Engagement ${currentIndex}`;
      engagementHiddenInput.value = `st3eng${currentIndex}`;
    } else {
      console.warn('Initial engagement block elements not found in the DOM.');
    }
  }

  // Run the initial update to synchronize the block index on page load
  updateInitialEngagementBlock();

  // "Add" button to clone a new engagement block
  addEngagementBtn.addEventListener('click', function (e) {
    e.preventDefault();

    // Get the next block index
    const nextBlockIndex = getNextEngagementIndex();

    const newEngagementBlock = document.createElement('div');
    newEngagementBlock.classList.add('engagementthree-block');
    newEngagementBlock.dataset.index = nextBlockIndex;

    const newEngagementId = `st3eng${nextBlockIndex}`;

    newEngagementBlock.innerHTML = `
        <p class="text-center text-white mb-1" style="font-style:'Poppins'; font-weight:bold;">
            Engagement ${nextBlockIndex}
        </p>
        <input type="hidden" name="engagement_id_3[]" value="${newEngagementId}">
        <div class="row mb-1">
            <div class="col-md-3">
                <label for="engagement" class="form-label text-white">Type of Engagement</label>
            </div>
            <div class="col-md-3">
                <label for="engagement" class="form-label text-white">Date</label>
            </div>
            <div class="col-md-4">
                <label for="engagement" class="form-label text-white">Remarks</label>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-3">
                <input name="engagement_three[]" type="text" class="form-control" placeholder="e.g. Sample Engagement">
            </div>
            <div class="col-md-3">
                <input name="engagement_date[]" type="date" class="form-control" style="font-size:10px;">
            </div>
            <div class="col-md-4">
                <input name="engagement_remarks_three[]" type="text" class="form-control" placeholder="e.g. Sample Remarks">
            </div>
            <div class="col-md-2">
            <button type="button"
                    class="btn btn-danger btn-sm removeEngagementThree"
                    style="width:100px; display:inline-flex; align-items:center; justify-content:center; font-size:12px;">
              <i class="fas fa-minus"></i>&nbsp;Remove
            </button>
          </div>
        </div>
    `;

    // Append the new block
    engagementContainer.appendChild(newEngagementBlock);

    console.log(`Added new block: Engagement ${nextBlockIndex}`);
  });

  // Delegate remove button functionality
  engagementContainer.addEventListener('click', function (e) {
    if (e.target.closest('.removeEngagementThree')) {
      e.preventDefault();
      const blockToRemove = e.target.closest('.engagementthree-block');
      if (blockToRemove) {
        blockToRemove.remove();
        console.log('Removed an engagement block.');
      }
    }
  });
});
