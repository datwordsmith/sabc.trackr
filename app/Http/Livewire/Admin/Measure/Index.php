<?php

namespace App\Http\Livewire\Admin\Measure;

use App\Models\Measure;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $unit_id, $name;
    public $search;

    public function rules()
    {
        return [
            'name' => 'required|string',
        ];
    }

    public function resetInput() {
        $this->name = NULL;
    }

    public function storeUnit()
    {
        $validatedData = $this->validate();

        Measure::create($validatedData);
        session()->flash('message', 'Unit Added Successfully');

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editUnit(int $unit_id)
    {
        $unit = Measure::FindOrFail($unit_id);
        $this->unit_id = $unit_id;
        $this->name = $unit->name;
    }

    public function updateUnit()
    {
        $validatedData = $this->validate();

        $unit = Measure::findOrFail($this->unit_id);
        $unit->update($validatedData);

        session()->flash('message', 'Unit Updated Successfully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deleteUnit($unit_id)
    {
        $this->unit_id = $unit_id;
    }

    public function destroyUnit()
    {
        try {
            $unit = Measure::FindOrFail($this->unit_id);
            $unit->delete();
            session()->flash('message', 'Unit deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete unit because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the unit.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the unit.');
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function closeModal() {
        $this->resetInput();
    }

    public function openModal() {
        $this->resetInput();
    }

    public function render()
    {
        $units = Measure::where('name', 'like', '%'.$this->search.'%')
                 ->orderBy('name', 'ASC')
                 ->paginate(10);
        return view('livewire.admin.measure.index', ['units' => $units])->extends('layouts.admin')->section('content');
    }

}
