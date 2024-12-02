<?php
/*
 * Plugin Name: Form Sender
 * Description: Создание форм
 * Author:      AnWeb
 * Version:     1.0
 * Plugin URI:  http://localhost/form-sender
 * Requires PHP: 7.0
 *
 */

register_activation_hook( __FILE__, 'init_function' );
function init_function(){
	
}

register_deactivation_hook( __FILE__, 'true_deactivate' );
function true_deactivate(){
	
}

add_action( 'acf/init', 'my_acf_init' );
function my_acf_init() {
	acf_add_local_field_group( [
		'key'      => 'formsender_settings',
		'title'    => 'Настройки формы',
		'fields'   => [
			[
				'key'   => 'form_shortcode',
				'label' => 'Шорткод',
				'name'  => 'form_shortcode',
				'type'  => 'text',
				'required' => 0,
				'wrapper' => [
					'class' => '',
				],
				'readonly' => 1,
			],[
				'key'   => 'form_content',
				'label' => 'Код формы',
				'name'  => 'form_content',
				'type'  => 'textarea',
				'required' => 0,
				'wrapper' => [
					'class' => 'field group-1',
				],
			],[
				'key'   => 'form_preview',
				'label' => 'Предпросмотр формы',
				'name'  => 'form_preview',
				'type'  => 'textarea',
				'required' => 0,
				'wrapper' => [
					'class' => 'field group-1 preview-block',
				],
			],
			
			[
				'key'   => 'form_mail',
				'label' => 'Адреса получателей',
				'name'  => 'form_mail',
				'type'  => 'text',
				'required' => 0,
				'wrapper' => [
					'class' => 'field group-2',
				],
			],[
				'key'   => 'letter_subject',
				'label' => 'Тема письма',
				'name'  => 'letter_subject',
				'type'  => 'text',
				'required' => 0,
				'wrapper' => [
					'class' => 'field group-2',
				],
			],[
				'key'   => 'letter_text',
				'label' => 'Текст письма',
				'name'  => 'letter_text',
				'type'  => 'textarea',
				'required' => 0,
				'wrapper' => [
					'class' => 'field group-2',
				],
			],
			
			[
				'key'   => 'form_mail2',
				'label' => 'Адреса получателей',
				'name'  => 'form_mail2',
				'type'  => 'text',
				'required' => 0,
				'wrapper' => [
					'class' => 'field group-3',
				],
			],[
				'key'   => 'letter_subject2',
				'label' => 'Тема письма',
				'name'  => 'letter_subject2',
				'type'  => 'text',
				'required' => 0,
				'wrapper' => [
					'class' => 'field group-3',
				],
			],[
				'key'   => 'letter_text2',
				'label' => 'Текст письма',
				'name'  => 'letter_text2',
				'type'  => 'textarea',
				'wrapper' => [
					'class' => 'field group-3',
				],
			],
			
			[
				'key'   => 'save_letters',
				'label' => 'Сохранять письма в архиве',
				'name'  => 'save_letters',
				'type'  => 'select',
				'required' => 0,
				'choices' => [
					'1' => 'Да',
					'0' => 'Нет',
				],
				'wrapper' => [
					'class' => 'field group-4',
				],
			],[
				'key'   => 'success_text',
				'label' => 'Сообщение после отправки',
				'name'  => 'success_text',
				'type'  => 'text',
				'required' => 0,
				'wrapper' => [
					'class' => 'field group-4',
				],
			],
		],
		'location' => [
			[
				[
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'formsender',
				],
			],
		],
		'label_placement' => 'bottom',
	] );
}

add_action( 'wp_footer','hook_javascript' );
function hook_javascript() {
	echo '<script src="/wp-content/plugins/form-sender/js/form-sender.js"></script>';
}

add_action('admin_enqueue_scripts', 'my_enqueue');
function my_enqueue($hook) {
	wp_enqueue_script('formsender_script', plugin_dir_url(__FILE__).'/js/admin-settings.js');
	wp_enqueue_style('formsender_style', plugin_dir_url(__FILE__).'/css/admin-settings.css');
}

