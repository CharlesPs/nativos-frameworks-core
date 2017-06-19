# nativos-frameworks-core

## MY_Model.php

##### Instalación
Nos situamos en el root de nuestro proyecto CodeIgniter y antes de instalar CodeIgniter en la consola escribimos:
```
$> git submodule add https://github.com/CharlesPs/nativos-frameworks-core.git application/core
```
Esto antes de instalar el CodeIgniter, sino tendremos un error.

##### Crear un modelo
Indicamos el nombre de la tabla con set_table
```php
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_users extends MY_Model {

    public function __construct () {
        parent::__construct();

        $this->set_table('users');
    }
}
```

##### Cargar el modelo
```php
<?php
$this->load->model('m_users');
```
##### Haciendo llamadas a los datos
Obtener el registro con el id 6:
```php
<?php
$user = $this->m_users->where_id(6)->get_row();
```
O con el alguna condición:
```php
<?php
$user = $this->m_users->where_condition('name="Alexis" AND gender="female"')->get_row();
```
Obtener varios registros:
```php
<?php
$users = $this->m_users->get_result();
```
También podemos establecer condiciones adicionales:

Establecer una condición:
```php
<?php
$users = $this->m_users->where_condition('dni="12345678"')->get_result();
```

Buscar por varios ids:
```php
<?php
$users = $this->m_users->where_ids_array('1,6')->get_result();
```
O buscar especificando el campo
```php
<?php
$users = $this->m_users->where_field_array('dni', '12345678,98765432')->get_result();
```
También podemos hacer encadenamiento de condiciones:
```php
<?php
$users = $this->m_users->where_condition('gender="female"')
                        ->where_field_array('dni', '12345678,98765432')
                        ->get_result();
```
