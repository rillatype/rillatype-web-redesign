<?php
defined('ABSPATH') || exit;

global $product;

if (empty($product)) return;

// Safe check for free product (WC_Product_Variable doesn't have is_free())
$is_free = false;
if ($product instanceof WC_Product) {
  $price = $product->get_price();
  $is_free = ($price !== '' && (float) $price <= 0);
}

$categories    = strip_tags(wc_get_product_category_list($product->get_id()));
$is_on_sale    = $product->is_on_sale();
$badge_text    = $is_free ? 'Free' : ($is_on_sale ? 'Sale' : '');
?>
<div <?php wc_product_class('anim-card', $product); ?>>
  <a href="<?php the_permalink(); ?>" class="product-card">
    <div class="product-card__image">
      <?php echo $product->get_image('rillatype-font-preview'); ?>
      <?php if ($badge_text) : ?>
        <span class="product-card__badge"><?php echo esc_html($badge_text); ?></span>
      <?php endif; ?>
      <?php if ($product->is_type('simple') && $product->is_purchasable()) : ?>
        <button class="product-card__addtocart button add_to_cart_button ajax_add_to_cart" data-product_id="<?php echo esc_attr($product->get_id()); ?>" data-quantity="1" aria-label="<?php echo esc_attr($product->add_to_cart_description()); ?>">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
        </button>
      <?php endif; ?>
    </div>
    <div class="product-card__body">
      <div class="product-card__info">
        <span class="product-card__name"><?php echo esc_html($product->get_name()); ?></span>
        <?php if ($categories) : ?>
          <span class="product-card__style"><?php echo esc_html($categories); ?></span>
        <?php endif; ?>
      </div>
      <span class="product-card__price"><?php echo $product->get_price_html(); ?></span>
    </div>
  </a>
</div>
