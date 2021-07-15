<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salaries
    </title>
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
        user_id
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

        /*$users = [
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
                'user_id' => '  2',
                'position_id' => '3',
                'salary' => '9000'
                
            ],
            [
                'id' => '10',
                'date' => '2001-04-01',
                'user_id' => ' 2',
                'position_id' => '4',
                'salary' => '18000'
                
            ],
            
            
        ]; */

        $mysqli = new mysqli('localhost', 'root', '', database: 'salaries');

        $result = $mysqli->query("SELECT * FROM salaries");

        if (!(mysqli_affected_rows($mysqli) > 500)) {

           
            
        }

        $salaries = mysqli_fetch_all($result, MYSQLI_ASSOC);
        
        $result = $mysqli->query("SELECT * FROM positions");
        $positions = mysqli_fetch_all($result, MYSQLI_ASSOC);

        $result = $mysqli->query("SELECT * FROM users");
        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);


        function preparation_data ($array) {
            $new_array = [];
            foreach ($array as $value){
                $new_array[intval($value['id'])] = $value;
            }
            
            return $new_array;
        }

        function salary_sort($key){
            return function ($a, $b) use ($key) {
                if ($a[$key] == $b[$key]) {
                    return 0;
                }
                return ($a[$key] > $b[$key]) ? -1 : 1;
            }; 
        }

        $processed_users = preparation_data($users);
        $processed_positions = preparation_data($positions);              

        // Главный боос-цикл foreach (Существует чтобы брать последнюю зарплату и добавлять имена и должности вместо id )
        $last_salaries_by_user = [];
        foreach ($salaries as $salary){
            
            if (!isset($salary['salary']) or $salary['salary'] == '0' or !isset($salary['position_id'])) continue;
            
            $salary['user_id'] = intval($salary['user_id']);

            $salary['user_name'] = (isset($processed_users[$salary['user_id']])?$processed_users[$salary['user_id']]['name']:null);
            $salary['position_name'] = (isset($processed_positions[$salary['position_id']])?$processed_positions[$salary['position_id']]['name']:null);

            $element =& $last_salaries_by_user[$salary['user_id']];
            if (!isset($element)) { 
                $element = $salary;         
            } else {
                
                if (strtotime($salary['date']) > strtotime($element['date'])){
                    $element = $salary;
                }
            }
        }
        
        usort($last_salaries_by_user, salary_sort('salary'));

        foreach ($last_salaries_by_user as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row['user_id'] . "</td>";
            echo "<td>" . ( isset($row['user_name']) ? $row['user_name'] : $row['user_id'] ) . "</td>";
            echo "<td>" . ( isset($row['position_name']) ? $row['position_name'] : $row['position_id'] ) . "</td>";
            echo "<td>" . $row['salary'] . "</td>";
            echo "</tr>";
        }
    ?>

</table>
</body>
</html>