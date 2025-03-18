<?php

namespace TemplateTheme;

use App\Classes\Theme;

use App\Facades\Hook;
use App\Forms\Components\TinyEditor;
use App\Frontend\ScheduledConference\Pages\Timelines;
use Filament\Forms\Components\ColorPicker;
use luizbills\CSS_Generator\Generator as CSSGenerator;
use matthieumastadenis\couleur\ColorFactory;
use matthieumastadenis\couleur\ColorSpace;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Blade;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;

class TemplateTheme extends Theme
{
	public function boot()
	{
		Blade::anonymousComponentPath($this->getPluginPath('resources/views/frontend/website/components'), 'lectura');
	}

	public function getFormSchema(): array
	{
		return [
			Toggle::make('top_navigation')
				->label('Enable Top Navigation')
				->default(false),
			SpatieMediaLibraryFileUpload::make('images')
				->collection('lectura-header')
				->label('Upload Header Images')
				->multiple()
				->maxFiles(4)
				->image()
				->conversion('thumb-xl'),
			ColorPicker::make('appearance_color')
				->regex('/^#?(([a-f0-9]{3}){1,2})$/i')
				->label(__('general.appearance_color')),

			// Layouts
			Builder::make('layouts')
				->blocks([
					Builder\Block::make('layouts')
						->schema([
							TextInput::make('name_content')
								->label('Name')
								->required(),
							TinyEditor::make('about')
								->label('About Site')
								->profile('advanced')
								->required(),

						]),

				])
				->reorderableWithButtons()
				->collapsed()
				->reorderableWithDragAndDrop(false),

			Repeater::make('banner_buttons')
				->schema([
					TextInput::make('text')->required(),
					TextInput::make('url')
						->required()
						->url(),
					ColorPicker::make('text_color'),
					ColorPicker::make('background_color'),
				])
				->columns(2),
		];
	}

	public function onActivate(): void
	{
		Hook::add('Frontend::Views::Head', function ($hookName, &$output) {
			$output .= '<script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp,container-queries"></script>';
			$output .= '<link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css" rel="stylesheet" type="text/css" />';
			$css = $this->url('Template.css');
			$output .= "<link rel='stylesheet' type='text/css' href='$css'/> ";

			if ($appearanceColor = $this->getSetting('appearance_color')) {
				$oklch = ColorFactory::new($appearanceColor)->to(ColorSpace::OkLch);
				$css = new CSSGenerator();
				$css->root_variable('p', "{$oklch->lightness}% {$oklch->chroma} {$oklch->hue}");

				$output .= <<<HTML
					<style>
						{$css->get_output()}
					</style>
				HTML;
			}
		});
	}

	public function getFormData(): array
	{
		return [
			'images' => $this->getSetting('images'),
			'appearance_color' => $this->getSetting('appearance_color'),
			'layouts' => $this->getSetting('layouts'),
			'name_content' => $this->getSetting('name_content'),
			'about' => $this->getSetting('about'),
			'top_navigation' => $this->getSetting('top_navigation'),
			'banner_buttons' => $this->getSetting('banner_buttons'),
            'timelines' => \App\Models\Timeline::orderBy('date', 'asc')->get(), // Ambil data timeline
		];
	}
}
