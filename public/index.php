<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "./../vendor/autoload.php";

Flight::set('flight.views.path', './../src/views');

use App\Errors\ValidationError;
use App\Validators\CategoryValidator;
use App\Validators\SubCategory;

$sqlInsert = <<<SQL
INSERT INTO SHOP (name, category, cat, dog, amphibia, fish, reptile, rodent)
VALUES (:name, :category, :cat, :dog, :amphibia, :fish, :reptile, :rodent)
SQL;

$sqlSearch = "SELECT * FROM SHOP WHERE 1 = 1 ";



Flight::route('/', function () {
    Flight::render('form.php', ['name' => 'Bob', 'type' => 'create']);
});

Flight::register('db', 'PDO', ['sqlite:../src/Sqlite/Shop.db'], function (PDO $db) {
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
});

/** @var PDO $db */
$db = Flight::db();

$db->exec(
    "CREATE TABLE IF NOT EXISTS `SHOP` (
    `id`    INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE,
        `name`  TEXT NOT NULL UNIQUE,
        `category`  TEXT NOT NULL,
        'cat' INTEGER NOT NULL,
        'dog' INTEGER NOT NULL,
        'amphibia' INTEGER NOT NULL,
        'fish' INTEGER NOT NULL,
        'reptile' INTEGER NOT NULL,
        'rodent' INTEGER NOT NULL);"
);

Flight::route('POST /create', function () use ($db, $sqlInsert) {

    $data = Flight::request()->data;
    try {
        foreach ($data as $key => $value) {
            if ($key == 'category') {
                (new CategoryValidator($value))->validate();
            } else {
                if (in_array($key, ["cat","dog","amphibia","fish","rodent","reptile"])) {
                    (new SubCategory($value))->validate();
                }
            }
        }
    } catch (ValidationError $ex) {
        Flight::render('form.php', [
            'error' => $ex->getMessage(),
            'type' => 'create'
        ]);
        return;
    }

    $stmt = $db->prepare($sqlInsert);
    $stmt->bindValue(':name', mb_strtoupper($data->name), SQLITE3_TEXT);
    $stmt->bindValue(':category', $data->category, SQLITE3_TEXT);
    $stmt->bindValue(':cat', (int) $data->cat, SQLITE3_INTEGER);
    $stmt->bindValue(':dog', (int) $data->dog, SQLITE3_INTEGER);
    $stmt->bindValue(':amphibia', (int) $data->amphibia, SQLITE3_INTEGER);
    $stmt->bindValue(':fish', (int) $data->fish, SQLITE3_INTEGER);
    $stmt->bindValue(':reptile', (int) $data->reptile, SQLITE3_INTEGER);
    $stmt->bindValue(':rodent', (int) $data->rodent, SQLITE3_INTEGER);
    $stmt->execute();

    Flight::render('create.php');
});

Flight::route('GET /search', function () {
    Flight::render('form', ['type' => 'search']);
});

Flight::route('POST /search', function () use ($db, $sqlSearch) {
    $data = Flight::request()->data;
    if ($data->category) {
        $sqlSearch .="AND UPPER(category) = UPPER('$data->category')";
    }
    if ($data->name) {
        $upperName = mb_strtoupper(($data->name));
        $sqlSearch .= "AND upper(name) like '%$upperName%'";
    }

    $subcats = [];

    foreach ($data as $key => $value) {
        if ($value == 1) {
            $subcats [$key] = $value;
        }
    }
    $subcats = array_keys($subcats);

    if (count($subcats) == 1) {
        $sqlSearch .= " AND $subcats[0] = 1";
    } elseif (count($subcats) > 1) {
        $sqlSearch .= " AND ($subcats[0] = 1";
        foreach (array_slice($subcats, 1) as $sub) {
            $sqlSearch .= " OR $sub = 1";
        }
        $sqlSearch .= ');';
    }

    $result = $db->query($sqlSearch);
//    var_dump($sqlSearch);
    if ($result != false) {
        $myResult= $result->fetchAll(PDO::FETCH_ASSOC);
        if ($myResult === false) {
            throw new Exception('Server error');
        }
        $headers = [];
        if ($myResult != []) {
            $headers = array_keys($myResult[0]);
        }
        Flight::render('search', ['data' => $myResult, 'headers' => $headers]);
    } else {
        throw new Exception('Server error');
    }
});

Flight::start();
