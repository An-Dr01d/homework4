<?php
include 'autoload.php';

$user1 = new \App\base(26, 1, 30,true, false);
echo "Сумма \"Базового\" = ";
echo $user1->countAge(); //проверка на диапазон возроста
echo $user1->yearsCounter().' руб.';
echo '<br>';
$user2 = new \App\onAnHour(26, 40, 30,false, false);
echo "Сумма \"Почасового\" = ";
echo $user2->countAge();
echo $user2->yearsCounter().' руб.';
echo '<br>';
$user3 = new \App\onTheDay(26, 40, 30,false, false);
echo "Сумма \"Суточного\" = ";
echo $user3->countAge();
echo $user3->yearsCounter().' руб.';
echo '<br>';
$user4 = new \App\forStudents(26, 40, 30,false, false);
echo "Сумма \"Студенческого\" = ";
echo $user4->countAge();
echo $user4->yearsCounter().' руб.';
echo '<br>';