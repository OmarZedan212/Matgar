@extends('layouts.app')
@section('title', __('My Account'))

@section('style')
<style> 
        /* =========================================
    1. VARIABLES & RESET
    ========================================= */
    :root {
    --primary: #2563eb; /* Professional Blue */
    --primary-dark: #1e40af;
    --secondary: #64748b; /* Slate Gray */
    --success: #10b981; /* Green */
    --warning: #f59e0b; /* Orange/Yellow */
    --danger: #ef4444; /* Red */
    --surface: #ffffff; /* White Background */
    --bg-body: #f8fafc; /* Light Grey Background */
    --border: #e2e8f0;
    --text-main: #1e293b;
    --text-muted: #64748b;
    --sidebar-width: 260px;
    --radius: 8px;
    --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    body {
        font-family: var(--font-main);
        background-color: var(--light-bg);
        color: #333;
    }
    a {
    text-decoration: none;
    color: inherit;
    transition: 0.2s;
    }
    ul {
    list-style: none;
    }

    /* =========================================
    2. MAIN LAYOUT
    ========================================= */
    .main-container {
    max-width: 1400px;
    margin: 30px auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: var(--sidebar-width) 1fr;
    gap: 30px;
    align-items: start;
    }

    /* --- SIDEBAR --- */
    aside.sidebar {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    position: sticky;
    top: 20px;
    box-shadow: var(--shadow);
    overflow: hidden;
    }

    .user-profile-summary {
    padding: 25px 20px;
    border-bottom: 1px solid var(--border);
    display: flex;
    align-items: center;
    gap: 15px;
    background: #f1f5f9;
    }
    .profile-img {
    width: 50px;
    height: 50px;
    background: var(--text-main);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    }
    .profile-info h3 {
    font-size: 1rem;
    margin: 0;
    }
    .user-role {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 600;
    text-transform: uppercase;
    }

    /* Navigation */
    .nav-menu {
    padding: 20px;
    }
    .nav-label {
    font-size: 0.7rem;
    font-weight: 700;
    text-transform: uppercase;
    color: #94a3b8;
    margin: 15px 0 8px 10px;
    }
    .nav-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    color: var(--text-muted);
    font-size: 0.9rem;
    font-weight: 500;
    border-radius: var(--radius);
    margin-bottom: 5px;
    cursor: pointer;
    }
    .nav-item:hover {
    background-color: #f1f5f9;
    color: var(--primary);
    }
    .nav-item.active {
    background-color: #eff6ff;
    color: var(--primary);
    font-weight: 600;
    }
    .nav-item.logout {
    color: var(--danger);
    margin-top: 20px;
    border-top: 1px dashed var(--border);
    }
    .nav-item.logout:hover {
    background: #fef2f2;
    }

    /* --- CONTENT --- */
    .content-wrapper {
    width: 100%;
    }
    .tab-pane {
    display: none;
    animation: fadeUp 0.3s ease;
    }
    .tab-pane.active {
    display: block;
    }
    @keyframes fadeUp {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
    }

    .content-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    }
    .content-header h2 {
    font-size: 1.5rem;
    color: var(--text-main);
    }

    /* =========================================
    3. COMPONENTS
    ========================================= */
    /* Stats Cards */
    .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
    gap: 20px;
    margin-bottom: 30px;
    }
    .stat-card {
    background: var(--surface);
    padding: 25px;
    border-radius: var(--radius);
    border: 1px solid var(--border);
    box-shadow: var(--shadow);
    display: flex;
    align-items: center;
    gap: 20px;
    }
    .icon-bg {
    width: 55px;
    height: 55px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    }
    .icon-bg.blue {
    background: #eff6ff;
    color: var(--primary);
    }
    .icon-bg.orange {
    background: #fff7ed;
    color: var(--warning);
    }
    .icon-bg.green {
    background: #f0fdf4;
    color: var(--success);
    }
    .stat-card h4 {
    font-size: 0.85rem;
    color: var(--text-muted);
    margin-bottom: 5px;
    }
    .stat-num {
    font-size: 1.5rem;
    font-weight: 700;
    }

    /* Tables */
    .table-container {
    background: var(--surface);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    overflow-x: auto;
    box-shadow: var(--shadow);
    }
    .pro-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
    }
    .pro-table th {
    text-align: left;
    padding: 15px 20px;
    background: #f8fafc;
    color: var(--text-muted);
    font-size: 0.75rem;
    text-transform: uppercase;
    border-bottom: 1px solid var(--border);
    }
    .pro-table td {
    padding: 15px 20px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 0.9rem;
    vertical-align: middle;
    }

    .badge {
    padding: 4px 10px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    }
    .badge.success {
    background: #ecfdf5;
    color: #059669;
    }
    .badge.warning {
    background: #fffbeb;
    color: #d97706;
    }
    .badge.danger {
    background: #fef2f2;
    color: #dc2626;
    }

    /* Forms & Inputs */
    .form-card {
    background: var(--surface);
    padding: 30px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow);
    }
    .row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 20px;
    }
    .input-group {
    margin-bottom: 20px;
    }
    .input-group label {
    display: block;
    margin-bottom: 8px;
    font-size: 0.9rem;
    font-weight: 600;
    }
    input,
    select,
    textarea {
    width: 100%;
    padding: 10px;
    border: 1px solid var(--border);
    border-radius: var(--radius);
    outline: none;
    }
    input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .btn-primary {
    background: var(--primary);
    color: white;
    padding: 10px 25px;
    border-radius: var(--radius);
    border: none;
    cursor: pointer;
    }
    .btn-secondary {
    background: white;
    border: 1px solid var(--border);
    padding: 10px 25px;
    border-radius: var(--radius);
    cursor: pointer;
    }
    .btn-xs {
    padding: 5px 10px;
    border-radius: 4px;
    border: 1px solid var(--border);
    background: white;
    cursor: pointer;
    }

    /* =========================================
    4. ACCOUNT SPECIFIC (Wallet & Address)
    ========================================= */
    /* Address Card */
    .address-card {
    background: var(--surface);
    border: 1px solid var(--border);
    padding: 20px;
    border-radius: var(--radius);
    position: relative;
    transition: 0.2s;
    }
    .address-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow);
    }
    .address-card h4 {
    font-size: 1rem;
    margin-bottom: 5px;
    }
    .address-card p {
    font-size: 0.85rem;
    color: var(--text-muted);
    line-height: 1.4;
    }
    .card-actions {
    margin-top: 15px;
    padding-top: 15px;
    border-top: 1px dashed var(--border);
    display: flex;
    gap: 15px;
    font-size: 0.85rem;
    }
    .card-actions a {
    font-weight: 600;
    color: var(--primary);
    cursor: pointer;
    }

    /* Wallet Banner */
    .wallet-banner {
    background: linear-gradient(135deg, #1e40af, #3b82f6);
    color: white;
    padding: 30px;
    border-radius: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 10px 20px rgba(37, 99, 235, 0.2);
    margin-bottom: 30px;
    }
    .balance-info h1 {
    font-size: 2.5rem;
    margin: 0;
    }
    .card-chip {
    font-size: 2rem;
    opacity: 0.5;
    transform: rotate(90deg);
    }

    /* =========================================
    5. MODALS & TOASTS
    ========================================= */
    .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
    }
    .modal-overlay.open {
    display: flex;
    animation: fadeIn 0.2s ease;
    }
    .modal-box {
    background: white;
    width: 500px;
    padding: 30px;
    border-radius: 10px;
    }
    .modal-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
    border-bottom: 1px solid #eee;
    padding-bottom: 10px;
    }
    .close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    }

    .toast-notification {
    position: fixed;
    bottom: -100px;
    left: 50%;
    transform: translateX(-50%);
    background: #1e293b;
    color: white;
    padding: 12px 25px;
    border-radius: 50px;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 10px;
    z-index: 10000;
    transition: bottom 0.4s ease;
    }
    .toast-notification.show {
    bottom: 30px;
    }
    .toast-notification.success {
    background: var(--success);
    }

