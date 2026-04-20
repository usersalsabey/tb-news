<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialMediaResource\Pages;
use App\Models\SocialMedia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SocialMediaResource extends Resource
{
    protected static ?string $model           = SocialMedia::class;
    protected static ?string $navigationIcon  = 'heroicon-o-share';
    protected static ?string $navigationGroup = 'Konten';
    protected static ?string $navigationLabel = 'Media Sosial';
    protected static ?string $modelLabel      = 'Media Sosial';
    protected static ?int    $navigationSort  = 6;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Detail Akun')
                ->schema([
                    Forms\Components\Select::make('name')
                        ->label('Platform')
                        ->required()
                        ->options([
                            'Instagram' => 'Instagram',
                            'Facebook'  => 'Facebook',
                            'YouTube'   => 'YouTube',
                            'TikTok'    => 'TikTok',
                            'Twitter/X' => 'Twitter/X',
                            'WhatsApp'  => 'WhatsApp',
                        ]),

                    Forms\Components\TextInput::make('handle')
                        ->label('Handle / Username')
                        ->nullable()
                        ->maxLength(100)
                        ->placeholder('@polres.gunungkidul'),

                    Forms\Components\TextInput::make('url')
                        ->label('URL')
                        ->required()
                        ->url()
                        ->maxLength(255)
                        ->placeholder('https://www.instagram.com/polres.gunungkidul/'),

                    Forms\Components\TextInput::make('urutan')
                        ->label('Urutan Tampil')
                        ->numeric()
                        ->default(1),

                    Forms\Components\Toggle::make('is_active')
                        ->label('Aktif')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Platform')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('handle')
                    ->label('Handle')
                    ->placeholder('-'),
                Tables\Columns\TextColumn::make('url')
                    ->label('URL')
                    ->limit(40)
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('urutan')
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListSocialMedia::route('/'),
            'create' => Pages\CreateSocialMedia::route('/create'),
            'edit'   => Pages\EditSocialMedia::route('/{record}/edit'),
        ];
    }
}