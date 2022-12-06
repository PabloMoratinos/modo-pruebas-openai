<?php
/*
  Plugin Name: Modo pruebas
  Plugin URI: https://chat.openai.com/
  Description: Escribe la frase "Web en pruebas" en la cabecera
  en todas las páginas del sitio y permite activar o desactivar
  esa funcionalidad desde la página de ajustes.
  Version: 1.0
  Author: ChatBot
  Author URI: https://chat.openai.com/
  License: GPL2
*/
// Crear una función que escriba la frase "Web en pruebas" en
// la cabecera de todas las páginas del sitio.
function testing_mode_header() {
  if (get_option('testing_mode_enabled')) {
    echo '<h1>Web en pruebas</h1>';
  }
}
// Asignar la función anterior al hook "wp_head" para £que se ejecute en la cabecera de todas las páginas del sitio.
add_action('wp_head', 'testing_mode_header');
// Crear una función que registre una página de ajustes para el plugin.
function testing_mode_settings_page() {
  add_options_page(
    'Modo pruebas',
    'Modo pruebas',
    'manage_options',
    'testing-mode',
    'testing_mode_settings_page_html'
  );
}
add_action('admin_menu', 'testing_mode_settings_page');
// Crear una función que genere el contenido HTML de la página de ajustes.
function testing_mode_settings_page_html() {
  // Comprobar si el usuario tiene permisos para acceder a la página de ajustes.
  if (!current_user_can('manage_options')) {
    return;
  }
  // Mostrar un formulario que permita al usuario activar o desactivar la opción "Modo pruebas".
  ?>
  <div class="wrap">
    <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
    <form action="options.php" method="post">
      <?php settings_fields('testing_mode_options'); ?>
      <?php do_settings_sections('testing-mode'); ?>
      <table class="form-table">
        <tr valign="top">
          <th scope="row">Modo pruebas</th>
          <td>
            <label for="testing_mode_enabled">
              <input name="testing_mode_enabled" type="checkbox" id="testing_mode_enabled" value="1" <?php checked('1', get_option('testing_mode_enabled')); ?> >
              Habilitar "Web en pruebas"
            </label>
          </td>
        </tr>
      </table>
      <?php submit_button(); ?>
    </form>
  </div>
<?php
}
// Comprobar si se ha enviado el formulario.
if (isset($_POST['testing_mode_enabled'])) {
  // Guardar la opción "Modo pruebas" en la base de datos.
  update_option('testing_mode_enabled', $_POST['testing_mode_enabled']);
}
  function testing_mode_register_settings() {
    register_setting(
      'testing_mode_options',
      'testing_mode_enabled'
    );
  }
  add_action('admin_init', 'testing_mode_register_settings');
