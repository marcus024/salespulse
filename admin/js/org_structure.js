
document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector(".org-container");

  const organizationData = {
    director: {
      name: "Alex Johnson",
      position: "Director",
      gender: "male",
    },
    units: [
      {
        head: { name: "Taylor Smith", position: "Unit Head", gender: "female" },
        members: [
          { name: "Chris Lee", position: "Team Member", gender: "male" },
          { name: "Jamie Garcia", position: "Team Member", gender: "female" },
        ],
      },
      {
        head: { name: "Jordan Brown", position: "Unit Head", gender: "male" },
        members: [
          { name: "Morgan White", position: "Team Member", gender: "female" },
          { name: "Drew Black", position: "Team Member", gender: "male" },
        ],
      },
    ],
  };

  function renderProfile(person, type = "profile") {
    const imgSrc = person.gender === "male" ? "../images/man.png" : "../images/woman.png";
    const profileUrl = `/profile/${person.name.replace(/\s+/g, '-').toLowerCase()}`;
    return `
      <a href="${profileUrl}" class="${type}" style="text-decoration: none; color: inherit;">
      <div style="display: inline-block; margin: 10px; text-align: center;">
        <img src="${imgSrc}" alt="${person.name}" style="width: 80px; height: 80px; border-radius: 50%; border: 2px solid #007bff;">
        <div class="profile-name">${person.name}</div>
        <div class="profile-position">${person.position}</div>
      </div>
    </a>
    `;
  }

  function renderOrgStructure(data) {
    let html = "";

    // Render Director
    html += `<div class="profile director" style="margin-right: 50px;">${renderProfile(data.director, "director")}</div>`;

    // Render Units Horizontally
    data.units.forEach((unit, index) => {
      html += `
        <div class="unit" style="text-align: center; flex: none;">
          <div class="profile unit-head" style="margin-bottom: 20px;">
            ${renderProfile(unit.head, "unit-head")}
          </div>
          <div class="members" style="display: flex; justify-content: center; gap: 10px;">
            ${unit.members.map((member) => renderProfile(member, "member")).join("")}
          </div>
        </div>
      `;

      // Add connecting lines
      html += `<svg class="line-svg" width="100" height="50" xmlns="http://www.w3.org/2000/svg" style="margin-top: -20px;">
        <line x1="50" y1="0" x2="50" y2="50" style="stroke:#007bff;stroke-width:2" />
      </svg>`;
    });

    container.innerHTML = html;
  }

  renderOrgStructure(organizationData);
});
