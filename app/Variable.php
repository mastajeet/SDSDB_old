<?php
/**
 * Created by PhpStorm.
 * User: jtbai
 * Date: 01/06/18
 * Time: 9:18 AM
 */

class Variable extends BaseModel
{

    const KEY_SUPER_ADMIN_PASSWORD = 'super_admin_password';

    static function define_table_info(){
        return array("model_table" => 'vars',
            "model_table_id" => 'Nom');
    }

    function get_super_admin_password(){
        $get_super_admin_password_variable_from_sql_repository_request = "SELECT Valeur FROM vars WHERE Nom = '".self::KEY_SUPER_ADMIN_PASSWORD."'";
        $response = $this->select($get_super_admin_password_variable_from_sql_repository_request);
        $password = $response[0]['Valeur'];

        return($password);
    }

}