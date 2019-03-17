<?php

class db //оголошуються параметри з'єднання з БД'
{

    const HOST = "localhost"; // хост БД

    const USER = "emlysvap_muskul"; // користувач БД

    const PASSWORD = "emlysvap_muskul"; // ПАРОЛЬ

    const BASE = "emlysvap_muskul"; // база данних

    private $_db; //приватна змінна для роботи з БД

    private static $_mysqli = null;



    private function __construct() //конструктор
    {

        $mysqli = @new mysqli(self::HOST, self::USER, self::PASSWORD, self::BASE); // з'єднання з БД

        if (!$mysqli->connect_error) { //яещо не помилка з'єднання'

            $this->_db = $mysqli; // тоді відбувається створення підключення з БД

            $this->_db->query("SET NAMES 'UTF8'"); //встановлюються кодування UTF 8

            return $mysqli; // і повертається сама база

        }

        else { //інакше

            exit("No connect to server!"); //вивести повідомлення помилки і вийти

        }





    }



    public static function getObject() //функція отримання об'єкта
    {

        $ms = self::$_mysqli;

        if ($ms == null) {//якщо об'єкт  бд пустий

            $base = new db(); //створюється нова

            $ms = $base;

        }

        if (!mysqli_connect_errno()) {

            return $ms; //якщо немає помилок,

        }

    }



    public function assoc($result) //функція створення асоціативного масиву з результату запиту до БД
    {

        if ($result) { //якщо є результат

            $rows = $result->fetch_assoc(); //створити змінну, яку створено як асоціативний масив з результату запиту

            if ($rows) { //і якщо вона існує

                return $rows; //повернути значення

            }

            else {

                return false; //інакше повернути false

            }

        }

        else {

            return false; //інакше повернути false

        }

    }



    public function query($sql) //функція надсилання запиту до бд
    {

        $arg = func_get_args(); // отримуються аргументи

        if (count($arg) > 0) { //кількість більше 0

            $mysqli = db::getObject(); //відбувається з'єднання з БД'

            for ($i = 1; $i < count($arg); $i++) { //обробка аргументів запиту

                $clear_arg = trim($this->_db->real_escape_string($arg[$i])); //отримуються аргументи для заміни в запит



                $sql = str_replace("%item" . $i . "%", $clear_arg, $sql); //заміняються аргументи



            }



            $result = $this->_db->query($sql); //оформлюється запит



            if ($result) {

                return $result; //якщо є результат ,повернути його

            }

            else {

                return false; //інакше повернути false

            }



        }

        else {

            throw new Exception("3");

        }

    }



}

?>
