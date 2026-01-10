// assets/app.js

function getUrlType() {
  const params = new URLSearchParams(window.location.search);
  //   console.log("params:", params);
  //   console.log("window.location.search:", window.location.search);
  const type = params.get("type"); // house | apartment | land | null
  return type;
}

function setActiveFilterButton(filter) {
  document.querySelectorAll(".filter-btn").forEach((btn) => {
    btn.classList.toggle("active", btn.dataset.filter === filter);
  });
}

function updateSubtitle(filter) {
  const el = document.getElementById("pageSubtitle");
  const label =
    filter === "house"
      ? "Showing: Houses"
      : filter === "apartment"
      ? "Showing: Apartments"
      : filter === "land"
      ? "Showing: Lands"
      : "Showing: All Properties";

  el.textContent = label;
}

function formatMoney(value, note) {
  return `$${Number(value).toLocaleString()} <span>/ ${note}</span>`;
}

function renderCards(items) {
  const container = document.getElementById("cardsContainer");
  const noProps = document.getElementById("noProperties");

  container.innerHTML = "";

  if (!items.length) {
    noProps.style.display = "block";
    return;
  }
  noProps.style.display = "none";

  container.innerHTML = items
    .map((p) => {
      const featuresHtml = p.features
        .slice(0, 4)
        .map(
          (f) => `
          <div class="feature">
            <i class="fas ${f.icon}"></i>
            <div class="feature-value">${f.value}</div>
            <div class="feature-label">${f.label}</div>
          </div>
        `
        )
        .join("");

      return `
      <div class="card" data-type="${p.type}">
        <div class="img-container">
          <span class="card-badge">${p.badge}</span>
          <img src="${p.image}" alt="${p.title}" class="card-img" />
        </div>

        <div class="card-content">
          <h3 class="card-title">${p.title}</h3>
          <p class="card-location">
            <i class="fas fa-map-marker-alt"></i> ${p.location}
          </p>
          <p class="card-description">${p.description}</p>

          <div class="card-features">${featuresHtml}</div>

          <div class="card-footer">
            <div class="price">${formatMoney(p.price, p.price_note)}</div>
            <button class="card-btn" data-id="${p.id}">
              <i class="fas fa-eye"></i> View Details
            </button>
          </div>
        </div>
      </div>
    `;
    })
    .join("");

  container.querySelectorAll(".card-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const id = btn.dataset.id;
      window.location.href = `details.html?id=${encodeURIComponent(id)}`;
    });
  });
}

function applyFilter(filter) {
  const all = window.PROPERTIES || [];
  console.log("window.PROPERTIES:", window.PROPERTIES);
  console.log("all:", all);
  const filtered =
    filter === "all" ? all : all.filter((p) => p.type === filter);

  console.log("filtered:", filtered);

  setActiveFilterButton(filter);
  updateSubtitle(filter);
  renderCards(filtered);
}

document.addEventListener("DOMContentLoaded", () => {
  const urlType = getUrlType();
  console.log("urlType:", urlType);
  const initialFilter = urlType || "all";

  applyFilter(initialFilter);

  document.querySelectorAll(".filter-btn").forEach((btn) => {
    btn.addEventListener("click", () => {
      const filter = btn.dataset.filter;

      const url = new URL(window.location.href);
      if (filter === "all") url.searchParams.delete("type");
      else url.searchParams.set("type", filter);
      window.history.replaceState({}, "", url);

      applyFilter(filter);
    });
  });
});
