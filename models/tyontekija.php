<?php

class Employee {

    private $id;
    private $password;
    private $email;
    private $firstname;
    private $lastname;

    public function __construct($id, $password, $email, $firstname, $lastname) {
        $this->id = $id;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
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


    public static function getEmployee($id) {
        $sql = "SELECT * FROM employee WHERE id = ? LIMIT 1";
        $query = getTietokantayhteys()->prepare($sql);
        $query->execute(array($id));

        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            $employee = new Employee($result->id, $result->password, $result->email, $result->firstname, $result->lastname);
            return $employee;
        }
    }

    public static function getEmployees() {
        $sql = "SELECT id, password, email from employee";
        $kysely = getTietokantayhteys()->prepare($sql);
        $kysely->execute();

        $tulokset = array();
        foreach ($kysely->fetchAll(PDO::FETCH_OBJ) as $tulos) {
            $tyontekija = new Employee($tulos->id, $tulos->password, $tulos->email);
            $tulokset[] = $tyontekija;
        }
        return $tulokset;
    }

    public static function getEmployeeByLoginInfo($email, $password) {
        $sql = "SELECT id,password,email,firstname,lastname FROM employee WHERE password = ? AND email = ? LIMIT 1";
        $query = getTietokantayhteys()->prepare($sql);
        $query->execute(array($password, $email));

        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            $employee = new Employee($result->id, $result->password, $result->email, $result->firstname, $result->lastname);
            return $employee;
        }
    }

}
