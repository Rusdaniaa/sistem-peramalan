<?php

namespace App;

class MovingAverage
{
    public $yt;
    public $moving_periode;
    public $next_periode;
    public $ft;
    public $et;
    public $x_kuadrat;

    public $et_square;
    public $et_abs;
    public $et_yt;
    public $error;
    public $next_ft;

    function __construct($yt, $moving_periode, $next_periode)
    {
        $this->yt = $yt;
        $this->moving_periode = $moving_periode;
        $this->next_periode = $next_periode;
        $this->hitung();
    }

    function hitung()
    {
        $temp = [];
        $temp_ft = null;
        foreach ($this->yt as $key => $val) {
            $temp[] = $val;
            $temp = array_slice($temp, -$this->moving_periode);
            if (count($temp) < $this->moving_periode) {
                $this->ft[$key] = null;
            } else {
                $this->ft[$key] = array_sum($temp) / count($temp);
                $temp_ft = $this->ft[$key];

                $this->et[$key] = $this->ft[$key] - $this->yt[$key];
                $this->et_square[$key] = $this->et[$key] * $this->et[$key];
                $this->et_abs[$key] = abs($this->et[$key]);
                $this->et_yt[$key] = abs($this->et[$key] / $this->yt[$key]);
            }
        }

        $this->error['MSE'] = array_sum($this->et_square) / count($this->et_square);
        $this->error['RMSE'] = sqrt($this->error['MSE']);
        $this->error['MAE'] = array_sum($this->et_abs) / count($this->et_abs);
        $this->error['MAPE'] = array_sum($this->et_yt) / count($this->et_yt);

        for ($a = 1; $a <= $this->next_periode; $a++) {
            $temp[] = $temp_ft;
            $temp = array_slice($temp, -$this->moving_periode);
            $this->next_ft[$a] = array_sum($temp) / count($temp);
            $temp_ft = $this->next_ft[$a];
        }
    }
}
