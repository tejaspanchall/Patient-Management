<?php

namespace App\Livewire;

use App\Models\Patient;
use Livewire\Component;
use Livewire\WithPagination;

class PatientsTable extends Component
{
    use WithPagination;

    public $search = '';
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $perPage = 5;

    public $filterGender = '';
    public $filterBloodGroup = '';

    protected $listeners = ['refreshPatients' => '$refresh'];

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
    }

    public function resetFilters()
    {
    $this->search = '';
    $this->filterGender = '';
    $this->filterBloodGroup = '';
    }

    public function render()
    {
    return view('livewire.patients-table', [
        'patients' => Patient::query()
            ->when($this->search, function($query) {
                $query->where(function($query) {
                    $query->where('first_name', 'like', '%'.$this->search.'%')
                        ->orWhere('last_name', 'like', '%'.$this->search.'%')
                        ->orWhere('email', 'like', '%'.$this->search.'%')
                        ->orWhere('phone_number', 'like', '%'.$this->search.'%');
                });
            })
            ->when($this->filterGender, function($query) {
                $query->where('gender', $this->filterGender);
            })
            ->when($this->filterBloodGroup, function($query) {
                $query->where('blood_group', $this->filterBloodGroup);
            })
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate($this->perPage)
    ]);
    }
}