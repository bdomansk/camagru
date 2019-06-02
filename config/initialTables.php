<?php

return [
    "CREATE TABLE IF NOT EXISTS images SELECT * FROM information_schema.COLLATIONS",
    "CREATE TABLE IF NOT EXISTS users (
    `id` INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `login` VARCHAR(32) NOT NULL,
    `password` VARCHAR(60) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `role` ENUM('user', 'admin')
    );"
]

?>