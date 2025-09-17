<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <?php wp_head(); ?>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>

<body <?php body_class(); ?>>

<!-- Header -->
<header class="custom-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo/Brand -->
            <a class="navbar-brand" href="<?php echo home_url(); ?>">
                <i class="fas fa-crown me-2"></i>Todo Tops
            </a>

            <!-- Mobile menu button -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo home_url(); ?>">
                            <i class="fas fa-home me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo get_permalink(wc_get_page_id('shop')); ?>">
                            <i class="fas fa-store me-1"></i>Tienda
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-tags me-1"></i>Categorías
                        </a>
                        <ul class="dropdown-menu">
                            <?php
                            $product_categories = get_terms('product_cat', array(
                                'orderby' => 'name',
                                'order' => 'ASC',
                                'hide_empty' => false,
                            ));

                            if (!empty($product_categories)) {
                                foreach ($product_categories as $category) {
                                    echo '<li><a class="dropdown-item" href="' . get_term_link($category) . '">' . $category->name . '</a></li>';
                                }
                            } else {
                                echo '<li><a class="dropdown-item" href="#">Ropa</a></li>';
                                echo '<li><a class="dropdown-item" href="#">Accesorios</a></li>';
                                echo '<li><a class="dropdown-item" href="#">Calzado</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo get_permalink(get_option('woocommerce_myaccount_page_id')); ?>">
                            <i class="fas fa-user me-1"></i>Mi Cuenta
                        </a>
                    </li>
                </ul>

                <!-- Cart and Search -->
                <ul class="navbar-nav">
                    <!-- Search -->
                    <li class="nav-item">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#searchModal">
                            <i class="fas fa-search"></i>
                        </a>
                    </li>

                    <!-- Cart -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="<?php echo wc_get_cart_url(); ?>">
                            <i class="fas fa-shopping-cart"></i>
                            <?php if (WC()->cart->get_cart_contents_count() > 0) : ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    <?php echo WC()->cart->get_cart_contents_count(); ?>
                                </span>
                            <?php endif; ?>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>

<!-- Search Modal -->
<div class="modal fade" id="searchModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buscar Productos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form role="search" method="get" action="<?php echo home_url('/'); ?>">
                    <div class="input-group">
                        <input type="search" class="form-control" placeholder="¿Qué estás buscando?" value="<?php echo get_search_query(); ?>" name="s">
                        <input type="hidden" name="post_type" value="product">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>