<?php


namespace Db;


class DbConnect extends \Core\McObjects
{
    protected $dbc;

    public function __construct($host, $user, $pwd, $db)
    {
        $this->dbc = @new \mysqli($host, $user, $pwd, $db);
        if (mysqli_connect_errno()) {
            throw new \RuntimeException('Cannot access database: ' . mysqli_connect_error());
        }
    }

    public function query($sql)
    {
        $result = $this->dbc->query($sql);
        $this->confirm_query($result);

        return $result;
    }

    public function confirm_query($result)
    {
        if (!$result) {
            die("Query failed: Error 257e9" );// . $this->dbc->error);
        }
    }

    public function escape_string($string)
    {
        return $this->dbc->real_escape_string($string);
    }

    public function the_insert_id()
    {
        return mysqli_insert_id($this->dbc);
    }
}