# nativos-frameworks-core

## MY_Model.php

##### Instalación
Nos situamos en el root de nuestro proyecto CodeIgniter y antes de instalar CodeIgniter en la consola escribimos:
```
$> git init
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
##### Paginación
Por defecto tenemos la paginación establecida en 20 registros por página:
```php
<?php
private $_pagination_limit = 20;
private $_pagination_offset = 0;
```
Podemos llamar a una consulta con paginación de la siguiente manera:
```php
<?php
$page = 0;
$pagination = $this->m_users->get_pagination_result($page);
```
Con esto recibiremos un array como el siguiente:
```
Array
(
    [actual_page] => 0
    [all_rows] => 3
    [page_row] => Array
        (
            [0] => stdClass Object
                (
                    [id] => 7
                    [dni] => 11111111
                    [nombres] => Diana
                    [apellidos] => Prince
                    [created_at] => 2017-06-19 15:27:21
                    [updated_at] => 2017-06-19 22:27:21
                    [status] => status_enabled
                )

            [1] => stdClass Object
                (
                    [id] => 6
                    [dni] => 22222222
                    [nombres] => Clark
                    [apellidos] => Kent
                    [created_at] => 2017-06-19 15:26:42
                    [updated_at] => 2017-06-19 22:26:42
                    [status] => status_enabled
                )

            [2] => stdClass Object
                (
                    [id] => 1
                    [dni] => 33333333
                    [nombres] => Bruce
                    [apellidos] => Wayne
                    [created_at] => 2017-06-19 11:54:02
                    [updated_at] => 2017-06-19 11:54:02
                    [status] => status_enabled
                )

        )

)
```
Esto convertido a json, podria ser manejado desde un frontend:
```php
<?php
$page = 0;
$pagination = $this->m_users->get_pagination_result($page);
jecho($pagination);
```
```json
{
    "actual_page":0,
    "all_rows":3,
    "page_row":[
        {
            "id":"7",
            "dni":"41557689",
            "nombres":"Charles",
            "apellidos":"Aguinaga",
            "created_at":"2017-06-19 15:27:21",
            "updated_at":"2017-06-19 22:27:21",
            "status":"status_enabled"
        },
        {
            "id":"6",
            "dni":"41557689",
            "nombres":"Charles",
            "apellidos":"Aguinaga",
            "created_at":"2017-06-19 15:26:42",
            "updated_at":"2017-06-19 22:26:42",
            "status":"status_enabled"
        },
        {
            "id":"1",
            "dni":"41557688",
            "nombres":"Carlos",
            "apellidos":"Aguinaga",
            "created_at":"2017-06-19 11:54:02",
            "updated_at":"2017-06-19 11:54:02",
            "status":"status_enabled"
        }
    ]
}
```
