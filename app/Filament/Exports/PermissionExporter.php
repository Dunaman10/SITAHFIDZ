<?php

namespace App\Filament\Exports;

use App\Models\Permission;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class PermissionExporter extends Exporter
{
  protected static ?string $model = Permission::class;

  public static function getColumns(): array
  {
    return [
      ExportColumn::make('student.student_name')
        ->label('Nama Santri'),
      ExportColumn::make('reason')
        ->label('Alasan Izin'),
      ExportColumn::make('date_out')
        ->label('Tanggal Keluar'),
      ExportColumn::make('date_in')
        ->label('Tanggal Kembali'),
      ExportColumn::make('status')
        ->label('Status'),
      ExportColumn::make('approved_by')
        ->label('Disetujui Oleh'),
    ];
  }

  public static function getCompletedNotificationBody(Export $export): string
  {
    $body = 'Your permission export has completed and ' . number_format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

    if ($failedRowsCount = $export->getFailedRowsCount()) {
      $body .= ' ' . number_format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
    }

    return $body;
  }
}
