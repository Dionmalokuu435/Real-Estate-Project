const API_URL = "/Real-Estate-Project/public/admin_api.php";

const navLinks = document.querySelectorAll(".nav-link[data-section]");
const contentSections = document.querySelectorAll(".content-section");
const pageTitle = document.getElementById("pageTitle");

const statTotal = document.getElementById("statTotalProperties");
const statActive = document.getElementById("statActiveProperties");
const statUsers = document.getElementById("statUsers");
const statFavorites = document.getElementById("statFavorites");

const recentBody = document.getElementById("recentPropertiesBody");
const propertiesBody = document.getElementById("propertiesBody");
const usersBody = document.getElementById("usersBody");
const favoritesBody = document.getElementById("favoritesBody");

const propertyForm = document.getElementById("propertyForm");
const propertyFormTitle = document.getElementById("propertyFormTitle");
const propertyIdInput = document.getElementById("propertyId");
const badgeInput = document.getElementById("badge");

const uploadArea = document.getElementById("uploadArea");
const fileInput = document.getElementById("imageUpload");

const sectionTitles = {
  dashboard: "Dashboard Overview",
  properties: "Properties Management",
  "add-property": "Add New Property",
  users: "Users Management",
  favorites: "Favorites Overview",
};

function apiGet(action, params = {}) {
  const url = new URL(API_URL, window.location.origin);
  url.searchParams.set("action", action);
  Object.entries(params).forEach(([k, v]) => url.searchParams.set(k, v));
  return fetch(url.toString(), { credentials: "same-origin" }).then((r) =>
    r.json(),
  );
}

function apiPost(action, body) {
  const isFormData = body instanceof FormData;
  return fetch(API_URL, {
    method: "POST",
    credentials: "same-origin",
    headers: isFormData ? undefined : { "Content-Type": "application/json" },
    body: isFormData ? body : JSON.stringify({ action, ...body }),
  }).then((r) => r.json());
}

function showSection(sectionId) {
  contentSections.forEach((section) => section.classList.add("hidden"));
  const active = document.getElementById(sectionId);
  if (active) active.classList.remove("hidden");

  pageTitle.textContent = sectionTitles[sectionId] || "Dashboard";

  navLinks.forEach((link) => {
    link.classList.remove("active");
    if (link.getAttribute("data-section") === sectionId) {
      link.classList.add("active");
    }
  });

  if (window.innerWidth <= 992) {
    document.getElementById("sidebar").classList.remove("active");
  }
}

