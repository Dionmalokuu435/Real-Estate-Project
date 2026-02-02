<?php
declare(strict_types=1);

require_once __DIR__ . '/../app/Http/AuthMiddleware.php';

AuthMiddleware::requireAdmin();

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$user = $_SESSION['user'] ?? [];
$name = (string) ($user['name'] ?? 'Admin');
$initials = '';
foreach (preg_split('/\s+/', trim($name)) as $part) {
    if ($part !== '') {
        $initials .= strtoupper($part[0]);
    }
}
$initials = $initials !== '' ? $initials : 'AD';
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>RealEstate Admin | Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="/Real-Estate-Project/public/assets/css/dashboard.css" />
</head>

<body>
    <aside class="sidebar" id="sidebar">
        <div class="logo">
            <i class="fas fa-home logo-icon"></i>
            <h1>RealEstate Admin</h1>
        </div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link active" data-section="dashboard">
                    <i class="fas fa-tachometer-alt nav-icon"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-section="properties">
                    <i class="fas fa-building nav-icon"></i>
                    <span>Properties</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-section="add-property">
                    <i class="fas fa-plus-circle nav-icon"></i>
                    <span>Add Property</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-section="users">
                    <i class="fas fa-users nav-icon"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link" data-section="favorites">
                    <i class="fas fa-heart nav-icon"></i>
                    <span>Favorites</span>
                </a>
            </li>
        </ul>

        <div class="logout">
            <a href="/Real-Estate-Project/public/logout.php" class="nav-link">
                <i class="fas fa-sign-out-alt nav-icon"></i>
                <span>Logout</span>
            </a>
        </div>
    </aside>

    <main class="main-content">
        <header class="topbar">
            <button class="menu-toggle" id="menuToggle">
                <i class="fas fa-bars"></i>
            </button>
            <div class="page-title" id="pageTitle">Dashboard Overview</div>
            <div class="user-info">
                <div class="user-avatar"><?= htmlspecialchars($initials) ?></div>
                <span><?= htmlspecialchars($name) ?></span>
            </div>
        </header>

        <section class="content">
            <div id="dashboard" class="content-section">
                <div class="cards-container">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Total Properties</h3>
                            <div class="card-icon"
                                style="background-color: rgba(58, 134, 255, 0.1); color: var(--primary);">
                                <i class="fas fa-building"></i>
                            </div>
                        </div>
                        <div class="card-value" id="statTotalProperties">0</div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Active Properties</h3>
                            <div class="card-icon"
                                style="background-color: rgba(40, 167, 69, 0.1); color: var(--success);">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                        <div class="card-value" id="statActiveProperties">0</div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Registered Users</h3>
                            <div class="card-icon"
                                style="background-color: rgba(255, 159, 28, 0.1); color: var(--warning);">
                                <i class="fas fa-users"></i>
                            </div>
                        </div>
                        <div class="card-value" id="statUsers">0</div>
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Favorites Count</h3>
                            <div class="card-icon"
                                style="background-color: rgba(230, 57, 70, 0.1); color: var(--danger);">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                        <div class="card-value" id="statFavorites">0</div>
                    </div>
                </div>

                <div class="table-container">
                    <div class="table-header">
                        <h2 class="section-title">Recent Properties</h2>
                        <button class="btn btn-primary" onclick="showSection('properties')">
                            <i class="fas fa-eye"></i> View All
                        </button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Property</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="recentPropertiesBody">
                            <tr>
                                <td colspan="6">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="properties" class="content-section hidden">
                <div class="table-container">
                    <div class="table-header">
                        <h2 class="section-title">Properties Management</h2>
                        <button class="btn btn-primary" onclick="showSection('add-property')">
                            <i class="fas fa-plus"></i> Add New Property
                        </button>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Type</th>
                                <th>Location</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="propertiesBody">
                            <tr>
                                <td colspan="7">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="add-property" class="content-section hidden">
                <div class="form-container">
                    <h2 class="section-title mb-4" id="propertyFormTitle">Add New Property</h2>

                    <form id="propertyForm">
                        <input type="hidden" id="propertyId" />
                        <input type="hidden" id="badge" />

                        <div class="form-row">
                            <div class="form-group">
                                <label for="title">Property Title *</label>
                                <input type="text" id="title" class="form-control" placeholder="Enter property title"
                                    required />
                            </div>

                            <div class="form-group">
                                <label for="type">Property Type *</label>
                                <select id="type" class="form-control" required>
                                    <option value="">Select type</option>
                                    <option value="house">House</option>
                                    <option value="apartment">Apartment</option>
                                    <option value="land">Land</option>
                                    <option value="commercial">Commercial</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="location">Location *</label>
                                <input type="text" id="location" class="form-control"
                                    placeholder="Enter property location" required />
                            </div>

                            <div class="form-group">
                                <label for="price">Price *</label>
                                <input type="number" id="price" class="form-control" placeholder="Enter price"
                                    required />
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="priceNote">Price Note</label>
                                <input type="text" id="priceNote" class="form-control"
                                    placeholder="e.g., negotiable, per month" />
                            </div>

                            <div class="form-group">
                                <label for="status">Status *</label>
                                <select id="status" class="form-control" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="description">Description *</label>
                            <textarea id="description" class="form-control" placeholder="Enter property description"
                                rows="4" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Property Features</label>
                            <div class="features-container">
                                <div id="featuresList">
                                    <div class="feature-row">
                                        <input type="text" class="form-control"
                                            placeholder="Feature label (e.g., Bedrooms)" />
                                        <input type="text" class="form-control" placeholder="Feature value (e.g., 3)" />
                                        <button type="button" class="btn btn-danger" onclick="removeFeatureRow(this)">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                                <button type="button" class="btn btn-outline mt-4" onclick="addFeatureRow()">
                                    <i class="fas fa-plus"></i> Add Feature
                                </button>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Media Upload</label>
                            <div class="upload-area" id="uploadArea">
                                <div class="upload-icon">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                </div>
                                <h3>Drag & Drop Images Here</h3>
                                <p>or click to browse</p>
                                <input type="file" id="imageUpload" multiple style="display: none" />
                            </div>
                            <div class="mt-4">
                                <label>
                                    <input type="checkbox" id="markPrimary" /> Mark first image as primary
                                </label>
                            </div>
                            <div class="mt-4">
                                <label>Upload PDF Brochure (Optional)</label>
                                <input type="file" id="brochureUpload" class="form-control" accept=".pdf" />
                            </div>
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-primary" style="padding: 12px 40px">
                                <i class="fas fa-save"></i> Save Property
                            </button>
                            <button type="button" class="btn btn-outline" onclick="showSection('properties')"
                                style="padding: 12px 40px">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="users" class="content-section hidden">
                <div class="table-container">
                    <div class="table-header">
                        <h2 class="section-title">Users Management</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="usersBody">
                            <tr>
                                <td colspan="5">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="favorites" class="content-section hidden">
                <div class="table-container">
                    <div class="table-header">
                        <h2 class="section-title">Favorites Overview</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Favorited Property</th>
                                <th>Date Added</th>
                            </tr>
                        </thead>
                        <tbody id="favoritesBody">
                            <tr>
                                <td colspan="3">Loading...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <script src="/Real-Estate-Project/public/assets/js/dashboard.js"></script>
</body>

</html>