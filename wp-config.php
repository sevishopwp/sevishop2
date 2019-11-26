<?php
/**
 * Configuración básica de WordPress.
 *
 * Este archivo contiene las siguientes configuraciones: ajustes de MySQL, prefijo de tablas,
 * claves secretas, idioma de WordPress y ABSPATH. Para obtener más información,
 * visita la página del Codex{@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} . Los ajustes de MySQL te los proporcionará tu proveedor de alojamiento web.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** Ajustes de MySQL. Solicita estos datos a tu proveedor de alojamiento web. ** //
/** El nombre de tu base de datos de WordPress */
define( 'DB_NAME', 'wp_sevishop' );

/** Tu nombre de usuario de MySQL */
define( 'DB_USER', 'sevishop' );

/** Tu contraseña de MySQL */
define( 'DB_PASSWORD', 'sevishop' );

/** Host de MySQL (es muy probable que no necesites cambiarlo) */
define( 'DB_HOST', 'localhost' );

/** Codificación de caracteres para la base de datos. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Cotejamiento de la base de datos. No lo modifiques si tienes dudas. */
define('DB_COLLATE', '');

/**#@+
 * Claves únicas de autentificación.
 *
 * Define cada clave secreta con una frase aleatoria distinta.
 * Puedes generarlas usando el {@link https://api.wordpress.org/secret-key/1.1/salt/ servicio de claves secretas de WordPress}
 * Puedes cambiar las claves en cualquier momento para invalidar todas las cookies existentes. Esto forzará a todos los usuarios a volver a hacer login.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY', '`:];n#H=;9^XMq,Bp2)m/5a&e4:gFZ4krWfm,]t %)56`xcr,TfuA>W(I8 Bi`nB' );
define( 'SECURE_AUTH_KEY', 'lyKtu,O+Ies*b8~4bXvM>dl`SMq}:f$+p88LeZ&shuKatEj?<NPAm7UNllL<:}M$' );
define( 'LOGGED_IN_KEY', '4f|SW{_[Vg+Vk#5XzFxwhXKMyBUJLRGb6_wVeH=ua_&s!lUd#1sDr99;yK2u%(6g' );
define( 'NONCE_KEY', '[S==]Wp{VcCm<a*sVTj*orLNu)Qz],|)$(.?(@dEKT9q@%i2W&{|r9T#RHOSrjjt' );
define( 'AUTH_SALT', 'T4GCSQ>Fd*qDI+xre.E fM<jABTD>JnhB*J&c16}(#BFDB@9T8H:S!GB*6JZ81Rn' );
define( 'SECURE_AUTH_SALT', '4*S_.>^rRX?ATqP69d&mQIuO!Q;v]a9IM|ec[+%TvZ/0l+LmE!2R`oV!94,*1r($' );
define( 'LOGGED_IN_SALT', 'Yc) P~T@&`ltn}UB3!_zWnYN(1Fhn#21Y)3[X9l;w&2`)wS!Xhn2_Q^Un,<=H7xG' );
define( 'NONCE_SALT', 'j!Gv3}:1RYY5 V%mP pBwuaTJy?!RVM+)wCj:H}$Uf N!!L^:u$paIe(u&M}RRbQ' );

/**#@-*/

/**
 * Prefijo de la base de datos de WordPress.
 *
 * Cambia el prefijo si deseas instalar multiples blogs en una sola base de datos.
 * Emplea solo números, letras y guión bajo.
 */
$table_prefix = 'wp_';


/**
 * Para desarrolladores: modo debug de WordPress.
 *
 * Cambia esto a true para activar la muestra de avisos durante el desarrollo.
 * Se recomienda encarecidamente a los desarrolladores de temas y plugins que usen WP_DEBUG
 * en sus entornos de desarrollo.
 */
define('WP_DEBUG', false);

/* ¡Eso es todo, deja de editar! Feliz blogging */

/** WordPress absolute path to the Wordpress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

