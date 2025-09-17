<?php get_header(); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="hero-title">¡Bienvenido a Todo Tops!</h1>
                <p class="hero-subtitle">La mejor tienda virtual con productos de calidad premium</p>
                <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-custom">
                    Explorar Productos
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="features-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shipping-fast"></i>
                    </div>
                    <h3 class="feature-title">Envío Rápido</h3>
                    <p>Entregamos tus productos en tiempo récord. Envío gratis en compras superiores a $50.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <h3 class="feature-title">Compra Segura</h3>
                    <p>Tus datos están protegidos con la mejor tecnología de seguridad disponible.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h3 class="feature-title">Calidad Premium</h3>
                    <p>Productos seleccionados cuidadosamente para garantizar la mejor calidad.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Productos Destacados -->
<section class="products-section">
    <div class="container">
        <h2 class="section-title">Productos Destacados</h2>
        <div class="row">
            <?php
            // Mostrar productos destacados de WooCommerce
            $featured_products = wc_get_featured_product_ids();

            if (!empty($featured_products)) {
                $args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 6,
                    'post__in' => $featured_products,
                    'orderby' => 'post__in'
                );

                $featured_query = new WP_Query($args);

                if ($featured_query->have_posts()) {
                    while ($featured_query->have_posts()) {
                        $featured_query->the_post();
                        global $product;
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="product-card">
                                <div class="product-image">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium', array('class' => 'img-fluid')); ?>
                                    <?php else : ?>
                                        <i class="fas fa-image"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="product-info">
                                    <h4 class="product-title"><?php the_title(); ?></h4>
                                    <div class="product-price">
                                        <?php echo $product->get_price_html(); ?>
                                    </div>
                                    <a href="<?php echo esc_url(add_query_arg('add-to-cart', $product->get_id(), wc_get_cart_url())); ?>"
                                       class="btn btn-add-cart">
                                        Agregar al Carrito
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                    wp_reset_postdata();
                } else {
                    // Productos de ejemplo si no hay productos destacados
                    for ($i = 1; $i <= 6; $i++) {
                        ?>
                        <div class="col-md-4 mb-4">
                            <div class="product-card">
                                <div class="product-image">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <div class="product-info">
                                    <h4 class="product-title">Producto Ejemplo <?php echo $i; ?></h4>
                                    <div class="product-price">$<?php echo rand(15, 99); ?>.99</div>
                                    <button class="btn btn-add-cart">Agregar al Carrito</button>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            } else {
                // Productos de ejemplo si no hay productos destacados
                for ($i = 1; $i <= 6; $i++) {
                    ?>
                    <div class="col-md-4 mb-4">
                        <div class="product-card">
                            <div class="product-image">
                                <i class="fas fa-tshirt"></i>
                            </div>
                            <div class="product-info">
                                <h4 class="product-title">Producto Todo Tops <?php echo $i; ?></h4>
                                <div class="product-price">$<?php echo rand(15, 99); ?>.99</div>
                                <button class="btn btn-add-cart">Agregar al Carrito</button>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-custom">
                Ver Todos los Productos
            </a>
        </div>
    </div>
</section>

<!-- Newsletter Section -->
<section style="background: var(--light-gray); padding: 60px 0;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3 text-center">
                <h3 style="color: var(--dark-gray); margin-bottom: 1rem;">¡Mantente Actualizado!</h3>
                <p style="margin-bottom: 2rem;">Recibe las mejores ofertas y productos nuevos directamente en tu email.</p>
                <form class="d-flex">
                    <input type="email" class="form-control me-2" placeholder="Tu email" style="border-radius: 25px;">
                    <button type="submit" class="btn btn-custom" style="white-space: nowrap;">Suscribirse</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>