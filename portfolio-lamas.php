<?php
/**
 * Plugin Name: Portfólio Ana Caroline Lamas
 * Description: Publica a landing page profissional em /portfolio/ e disponibiliza o shortcode [portfolio_lamas].
 * Version: 3.0.0
 * Requires PHP: 7.4
 */
if (!defined('ABSPATH')) exit;
function acl_portfolio_activate() {
    if (!get_page_by_path('portfolio')) {
        wp_insert_post(array('post_title'=>'Portfólio profissional','post_name'=>'portfolio','post_type'=>'page','post_status'=>'publish','post_content'=>'[portfolio_lamas]'));
    }
}
register_activation_hook(__FILE__, 'acl_portfolio_activate');
add_shortcode('portfolio_lamas', function() {
    return '<iframe title="Portfólio profissional de Ana Caroline Lamas" src="'.esc_url(plugins_url('index.html', __FILE__)).'" style="width:100%;height:90vh;min-height:600px;border:0;display:block" loading="lazy"></iframe>';
});
add_action('template_redirect', function() {
    if (!is_page()) return;
    $page = get_queried_object();
    if (!$page || trim($page->post_content) !== '[portfolio_lamas]') return;
    $html = file_get_contents(__DIR__.'/index.html');
    if ($html === false) return;
    $html = str_replace('href="Curriculo_Ana_Caroline_Lamas_Atualizado.pdf"', 'href="'.esc_url(plugins_url('Curriculo_Ana_Caroline_Lamas_Atualizado.pdf', __FILE__)).'"', $html);
    header('Content-Type: text/html; charset=UTF-8');
    echo $html;
    exit;
});
