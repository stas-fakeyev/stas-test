<?php
/*
Plugin Name: wpsync-webspark
Description: Синхронизация базы товаров с остатками
Plugin URI: http://example.com
Author: Станислав Факеев
Author URI: http://example.com
*/

//подключения для загрузки изображения товара
require_once ABSPATH . 'wp-admin/includes/media.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/image.php';
//проверка активен ли woocommerce
 if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ){
	 echo'Необходимо сперва установить и активировать плагин Woocommerce';
	exit;
 }

add_theme_support( 'post-thumbnails', array('product') );

register_activation_hook(__FILE__, 'sof_activation');
function sof_activation() {
	//удалить задачи при активации плагина
	wp_clear_scheduled_hook( 'my_hourly_event' );

	wp_schedule_event( time(), 'hourly', 'my_hourly_event');
}

add_action( 'my_hourly_event', 'do_this_hourly' );
function do_this_hourly() {
	//обновление товаров каждый час
		global $wpdb;
	//Получить товары по апи
	$url = 'https://my.api.mockaroo.com/products.json?key=89b23a40';
	        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_GET, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);

        if (!isset($response))            return;
		//Преобразовать полученые данные в массив
		$response = json_decode($response, true);
		//создать массив для всех ску
		$sku = [];
						$pc = new WP_Query( array(
					'post_type' => 'product',
					'posts_per_page' => -1,
				));
$found = $pc->found_posts;
$limit = 10000;
if($found >= $limit){
	return;
}
$num = ($limit - $found);
		if(count($response) > 0){
			$q = 0;
			foreach($response as $key => $value){
				$q++;
				if($q == $num) break;
				//проверить есть ли товар на сайте по полученному ску
  $product_id = $wpdb->get_var( $wpdb->prepare( "SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value= %s LIMIT 1", $value['sku'] ) );
  if($product_id){
	  //Обновить товар
	  	  		$post_data = array(
				'ID' => $product_id,
'post_type'     => 'product',
	'post_title'    => $value['name'],
	'post_content'  => $value['description'],
	'post_excerpt' => $value['description'],
	'post_status'   => 'publish',
	'post_author'   => 1,
);
$post_id = wp_insert_post( $post_data );

  } //endif
  else{
	  //Создать товар
	  		$post_data = array(
'post_type'     => 'product',
	'post_title'    => $value['name'],
	'post_content'  => $value['description'],
	'post_excerpt' => $value['description'],
	'post_status'   => 'publish',
	'post_author'   => 1,
);
$post_id = wp_insert_post( $post_data );
  } //endelse
	  //обновить мета-поля товара
//запасы
update_post_meta($post_id, '_stock', $value['in_stock']);
//ску
update_post_meta($post_id, '_sku', $value['sku']);
//цена
$price = str_replace('$', null, $value['price']);
update_post_meta($post_id, '_regular_price', $price);
update_post_meta($post_id, '_sale_price', $price);
update_post_meta($post_id, '_price', $price);
//добавить изображение товара
$img = media_sideload_image( $value['picture'], $post_id, 'product', 'id' );
$sku[] = $value['sku'];
			} //endforeach
			//удаление лишних товаров
				if($pc->have_posts()){
    while ($pc->have_posts()) {
        $pc->the_post();
		$meta_sku = get_post_meta(get_the_ID(), '_sku', true);
if(!in_array($meta_sku, $sku)){
$del = wp_delete_post(get_the_ID(), true);
} //endif
	} //endwhile
	wp_reset_postdata();
				} //endif
		} //endif count
		

} //endfunction

//деактивация плагина и удаление задачь
register_deactivation_hook( __FILE__, 'sof_deactivation' );
function sof_deactivation(){
	wp_clear_scheduled_hook( 'my_hourly_event' );
}