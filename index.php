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

        function array_unique_key($array, $key) { 
            $temp = $key_array = array(); 
            $i = 0; 
            foreach($array as $val) { 
                if (!in_array($val[$key], $key_array)) { 
                    $key_array[$i] = $val[$key]; 
                    $temp[$i] = $val; 
                } 
                $i++; 
            } 
            return $temp; 
        }        

        function preparation_data ($array) {
            $new_array = [];
            foreach ($array as $value){
                $new_array[$value['id']] = $value;
            }
            
            return $new_array;
        }

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
            
            
        ];

        $processed_users = preparation_data($users);
        $processed_positions = preparation_data($positions);

        
        

    
        $result = [];
        foreach ($salaries as $key => $salary){    
            if (!isset($salary['salary'])  || 
            $salary['salary'] == '0' || 
            !isset($salary['position_id'])){  
                continue;
            }

            array_push($result, $salary);

            if (isset($processed_users[$salary['user_id']])){
                
                $result[$key]['user_id'] = $processed_users[$salary['user_id']]['name'];

            }
            if (isset($processed_positions[$salary['position_id']])){
                
                $result[$key]['position_id'] = $processed_positions[$salary['position_id']]['name'];

            }
            
            
            
        }
        $slrs_column = array_column($result, 'date');
        array_multisort($slrs_column, SORT_DESC , $result);
        $result = array_unique_key($result, 'user_id');
        $slrs_column = array_column($result, 'salary');
        array_multisort($slrs_column, SORT_DESC | SORT_NUMERIC , $result);

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["user_id"] . "</td>";
            echo "<td>" . $row['position_id'] . "</td>";
            echo "<td>" . $row['salary'] . "</td>";
            echo "</tr>";
        }
    ?>

</table>
</body>
</html>