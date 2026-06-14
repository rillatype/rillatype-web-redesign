<?php
/**
 * Rillatype V2 — Custom Search Form
 */
printf(
  '<form role="search" method="get" class="search-form" action="%s">
    <label class="screen-reader-text" for="search-field">%s</label>
    <input type="search" id="search-field" class="search-field" placeholder="%s" value="%s" name="s" />
    <button type="submit" class="search-submit">%s</button>
  </form>',
  esc_url(home_url('/')),
  esc_html__('Search', 'rillatype-v2'),
  esc_attr__('Search...', 'rillatype-v2'),
  esc_attr(get_search_query()),
  esc_html__('Search', 'rillatype-v2')
);
