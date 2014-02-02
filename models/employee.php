<?php

class Employee {

    private $id;
    private $password;
    private $email;
    private $firstname;
    private $lastname;
    private $admin;

    public function __construct($id, $password, $email, $firstname, $lastname, $admin) {
        $this->id = $id;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->admin = $admin;
    }

    public function getID() {
        return $this->id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getFirstName() {
        return $this->firstname;
    }
    
    public function getLastName() {
        return $this->lastname;
    }
    
    public function isAdmin() {
        return $this->admin;
    }

    public static function getEmployees() {
        $sql = "SELECT * from employee";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $tyontekija = new Employee($result->id, $result->password, $result->email, $result->firstname, $result->lastname, $result->admin);
            $results[] = $tyontekija;
        }
        return $results;
    }

    public static function getEmployeeByLoginInfo($email, $password) {
        $sql = "SELECT * FROM employee WHERE password = ? AND email = ? LIMIT 1";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($password, $email));

        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            $employee = new Employee($result->id, $result->password, $result->email, $result->firstname, $result->lastname, $result->admin);
            return $employee;
        }
    }

}