function mediaUrl(path) {
  if (!path) return "";
  if (/^https?:\/\//i.test(path)) return path;
  return "/Real-Estate-Project/public/" + String(path).replace(/^\/+/, "");
}

function formatPrice(value) {
  if (!value && value !== 0) return "";
  const num = Number(value);
  if (Number.isNaN(num)) return value;
  return "$" + num.toLocaleString();
}

function statusBadge(status) {
  const cls =
    status === "active" ? "status status-active" : "status status-inactive";
  const label = status === "active" ? "Active" : "Inactive";
  return `<span class="${cls}">${label}</span>`;
}

function iconForLabel(label) {
  const v = String(label || "").toLowerCase();
  if (v.includes("bed")) return "fa-bed";
  if (v.includes("bath")) return "fa-bath";
  if (
    v.includes("area") ||
    v.includes("m sq") ||
    v.includes("m²") ||
    v.includes("sqm")
  )
    return "fa-ruler-combined";
  if (v.includes("garage") || v.includes("parking")) return "fa-car";
  if (v.includes("elevator")) return "fa-elevator";
  if (v.includes("acres")) return "fa-vector-square";
  if (v.includes("water")) return "fa-tint";
  if (v.includes("electric")) return "fa-bolt";
  if (v.includes("road") || v.includes("access")) return "fa-road";
  if (v.includes("pool")) return "fa-swimming-pool";
  if (v.includes("wifi")) return "fa-wifi";
  return "fa-circle";
}

async function loadStats() {
  const res = await apiGet("stats");
  if (!res.ok) return;
  statTotal.textContent = res.stats.total_properties;
  statActive.textContent = res.stats.active_properties;
  statUsers.textContent = res.stats.users;
  statFavorites.textContent = res.stats.favorites;
}

async function loadRecent() {
  const res = await apiGet("recent_properties");
  if (!res.ok) return;
  if (!res.items.length) {
    recentBody.innerHTML = `<tr><td colspan="6">No properties found.</td></tr>`;
    return;
  }
  recentBody.innerHTML = res.items
    .map((p) => {
      return `
        <tr>
          <td>
            <div style="display:flex; align-items:center; gap:12px;">
              ${p.primary_image ? `<img class="thumbnail" src="${mediaUrl(p.primary_image)}" alt="" />` : `<div class="thumbnail"></div>`}
              <span>${p.title}</span>
            </div>
          </td>
          <td>${p.type}</td>
          <td>${p.location}</td>
          <td>${formatPrice(p.price)}${p.price_note ? " / " + p.price_note : ""}</td>
          <td>${statusBadge(p.status)}</td>
          <td class="actions">
            <button class="btn btn-sm btn-outline" data-edit-id="${p.id}">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger" data-delete-id="${p.id}">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      `;
    })
    .join("");
  attachPropertyActions();
}

async function loadProperties() {
  const res = await apiGet("properties");
  if (!res.ok) return;
  if (!res.items.length) {
    propertiesBody.innerHTML = `<tr><td colspan="7">No properties found.</td></tr>`;
    return;
  }
  propertiesBody.innerHTML = res.items
    .map((p) => {
      return `
        <tr>
          <td>${p.primary_image ? `<img class="thumbnail" src="${mediaUrl(p.primary_image)}" alt="" />` : `<div class="thumbnail"></div>`}</td>
          <td>${p.title}</td>
          <td>${p.type}</td>
          <td>${p.location}</td>
          <td>${formatPrice(p.price)}${p.price_note ? " / " + p.price_note : ""}</td>
          <td>${statusBadge(p.status)}</td>
          <td class="actions">
            <button class="btn btn-sm btn-outline" data-edit-id="${p.id}">
              <i class="fas fa-edit"></i>
            </button>
            <button class="btn btn-sm btn-danger" data-delete-id="${p.id}">
              <i class="fas fa-trash"></i>
            </button>
          </td>
        </tr>
      `;
    })
    .join("");
  attachPropertyActions();
}

async function loadUsers() {
  const res = await apiGet("users");
  if (!res.ok) return;
  if (!res.items.length) {
    usersBody.innerHTML = `<tr><td colspan="5">No users found.</td></tr>`;
    return;
  }
  usersBody.innerHTML = res.items
    .map((u) => {
      const roleClass = u.role === "admin" ? "status status-user" : "status";
      const active = String(u.is_active) === "1";
      return `
        <tr>
          <td>${u.name}</td>
          <td>${u.email}</td>
          <td><span class="${roleClass}">${u.role}</span></td>
          <td>${active ? `<span class="status status-active">Active</span>` : `<span class="status status-inactive">Inactive</span>`}</td>
          <td class="actions">
            <button class="btn btn-sm btn-outline" data-role-id="${u.id}" data-role="${u.role}">
              Change Role
            </button>
            <button class="btn btn-sm ${active ? "btn-danger" : "btn-success"}" data-active-id="${u.id}" data-active="${active ? 0 : 1}">
              ${active ? "Deactivate" : "Activate"}
            </button>
          </td>
        </tr>
      `;
    })
    .join("");
  attachUserActions();
}

async function loadFavorites() {
  const res = await apiGet("favorites");
  if (!res.ok) return;
  if (!res.items.length) {
    favoritesBody.innerHTML = `<tr><td colspan="3">No favorites found.</td></tr>`;
    return;
  }
  favoritesBody.innerHTML = res.items
    .map((f) => {
      return `
        <tr>
          <td>${f.user_name} (${f.user_email})</td>
          <td>${f.property_title}</td>
          <td>${f.created_at}</td>
        </tr>
      `;
    })
    .join("");
}

function attachPropertyActions() {
  document.querySelectorAll("[data-edit-id]").forEach((btn) => {
    btn.addEventListener("click", async () => {
      const id = Number(btn.dataset.editId);
      const res = await apiGet("property", { id });
      if (!res.ok) {
        alert(res.error || "Failed to load property");
        return;
      }
      fillPropertyForm(res.property, res.features || []);
      showSection("add-property");
    });
  });

  document.querySelectorAll("[data-delete-id]").forEach((btn) => {
    btn.addEventListener("click", async () => {
      const id = Number(btn.dataset.deleteId);
      if (!confirm("Delete this property?")) return;
      const form = new FormData();
      form.append("action", "delete_property");
      form.append("id", String(id));
      const res = await apiPost("delete_property", form);
      if (!res.ok) {
        alert(res.error || "Delete failed");
        return;
      }
      await loadRecent();
      await loadProperties();
      await loadStats();
    });
  });
}

function attachUserActions() {
  document.querySelectorAll("[data-role-id]").forEach((btn) => {
    btn.addEventListener("click", async () => {
      const id = Number(btn.dataset.roleId);
      const current = btn.dataset.role;
      const next = current === "admin" ? "user" : "admin";
      if (!confirm(`Change role to ${next}?`)) return;
      const form = new FormData();
      form.append("action", "update_user_role");
      form.append("id", String(id));
      form.append("role", next);
      const res = await apiPost("update_user_role", form);
      if (!res.ok) {
        alert(res.error || "Update failed");
        return;
      }
      await loadUsers();
    });
  });

  document.querySelectorAll("[data-active-id]").forEach((btn) => {
    btn.addEventListener("click", async () => {
      const id = Number(btn.dataset.activeId);
      const nextActive = Number(btn.dataset.active) === 1;
      const form = new FormData();
      form.append("action", "set_user_active");
      form.append("id", String(id));
      form.append("active", nextActive ? "1" : "0");
      const res = await apiPost("set_user_active", form);
      if (!res.ok) {
        alert(res.error || "Update failed");
        return;
      }
      await loadUsers();
    });
  });
}

function resetPropertyForm() {
  propertyForm.reset();
  propertyIdInput.value = "";
  badgeInput.value = "";
  propertyFormTitle.textContent = "Add New Property";
  const list = document.getElementById("featuresList");
  list.innerHTML = `
    <div class="feature-row">
      <input type="text" class="form-control" placeholder="Feature label (e.g., Bedrooms)" />
      <input type="text" class="form-control" placeholder="Feature value (e.g., 3)" />
      <button type="button" class="btn btn-danger" onclick="removeFeatureRow(this)">
        <i class="fas fa-times"></i>
      </button>
    </div>
  `;
  uploadArea.innerHTML = `
    <div class="upload-icon">
      <i class="fas fa-cloud-upload-alt"></i>
    </div>
    <h3>Drag & Drop Images Here</h3>
    <p>or click to browse</p>
    <input type="file" id="imageUpload" multiple style="display: none" />
  `;
}

function fillPropertyForm(property, features) {
  propertyIdInput.value = property.id;
  badgeInput.value = property.badge || "";
  document.getElementById("title").value = property.title || "";
  document.getElementById("type").value = property.type || "";
  document.getElementById("location").value = property.location || "";
  document.getElementById("price").value = property.price || "";
  document.getElementById("priceNote").value = property.price_note || "";
  document.getElementById("status").value = property.status || "active";
  document.getElementById("description").value = property.description || "";
  propertyFormTitle.textContent = "Edit Property";

  const list = document.getElementById("featuresList");
  list.innerHTML = "";
  if (features.length) {
    features.forEach((f) => {
      list.innerHTML += `
        <div class="feature-row">
          <input type="text" class="form-control" placeholder="Feature label (e.g., Bedrooms)" value="${f.label || ""}" />
          <input type="text" class="form-control" placeholder="Feature value (e.g., 3)" value="${f.value || ""}" />
          <button type="button" class="btn btn-danger" onclick="removeFeatureRow(this)">
            <i class="fas fa-times"></i>
          </button>
        </div>
      `;
    });
  } else {
    list.innerHTML = `
      <div class="feature-row">
        <input type="text" class="form-control" placeholder="Feature label (e.g., Bedrooms)" />
        <input type="text" class="form-control" placeholder="Feature value (e.g., 3)" />
        <button type="button" class="btn btn-danger" onclick="removeFeatureRow(this)">
          <i class="fas fa-times"></i>
        </button>
      </div>
    `;
  }
}

function collectFeatures() {
  const rows = Array.from(
    document.querySelectorAll("#featuresList .feature-row"),
  );
  return rows
    .map((row) => {
      const inputs = row.querySelectorAll("input");
      const label = (inputs[0]?.value || "").trim();
      const value = (inputs[1]?.value || "").trim();
      if (!label || !value) return null;
      return { label, value, icon: iconForLabel(label) };
    })
    .filter(Boolean);
}

document.getElementById("menuToggle").addEventListener("click", function () {
  document.getElementById("sidebar").classList.toggle("active");
});

navLinks.forEach((link) => {
  link.addEventListener("click", function (e) {
    e.preventDefault();
    const sectionId = this.getAttribute("data-section");
    if (sectionId === "add-property") resetPropertyForm();
    showSection(sectionId);
  });
});

propertyForm.addEventListener("submit", async (e) => {
  e.preventDefault();
  const formData = new FormData();
  formData.append("action", "save_property");
  const id = propertyIdInput.value.trim();
  if (id) formData.append("id", id);

  formData.append("title", document.getElementById("title").value.trim());
  formData.append("type", document.getElementById("type").value);
  formData.append("location", document.getElementById("location").value.trim());
  formData.append("price", document.getElementById("price").value);
  formData.append(
    "price_note",
    document.getElementById("priceNote").value.trim(),
  );
  formData.append("status", document.getElementById("status").value);
  formData.append(
    "description",
    document.getElementById("description").value.trim(),
  );
  formData.append("badge", badgeInput.value || "");

  const markPrimary = document.getElementById("markPrimary").checked
    ? "1"
    : "0";
  formData.append("mark_primary", markPrimary);

  const features = collectFeatures();
  formData.append("features", JSON.stringify(features));

  const images = document.getElementById("imageUpload").files;
  if (images && images.length) {
    Array.from(images).forEach((f) => formData.append("images[]", f));
  }
  const brochure = document.getElementById("brochureUpload").files[0];
  if (brochure) {
    formData.append("brochure", brochure);
  }

  const res = await apiPost("save_property", formData);
  if (!res.ok) {
    alert(res.error || "Save failed");
    return;
  }

  await loadRecent();
  await loadProperties();
  await loadStats();
  showSection("properties");
});

uploadArea.addEventListener("click", function () {
  const input = document.getElementById("imageUpload");
  if (input) input.click();
});

uploadArea.addEventListener("dragover", function (e) {
  e.preventDefault();
  this.style.borderColor = "var(--primary)";
  this.style.backgroundColor = "rgba(58, 134, 255, 0.05)";
});

uploadArea.addEventListener("dragleave", function () {
  this.style.borderColor = "#ddd";
  this.style.backgroundColor = "";
});

uploadArea.addEventListener("drop", function (e) {
  e.preventDefault();
  this.style.borderColor = "#ddd";
  this.style.backgroundColor = "";

  const input = document.getElementById("imageUpload");
  if (e.dataTransfer.files.length > 0 && input) {
    input.files = e.dataTransfer.files;
    uploadArea.innerHTML = `
      <div class="upload-icon" style="color: var(--success);">
        <i class="fas fa-check-circle"></i>
      </div>
      <h3>${e.dataTransfer.files.length} file(s) selected</h3>
      <p>Click to change selection</p>
      <input type="file" id="imageUpload" multiple style="display: none" />
    `;
  }
});

document.addEventListener("change", function (e) {
  if (e.target && e.target.id === "imageUpload") {
    const files = e.target.files || [];
    if (files.length > 0) {
      uploadArea.innerHTML = `
        <div class="upload-icon" style="color: var(--success);">
          <i class="fas fa-check-circle"></i>
        </div>
        <h3>${files.length} file(s) selected</h3>
        <p>Click to change selection</p>
        <input type="file" id="imageUpload" multiple style="display: none" />
      `;
    }
  }
});

function addFeatureRow() {
  const featuresList = document.getElementById("featuresList");
  const newRow = document.createElement("div");
  newRow.className = "feature-row";
  newRow.innerHTML = `
    <input type="text" class="form-control" placeholder="Feature label (e.g., Bedrooms)">
    <input type="text" class="form-control" placeholder="Feature value (e.g., 3)">
    <button type="button" class="btn btn-danger" onclick="removeFeatureRow(this)"><i class="fas fa-times"></i></button>
  `;
  featuresList.appendChild(newRow);
}

function removeFeatureRow(button) {
  const row = button.parentElement;
  if (document.querySelectorAll(".feature-row").length > 1) {
    row.remove();
  }
}

window.showSection = showSection;
window.addFeatureRow = addFeatureRow;
window.removeFeatureRow = removeFeatureRow;

async function init() {
  await loadStats();
  await loadRecent();
  await loadProperties();
  await loadUsers();
  await loadFavorites();
}

init();
