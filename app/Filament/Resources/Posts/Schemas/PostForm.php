<?php

namespace App\Filament\Resources\Posts\Schemas;

use App\Models\Category;
use Dom\Text;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make("Fields")
                    ->description("Fill All The Fields")
                    ->icon(Heroicon::RocketLaunch)
                    ->schema([
                        Group::make()
                            ->schema([
                                TextInput::make('title')->rules(['required', 'min:3', 'max:25']),   // Validation Rules :-"required|min:3") , Array of Rules:- ['required', 'min:3', 'max:25']
                                TextInput::make('slug')->unique()
                                ->validationMessages([
                                    'unique' => 'Slug Should Be Unique.',
                                ]),
                                Select::make("category_id")
                                    ->label("category")
                                    ->options(Category::all()->pluck("name", "id")),
                                ColorPicker::make("color")
                            ])->columns(2),
                        MarkdownEditor::make("body")
                    ])->columnSpan(2),
                Group::make()
                    ->schema([
                        Section::make("Image Upload")
                            ->schema([
                                FileUpload::make("image")->disk("public")->directory("posts")
                            ]),
                        Section::make("Meta")
                            ->schema([
                                TagsInput::make("tags"),
                                Checkbox::make("published"),
                                DatePicker::make("published_at")
                            ])
                    ])->columnSpan(1)

            ])->columns(3);
    }
}
    