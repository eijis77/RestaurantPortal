<?php
    $mysqli = new mysqli("localhost", "root", "Toriaezu@0705","shinjinkadai_deta");
    if ($mysqli->connect_error)
    {
        echo $mysqli->connect_error;
        exit();
    }
    else
    {
        $mysqli->set_charset("utf8");
    }


    try
    {
        $sql_shop = "SELECT * FROM shopdata";
        $sql_shop_result = $mysqli->query($sql_shop);

        foreach ($sql_shop_result as $value)
        {
            $temp = array();

            $temp = ['id'=>$value['id'],
                     'name'=>$value['name'],
                     'address'=>$value['address'],
                     'genre'=>$value['genre'],
                     'number'=>$value['number']
                    ];
            $data[] = $temp;
        }

        $php_json = json_encode($data, JSON_UNESCAPED_UNICODE);
        // $geo_data = var_dump($php_json);
        echo $php_json;

    }  catch(PDOException $e) {
        echo $e->getMessage();
        die();
    }

    $mysqli->close();

 ?>
