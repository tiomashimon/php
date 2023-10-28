<!DOCTYPE html>
<html>
<head>
    <title>Список студентів</title>
</head>
<body>
    <h1>Список студентів</h1>

    <?php
    $students = [];

    // Функція для завантаження даних із CSV файлу
    function loadStudentsFromCSV($filename) {
        $students = [];
        if (($handle = fopen($filename, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $students[] = [
                    'id' => $data[0],
                    'name' => $data[1],
                    'course' => $data[2],
                    'specialty' => $data[3],
                ];
            }
            fclose($handle);
        }
        return $students;
    }

    // Функція для збереження даних у CSV файлі
    function saveStudentsToCSV($filename, $students) {
        $handle = fopen($filename, "w");
        foreach ($students as $student) {
            fputcsv($handle, $student);
        }
        fclose($handle);
    }

    $csvFileName = 'students.csv';

    // Перевірка наявності параметра "sort" у URL
    $sortOrder = isset($_GET['sort']) ? ($_GET['sort'] == 'asc' ? 'asc' : 'desc') : 'asc';

    if (file_exists($csvFileName)) {
        $students = loadStudentsFromCSV($csvFileName);
    }

    if (isset($_POST['name']) && isset($_POST['course']) && isset($_POST['specialty'])) {
        $newStudent = [
            'id' => count($students) + 1,
            'name' => $_POST['name'],
            'course' => $_POST['course'],
            'specialty' => $_POST['specialty'],
        ];

        $students[] = $newStudent;
        saveStudentsToCSV($csvFileName, $students);
    }
    
    // Сортування студентів за іменем
    usort($students, function ($a, $b) use ($sortOrder) {
        return ($sortOrder == 'asc') ? strcmp($a['name'], $b['name']) : strcmp($b['name'], $a['name']);
    });
    ?>

    <?php include('templates/students_sort.phtml'); ?>

    <form method="post">
        <label for="name">ПІБ:</label>
        <input type="text" id="name" name="name" required>
        <label for="course">Курс:</label>
        <input type="number" id="course" name="course" required>
        <label for="specialty">Спеціальність:</label>
        <input type="text" id="specialty" name="specialty" required>
        <button type="submit">Додати студента</button>
    </form>

    <?php include('templates/students_table.phtml'); ?>
</body>
</html>
