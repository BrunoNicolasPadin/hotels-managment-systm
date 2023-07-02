<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class HotelsExport implements FromArray, WithHeadings, WithMapping
{
    protected array $hotels;

    public function __construct(array $hotels)
    {
        $this->hotels = $hotels;
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Description',
            'Type',
            'Address',
        ];
    }

    public function map($hotel): array
    {
        return [
            $hotel['id'],
            $hotel['name'],
            $hotel['description'],
            $hotel['type']['label'],
            $hotel['address'],
        ];
    }

    public function array(): array
    {
        return $this->hotels;
    }

    public function title(): string
    {
        return 'Hotels';
    }
}
