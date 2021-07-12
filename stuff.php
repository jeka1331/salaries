function replace_userid ($salaries, $users){
            $slrs = $salaries;
            foreach ($slrs as $key => $salary){
                foreach($users as $user){
                    if ($salary['user_id'] == $user['id']){
                        $slrs[$key]['user_id'] = $user['name']; 
                    }
                }
            }

            
        return $slrs; 
        }

        function replace_positionid ($salaries, $positions){
            $slrs = $salaries;
            foreach ($slrs as $key => $salary){
                foreach($positions as $position){
                    if ($salary['position_id'] == $position['id']){
                        $slrs[$key]['position_id'] = $position['name'];                    
                    }
                }
            }

            
        return $slrs; 
        }

        function exclude_null_p ($salaries){
            $slrs = $salaries;
            foreach ($slrs as $key => $salary){
                if (!isset($salary['position_id'])){
                    array_splice($slrs, $key, 1);
                }
            }

            
        return $slrs; 
        }

        function exclude_null_s ($salaries){
            $slrs = $salaries;
            foreach ($slrs as $key => $salary){
                if (!isset($salary['salary'])  || $salary['salary'] == '0' ){
                    array_splice($slrs, $key, 1);
                }
            }

            
        return $slrs; 
        }
        
        

        function salaries_sort ($salaries){
            $slrs = $salaries;
            $slrs_column = array_column($slrs, 'salary');

            array_multisort($slrs_column, SORT_DESC | SORT_NUMERIC , $slrs);

            
        return $slrs; 
        }

        function salaries_includes_only_last_salary ($salaries){
            $slrs = $salaries;
            $slrs_column = array_column($slrs, 'date');
            array_multisort($slrs_column, SORT_DESC , $slrs);
            
            $slrs = array_unique_key($slrs, 'user_id');
            
        return $slrs; 
        }





        $result = replace_userid($salaries, $users);
        $result = replace_positionid($result, $positions);
        $result = exclude_null_p($result);
        $result = exclude_null_s($result);
        $result = salaries_includes_only_last_salary($result);
        $result = salaries_sort($result);
        
        

        foreach ($result as $row) {
            echo "<tr>";
            echo "<td>" . $row["id"] . "</td>";
            echo "<td>" . $row["date"] . "</td>";
            echo "<td>" . $row["user_id"] . "</td>";
            echo "<td>" . $row['position_id'] . "</td>";
            echo "<td>" . $row['salary'] . "</td>";
            echo "</tr>";
        }

        

        function data_viewing_manipulations ($salaries, $users, $positions){
            $slrs = $salaries;
            foreach ($slrs as $key => $salary){
            // (!isset($salary['salary'])  || $salary['salary'] == '0' || !isset($salary['position_id']))    
                if (!isset($salary['salary'])  || 
                $salary['salary'] == '0' || 
                !isset($salary['position_id'])){
                    unset($slrs[$key]);
                    continue;
                }
                // $salary['user_id'] = $users[intval($salary['user_id'])];
                if (isset($users[$salary['user_id']])){
                    
                    $slrs[$key]['user_id'] = $users[$salary['user_id']]['name'];

                }
                if (isset($positions[$salary['position_id']])){
                    
                    $slrs[$key]['position_id'] = $positions[$salary['position_id']]['name'];

                }
                
                
                
            }


            $slrs_column = array_column($slrs, 'date');
            array_multisort($slrs_column, SORT_DESC , $slrs);
            $slrs = array_unique_key($slrs, 'user_id');
            $slrs_column = array_column($slrs, 'salary');
            array_multisort($slrs_column, SORT_DESC | SORT_NUMERIC , $slrs);
            
        return $slrs; 
        }


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