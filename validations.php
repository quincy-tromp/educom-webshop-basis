<?php

function cleanData($data) {
    foreach ($_POST as $key => $value) {
        $value = trim($value);
        $value = stripslashes($value);
        $value = htmlspecialchars($value);

        if ($key == "page") {
            $data["page"] = $value;
        }
        else {
            $data["values"][$key] = $value;
        }
    }
    return $data;
}

function validateFields($data) {
    foreach ($data["values"] as $key => $value) {
        if (empty($value)) {
            $data["errors"][$key] = ucfirst(str_replace("_", " ", $key)) .  " is required";
        }
        else {
            switch($key) {
                case "name":
                    if (!preg_match("/^[a-zA-Z-' ]*$/",$data["values"]["name"])) {
                        $data["errors"]["name"] = "Only letters and white space allowed";
                        break;
                    }
                case "email":
                    if (!filter_var($data["values"]["email"], FILTER_VALIDATE_EMAIL)) {
                        $data["errors"]["email"] = "Invalid email format";
                        break;
                    }
        if ($data["page"] == "register") {
            if ($data["values"]["confirm_password"] != $data["values"]["password"]) {
                $data["errors"]["confirm_password"] = "Passwords do not match";
                break;
            }
        }
            } 
        } 
    }
    return $data;
}

function validateData($data) {
    if (empty($data["errors"])) {
        $data["valid"] = true;
    }
    return $data;
}

function validateContact() {
    $contact_fields = array("gender"=>"","name"=>"","email"=>"","phone"=>"","subject"=>"","communication_preference"=>"","message"=>"");
    $data = array("values" => $contact_fields, "errors" => array(), "valid" => false);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = cleanData($data);
        $data = validateFields($data);
        $data = validateData($data);
    }
    return $data;
}

function validateRegister() {
    $register_fields = array("email"=>"","name"=>"","password"=>"","confirm_password"=>"");
    $data = array("values"=>$register_fields,"errors"=>array(),"valid"=>false);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $data = cleanData($data);
        $data = validateFields($data);
        $data = validateData($data);
    }
    return $data;
}

function validateUser($data) {
    $users_file = fopen("users/users.txt", "r") or die("Unable to open file.");
    $existing_users = fread($users_file, filesize("users/users.txt"));
    if (str_contains($existing_users, $data["values"]["email"])) {
        $data["errors"]["user"] = "A user with that same email already exists";
    }
    fclose($users_file);
    return $data;
}

function storeUser($data) {
    fopen("users/users.txt", "a");
    validateUser($data);
}