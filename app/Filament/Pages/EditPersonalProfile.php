<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use App\Models\Employee;
use Filament\Actions\Action;
use Filament\Support\Exceptions\Halt;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class EditPersonalProfile extends Page implements HasForms
{ 
    use InteractsWithForms;

    public ?array $data = [];

    public Employee $post;

    public $name= '';

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationLabel = 'Profile';

    protected static string $view = 'filament.pages.edit-personal-profile';

    public function mount(): void
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        
        // Retrieve the employee record associated with the authenticated user
        $this->post = $user->employee ?? new Employee(); // If no employee record is associated, create a new one

        // Fill the form with data
        $this->form->fill($this->post->toArray());
    }

    public function form(Form $form): Form {
        return $form
        
            ->schema([
            Section::make('Personal Profile')
            ->schema([
                Forms\Components\TextInput::make('last_name')
                ->required()
                ->maxLength(255),
                Forms\Components\TextInput::make('first_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('middle_name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('gender')
                    ->required()
                    ->label('Sex')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                    ])
                    ->native(false),
                Forms\Components\DatePicker::make('birth_date')
                    ->required(),
                Forms\Components\Select::make('civil_status')
                    ->required()
                    ->options([
                        'single' => 'Single',
                        'married' => 'Married',
                        'widowed' => 'Widowed',
                        'divorced' => 'Divorced',
                    ])
                    ->native(false),
                Forms\Components\TextInput::make('mobile_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('address')
                    ->required()
                    ->columnSpan('full')
                    ->maxLength(255),
                ])
                ->columns(2),
            Section::make()
                ->schema([
                    Forms\Components\TextInput::make('tin')
                        ->label('TIN'),
                    Forms\Components\TextInput::make('sss')
                        ->label('SSS'),
                    Forms\Components\TextInput::make('philhealth')
                        ->label('Philhealth'),
                    Forms\Components\TextInput::make('pagibig')
                        ->label('Pag-Ibig'),
                    ])
                    ->columns(4),
            Section::make('In case of emergency, contact:')
                ->schema([
                    Forms\Components\TextInput::make('contact_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('contact_number')
                        ->required()
                        ->numeric(),
                    Forms\Components\TextInput::make('relationship')
                        ->required()
                        ->maxLength(255),
                    ])
                    ->columns(3),
                    ])
                ->statePath('data');
            }
    
    protected function getFormActions(): array
        {
            return [
                Action::make('save')
                    ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                    ->submit('save'),
            ];
        }
        
    public function save(): void
        {
            try {
                // Retrieve the authenticated user
                $user = Auth::user();
    
                // Retrieve the associated employee record or create a new one
                $employee = $user->employee ?? new Employee();
    
                $employee->fill($this->form->getState()); // Fill the model with form data
    
                $employee->save(); // Save the model to the database
    
            } catch (Halt $exception) {
                return;
            }
            Notification::make()
                ->success()
                ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
                ->send();
    
        }
}
