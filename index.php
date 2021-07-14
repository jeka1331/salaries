<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>Зарплаты</h2>
<table border="1px"> 
    <tr>
        <th>
        id
        </th>
        <th>
        date
        </th>
        <th>
        user_name
        </th>
        <th>
        position_name
        </th>
        <th>
        salary
        </th>
        
    </tr>

    <?php 

        $users = [
            [
                'id' => '1',
                'name' => 'Andrey'
            ],
            [
                'id' => '2',
                'name' => 'Boris'
            ],
            [
                'id' => '3',
                'name' => 'Anna'
            ],
            [
                'id' => '4',
                'name' => 'Anton'
            ],
            [
                'id' => '5',
                'name' => 'Maksim'
            ],
            [
                'id' => '6',
                'name' => 'Lena'
            ]
        ];

        $positions = [
            [
                'id' => '1',
                'name' => 'Stazher'
            ],
            [
                'id' => '2',
                'name' => 'Tech'
            ],
            [
                'id' => '3',
                'name' => 'Special'
            ],
            [
                'id' => '4',
                'name' => 'Program'
            ]
        ];

        $salaries = [
            [
                'id' => '1',
                'date' => '2001-01-01',
                'user_id' => '1',
                'position_id' => '4',
                'salary' => '9500'
                
            ],
            [
                'id' => '2',
                'date' => '2001-01-01',
                'user_id' => '2',
                'position_id' => '1',
                'salary' => '500'
                
            ],
            [
                'id' => '3',
                'date' => '2001-01-01',
                'user_id' => '3',
                'position_id' => '3',
                'salary' => '4500'
                
            ],            
            [
                'id' => '4',
                'date' => '2001-01-01',
                'user_id' => '4',
                'position_id' => '3',
                'salary' => '4000'
                
            ],
            [
                'id' => '5',
                'date' => '2001-02-01',
                'user_id' => '5',
                'position_id' => '4',
                'salary' => '7500'
                
            ],
            [
                'id' => '6',
                'date' => '2001-02-01',
                'user_id' => '2',
                'position_id' => '2',
                'salary' => '2000'
                
            ],
            [
                'id' => '7',
                'date' => '2001-02-01',
                'user_id' => '6',
                'position_id' => NULL,
                'salary' => '5000'
                
            ],
            [
                'id' => '8',
                'date' => '2001-02-01',
                'user_id' => '6',
                'position_id' => '3',
                'salary' => '0'
                
            ],
            [
                'id' => '9',
                'date' => '2001-03-01',
                'user_id' => '2',
                'position_id' => '3',
                'salary' => '9000'
                
            ],
            [
                'id' => '10',
                'date' => '2001-04-01',
                'user_id' => '2',
                'position_id' => '4',
                'salary' => '18000'
                
            ],
            
            
        ];

        function preparation_data ($array) {
            $new_array = [];
            foreach ($array as $value){
                $new_array[$value['id']] = $value;
            }
            
            return $new_array;
        }

        function salary_sort($key){
            return function ($a, $b) use ($key) {
                if (intval($a[$key]) == intval($b[$key])) {
                    return 0;
                }
                return (intval($a[$key]) > intval($b[$key])) ? -1 : 1;
            }; 
        }

        $processed_users = preparation_data($users);
        $processed_positions = preparation_data($positions);
                      
        $last_salaries = [];


        // Главный боос-цикл foreach (Существует чтобы братьпоследнюю зарплату)
        foreach ($salaries as $key => $salary){
            
            if (!isset($salary['salary'])  || 
            $salary['salary'] == '0' || 
            !isset($salary['position_id'])) {continue; }

            if (!in_array($salary['user_id'], array_column($last_salaries, 'user_id', 'id'))) { 
                
                $last_salaries[intval($salary['id'])] = $salary; 
                

            } else {
                $last_user_key = array_search($salary['user_id'], array_column($last_salaries, 'user_id', 'id'));


                if (strtotime($salary['date']) > strtotime($last_salaries[$last_user_key]['date'])){
                    unset($last_salaries[$last_user_key]);
                    $last_salaries[intval($salary['id'])] = $salary;
                    

                }
            }
        }
        

        usort($last_salaries, salary_sort('salary'));

        // Цикл переименований (Существует, чтобы не делать бесполезные действия в foreach выше и помогает сократить немного количество кода)
        // Можно перенести в главный foreach при надобности, но тогда для элементов массива придется изменять поле 'user_id' на массив со значениями
        // 'id' и 'name'
        foreach ($last_salaries as $key => $salary){

            if (isset($processed_users[$salary['user_id']])){

                $last_salaries[$key]['user_id'] = array("id" => $last_salaries[$key]['user_id'], 
                "name" => $processed_users[$salary['user_id']]['name']);

            }
            if (isset($processed_positions[$salary['position_id']])){
                
                $last_salaries[$key]['position_id'] = array( "id" => $last_salaries[$key]['position_id'], 
                "name" => $processed_positions[$salary['position_id']]['name']);
            
            }
              
        }
        


        foreach ($last_salaries as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . (is_array($row['user_id']) ? $row['user_id']['name'] : $row['user_id']) . "</td>";
            echo "<td>" . (is_array($row['position_id']) ? $row['position_id']['name'] : $row['position_id']) . "</td>";
            echo "<td>" . $row['salary'] . "</td>";
            echo "</tr>";
        }
    ?>

</table>
</body>
</html>