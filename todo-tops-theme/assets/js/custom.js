/**
 * Custom JavaScript for Todo Tops Theme
 */

jQuery(document).ready(function($) {

    // Smooth scrolling for anchor links
    $('a[href*="#"]').on('click', function(e) {
        e.preventDefault();

        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top - 100
        }, 500, 'linear');
    });

    // Add to cart via AJAX
    $('.btn-add-cart').on('click', function(e) {
        e.preventDefault();

        var $button = $(this);
        var product_id = $button.data('product-id');
        var quantity = $button.data('quantity') || 1;

        // Show loading state
        $button.html('<i class="fas fa-spinner fa-spin"></i> Agregando...');
        $button.prop('disabled', true);

        $.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            data: {
                action: 'add_to_cart',
                product_id: product_id,
                quantity: quantity,
                nonce: ajax_object.nonce
            },
            success: function(response) {
                if (response.success) {
                    // Update cart count
                    $('.cart-count').text(response.data.cart_count);

                    // Show success message
                    $button.html('<i class="fas fa-check"></i> ¡Agregado!');
                    $button.removeClass('btn-add-cart').addClass('btn-success');

                    // Reset button after 2 seconds
                    setTimeout(function() {
                        $button.html('Agregar al Carrito');
                        $button.removeClass('btn-success').addClass('btn-add-cart');
                        $button.prop('disabled', false);
                    }, 2000);

                    // Show toast notification
                    showToast('Producto agregado al carrito', 'success');
                } else {
                    $button.html('Error');
                    $button.prop('disabled', false);
                    showToast('Error al agregar producto', 'error');
                }
            },
            error: function() {
                $button.html('Error');
                $button.prop('disabled', false);
                showToast('Error de conexión', 'error');
            }
        });
    });

    // Product image hover effect
    $('.product-card').hover(
        function() {
            $(this).find('.product-image').addClass('hover-effect');
        },
        function() {
            $(this).find('.product-image').removeClass('hover-effect');
        }
    );

    // Newsletter subscription
    $('#newsletter-form').on('submit', function(e) {
        e.preventDefault();

        var email = $(this).find('input[type="email"]').val();

        if (validateEmail(email)) {
            // Simulate subscription (replace with actual implementation)
            showToast('¡Gracias por suscribirte!', 'success');
            $(this).find('input[type="email"]').val('');
        } else {
            showToast('Por favor ingresa un email válido', 'error');
        }
    });

    // Quantity selector
    $('.quantity-selector').on('click', '.qty-btn', function() {
        var $input = $(this).siblings('.qty-input');
        var currentVal = parseInt($input.val());
        var min = parseInt($input.attr('min')) || 1;
        var max = parseInt($input.attr('max')) || 999;

        if ($(this).hasClass('qty-plus')) {
            if (currentVal < max) {
                $input.val(currentVal + 1);
            }
        } else {
            if (currentVal > min) {
                $input.val(currentVal - 1);
            }
        }

        $input.trigger('change');
    });

    // Product filter (for shop page)
    $('.filter-btn').on('click', function() {
        var filter = $(this).data('filter');
        var $products = $('.product-card');

        if (filter === 'all') {
            $products.show();
        } else {
            $products.hide();
            $products.filter('[data-category="' + filter + '"]').show();
        }

        // Update active filter button
        $('.filter-btn').removeClass('active');
        $(this).addClass('active');
    });

    // Back to top button
    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('#scrollToTop').fadeIn();
        } else {
            $('#scrollToTop').fadeOut();
        }
    });

    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Search functionality
    $('#search-input').on('input', function() {
        var searchTerm = $(this).val().toLowerCase();

        if (searchTerm.length > 2) {
            // Perform search (implement with AJAX for live search)
            performSearch(searchTerm);
        }
    });

});

/**
 * Utility Functions
 */

// Show toast notification
function showToast(message, type = 'info') {
    var toastClass = type === 'success' ? 'bg-success' :
                    type === 'error' ? 'bg-danger' : 'bg-info';

    var toast = $(`
        <div class="toast align-items-center text-white ${toastClass} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `);

    $('#toast-container').append(toast);

    var bsToast = new bootstrap.Toast(toast[0]);
    bsToast.show();

    // Remove toast after it's hidden
    toast.on('hidden.bs.toast', function() {
        $(this).remove();
    });
}

// Validate email
function validateEmail(email) {
    var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// Format price
function formatPrice(price) {
    return '$' + parseFloat(price).toFixed(2);
}

// Perform search
function performSearch(searchTerm) {
    // This would typically make an AJAX call to search products
    console.log('Searching for: ' + searchTerm);

    // Example implementation:
    $.ajax({
        type: 'GET',
        url: ajax_object.ajax_url,
        data: {
            action: 'search_products',
            search: searchTerm,
            nonce: ajax_object.nonce
        },
        success: function(response) {
            if (response.success) {
                // Update search results
                displaySearchResults(response.data);
            }
        }
    });
}

// Display search results
function displaySearchResults(results) {
    var $resultsContainer = $('#search-results');
    $resultsContainer.empty();

    if (results.length > 0) {
        results.forEach(function(product) {
            var resultHtml = `
                <div class="search-result-item">
                    <a href="${product.url}">
                        <img src="${product.image}" alt="${product.title}" class="search-result-image">
                        <div class="search-result-content">
                            <h6>${product.title}</h6>
                            <span class="price">${product.price}</span>
                        </div>
                    </a>
                </div>
            `;
            $resultsContainer.append(resultHtml);
        });
    } else {
        $resultsContainer.html('<p>No se encontraron productos.</p>');
    }
}

// Animation on scroll
function animateOnScroll() {
    const elements = document.querySelectorAll('.animate-on-scroll');

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animated');
            }
        });
    }, { threshold: 0.1 });

    elements.forEach(element => {
        observer.observe(element);
    });
}

// Initialize animations when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    animateOnScroll();

    // Create toast container if it doesn't exist
    if (!document.getElementById('toast-container')) {
        const toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        toastContainer.style.zIndex = '1050';
        document.body.appendChild(toastContainer);
    }
});