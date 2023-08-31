<?php

namespace App\Http\Livewire\Admin\MaterialCategory;

use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use App\Models\MaterialCategory;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $category_id, $category, $slug;
    public $search;

    public function rules()
    {
        return [
            'category' => 'required|string',
        ];
    }

    public function resetInput() {
        $this->category = NULL;
    }

    public function storeCategory()
    {
        $validatedData = $this->validate();
        $validatedData['slug'] = Str::slug($validatedData['category']);

        MaterialCategory::create($validatedData);
        session()->flash('message', 'Category Added Successfully');

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editCategory(int $category_id)
    {
        $material_category = MaterialCategory::FindOrFail($category_id);
        $this->category_id = $category_id;
        $this->category = $material_category->category;
    }

    public function updateCategory()
    {
        $validatedData = $this->validate();
        $validatedData['slug'] = Str::slug($validatedData['category']);

        $material_category = MaterialCategory::findOrFail($this->category_id);
        $material_category->update($validatedData);

        session()->flash('message', 'Category Updated Successfully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deleteCategory($category_id)
    {
        $this->category_id = $category_id;
    }

    public function destroyCategory()
    {

        try {
            $material_category = MaterialCategory::findOrFail($this->category_id);
            $material_category->delete();
            session()->flash('message', 'Category deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete category because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the category.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the category.');
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
        $categories = MaterialCategory::where('category', 'like', '%'.$this->search.'%')
                 ->orderBy('category', 'ASC')
                 ->paginate(10);
        return view('livewire.admin.material-category.index', ['categories' => $categories])->extends('layouts.admin')->section('content');
    }

}