</style> 
@endsection

@section('content')
    <!-- 2. MAIN LAYOUT -->
    <div class="main-container">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="user-profile-summary">
                <div class="profile-img">JD</div>
                <div class="profile-info">
                    <h3>John Doe</h3>
                    <span class="user-role">Member</span>
                </div>
            </div>

            <nav class="nav-menu">
                <p class="nav-label">My Account</p>
                <a href="#" class="nav-item active" onclick="showTab('dashboard', this)">
                    <i class="fa-solid fa-chart-line"></i> Dashboard
                </a>
                <a href="#" class="nav-item" onclick="showTab('orders', this)">
                    <i class="fa-solid fa-box"></i> My Orders
                </a>
                <!-- Wallet Link Removed Here -->

                <p class="nav-label">Settings</p>
                <a href="#" class="nav-item" onclick="showTab('addresses', this)">
                    <i class="fa-solid fa-map-location-dot"></i> Addresses
                </a>
                <a href="#" class="nav-item" onclick="showTab('profile', this)">
                    <i class="fa-solid fa-user-gear"></i> Edit Profile
                </a>
                <a href="#" class="nav-item logout" onclick="logout()">
                    <i class="fa-solid fa-power-off"></i> Log Out
                </a>
            </nav>
        </aside>

        <!-- CONTENT AREA -->
        <main class="content-wrapper">

            <!-- TAB 1: DASHBOARD -->
            <div id="dashboard" class="tab-pane active">
                <header class="content-header">
                    <h2>Account Overview</h2>
                </header>

                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="icon-bg blue"><i class="fa-solid fa-basket-shopping"></i></div>
                        <div><h4>Total Orders</h4><span class="stat-num">124</span></div>
                    </div>
                    <div class="stat-card">
                        <div class="icon-bg orange"><i class="fa-solid fa-clock"></i></div>
                        <div><h4>Pending</h4><span class="stat-num">3</span></div>
                    </div>
                    <!-- Wallet Stat Card Removed Here -->
                    <div class="stat-card">
                        <div class="icon-bg green"><i class="fa-solid fa-check-circle"></i></div>
                        <div><h4>Completed</h4><span class="stat-num">118</span></div>
                    </div>
                </div>

                <div class="table-container">
                    <h3 style="padding:20px; border-bottom:1px solid #eee; margin:0;">Recent Orders</h3>
                    <table class="pro-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Status</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Order 1 -->
                            <tr>
                                <td><strong>#ORD-7782</strong></td>
                                <td>Oct 24, 2025</td>
                                <td>Wireless Headset...</td>
                                <td><span class="badge success">Delivered</span></td>
                                <td>$150.00</td>
                                <td style="display:flex; gap:5px;">
                                    <button class="btn-xs" onclick="viewOrder('#ORD-7782')" title="View Invoice"><i class="fa-solid fa-eye"></i></button>
                                    <button class="btn-xs" onclick="goToTrack('#ORD-7782')" title="Track Order"><i class="fa-solid fa-truck-fast"></i></button>
                                </td>
                            </tr>
                            <!-- Order 2 -->
                            <tr>
                                <td><strong>#ORD-7783</strong></td>
                                <td>Oct 26, 2025</td>
                                <td>Smart Watch...</td>
                                <td><span class="badge warning">Processing</span></td>
                                <td>$45.50</td>
                                <td style="display:flex; gap:5px;">
                                    <button class="btn-xs" onclick="viewOrder('#ORD-7783')" title="View Invoice"><i class="fa-solid fa-eye"></i></button>
                                    <button class="btn-xs" onclick="goToTrack('#ORD-7783')" title="Track Order"><i class="fa-solid fa-truck-fast"></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 2: ORDERS -->
            <div id="orders" class="tab-pane">
                <header class="content-header">
                    <h2>Order History</h2>
                    <div style="display:flex; gap:10px;">
                        <input type="text" placeholder="Search Order ID..." class="search-sm">
                        <select class="search-sm" onchange="renderOrders()">
                            <option value="all">All</option>
                            <option value="Pending">Pending</option>
                            <option value="Delivered">Delivered</option>
                        </select>
                    </div>
                </header>
                <div class="table-container">
                    <table class="pro-table">
                        <thead>
                            <tr><th>Order ID</th><th>Date</th><th>Total</th><th>Status</th><th>Action</th></tr>
                        </thead>
                        <tbody id="ordersTableBody">
                            <!-- JS Fills this -->
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- TAB 3: WALLET REMOVED -->

            <!-- TAB 4: ADDRESSES -->
            <div id="addresses" class="tab-pane">
                <header class="content-header">
                    <h2>Saved Addresses</h2>
                    <button class="btn-primary" onclick="openAddressModal()">+ Add New Address</button>
                </header>

                <div id="addressGrid" class="stats-grid" style="grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));">
                    <!-- JS Fills this -->
                </div>
            </div>

            <!-- TAB 5: PROFILE -->
            <div id="profile" class="tab-pane">
                <header class="content-header"><h2>Edit Profile</h2></header>
                <div class="form-card">
                    <form id="profileForm">
                        <div class="row">
                            <div class="input-group"><label>First Name</label><input type="text" value="John"></div>
                            <div class="input-group"><label>Last Name</label><input type="text" value="Doe"></div>
                        </div>
                        <div class="input-group"><label>Email</label><input type="email" value="john.doe@example.com"></div>
                        <div class="input-group"><label>Phone</label><input type="tel" value="+1 234 567 890"></div>
                        <div class="form-actions">
                            <button type="submit" class="btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <!-- ADDRESS MODAL -->
    <div id="address-modal" class="modal-overlay">
        <div class="modal-box">
            <header class="modal-header">
                <h3>Add New Address</h3>
                <button class="close-modal" onclick="closeAddressModal()">&times;</button>
            </header>
            <form id="addressForm">
                <input type="hidden" id="editAddressId">
                <div class="input-group">
                    <label>Label (e.g. Home)</label>
                    <input type="text" id="addrTitle" required placeholder="Home, Office...">
                </div>
                <div class="input-group">
                    <label>Full Address</label>
                    <textarea id="addrText" rows="3" required placeholder="Street, City, Country"></textarea>
                </div>
                <div class="input-group">
                    <label>Phone Number</label>
                    <input type="tel" id="addrPhone" required placeholder="+1 234...">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-secondary" onclick="closeAddressModal()">Cancel</button>
                    <button type="submit" class="btn-primary">Save Address</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
