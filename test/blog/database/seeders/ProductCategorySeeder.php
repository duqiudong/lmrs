<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run () {
        ini_set('memory_limit', '-1');

        $sqlPath = base_path().'/resources/sql/ProductsCategory.sql';
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
            $res = \DB::insert($sql);
            echo "id = $res".PHP_EOL;
            $line--;
        }
        fclose($fp);
        echo "success!";
    }
}
