<?php

namespace App\Imports;

use App\Models\TrackList;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;

class TracksImport implements ToModel, SkipsOnError
{

    use Importable;
    private $date;

    public function __construct(string $date)
    {
        $this->date = $date;
    }
    /**
     * @param \Throwable $e
     */
    public function onError(\Throwable $e)
    {
        // Handle the exception how you'd like.
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Пустые строки в конце файла приходят как null — пропускаем их,
        // иначе в базу попадают записи с пустым трек кодом.
        if (! isset($row[0]) || trim((string) $row[0]) === '') {
            return null;
        }

        return new TrackList([
            'track_code' => $row[0],
            'to_china' => $this->date,
            'status' => 'Получено в Китае',
            'reg_china' => 1,
            'created_at' => date(now()),
        ]);
    }
}
