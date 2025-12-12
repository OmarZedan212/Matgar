/* =========================================
   1. GLOBAL HEADER COUNTS (Cart & Wishlist)
   Used by shop.js and product.js to update UI
   ========================================= */
function updateHeaderCounts() {
    // Read from LocalStorage
    const cart = JSON.parse(localStorage.getItem("myCart")) || [];
    const wishlist = JSON.parse(localStorage.getItem("myWishlist")) || [];

    // Get Elements
    const cartEl = document.getElementById("cartCount");
    const wishEl = document.getElementById("wishlistCount");

    // Update Cart Badge
    if (cartEl) {
        cartEl.innerText = cart.length;
        // Show badge only if count > 0
        cartEl.style.display = cart.length > 0 ? "flex" : "none";
    }

    // Update Wishlist Badge
    if (wishEl) {
        wishEl.innerText = wishlist.length;
        wishEl.style.display = wishlist.length > 0 ? "flex" : "none";
    }
}

/* =========================================
   2. EVENT LISTENERS (Search & Newsletter)
   ========================================= */
document.addEventListener("DOMContentLoaded", () => {
    // A. Initialize Counts on Load
    updateHeaderCounts();

    // --- B. SEARCH LOGIC ---
    const searchInput = document.querySelector(".search-box input");
    const searchBtn = document.querySelector(".search-box button");
    const categorySelect = document.querySelector(".search-cat"); // Optional dropdown

    function performSearch() {
        if (!searchInput) return;

        const query = searchInput.value.trim();
        const category = categorySelect ? categorySelect.value : "all";

        // Validation: Empty Search
        if (query === "") {
            searchInput.style.border = "2px solid #ff4757";
            const originalPlaceholder = searchInput.placeholder;
            searchInput.placeholder = "Please enter a product...";

            setTimeout(() => {
                searchInput.style.border = "1px solid #dae1e7"; // Reset to default gray
                searchInput.placeholder = originalPlaceholder;
            }, 2000);
            return;
        }

        // Redirect Logic
        // We always reload/redirect to shop.html with parameters
        // This ensures filters reset and new search applies
        const targetPage = "shop.html";
        const url = `${targetPage}?search=${encodeURIComponent(
            query
        )}&category=${encodeURIComponent(category)}`;
        window.location.href = url;
    }

    // Click Listener
    if (searchBtn) {
        searchBtn.addEventListener("click", (e) => {
            e.preventDefault();
            performSearch();
        });
    }

    // "Enter" Key Listener
    if (searchInput) {
        searchInput.addEventListener("keypress", (e) => {
            if (e.key === "Enter") {
                e.preventDefault(); // Stop form submit
                performSearch();
            }
        });

        // Remove red border when user starts typing
        searchInput.addEventListener("input", () => {
            searchInput.style.border = "1px solid #dae1e7";
        });
    }

    // --- C. NEWSLETTER SUBSCRIPTION (With Toast) ---
    const newsletterForm = document.getElementById("newsletterForm");

    if (newsletterForm) {
        newsletterForm.addEventListener("submit", (e) => {
            e.preventDefault();
            const emailInput = newsletterForm.querySelector("input");
            const email = emailInput ? emailInput.value : "User";

            if (email) {
                // 1. Get the toast element
                const toast = document.getElementById("toast-notification");

                // 2. Set content and style
                toast.innerHTML = `<i class="fa-solid fa-check-circle"></i> Success! ${email} subscribed.`;
                toast.classList.add("success"); // Makes it green

                // 3. Trigger Animation (Slide Up)
                toast.classList.add("show");

                // 4. Clear Input
                newsletterForm.reset();

                // 5. Hide after 3 seconds (Slide Down)
                setTimeout(() => {
                    toast.classList.remove("show");
                }, 3000);
            }
        });
    }
}); // End of DOMContentLoaded
document.addEventListener("DOMContentLoaded", () => {
    /* =========================================
       DROPDOWN LOGIC (Mobile & Active State)
       ========================================= */

    // 1. MOBILE: Click to Toggle Submenus
    // We detect if the screen is small (tablet/mobile)
    const isMobile = window.matchMedia("(max-width: 992px)").matches;

    if (isMobile) {
        const submenuToggles = document.querySelectorAll(
            ".dropdown-submenu > a"
        );

        submenuToggles.forEach((toggle) => {
            toggle.addEventListener("click", (e) => {
                // Prevent the link from jumping to the page immediately
                e.preventDefault();
                e.stopPropagation();

                // Find the submenu (the <ul> immediately after the <a>)
                const submenu = toggle.nextElementSibling;

                // Toggle display
                if (submenu.style.display === "block") {
                    submenu.style.display = "none";
                } else {
                    // Close other open menus first (optional, keeps it clean)
                    document
                        .querySelectorAll(".submenu")
                        .forEach((m) => (m.style.display = "none"));
                    submenu.style.display = "block";
                }
            });
        });
    }

    // 2. ACTIVE STATE: Highlight the current category
    const currentUrl = window.location.href;
    const menuLinks = document.querySelectorAll(".dropdown-menu a");

    menuLinks.forEach((link) => {
        // Check if the link href matches the current browser URL
        if (
            link.href === currentUrl ||
            currentUrl.includes(link.getAttribute("href"))
        ) {
            // Add active class to the sub-item (e.g., "Mobiles")
            link.classList.add("active-nav-item");

            // Also highlight the parent category (e.g., "Electronics")
            const parentItem = link.closest(".dropdown-submenu");
            if (parentItem) {
                const parentLink = parentItem.querySelector(".dropdown-item");
                if (parentLink) parentLink.classList.add("active-nav-parent");
            }
        }
    });
});
