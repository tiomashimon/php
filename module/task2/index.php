<!DOCTYPE html>
<html>
<head>
    <title>Список студентів</title>
</head>
<body>
    <h1>Список студентів</h1>

    <?php
    // Масив зі списком студентів (замість цього може бути підключення до бази даних)
    $students = [
        ['id' => 1, 'name' => 'Іван Петров', 'course' => 3, 'specialty' => 'Інформатика'],
        ['id' => 2, 'name' => 'Марія Сидорова', 'course' => 2, 'specialty' => 'Економіка'],
        ['id' => 3, 'name' => 'Петро Іванов', 'course' => 4, 'specialty' => 'Медицина'],
        // Додайте інших студентів за потребою
    ];

    if (isset($_GET['sort'])) {
        $sortOrder = ($_GET['sort'] == 'asc') ? 'asc' : 'desc';
        usort($students, function ($a, $b) use ($sortOrder) {
            return ($sortOrder == 'asc') ? strcmp($a['name'], $b['name']) : strcmp($b['name'], $a['name']);
        });
    }
    ?>

    <?php include('templates/students_sort.phtml'); ?>

    <?php include('templates/students_table.phtml'); ?>
</body>
</html>
