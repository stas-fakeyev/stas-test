<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'testbase' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '|Ja)^HmT$-ZD^h._(dt]-&Gop;vO.zaNgXE_j|F=`:+n$ 5GP=v90@v40ljD#o/&' );
define( 'SECURE_AUTH_KEY',  'aU/Hq^C_LCkZkZM}qiY w:(s:H/us/$#gZrlB3Pir,.BI/%$81`+%k/U02A:ZSS2' );
define( 'LOGGED_IN_KEY',    'Of]oor-2`wIyc$byHY#XYQn>6apCWXrJxnC+$TY_J%/b<+sj8Kp},1|qnCO3?pjv' );
define( 'NONCE_KEY',        'va#jV894oxBqVJdMsOtn9y_T/11HGf=irLKHZ<lLGP<CTp-*?s?3z!HZ4e&>d{A]' );
define( 'AUTH_SALT',        '/h1uWgF7l[eoneGm|>f)(PeBv}/WPi33]wjp`<g!gt%3qWE`:(ZcH EUH`yF^vWa' );
define( 'SECURE_AUTH_SALT', '~y;*08p:]Zj`ih/yE[`i?BJt+twHf=:Fy|aoxp=q2J6Nd%{kzwNjO]x,9d@I3+4M' );
define( 'LOGGED_IN_SALT',   '6Or.mA`d1smEIFDVW}Gvg2vw]FX0(EsDfW<=H;8_a.:]mc== >,H6(g>U?,;[769' );
define( 'NONCE_SALT',       '}sTa0J,ZTovx1;I=RHH&LR^Q0n(mt4vzl~>[r>Ded~G#@%WW9vNL_W)A6~j7,R-*' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
