<?php
/**
 * La configuration de base de votre installation WordPress.
 *
 * Ce fichier est utilisé par le script de création de wp-config.php pendant
 * le processus d’installation. Vous n’avez pas à utiliser le site web, vous
 * pouvez simplement renommer ce fichier en « wp-config.php » et remplir les
 * valeurs.
 *
 * Ce fichier contient les réglages de configuration suivants :
 *
 * Réglages MySQL
 * Préfixe de table
 * Clés secrètes
 * Langue utilisée
 * ABSPATH
 *
 * @link https://fr.wordpress.org/support/article/editing-wp-config-php/.
 *
 * @package WordPress
 */

// ** Réglages MySQL - Votre hébergeur doit vous fournir ces informations. ** //
/** Nom de la base de données de WordPress. */
define( 'DB_NAME', 'bwuvaqhprecnav' );

/** Utilisateur de la base de données MySQL. */
define( 'DB_USER', 'bwuvaqhprecnav' );

/** Mot de passe de la base de données MySQL. */
define( 'DB_PASSWORD', 'interCNAV2021lude' );

/** Adresse de l’hébergement MySQL. */
define( 'DB_HOST', 'bwuvaqhprecnav.mysql.db' );

/** Jeu de caractères à utiliser par la base de données lors de la création des tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/**
 * Type de collation de la base de données.
 * N’y touchez que si vous savez ce que vous faites.
 */
define( 'DB_COLLATE', '' );

/**#@+
 * Clés uniques d’authentification et salage.
 *
 * Remplacez les valeurs par défaut par des phrases uniques !
 * Vous pouvez générer des phrases aléatoires en utilisant
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ le service de clés secrètes de WordPress.org}.
 * Vous pouvez modifier ces phrases à n’importe quel moment, afin d’invalider tous les cookies existants.
 * Cela forcera également tous les utilisateurs à se reconnecter.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '?!/H_:MKKo.1fh3<@.WED}mQlC<LK=n#a|ei _Zf+a]s;#Qp|v(|Ke^Zm!DH.GxT' );
define( 'SECURE_AUTH_KEY',  'C[nv0B2J.!dn6lT-g/*H5r`y1Q *FY- ODGCES6q!X.6S!xK9{eh?}AYD=ukaD)Z' );
define( 'LOGGED_IN_KEY',    'WucGJN$y&wygP=|J9enV+@+A&2eq|fkj,5yGz=1BLM#<Y(c@olD([g)m?%=^ #BP' );
define( 'NONCE_KEY',        'Pz@{5-CH=D!3+7Y=&j@nfWIV)G~8oC{n(_ag~Hij7ZOmU7cPj}_$}NX>MjP~b6y,' );
define( 'AUTH_SALT',        'n|TTBLyA)J@B t!r|T_wai]UjAV5l7`z5 s4k<My-XvI 5y~ixxQ;L g]>T7(g S' );
define( 'SECURE_AUTH_SALT', ':F9m`fsEE7O)x}^C+GrIRl0)3F]D2uJ6EoQeI15cwdeKl)#9!HRAfS(]Sq#F_2M7' );
define( 'LOGGED_IN_SALT',   'zL;yOBB/CX6||Zq.+eyx%%0C9ac^d<LT{:$bgo}=b>f3+;Qht0(dne5N&L88/cR1' );
define( 'NONCE_SALT',       'JwmlPw>L!MRI`piKrcCY~AT.C0I>h8r-g8]3+TL4pBhHn6^7_2@Xc92x#!q*L7Vc' );
/**#@-*/

/**
 * Préfixe de base de données pour les tables de WordPress.
 *
 * Vous pouvez installer plusieurs WordPress sur une seule base de données
 * si vous leur donnez chacune un préfixe unique.
 * N’utilisez que des chiffres, des lettres non-accentuées, et des caractères soulignés !
 */
$table_prefix = 'cnavE_';

/**
 * Pour les développeurs : le mode déboguage de WordPress.
 *
 * En passant la valeur suivante à "true", vous activez l’affichage des
 * notifications d’erreurs pendant vos essais.
 * Il est fortement recommandé que les développeurs d’extensions et
 * de thèmes se servent de WP_DEBUG dans leur environnement de
 * développement.
 *
 * Pour plus d’information sur les autres constantes qui peuvent être utilisées
 * pour le déboguage, rendez-vous sur le Codex.
 *
 * @link https://fr.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* C’est tout, ne touchez pas à ce qui suit ! Bonne publication. */

/** Chemin absolu vers le dossier de WordPress. */
if ( ! defined( 'ABSPATH' ) )
  define( 'ABSPATH', dirname( __FILE__ ) . '/' );

/** Réglage des variables de WordPress et de ses fichiers inclus. */
require_once( ABSPATH . 'wp-settings.php' );
define('FS_METHOD','direct');
