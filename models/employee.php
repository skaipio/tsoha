<?php

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

    public function getErrors() {
        return $this->errors;
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

    public function getPersonnelCategoryID() {
        return $this->personnelcategory_id;
    }

    public function isAdmin() {
        return $this->admin;
    }

    public function setFirstName($firstname) {
        $this->firstname = trim($firstname);
        if (empty($this->firstname)) {
            $this->errors['firstname'] = "Etunimi puuttuu. ";
        } else {
            unset($this->errors['firstname']);
        }
    }

    public function setLastName($lastname) {
        $this->lastname = trim($lastname);
        if (empty($this->lastname)) {
            $this->errors['lastname'] = "Sukunimi puuttuu. ";
        } else {
            unset($this->errors['lastname']);
        }
    }

    public function setSocialSecurityNumber($ssn) {
        $this->ssn = trim($ssn);
//        if(strlen($ssn) != 11){
//            $this->errors['ssn'] = "Henkilötunnuksen on oltava 11 merkkiä pitkä. ";
//        } else{
//            unset($this->errors['ssn']);
//        }       
    }

    public function setAddress($address) {
        $this->address = trim($address);
        if (empty($this->address)) {
            $this->errors['address'] = "Osoite puuttuu. ";
        } else {
            unset($this->errors['address']);
        }
    }

    public function setEmail($email) {
        $this->email = $email;
        if (trim($email) == '') {
            $this->errors['email'] = "Sähköpostiosoite puuttuu. ";
        } else {
            unset($this->errors['email']);
        }
    }

    public function setPhone($phonenumber) {
        $this->phone = trim($phonenumber);
        if (empty($this->phone)) {
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
        if (empty($maxhours)) {
            $this->errors['maxhoursperweek'] = "Maksimitunnit viikossa puuttuu. ";
        } else if (!is_numeric($maxhours)) {
            $this->errors['maxhoursperweek'] = "Maksimitunnit viikossa on oltava kokonaisluku. ";
        } else {
            unset($this->errors['maxhoursperweek']);
        }
    }

    public function setMaxHoursPerDay($maxhours) {
        $this->maxhoursperday = $maxhours;
        if (empty($maxhours)) {
            $this->errors['maxhoursperday'] = "Maksimitunnit päivässä puuttuu. ";
        } else if (!is_numeric($maxhours)) {
            $this->errors['maxhoursperday'] = "Maksimitunnit päivässä on oltava kokonaisluku. ";
        } else {
            unset($this->errors['maxhoursperday']);
        }
    }

    public function setAdmin($isAdmin) {
        $this->admin = (bool) $isAdmin;
    }

    public function setFromData($data) {
        if (is_array($data) && count($data)) {
            $valid = get_class_vars(get_class($this));
            foreach ($valid as $var => $val) {
                if (isset($data[$var])) {
                    $this->$var = $data[$var];
                }
            }
        }
    }

    public function getAsDataArray() {
        $id = $this->id;
        $password = $this->password;
        $firstname = $this->firstname;
        $lastname = $this->lastname;
        $ssn = $this->ssn;
        $address = $this->address;
        $email = $this->email;
        $phone = $this->phone;
        $pcategory = $this->personnelcategory_id;
        $maxhoursperweek = $this->maxhoursperweek;
        $maxhoursperday = $this->maxhoursperday;
        $admin = $this->admin;
        $data = array('id' => $id, 'password' => $password, 'firstname' => $firstname, 'lastname' => $lastname, 'ssn' => $ssn,
            'address' => $address, 'email' => $email, 'phone' => $phone, 'personnelcategory' => $pcategory,
            'maxhoursperweek' => $maxhoursperweek, 'maxhoursperday' => $maxhoursperday, 'admin' => $admin);
        return $data;
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
        $employeeDataArray = array();
        $employeeDataArray['password'] = Employee::generatePassword();
        $employeeDataArray = $employeeDataArray + $this->getAsDataArray();
        unset($employeeDataArray['id']);
        $employeeDataArray['admin'] = $employeeDataArray['admin'] ? 'true' : 'false';
        $ok = $query->execute(array_values($employeeDataArray));
        if ($ok) {
            $this->id = $query->fetchColumn();
        }
        return $ok;
    }

    public function updateDatabaseEntry() {
        $employeeDataArray = $this->getAsDataArray();
        $employeeDataArray['admin'] = $employeeDataArray['admin'] ? 'true' : 'false';
        unset($employeeDataArray['id']);
        $employeeDataArray['id'] = $this->getID();
        $sql = "UPDATE employee SET password=?, firstname=?, lastname=?, "
                . "ssn=?, address=?, email=?, phone=?, personnelcategory_id=?, "
                . "maxhoursperday=?, maxhoursperweek=?, admin=? "
                . "WHERE id=?";
        $query = getDatabaseConnection()->prepare($sql);
        $ok = $query->execute(array_values($employeeDataArray));
        return $ok;
    }

    public static function getEmployees() {
        $sql = "SELECT * from employee";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $results[] = Employee::createEmployeeFromData($result);
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
            return Employee::createEmployeeFromData($result);
        }
    }

    public static function getEmployeeByID($id) {
        $sql = "SELECT * FROM employee WHERE id = ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($id));

        $result = $query->fetchObject();
        if ($result == null) {
            return null;
        } else {
            return Employee::createEmployeeFromData($result);
        }
    }

    public static function createEmployeeFromData($data) {
        $employee = new Employee();
        $employee->id = $data->id;
        $employee->password = $data->password;
        $employee->setFirstName($data->firstname);
        $employee->setLastName($data->lastname);
        $employee->setSocialSecurityNumber($data->ssn);
        $employee->setAddress($data->address);
        $employee->setEmail($data->email);
        $employee->setPhone($data->phone);
        $employee->setPersonnelCategory($data->personnelcategory_id);
        $employee->setMaxHourPerAWeek($data->maxhoursperweek);
        $employee->setMaxHoursPerDay($data->maxhoursperday);
        $employee->setAdmin($data->admin);
        return $employee;
    }

    public static function removeEmployeeFromDatabase($id) {
        $sql = "DELETE FROM employee WHERE id = ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($id));
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
