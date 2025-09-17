<!-- Footer -->
<footer class="custom-footer">
    <div class="container">
        <div class="row">
            <!-- Información de la empresa -->
            <div class="col-md-4 footer-section">
                <h5><i class="fas fa-crown me-2"></i>Todo Tops</h5>
                <p>Tu tienda virtual de confianza con los mejores productos de calidad premium. Comprometidos con la excelencia en cada compra.</p>
                <div class="d-flex">
                    <a href="#" class="text-light me-3"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="#" class="text-light me-3"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>

            <!-- Enlaces rápidos -->
            <div class="col-md-2 footer-section">
                <h5>Enlaces</h5>
                <ul>
                    <li><a href="<?php echo home_url(); ?>">Inicio</a></li>
                    <li><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">Tienda</a></li>
                    <li><a href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">Mi Cuenta</a></li>
                    <li><a href="<?php echo wc_get_cart_url(); ?>">Carrito</a></li>
                </ul>
            </div>

            <!-- Categorías -->
            <div class="col-md-2 footer-section">
                <h5>Categorías</h5>
                <ul>
                    <?php
                    $product_categories = get_terms('product_cat', array(
                        'orderby' => 'name',
                        'order' => 'ASC',
                        'hide_empty' => false,
                        'number' => 4
                    ));

                    if (!empty($product_categories)) {
                        foreach ($product_categories as $category) {
                            echo '<li><a href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
                        }
                    } else {
                        echo '<li><a href="#">Ropa</a></li>';
                        echo '<li><a href="#">Accesorios</a></li>';
                        echo '<li><a href="#">Calzado</a></li>';
                        echo '<li><a href="#">Ofertas</a></li>';
                    }
                    ?>
                </ul>
            </div>

            <!-- Información de contacto -->
            <div class="col-md-4 footer-section">
                <h5>Contacto</h5>
                <ul>
                    <li><i class="fas fa-envelope me-2"></i>info@todotops.com</li>
                    <li><i class="fas fa-phone me-2"></i>+1 (555) 123-4567</li>
                    <li><i class="fas fa-map-marker-alt me-2"></i>123 Calle Principal, Ciudad</li>
                    <li><i class="fas fa-clock me-2"></i>Lun-Vie: 9am-6pm</li>
                </ul>

                <!-- Métodos de pago -->
                <div class="mt-3">
                    <h6>Métodos de Pago</h6>
                    <div class="d-flex">
                        <i class="fab fa-cc-visa fa-2x me-2 text-light"></i>
                        <i class="fab fa-cc-mastercard fa-2x me-2 text-light"></i>
                        <i class="fab fa-cc-paypal fa-2x me-2 text-light"></i>
                        <i class="fab fa-cc-amex fa-2x text-light"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <div class="footer-bottom">
            <div class="row">
                <div class="col-md-6">
                    <p>&copy; <?php echo date('Y'); ?> Todo Tops. Todos los derechos reservados.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <a href="#" class="text-light me-3">Política de Privacidad</a>
                    <a href="#" class="text-light me-3">Términos de Servicio</a>
                    <a href="#" class="text-light">Devoluciones</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Botón de WhatsApp flotante -->
<div class="whatsapp-float">
    <a href="https://wa.me/1234567890" target="_blank" style="
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: #25d366;
        color: white;
        border-radius: 50px;
        padding: 15px;
        font-size: 24px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.3);
        z-index: 1000;
        transition: all 0.3s ease;
    " onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

<!-- Scroll to top button -->
<button onclick="topFunction()" id="scrollToTop" style="
    display: none;
    position: fixed;
    bottom: 80px;
    right: 20px;
    z-index: 99;
    border: none;
    outline: none;
    background-color: var(--primary-color);
    color: white;
    cursor: pointer;
    padding: 15px;
    border-radius: 50%;
    font-size: 18px;
    transition: all 0.3s ease;
">
    <i class="fas fa-arrow-up"></i>
</button>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script>
// Scroll to top functionality
window.onscroll = function() {scrollFunction()};

function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("scrollToTop").style.display = "block";
    } else {
        document.getElementById("scrollToTop").style.display = "none";
    }
}

function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}

// Add animation to cards on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Observe all cards
document.addEventListener('DOMContentLoaded', function() {
    const cards = document.querySelectorAll('.feature-card, .product-card');
    cards.forEach(card => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(card);
    });
});

// Cart counter update (if using AJAX)
function updateCartCount() {
    // This would be implemented with AJAX to update cart count dynamically
    console.log('Cart updated');
}
</script>

<?php wp_footer(); ?>

</body>
</html>