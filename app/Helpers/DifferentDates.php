<?php

namespace App\Helpers;

class DifferentDates
{
    public function dateFormat($date)
    {
        $data_atual = date_create(date('y-m-d'));
        $data_recebido = date_create(date_format($date, 'y-m-d'));

        $diff = date_diff($data_atual, $data_recebido);

        $year = intval($diff->format("%y"));
        $month = intval($diff->format("%m"));
        $days = intval($diff->format("%d"));
        $result = 0;

        if ($year > 0) {
            $result = [
                'anos' => $year == 1 ? strval($year . ' ano') : strval($year . ' anos'),
                'meses' => $month == 1 ? strval($month . ' mês') : strval($month . ' meses')
            ];
        } elseif ($month > 0 && $month <= 12) {
            $result = [
                'meses' => $month == 1 ? strval($month . ' mês') : strval($month . ' meses'),
                'dias' => $days == 1 ? strval($days . ' dia') : strval($days . ' dias')
            ];
        } elseif ($days <= 31) {
            $result = ['dias' => $days == 1 ? strval($days . ' dia') : strval($days . ' dias')];
        }

        return $result;
    }
}