<script>
        document.addEventListener("DOMContentLoaded", function() {

        // =========================================
        // 1. INTERNAL HELPER: TOAST
        // =========================================
        function showAccountToast(message, isSuccess = true) {
            let toast = document.getElementById('toast-notification');
            if (!toast) {
                toast = document.createElement('div');
                toast.id = 'toast-notification';
                toast.className = 'toast-notification';
                document.body.appendChild(toast);
            }
            toast.innerHTML = isSuccess
                ? `<i class="fa-solid fa-check-circle"></i> ${message}`
                : `<i class="fa-solid fa-circle-exclamation"></i> ${message}`;

            if (isSuccess) {
                toast.classList.add('success');
                toast.style.backgroundColor = "#10b981";
            } else {
                toast.classList.remove('success');
                toast.style.backgroundColor = "#ef4444";
            }
            toast.classList.add('show');
            setTimeout(() => { toast.classList.remove('show'); }, 3000);
        }

        // =========================================
        // 2. DATA SOURCES
        // =========================================
        const ordersData = [
            { id: "#ORD-7782", date: "Nov 22, 2025", total: 150.00, status: "Delivered" },
            { id: "#ORD-7783", date: "Nov 25, 2025", total: 45.50, status: "Processing" },
            { id: "#ORD-7784", date: "Oct 10, 2025", total: 0.00, status: "Cancelled" }
        ];

        let addresses = JSON.parse(localStorage.getItem('userAddresses')) || [
            { id: 1, title: "Home", text: "123 Main St, New York, NY", phone: "+1 234 567 890" },
            { id: 2, title: "Office", text: "456 Market St, San Francisco, CA", phone: "+1 987 654 321" }
        ];

        // =========================================
        // 3. RENDER FUNCTIONS
        // =========================================

        window.renderOrders = function() {
            const tbody = document.getElementById('ordersTableBody');
            const searchInput = document.querySelector('#orders input.search-sm');
            const statusSelect = document.querySelector('#orders select.search-sm');
            if(!tbody) return;
            tbody.innerHTML = "";

            const searchTerm = searchInput ? searchInput.value.toLowerCase() : "";
            const filterStatus = statusSelect ? statusSelect.value : "all";

            ordersData.forEach(order => {
                if (filterStatus !== "all" && order.status !== filterStatus) return;
                if (searchTerm && !order.id.toLowerCase().includes(searchTerm)) return;

                let badgeColor = 'warning';
                if (order.status === 'Delivered') badgeColor = 'success';
                if (order.status === 'Cancelled') badgeColor = 'danger';

                tbody.innerHTML += `
                    <tr>
                        <td><strong>${order.id}</strong></td>
                        <td>${order.date}</td>
                        <td>$${order.total.toFixed(2)}</td>
                        <td><span class="badge ${badgeColor}">${order.status}</span></td>
                        <td style="display:flex; gap:5px;">
                            <button class="btn-xs" onclick="viewOrder('${order.id}')" title="View Invoice">
                                <i class="fa-solid fa-eye"></i> View
                            </button>
                            <button class="btn-xs" onclick="goToTrack('${order.id}')" title="Track Order">
                                <i class="fa-solid fa-truck-fast"></i> Track
                            </button>
                        </td>
                    </tr>
                `;
            });
        };

        window.renderAddresses = function() {
            const grid = document.getElementById('addressGrid');
            if(!grid) return;
            grid.innerHTML = "";

            addresses.forEach(addr => {
                grid.innerHTML += `
                    <div class="address-card">
                        <h4>${addr.title}</h4>
                        <p>${addr.text}</p>
                        <p style="margin-top:5px; color:#666;"><i class="fa-solid fa-phone"></i> ${addr.phone}</p>
                        <div class="card-actions">
                            <a href="#" onclick="editAddress(${addr.id})"><i class="fa-solid fa-pen"></i> Edit</a>
                            <a href="#" style="color:#ef4444" onclick="deleteAddress(${addr.id})"><i class="fa-solid fa-trash"></i> Delete</a>
                        </div>
                    </div>
                `;
            });
        };

        renderOrders();
        renderAddresses();

        const orderSearchInput = document.querySelector('#orders input.search-sm');
        if(orderSearchInput) orderSearchInput.addEventListener('keyup', renderOrders);

        // =========================================
        // 4. ACTION FUNCTIONS
        // =========================================

        // View Order (Invoice)
        window.viewOrder = function(orderId) {
            window.location.href = `order-details.html?id=${encodeURIComponent(orderId)}`;
        };

        // Track Order
        window.goToTrack = function(orderId) {
            window.location.href = `track.html?id=${encodeURIComponent(orderId)}`;
        };

        // =========================================
        // 5. ADDRESS LOGIC
        // =========================================

        const addrForm = document.getElementById('addressForm');
        const addrModal = document.getElementById('address-modal');
        const editIdInput = document.getElementById('editAddressId');
        const modalTitle = document.querySelector('#address-modal .modal-header h3');

        if(addrForm) {
            addrForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const title = document.getElementById('addrTitle').value;
                const text = document.getElementById('addrText').value;
                const phone = document.getElementById('addrPhone').value;
                const editId = editIdInput.value;

                if (editId) {
                    const addr = addresses.find(a => a.id == editId);
                    if(addr) { addr.title = title; addr.text = text; addr.phone = phone; }
                    showAccountToast("Address Updated Successfully!");
                } else {
                    addresses.push({ id: Date.now(), title, text, phone });
                    showAccountToast("New Address Added!");
                }

                localStorage.setItem('userAddresses', JSON.stringify(addresses));
                renderAddresses();
                closeAddressModal();
            });
        }

        window.openAddressModal = function() {
            if(addrForm) addrForm.reset();
            if(editIdInput) editIdInput.value = "";
            if(modalTitle) modalTitle.innerText = "Add New Address";
            addrModal.classList.add('open');
        };

        window.closeAddressModal = function() { addrModal.classList.remove('open'); };

        window.editAddress = function(id) {
            const addr = addresses.find(a => a.id === id);
            if(!addr) return;
            document.getElementById('addrTitle').value = addr.title;
            document.getElementById('addrText').value = addr.text;
            document.getElementById('addrPhone').value = addr.phone;
            editIdInput.value = id;
            if(modalTitle) modalTitle.innerText = "Edit Address";
            addrModal.classList.add('open');
        };

        window.deleteAddress = function(id) {
            if(confirm("Delete this address?")) {
                addresses = addresses.filter(a => a.id !== id);
                localStorage.setItem('userAddresses', JSON.stringify(addresses));
                renderAddresses();
                showAccountToast("Address Deleted", false);
            }
        };

        // =========================================
        // 6. PROFILE & TABS
        // =========================================

        const profileForm = document.getElementById('profileForm');
        if(profileForm) {
            profileForm.addEventListener('submit', (e) => {
                e.preventDefault();
                const btn = profileForm.querySelector('button');
                const original = btn.innerText;
                btn.innerText = "Saving...";
                setTimeout(() => {
                    btn.innerText = original;
                    showAccountToast("Profile Updated Successfully!", true);
                }, 800);
            });
        }

        window.showTab = function(tabId, link) {
            document.querySelectorAll('.tab-pane').forEach(t => t.classList.remove('active'));
            document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            link.classList.add('active');
        };

        window.logout = function() {
            if(confirm("Log out?")) window.location.href = "login.html";
        };
    });

</script>
@endsection