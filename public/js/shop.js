document.addEventListener("DOMContentLoaded", () => {
    
    // =========================================
    // 1. INITIALIZE DATA (Connects to Seller Dashboard)
    // =========================================
    const defaultProducts = [
        { id: 1, category: "mobiles", name: "Ultra Smart Phone 14", price: 999.00, oldPrice: 1099.00, rating: 5, img: "https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?w=500&q=80", badge: "New", stock: 10 },
        { id: 2, category: "laptops", name: "ProBook Studio X", price: 1250.00, oldPrice: 1400.00, rating: 4, img: "https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=500&q=80", badge: "Sale", stock: 5 },
        { id: 3, category: "smartwatches", name: "Fitness Tracker Elite", price: 150.00, oldPrice: 150.00, rating: 3, img: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=500&q=80", badge: null, stock: 15 },
        { id: 13, category: "accessories_e", name: "Wireless Earbuds", price: 49.00, oldPrice: 89.00, rating: 5, img: "https://images.unsplash.com/photo-1572569028738-411a56103308?w=500&q=80", badge: "Hot", stock: 20 },
        { id: 4, category: "mens-wear", name: "Classic Leather Jacket", price: 120.00, oldPrice: 180.00, rating: 5, img: "https://images.unsplash.com/photo-1551028919-ac66e624ec95?w=500&q=80", badge: "Hot", stock: 8 },
        { id: 5, category: "womens-wear", name: "Summer Floral Dress", price: 45.00, oldPrice: 60.00, rating: 4, img: "https://images.unsplash.com/photo-1572804013309-59a88b7e92f1?w=500&q=80", badge: null, stock: 12 },
        { id: 6, category: "shoes", name: "Running Sneakers Air", price: 85.00, oldPrice: 85.00, rating: 4, img: "https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=500&q=80", badge: null, stock: 7 },
        { id: 7, category: "furniture", name: "Modern Lounge Chair", price: 350.00, oldPrice: 450.00, rating: 5, img: "https://images.unsplash.com/photo-1592078615290-033ee584e267?w=500&q=80", badge: null, stock: 3 },
        { id: 8, category: "decor", name: "Minimalist Ceramic Vase", price: 25.00, oldPrice: 25.00, rating: 3, img: "https://images.unsplash.com/photo-1578500494198-246f612d3b3d?w=500&q=80", badge: null, stock: 25 },
        { id: 9, category: "skincare", name: "Organic Aloe Serum", price: 30.00, oldPrice: 45.00, rating: 4, img: "https://images.unsplash.com/photo-1620916566398-39f1143ab7be?w=500&q=80", badge: "Organic", stock: 50 },
        { id: 10, category: "makeup", name: "Matte Lipstick Set", price: 55.00, oldPrice: 70.00, rating: 5, img: "https://images.unsplash.com/photo-1596462502278-27bfdd403348?w=500&q=80", badge: null, stock: 18 },
        { id: 11, category: "gym", name: "Adjustable Dumbbells", price: 80.00, oldPrice: 100.00, rating: 4, img: "https://images.unsplash.com/photo-1638536532686-d610adfc8e5c?w=500&q=80", badge: "Heavy", stock: 6 },
        { id: 12, category: "sportswear", name: "Dri-Fit Gym Tee", price: 25.00, oldPrice: 35.00, rating: 3, img: "https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=500&q=80", badge: null, stock: 30 }
    ];

    // Check LocalStorage. If empty, load default.
    if (!localStorage.getItem('siteProducts')) {
        localStorage.setItem('siteProducts', JSON.stringify(defaultProducts));
    }

    // Make products global so other scripts (product.js, home.js) can see it
    window.products = JSON.parse(localStorage.getItem('siteProducts'));

    // =========================================
    // 2. DOM ELEMENTS
    // =========================================
    const grid = document.getElementById('grid');
    const noResults = document.getElementById('noResults');
    const searchInput = document.getElementById('searchInput');
    const priceRange = document.getElementById('priceRange');
    const priceValue = document.getElementById('priceValue');
    const checkboxes = document.querySelectorAll('.category-checkbox');
    const radioRatings = document.querySelectorAll('input[name="rating"]');

    // =========================================
    // 3. RENDER FUNCTION
    // =========================================
    function renderProducts(data) {
        if(!grid) return;
        grid.innerHTML = "";
        const wishlist = JSON.parse(localStorage.getItem('myWishlist')) || [];

        if(data.length === 0) {
            grid.style.display = "none";
            if(noResults) noResults.style.display = "block";
            return;
        } else {
            grid.style.display = "grid";
            if(noResults) noResults.style.display = "none";
        }

        data.forEach(p => {
            const isLiked = wishlist.some(item => item.id === p.id);
            const heartClass = isLiked ? "fa-solid fa-heart" : "fa-regular fa-heart";
            const heartColor = isLiked ? "color:#ef4444" : "color:#888"; 

            let discountBadge = '';
            if (p.oldPrice > p.price) {
                const percent = Math.round(((p.oldPrice - p.price) / p.oldPrice) * 100);
                discountBadge = `<span class="badge-box" style="background:#d23f57">-${percent}%</span>`;
            } else if (p.badge) {
                discountBadge = `<span class="badge-box">${p.badge}</span>`;
            }

            const card = document.createElement('div');
            card.className = 'card';
            card.innerHTML = `
                ${discountBadge}
                <div class="wishlist-btn" onclick="toggleWishlist(${p.id})"><i class="${heartClass}" style="${heartColor}"></i></div>
                <a href="product.html?id=${p.id}">
                    <div class="card-img"><img src="${p.img}" alt="${p.name}"></div>
                    <div class="card-info">
                        <div class="category-tag">${p.category}</div>
                        <h4 class="product-name">${p.name}</h4>
                        <div class="rating-stars" style="color:#ffc107; font-size:0.8rem; margin-bottom:5px;">
                            ${'<i class="fa-solid fa-star"></i>'.repeat(Math.floor(p.rating || 4))}
                        </div>
                        <div class="price-wrap">
                            <span class="new-price">$${p.price.toFixed(2)}</span>
                            <span class="old-price">$${p.oldPrice.toFixed(2)}</span>
                        </div>
                    </div>
                </a>
            `;
            grid.appendChild(card);
        });
    }

    // =========================================
    // 4. FILTER LOGIC
    // =========================================
    function filterAll() {
        if(!grid) return;
        const term = searchInput ? searchInput.value.toLowerCase() : "";
        const selectedCats = Array.from(checkboxes).filter(c => c.checked).map(c => c.value); 
        const maxPrice = priceRange ? parseInt(priceRange.value) : 5000;
        const ratingEl = document.querySelector('input[name="rating"]:checked');
        const minRating = ratingEl ? parseInt(ratingEl.value) : 0;

        const params = new URLSearchParams(window.location.search);
        const isSaleMode = params.get('sale') === 'true';

        // Title Update
        const pageTitle = document.querySelector('.products-area h2'); 
        if(pageTitle) {
            if(isSaleMode) {
                pageTitle.innerHTML = '<i class="fa-solid fa-fire"></i> Hot Offers';
                pageTitle.style.color = "#d23f57";
            } else {
                pageTitle.innerText = "Shop All Products";
                pageTitle.style.color = "#333";
            }
        }

        const filtered = window.products.filter(p => {
            const matchSearch = p.name.toLowerCase().includes(term);
            const matchCat = selectedCats.length === 0 || selectedCats.includes(p.category);
            const matchPrice = p.price <= maxPrice;
            const matchRating = (p.rating || 0) >= minRating;
            const matchSale = isSaleMode ? (p.oldPrice > p.price) : true;
            return matchSearch && matchCat && matchPrice && matchRating && matchSale;
        });

        renderProducts(filtered);
    }

    // =========================================
    // 5. URL HANDLER
    // =========================================
    function loadFromURL() {
        const params = new URLSearchParams(window.location.search);
        // Category Groups Map
        const categoryGroups = {
            'electronics': ['mobiles', 'laptops', 'smartwatches', 'accessories_e', 'cameras'],
            'fashion':     ['mens-wear', 'womens-wear', 'shoes', 'bags', 'accessories'],
            'home':        ['furniture', 'kitchen', 'appliances', 'decor'],
            'beauty':      ['skincare', 'makeup', 'perfumes', 'hair-care'],
            'sports':      ['gym', 'sportswear', 'supplements', 'outdoor-gear']
        };

        if (params.has('search') && searchInput) searchInput.value = params.get('search');

        if (params.has('category')) {
            const catParam = params.get('category').toLowerCase();
            if (categoryGroups[catParam]) {
                const children = categoryGroups[catParam];
                checkboxes.forEach(box => {
                    if (children.includes(box.value.toLowerCase())) {
                        box.checked = true;
                        if(box.closest('details')) box.closest('details').open = true;
                    }
                });
            } else {
                checkboxes.forEach(box => {
                    if (box.value.toLowerCase() === catParam) {
                        box.checked = true;
                        if(box.closest('details')) box.closest('details').open = true;
                    }
                });
            }
        }
    }

    // --- Events ---
    if(searchInput) searchInput.addEventListener('input', filterAll);
    if(priceRange) {
        priceRange.addEventListener('input', (e) => {
            if(priceValue) priceValue.textContent = e.target.value;
            filterAll();
        });
    }
    checkboxes.forEach(box => box.addEventListener('change', filterAll));
    radioRatings.forEach(radio => radio.addEventListener('change', filterAll));

    loadFromURL();
    filterAll(); 
});

// Helper for Wishlist
function toggleWishlist(id) {
    let wishlist = JSON.parse(localStorage.getItem('myWishlist')) || [];
    const product = window.products.find(p => p.id === id);
    const index = wishlist.findIndex(p => p.id === id);
    
    if(index > -1) {
        wishlist.splice(index, 1);
        if(typeof showToast === 'function') showToast("Removed from Wishlist", false);
    } else {
        wishlist.push(product);
        if(typeof showToast === 'function') showToast("Added to Wishlist");
    }
    localStorage.setItem('myWishlist', JSON.stringify(wishlist));
    // Re-trigger filter to update heart icon immediately
    const searchInput = document.getElementById('searchInput');
    if(searchInput) searchInput.dispatchEvent(new Event('input'));
    if(typeof updateHeaderCounts === "function") updateHeaderCounts();
}