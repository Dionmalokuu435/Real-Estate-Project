// assets/details.js

function getIdFromUrl() {
  const params = new URLSearchParams(window.location.search);
  const id = params.get("id");
  return id ? Number(id) : null;
}

function formatMoney(value, note) {
  return `$${Number(value).toLocaleString()} / ${note}`;
}

document.addEventListener("DOMContentLoaded", () => {
  const id = getIdFromUrl();
  const data = window.PROPERTIES || [];
  const item = data.find((p) => p.id === id);

  const detailsCard = document.getElementById("detailsCard");
  const notFound = document.getElementById("notFound");

  if (!item) {
    notFound.style.display = "block";
    return;
  }

  detailsCard.style.display = "block";

  document.getElementById("img").src = item.image;
  document.getElementById("img").alt = item.title;
  document.getElementById("title").textContent = item.title;
  document.getElementById("location").textContent = item.location;
  document.getElementById("price").textContent = formatMoney(
    item.price,
    item.price_note
  );
  document.getElementById("description").textContent = item.description;

  const featuresEl = document.getElementById("features");
  featuresEl.innerHTML = item.features
    .map(
      (f) => `
      <div class="feat">
        <i class="fas ${f.icon}"></i>
        <div style="font-weight:900;margin-top:6px;">${f.value}</div>
        <div class="muted">${f.label}</div>
      </div>
    `
    )
    .join("");

  document.getElementById(
    "meta"
  ).textContent = `Type: ${item.type} • Badge: ${item.badge} • ID: ${item.id}`;
});
