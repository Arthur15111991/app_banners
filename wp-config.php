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
define('DB_NAME', 'wp_drup');

/** Имя пользователя MySQL */
define('DB_USER', 'root');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', '369970');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'V~Czbu#V2^w ^wpHz45q+yL`<,;WQY&Ifv%@SjQD1O[}^6`![Tj_Q2Z<L>HCPSj]');
define('SECURE_AUTH_KEY',  'j(vpgE^@@hvOl7aXrCTNzL-{@$Sa.iQY/H=L]}$-::q]m1d9>/jQm4^)lJLaU[u_');
define('LOGGED_IN_KEY',    'JE_-ac;J5z$/R 9Q3Ay%s&82>&O_7ND`d}VVq7< >4)Fh[9`8Mum,6|~jc~>yz %');
define('NONCE_KEY',        'A:Yjg@6lqrs}iEH@v].CJ08y}gdAGjvbmmEt-%sI+B-BOIc6C74EZ3-e=rQ2rd4j');
define('AUTH_SALT',        'jU>>x%!|yZ>q~+4]Z$I-?D6SeUK7!I2Vfzp,0+xuU!6VxC_?agQ6GC3~<lZ*fx0?');
define('SECURE_AUTH_SALT', '7(ndi;E5*]|u;g(}0(3sH  x+o1$g]QZjwW;d^WMI S6D^k/GpIx&id%#Kf2PVOw');
define('LOGGED_IN_SALT',   '9&NDiruI;[|LSgR 7s:s)#<nYo+!^Fv-$y<]CY;IQChWE@5Z`fvS#@kC1yC)mt8w');
define('NONCE_SALT',       'U33y%*?K6bi;1~/.h(KK7rZcH6^p5{e.gO2PJd<@(&6C0%fas*CfBptEV-bcJ:j9');

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
