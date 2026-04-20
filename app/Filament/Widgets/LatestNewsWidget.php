<?php

namespace App\Filament\Widgets;

use App\Models\News;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestNewsWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    protected static ?string $heading = '📰 Berita Terbaru';
    protected static ?string $pollingInterval = null;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                News::query()->latest('published_at')->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('icon')
                    ->label('')
                    ->width(40),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Berita')
                    ->limit(60)
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Kategori')
                    ->colors([
                        'info'    => 'lalu_lintas',
                        'success' => 'pelayanan',
                        'warning' => 'sosial',
                        'danger'  => 'kriminal',
                        'gray'    => 'umum',
                    ])
                    ->formatStateUsing(fn ($state) => match($state) {
                        'lalu_lintas' => 'Lalu Lintas',
                        'pelayanan'   => 'Pelayanan',
                        'sosial'      => 'Sosial',
                        'kriminal'    => 'Kriminal',
                        'umum'        => 'Umum',
                        default       => $state,
                    }),

                Tables\Columns\TextColumn::make('source')
                    ->label('Sumber')
                    ->limit(25)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_published')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-clock')
                    ->trueColor('success')
                    ->falseColor('warning'),
            ])
            ->actions([
                Tables\Actions\Action::make('edit')
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->url(fn (News $record) => route('filament.admin.resources.news.edit', $record)),
            ])
            ->paginated(false);
    }
}