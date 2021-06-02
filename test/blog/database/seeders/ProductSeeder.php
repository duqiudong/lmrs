<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run () {
        ini_set('memory_limit', '-1');

        $sqlPath = base_path().'/resources/sql/Products.sql';
        $data = file($sqlPath);

        $line = count($data) - 1;
        $fp = fopen($sqlPath, "r");

        $pos = -2;
        $t = " ";
        while ($line > 0) {
            while ($t != "\n") {
                fseek($fp, $pos, SEEK_END);
                $t = fgetc($fp);
                $pos--;
            }
            $t = " ";
            $sql = fgets($fp);
            if ($sql == "\r\n") continue;

            $sqlDataBack = substr($sql, strrpos($sql, "VALUES"));
            $sqlDataFront = substr($sql, 0,strrpos($sql, "VALUES") - 1);
            $sqlDataFront .= "(id,name,long_name,brand_id,one_category_id,two_category_id,three_category_id,shop_id,price,sold_count,review_count,status,created_at,updated_at,deleted_at) ";
            $res = \DB::insert($sqlDataFront.$sqlDataBack);
            $line--;
        }
        fclose($fp);
        echo "success!";
    }
}
