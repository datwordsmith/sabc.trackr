<?php

namespace App\Http\Livewire\Admin\Material;

use App\Models\Measure;
use Livewire\Component;
use App\Models\Material;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\MaterialCategory;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $material_id, $name, $slug, $category_id, $unit_id;
    public $search;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'category_id' => 'required|numeric|min:1|exists:material_category,id',
            'unit_id' => 'required|numeric|min:1|exists:measures,id'
        ];
    }

    public function mount()
    {
        $this->categories = MaterialCategory::all();
        $this->units = Measure::all();
    }

    public function resetInput() {
        $this->name = NULL;
        $this->category_id = NULL;
        $this->unit_id = NULL;
    }

    public function closeModal() {
        $this->resetInput();
    }

    public function openModal() {
        $this->resetInput();
    }

    public function storeMaterial()
    {
        $validatedData = $this->validate();
        $validatedData['slug'] = Str::slug($validatedData['name']);

        Material::create($validatedData);
        session()->flash('message', 'Material Added Successfully');

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editMaterial(int $material_id)
    {
        $material = Material::FindOrFail($material_id);
        $this->material_id = $material_id;
        $this->name = $material->name;
        $this->category_id = $material->category_id;
        $this->unit_id = $material->unit_id;
    }

    public function updateMaterial()
    {
        $validatedData = $this->validate();
        $validatedData['slug'] = Str::slug($validatedData['name']);

        $material = Material::findOrFail($this->material_id);
        $material->update($validatedData);

        session()->flash('message', 'Material Updated Successfully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deleteMaterial($material_id)
    {
        $this->material_id = $material_id;
    }

    public function destroyMaterial()
    {
        try {
            $material = Material::FindOrFail($this->material_id);
            $material->delete();
            session()->flash('message', 'Material deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete material because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the material.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the material.');
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();

    }

    public function render()
    {
        $materials = Material::where('materials.name', 'like', '%'.$this->search.'%')
                ->join('material_category', 'materials.category_id', '=', 'material_category.id')
                ->join('measures', 'materials.unit_id', '=', 'measures.id')
                ->select('materials.*', 'material_category.category as category', 'measures.name as unit')
                ->orderBy('materials.name', 'ASC')
                ->paginate(10);
        return view('livewire.admin.material.index',
            [
                'materials' => $materials,
            ])
            ->extends('layouts.admin')->section('content');
    }
}
