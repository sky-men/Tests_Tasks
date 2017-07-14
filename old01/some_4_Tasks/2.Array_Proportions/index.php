<?php


class Proportions
{
    protected $z = 1;

    public function getKeyByProportions(array $array)
    {
        asort($array);

        foreach ($array as $key => $value) {

            if ($this->is_int($value * $this->z)) {
                $this->z++;
                return $key;
            }
        }

        $this->z++;

        return null;
    }

    protected function is_int($num)
    {
        $num = (float)$num;

        $num = sprintf("%01.4f", $num);

        $num = (int)substr($num, strrpos($num, '.') + 1);

        if ($num !== 0)
            return false;
        else
            return true;
    }
}


$proportions = new Proportions;

$array = [
    'a' => 1 / 2,
    'b' => 1 / 8,
];

$count_runs = 10;

for ($i = 1; $i <= $count_runs; $i++) {
    $key = $proportions->getKeyByProportions($array);

    if ($key)
        echo "Run Number: $i. Key: <b>$key</b> <br>";
}