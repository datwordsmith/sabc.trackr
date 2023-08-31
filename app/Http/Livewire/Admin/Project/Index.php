<?php

namespace App\Http\Livewire\Admin\Project;

use App\Models\Project;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $project_id, $name, $slug, $description, $client, $start_date, $expected_delivery_date;
    public $search;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'nullable|string',
            'client' => 'required|string',
            'start_date' => 'required|date',
            'expected_delivery_date' => 'required|date|after:start_date'
        ];
    }

    public function resetInput() {
        $this->name = NULL;
        $this->description = NULL;
        $this->client = NULL;
        $this->start_date = NULL;
        $this->expected_delivery_date = NULL;
        $this->project_id = NULL;
    }

    public function storeProject()
    {
        $validatedData = $this->validate();
        $validatedData['slug'] = Str::slug($validatedData['name']);
        //dd($validatedData);
        Project::create($validatedData);

        session()->flash('message', 'Project Added Successfully');

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editProject(int $project_id)
    {
        $project = Project::FindOrFail($project_id);
        $this->project_id = $project_id;
        $this->name = $project->name;
        $this->description = $project->description;
        $this->client = $project->client;
        $this->start_date = $project->start_date;
        $this->expected_delivery_date = $project->expected_delivery_date;
    }

    public function updateProject()
    {
        $validatedData = $this->validate();
        $validatedData['slug'] = Str::slug($validatedData['name']);

        $project = Project::findOrFail($this->project_id);
        $project->update($validatedData);

        session()->flash('message', 'Project Updated Successfully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deleteProject($project_id)
    {
        $this->project_id = $project_id;
    }

    public function destroyProject()
    {
        try {
            $project = Project::FindOrFail($this->project_id);
            $project->delete();
            session()->flash('message', 'Project deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete project because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the project.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the project.');
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
        $projects = Project::where('name', 'like', '%'.$this->search.'%')
                 ->orWhere('client', 'like', '%'.$this->search.'%')
                 ->orderBy('name', 'ASC')
                 ->orderBy('client', 'ASC')
                 ->paginate(10);
        return view('livewire.admin.project.index', ['projects' => $projects])->extends('layouts.admin')->section('content');
    }
}
