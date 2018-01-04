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
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define('DB_NAME', 'my');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'uyhqEK.S:Ym=|l^D)iPOHG#^WE7qX}mI~&@#f1vVqf~:}$eU=1Hth6QXjk=B9Am%');
define('SECURE_AUTH_KEY',  'd:)Ps8!4wN*-ptG;tgy><3fRsqCfr//uUP}V-mi8w?Yg|46qYaP>,g%|^]^pm>k:');
define('LOGGED_IN_KEY',    '+x[Rph`6=_uVpfF>LXG+^tgdUOB*Ujb[sQUn03i7[pdxo(/-nH+17sN8999}$L}P');
define('NONCE_KEY',        'e-Fn?f]qu&1NA-`J~%-^MI01GYJN{MTK&!{TJn2PXW^6kF-%wVUW@!:+G2L_jXIj');
define('AUTH_SALT',        'p5|Qh:N>;q@c]w+Xl;7}`Ts17&2w2^J}dq}-Sg=`ra=$q*Kpo[68i6{bp+d=sd//');
define('SECURE_AUTH_SALT', '9G{%F_Tt8NhS]fc5AU?!<}d[2xABj9J$Lt{#(K(qZV=Cu1hdgK-g3!Pj9.U`d[S/');
define('LOGGED_IN_SALT',   '6s c/B `-qm6Q`,b2se7~kuU;)>*DbX@Db=Ufsm,zl;kj/#HBW^RO>m+B-qb90jD');
define('NONCE_SALT',       'UDPh  :VW&n|,oOxoV4DJ</h3b:@JpIMmM>V9x|] J*xQ</A~foREz9BLJR%BaU=');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');
