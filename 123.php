<?php
echo "<link rel='stylesheet' href='styles.css'>";
$fruits = array('Яблоки' => '30кг', 'Груши' => '50кг', 'Бананы' => '20кг');
$vegetables = array('Картошка' => '100кг', 'Огурцы' => '80кг', 'Помидоры' => '50кг');
$berries = array('Вишня' => '20кг', 'Виноград' => '30кг', 'Малина' => '50кг');

$searchText = mb_strtolower($_GET['searchText']);

if(isset($_GET['searchSubmit'])){
    if($searchText == 'фрукты')
        $products = $fruits;
    elseif ($searchText == 'овощи')
        $products = $vegetables;
    elseif ($searchText == 'ягоды')
        $products = $berries;

    echo '<table>
              <thead>
                 <td>Продукт</td>
                 <td>Количество</td>
              </thead>';
    foreach ((array)$products as $key => $value) {
        echo '<tr>
                   <td>'. $key .'</td>
                   <td>'. $value .'</td>
               </tr>';
    }
    echo '<table>';
}