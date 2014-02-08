<?php

require_once 'personnelcategory.php';

class Employee {

    private $errors = array();
    private $id;
    private $password;
    private $firstname;
    private $lastname;
    private $ssn;
    private $address;
    private $email;
    private $phone;
    private $personnelcategory_id;
    private $maxhoursperweek;
    private $maxhoursperday;
    private $admin;

    public function __construct($id, $password, $email, $firstname, $lastname, $admin, $personnelcategory_id) {
        $this->id = $id;
        $this->password = $password;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->admin = $admin;
        $this->personnelcategory_id = $personnelcategory_id;
    }

    public function getErrors() {
        return $this->errors;
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

    public function getPersonnelCategoryID() {
        return $this->personnelcategory_id;
    }

    public function isAdmin() {
        return $this->admin;
    }

    public function setFirstName($firstname) {
        $this->firstname = $firstname;
        if (trimInput($firstname) == '') {
            $this->errors['firstname'] = "Etunimi puuttuu. ";
        } else {
            unset($this->errors['firstname']);
        }
    }

    public function setLastName($lastname) {
        $this->lastname = $lastname;
        if (trimInput($lastname) == '') {
            $this->errors['lastname'] = "Sukunimi puuttuu. ";
        } else {
            unset($this->errors['lastname']);
        }
    }

    public function setSocialSecurityNumber($ssn) {
        $this->ssn = $ssn;
    }

    public function setAddress($address) {
        $this->address = $address;
        if (trimInput($address) == '') {
            $this->errors['adress'] = "Osoite puuttuu. ";
        } else {
            unset($this->errors['adress']);
        }
    }

    public function setEmail($email) {
        $this->email = $email;
        if (trimInput($email) == '') {
            $this->errors['email'] = "Sähköpostiosoite puuttuu. ";
        } else {
            unset($this->errors['email']);
        }
    }

    public function setPhone($phonenumber) {
        $this->phone = $phonenumber;
        if (trimInput($phonenumber) == '') {
            $this->errors['phone'] = "Puhelinnumero puuttuu. ";
        } else {
            unset($this->errors['phone']);
        }
    }

    public function setPersonnelCategory($category) {
        $this->personnelcategory_id = $category;
    }

    public function setMaxHourPerAWeek($maxhours) {
        $this->maxhoursperweek = $maxhours;
        if (trimInput($maxhours) == '') {
            $this->errors['maxhoursperweek'] = "Maksimitunnit viikossa puuttuu. ";
        } else {
            unset($this->errors['maxhoursperweek']);
        }
    }

    public function setMaxHoursPerDay($maxhours) {
        $this->maxhoursperday = $maxhours;
        if (trimInput($maxhours) == '') {
            $this->errors['maxhoursperday'] = "Maksimitunnit päivässä puuttuu. ";
        } else {
            unset($this->errors['maxhoursperday']);
        }
    }

    public function setAdmin($isAdmin) {
        if (trimInput($isAdmin) == 'true') {
            $this->admin = 'true';
        } else {
            $this->admin = 'false';
        }
    }

    public function isValid() {
        return empty($this->errors);
    }

    public function addToDatabase() {
        $password = Employee::generatePassword();
        $sql = "INSERT INTO employee(password, firstname, lastname,"
                . "ssn, address, email, phone, personnelcategory_id,"
                . "maxhoursperday, maxhoursperweek, admin)"
                . "VALUES (?,?,?,?,?,?,?,?,?,?,?) RETURNING id";
        $query = getDatabaseConnection()->prepare($sql);
        $ok = $query->execute(array($password, $this->firstname, $this->lastname,
            $this->ssn, $this->address, $this->email, $this->phone, $this->personnelcategory_id,
            $this->maxhoursperday, $this->maxhoursperweek, $this->admin));
        if ($ok) {
            $this->id = $query->fetchColumn();
        }
        return $ok;
    }

    public static function getEmployees() {
        $sql = "SELECT * from employee";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $results[] = Employee::newEmployeeFromDBResultArray($result);
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
            return Employee::newEmployeeFromDBResultArray($result);
        }
    }

    public static function createEmployeeFromData($data) {
        $employee = new Employee();
        $employee->setFirstName($data->firstname);
        $employee->setLastName($data->lastname);
        $employee->setSocialSecurityNumber($data->ssn);
        $employee->setAddress($data->address);
        $employee->setEmail($data->email);
        $employee->setPhone($data->phone);
        $employee->setPersonnelCategory($data->personnelcategory);
        $employee->setMaxHourPerAWeek($data->maxhoursperweek);
        $employee->setMaxHoursPerDay($data->maxhoursperday);
        $employee->setAdmin($data->admin);
        return $employee;
    }

    private static function newEmployeeFromDBResultArray($result) {
        $employee = new Employee($result->id, $result->password, $result->email, $result->firstname, $result->lastname, $result->admin, $result->personnelcategory_id);
        return $employee;
    }

    private static function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }

}