add_action( 'init', 'true_register_formsender' );
function true_register_formsender() {
	$labels = array(
		'name' => 'Form Sernder',
		'singular_name' => 'Form Sender',
		'add_new' => 'Добавить форму',
		'add_new_item' => 'Добавление формы',
		'edit_item' => 'Редактирование формы',
		'new_item' => 'Новая форма',
		'view_item' => 'Смотреть все фомры',
		'search_items' => 'Искать форму',
		'not_found' => 'Не найдено',
		'not_found_in_trash' => 'Не найдено в корзине',
		'menu_name' => 'Form Sernder',
		'all_items' => 'Все формы',
		'menu_name' => 'Form Sender',
		'name_admin_bar' => 'Форма',
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'menu_icon' => 'dashicons-media-archive',
		'menu_position' => 20,
		'has_archive' => false,
		'supports' => array('title'),
		'taxonomies' => array()
	);
	register_post_type('formsender',$args);
}

add_action( 'init', 'true_register_formarchive' );
function true_register_formarchive() {
	$labels = array(
		'name' => 'Архив писем',
		'singular_name' => 'Архив писем',
		'add_new' => 'Добавить форму',
		'add_new_item' => 'Добавление формы',
		'edit_item' => 'Редактирование формы',
		'new_item' => 'Новая форма',
		'view_item' => 'Смотреть все фомры',
		'search_items' => 'Искать форму',
		'not_found' => 'Не найдено',
		'not_found_in_trash' => 'Не найдено в корзине',
		'menu_name' => 'Архив писем',
		'all_items' => 'Все формы',
		'menu_name' => 'Архив писем',
		'name_admin_bar' => 'Письмо',
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'menu_icon' => 'dashicons-media-archive',
		'menu_position' => 21,
		'has_archive' => false,
		'supports' => array('title', 'editor'),
		'taxonomies' => array(),
		'capability_type' => 'post',
		'capabilities' => array(
			'create_posts' => false,
		),
 		'map_meta_cap' => true,
	);
	register_post_type('formarchive',$args);
}

add_shortcode( 'form', 'form_shortcode' );
function form_shortcode( $atts ){
	$form_id = $atts['id'];
	ob_start();
	include($_SERVER['DOCUMENT_ROOT']."/wp-content/plugins/form-sender/form/form-template.php");
	return ob_get_clean();
}

add_action('admin_menu', 'mt_add_pages');
function mt_add_pages() {
	add_submenu_page(
		'edit.php?post_type=formsender',
		'Настройки отправки',
		'Настройки отправки',
		8,
		'formsender-settings',
		'formsender_settings');
}

