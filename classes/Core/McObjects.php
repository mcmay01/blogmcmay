<?php

namespace Core;

class McObjects
{
    public static function find_by_query($sql)
    {
        global $database;
        $result_set = $database->query($sql);
        $the_object_array = array();
        while ($row = mysqli_fetch_array($result_set)) {
            $the_object_array[] = static::instantiate($row);
        }
        return $the_object_array;
    }

    //instantiating objects...
    public static function instantiate($found_user)
    {
        $calling_class = get_called_class();
        $object = new $calling_class;

        foreach ($found_user as $the_attribute => $value) {
            if ($object->has_the_attribute($the_attribute)) {
                $object->$the_attribute = $value;
            }
        }
        return $object;
    }

    protected function properties()
    {
        $properties = array();
        foreach (static::$db_table_fields as $table_field) {
            if (property_exists($this, $table_field)) {
                $properties[$table_field] = $this->$table_field;
            }
        }
        return $properties;
    }

    private function has_the_attribute($the_attribute)
    {
        //store all properties from an object;
        $object_properties = get_object_vars($this);
        return array_key_exists($the_attribute, $object_properties);
    }

    protected function clean_properties()
    {
        global $database;
        $clean_properties = array();
        foreach ($this->properties() as $key => $value) {
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }

    public function create()
    {
        global $database;
        $properties = $this->clean_properties();
        $sql = "INSERT INTO " . static::$db_table . "(" . implode(",", array_keys($properties)) . ")";
        $sql .= "VALUES ('" . implode("','", array_values($properties)) . "')";
        if ($database->query($sql)) {
            $this->id = $database->the_insert_id();
            return true;
        } else {
            return false;
        }
    }

    public function update()
    {
        global $database;
        $properties = $this->clean_properties();
        foreach ($properties as $key => $value) {
            $properties_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE " . static::$db_table . " SET " . implode(",", $properties_pairs);
        $sql .= " WHERE id=" . $database->escape_string($this->id);
        $database->query($sql);
        return (mysqli_affected_rows($database->dbc) == 1) ? true : false;
    }

    public function delete_update($id = '')
    {
        global $database;
        if (empty($id)) return false;
        if (!is_numeric($id)) return false;
        $sql = "UPDATE " . static::$db_table . " SET deleted=1 WHERE id={$database->escape_string($id)} LIMIT 1";
        $database->query($sql);
        return (mysqli_affected_rows($database->dbc) == 1) ? true : false;
    }

    public function delete_img($filename = '')
    {
        if (empty($filename)) return false;
        if (file_exists(SITE_ROOT . "/uploads/" . $filename)) {
            unlink(SITE_ROOT . "/uploads/" . $filename);
            return true;
        }
    }
    public function delete_by_id($id)
    {
        if (!empty($id) && is_integer($id)){
            $this->delete_update($id);
        }
    }
    public function delete_target($target='', $id=''){
        global $database;
        if (empty($target) || empty($id) || !is_numeric($id)) return false;
        $target = trim($target); $id = trim($id);
        switch ($target){
            case 'phone':
                $sql = "UPDATE phone_product SET deleted=1 WHERE id={$database->escape_string($id)} LIMIT 1";
                break;
            case 'gallery':
                $sql = "UPDATE phone_gallery SET deleted=1 WHERE id={$database->escape_string($id)} LIMIT 1";
                break;
            case 'user':
                $sql = "UPDATE gengadug_login SET deleted=1 WHERE id={$database->escape_string($id)} LIMIT 1";
                break;
            case 'accessories':
                $sql = "UPDATE accessories_phone SET deleted=1 WHERE id={$database->escape_string($id)} LIMIT 1";
                break;
            case 'feedback':
                $sql = "UPDATE user_feedback SET deleted=1 WHERE id={$database->escape_string($id)} LIMIT 1";
                break;
            case 'p_sold':
                $sql = "UPDATE phone_sold SET deleted=1 WHERE id={$database->escape_string($id)} LIMIT 1";
                break;
            case 'p_bought':
                $sql = "UPDATE phone_bought SET deleted=1 WHERE id={$database->escape_string($id)} LIMIT 1";
                break;
            case 'p_inquiry':
                $sql = "UPDATE phone_inquiries SET deleted=1 WHERE id={$database->escape_string($id)} LIMIT 1";
                break;
            default:
                break;
        }
        if (empty($sql)) return false;

        if ($database->query($sql)){
            return true;
        }
        return false;
    }

    public function save()
    {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public static function find_all_asc()
    {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " ORDER BY Id ASC ");
    }

    public static function find_all()
    {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " ORDER BY Id DESC ");
    }
    public static function find_all_not_deleted()
    {
        return static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE deleted=0 ORDER BY Id DESC ");
    }

    public static function count_all($count_mkt = '')
    {
        global $database;
        $sql = "SELECT COUNT(*) FROM " . static::$db_table;// . " WHERE in_stock = 'Y' AND  deleted = 0";
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        return array_shift($row);
    }

    public static function count_all_by_catid($catId)
    {
        global $database;
        $catId = $database->escape_string($catId);
        $sql = "SELECT COUNT(*) FROM " . static::$db_table . " WHERE cat_id={$catId} AND deleted=0";// . " WHERE in_stock = 'Y' AND  deleted = 0";
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        return array_shift($row);
    }

    public static function count_by_user_id($user_id = '')
    {
        global $database;
        $catId = $database->escape_string($user_id);
        $sql = "SELECT COUNT(*) FROM " . static::$db_table . " WHERE user_id={$user_id} AND deleted=0";
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        return array_shift($row);
    }

    public static function find_by_id($id)
    {
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE id={$id} LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_by_user_id($user_id)
    {
        global $database;
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE user_id={$user_id} LIMIT 1");
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public static function find_by_ph_id($ph_id)
    {
        if (empty($ph_id)) return false;
        $result = static::find_by_query("SELECT * FROM " . static::$db_table . " WHERE ph_id={$ph_id} LIMIT 1");
        return !empty($result) ? array_shift($result) : false;
    }

    public static function join_find_by_ph_id($ph_id)
    {
        global $database;
        $ph_id = $database->escape_string($ph_id);
        $sql = "SELECT phone_product.id, ( SELECT category FROM phone_category WHERE id = phone_product.cat_id ) AS category, phone_product.model, ( SELECT capacity FROM phone_capacity WHERE id = phone_product.cap_id ) AS capacity, (SELECT memory FROM phone_memory WHERE id = phone_product.mem_id) AS memory, ( SELECT color FROM phone_color WHERE id = phone_product.col_id ) AS color, ( SELECT p_condition FROM phone_condition WHERE id = phone_product.con_id ) AS p_condition, phone_product.description, phone_product.price, phone_product.compare_price,  phone_image.filename, phone_product.in_stock AS available, phone_product.create_date FROM phone_product INNER JOIN phone_image ON (phone_product.id = phone_image.ph_id) AND (phone_product.in_stock = 'Y') AND (phone_product.id = {$ph_id})";
        $result = self::find_by_query($sql);
        return !empty($result) ? array_shift($result) : false;
    }

    public static function join_find_by_category($cat_id)
    {
        global $database;
        $cat_id = $database->escape_string($cat_id);
        $sql = "SELECT phone_product.id, ( SELECT category FROM phone_category WHERE id = phone_product.cat_id ) AS category, phone_product.model, ( SELECT capacity FROM phone_capacity WHERE id = phone_product.cap_id ) AS capacity, (SELECT memory FROM phone_memory WHERE id = phone_product.mem_id) AS memory, ( SELECT color FROM phone_color WHERE id = phone_product.col_id ) AS color, ( SELECT p_condition FROM phone_condition WHERE id = phone_product.con_id ) AS p_condition, phone_product.description, phone_product.price, phone_product.compare_price, phone_image.filename, phone_product.in_stock AS available, phone_product.create_date FROM phone_product INNER JOIN phone_image ON (phone_product.id = phone_image.ph_id) AND (phone_product.in_stock = 'Y') AND (phone_product.cat_id = {$cat_id})";
        return self::find_by_query($sql);
//        return !empty($result) ? array_shift($result) : false;
    }
}