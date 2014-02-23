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

    public function getPassword() {
        return $this->password;
    }

    public function getFirstName() {
        return $this->firstname;
    }

    public function getLastName() {
        return $this->lastname;
    }

    public function getSSN() {
        return $this->ssn;
    }

    public function getAddress() {
        return $this->address;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getPhone() {
        return $this->phone;
    }

    public function getPersonnelCategoryID() {
        return $this->personnelcategory_id;
    }

    public function getMaxHoursPerWeek() {
        return $this->maxhoursperweek;
    }

    public function getMaxHoursPerDay() {
        return $this->maxhoursperday;
    }

    public function isAdmin() {
        return $this->admin;
    }

    private function setId($id) {
        $this->id = $id;
    }

    private function setPassword($password) {
        $this->password = $password;
    }

    public function setFirstname($firstname) {
        $this->firstname = trim($firstname);
        if (empty($this->firstname)) {
            $this->errors['firstname'] = "Etunimi puuttuu. ";
        } else {
            unset($this->errors['firstname']);
        }
    }

    public function setLastname($lastname) {
        $this->lastname = trim($lastname);
        if (empty($this->lastname)) {
            $this->errors['lastname'] = "Sukunimi puuttuu. ";
        } else {
            unset($this->errors['lastname']);
        }
    }

    public function setSSN($socialsecuritynumber) {
        $this->ssn = trim($socialsecuritynumber);
        if (strlen($this->ssn) != 11) {
            $this->errors['ssnLength'] = "Henkilötunnuksen on oltava 11 merkkiä pitkä. ";
        } else {
            unset($this->errors['ssnLength']);
        }
        if ($this->ssnInUse($this->ssn)) {
            $this->errors['ssnInUse'] = "Henkilötunnuksen on oltava uniikki. ";
        } else {
            unset($this->errors['ssnInUse']);
        }
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

    public function setPersonnelcategory_id($category) {
        $this->personnelcategory_id = $category;
    }

    public function setMaxhoursperweek($maxhours) {
        $this->maxhoursperweek = $maxhours;
        if (empty($maxhours)) {
            $this->errors['maxhoursperweek'] = "Maksimitunnit viikossa puuttuu. ";
        } else if (!is_numeric($maxhours)) {
            $this->errors['maxhoursperweek'] = "Maksimitunnit viikossa on oltava kokonaisluku. ";
        } else {
            unset($this->errors['maxhoursperweek']);
        }
    }

    public function setMaxhoursperday($maxhours) {
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

    public function setFromDataObject($data) {
        if (is_object($data) && count($data)) {
            $valid = get_class_vars(get_class($this));
            foreach ($valid as $var => $val) {
                if (isset($data->$var)) {
                    call_user_func(array($this, 'set' . ucfirst($var)), $data->$var);
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
        $data = array('id' => $id, 'password' => $password, 'firstname' => $firstname,
            'lastname' => $lastname, 'ssn' => $ssn, 'address' => $address,
            'email' => $email, 'phone' => $phone, 'personnelcategory_id' => $pcategory,
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
        $employeeDataArray = $this->getAsDataArray();
        $employeeDataArray['password'] = Employee::generatePassword();
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
        return $query->execute(array_values($employeeDataArray));
    }

    private function ssnInUse($ssn) {
        $sql = "SELECT id FROM employee WHERE ssn = ?";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute(array($ssn));

        $rows = 0;
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $rows++;
        }
        return $rows > 0;
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
    
    public static function getEmployeesWithShiftLimitDetails() {
        $sql = "SELECT id, firstname, lastname, personnelcategory_id,"
                . "maxhoursperweek, maxhoursperday FROM employee";
        $query = getDatabaseConnection()->prepare($sql);
        $query->execute();

        $results = array();
        foreach ($query->fetchAll(PDO::FETCH_OBJ) as $result) {
            $employee = new Employee();
            $employee->setId($result->id);
            $employee->setFirstname($result->firstname);
            $employee->setLastname($result->lastname);
            $employee->setPersonnelcategory_id($result->personnelcategory_id);
            $employee->setMaxhoursperweek($result->maxhoursperweek);
            $employee->setMaxhoursperday($result->maxhoursperday);
            $results[$result->id] = $employee;
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
        $employee->setFromDataObject((object) $data);
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