function formsender_settings() {
  echo '
  <div class="wrap">
    <h1 class="wp-heading-inline formsend-settings">Настройки отпраки</h1>
    <form action="'.$_SERVER['REQUEST_URI'].'" method="post">
      <table class="form-table">
        <tr class="field group-1">
          <th>Метод отправки</th>
          <td>
            <select name="formsender[method]" class="formsender-method regular-text">
              <option value="phpmail"'; if (get_option('formsender_method')=='phpmail'){ echo 'selected'; }; echo '>PHP mail</option>
              <option value="smtp"'; if (get_option('formsender_method')=='smtp'){ echo 'selected'; }; echo '>SMTP</option>
            </select>
          </td>
        </tr>
        <tr class="field group-1">
          <th>Имя отправителя</th>
          <td><input type="text" name="formsender[from_name]" value="'.get_option('formsender_from_name').'" class="regular-text"></td>
        </tr>
        <tr class="field group-1">
          <th>Адрес отправителя</th>
          <td><input type="text" name="formsender[from_mail]" value="'.get_option('formsender_from_mail').'" class="regular-text"></td>
        </tr>
        <tr class="field group-1 settings-smtp">
          <th>SMTP сервер</th>
          <td><input type="text" name="formsender[smtp_host]" value="'.get_option('formsender_smtp_host').'" class="regular-text"></td>
        </tr>
        <tr class="field group-1 settings-smtp">
          <th>SMTP порт</th>
          <td><input type="text" name="formsender[smtp_port]" value="'.get_option('formsender_smtp_port').'" class="regular-text"></td>
        </tr>
        <tr class="field group-1 settings-smtp">
          <th>Тип шифрования</th>
          <td>
            <select name="formsender[smtp_secure]" class="regular-text">
              <option value=""'; if (get_option('formsender_smtp_secure')==''){ echo 'selected'; }; echo '>Нет</option>
              <option value="tsl"'; if (get_option('formsender_smtp_secure')=='tsl'){ echo 'selected'; }; echo '>TSL</option>
              <option value="ssl"'; if (get_option('formsender_smtp_secure')=='ssl'){ echo 'selected'; }; echo '>SSL</option>
            </select>
          </td>
        </tr>
        <tr class="field group-1 settings-smtp">
          <th>Имя пользователя</th>
          <td><input type="text" name="formsender[smtp_username]" value="'.get_option('formsender_smtp_username').'" class="regular-text"></td>
        </tr>
        <tr class="field group-1 settings-smtp">
          <th>Пароль</th>
          <td><input type="text" name="formsender[smtp_password]" value="'.get_option('formsender_smtp_password').'" class="regular-text"></td>
        </tr>
        
        <tr class="field group-2">
          <td colspan="2">
            Если вы хотите связать ваши формы с каналом в Telegram заполните следующие поля.
          </td>
        </tr>
        <tr class="field group-2">
          <th>Отправлять сообщения боту</th>
          <td>
            <select name="formsender[tg_status]" class="regular-text">
              <option value="0"'; if (get_option('formsender_tg_status')=='0'){ echo 'selected'; }; echo '>Нет</option>
              <option value="1"'; if (get_option('formsender_tg_status')=='1'){ echo 'selected'; }; echo '>Да</option>
            </select>
          </td>
        </tr>
        <tr class="field group-2">
          <th>Token</th>
          <td><input type="text" name="formsender[tg_token]" value="'.get_option('formsender_tg_token').'" class="regular-text"></td>
        </tr>
        <tr class="field group-2">
          <th>Chat ID</th>
          <td><input type="text" name="formsender[tg_chat_id]" value="'.get_option('formsender_tg_chat_id').'" class="regular-text"></td>
        </tr>
        
        <tr class="field group-3">
          <td colspan="2">
            Если вы хотите связать ваши формы с AMOCRM заполните следующие поля.
          </td>
        </tr>
        <tr class="field group-3">
          <th>Включить интеграцию</th>
          <td>
            <select name="formsender[amo_status]" class="regular-text">
              <option value="0"'; if (get_option('formsender_amo_status')=='0'){ echo 'selected'; }; echo '>Нет</option>
              <option value="1"'; if (get_option('formsender_amo_status')=='1'){ echo 'selected'; }; echo '>Да</option>
            </select>
          </td>
        </tr>
        <tr class="field group-3">
          <th>User ID</th>
          <td><input type="text" name="formsender[amo_user_id]" value="'.get_option('formsender_amo_user_id').'" class="regular-text"></td>
        </tr>
        <tr class="field group-3">
          <th>Secret code</th>
          <td><input type="text" name="formsender[amo_secret]" value="'.get_option('formsender_amo_secret').'" class="regular-text"></td>
        </tr>
        <tr class="field group-3">
          <th>Token</th>
          <td><input type="text" name="formsender[amo_token]" value="'.get_option('formsender_amo_token').'" class="regular-text"></td>
        </tr>
      </table>
      <br>
      <input type="submit" value="Сохранить" class="button button-primary">
    </form>
  </div>';
}

if (!empty($_REQUEST['formsender'])){
	foreach ($_REQUEST['formsender'] as $key=>$value){
		update_option('formsender_'.$key, $value);
	}
}
?>