<?php

namespace App\Http\Livewire\Admin\Vendor;

use App\Models\Vendor;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\VendorService;
use Illuminate\Support\Facades\DB;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $vendor_id, $name, $phone, $email, $location, $vendor, $services = [];
    public $search;

    public function rules()
    {
        return [
            'name' => 'required|string',
            'phone' => 'required|numeric|regex:/^0\d{0,15}$/',
            'email' => 'nullable|string',
            'location' => 'required|string',
        ];
    }

    public function mount(Vendor $vendor)
    {
        $this->vendor = $vendor;
    }

    public function resetInput() {
        $this->name = NULL;
        $this->phone = NULL;
        $this->email = NULL;
        $this->location = NULL;
        $this->services = [];
    }

    public function closeModal() {
        $this->resetInput();
    }

    public function openModal() {
        $this->resetInput();
    }

    public function addService()
    {
        $this->services[] = '';
    }

    public function removeService($index)
    {
        unset($this->services[$index]);
        $this->services = array_values($this->services);
    }

    public function storeVendor()
    {
        $validatedData = $this->validate();
        $vendor = Vendor::create($validatedData);

        foreach ($this->services as $service) {
            VendorService::create([
                'vendor_id' => $vendor->id,
                'service' => $service,
            ]);
        }

        session()->flash('message', 'Vendor Added Successfully');

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function editVendor(int $vendor_id)
    {
        $vendor = Vendor::FindOrFail($vendor_id);
        $this->vendor_id = $vendor->id;
        $this->name = $vendor->name;
        $this->phone = $vendor->phone;
        $this->email = $vendor->email;
        $this->location = $vendor->location;

        // Get the services
        $this->services = $vendor->services->pluck('service')->toArray();
    }

    public function updateVendor()
    {
        $validatedData = $this->validate();

        $vendor = Vendor::findOrFail($this->vendor_id);
        $vendor->update($validatedData);

        $vendor->services()->delete(); // Remove all old services for this vendor

        foreach ($this->services as $service) {
            VendorService::create([
                'vendor_id' => $vendor->id,
                'service' => $service,
            ]);
        }

        session()->flash('message', 'Vendor Updated Successfully');
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();
    }

    public function deleteVendor($vendor_id)
    {
        $this->vendor_id = $vendor_id;
    }

    public function destroyVendor()
    {
        try {
            $vendor = Vendor::FindOrFail($this->vendor_id);
            $vendor->delete();
            session()->flash('message', 'Vendor deleted successfully.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->errorInfo[1] == 1451) { // check if error is foreign key constraint violation
                session()->flash('error', 'Cannot delete vendor because it is referenced in another module.');
            } else {
                session()->flash('error', 'An error occurred while deleting the vendor.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'An error occurred while deleting the vendor.');
        }

        $this->dispatchBrowserEvent('close-modal');
        $this->resetInput();

    }

    public function render()
    {
        /* $vendors = Vendor::where('name', 'like', '%'.$this->search.'%')
                 ->orWhere('location', 'like', '%'.$this->search.'%')
                 ->orderBy('name', 'ASC')
                 ->paginate(10); */
        $vendors = Vendor::select('vendors.*')
                 ->leftJoin(DB::raw('(SELECT vendor_id, GROUP_CONCAT(service SEPARATOR ", ") AS services FROM vendor_services GROUP BY vendor_id) AS vs'), 'vendors.id', '=', 'vs.vendor_id')
                 ->where(function($query) {
                     $query->where('name', 'like', '%'.$this->search.'%')
                           ->orWhere('location', 'like', '%'.$this->search.'%')
                           ->orWhere('vs.services', 'like', '%'.$this->search.'%');
                 })
                 ->orderBy('name', 'ASC')
                 ->paginate(10);
        return view('livewire.admin.vendor.index', ['vendors' => $vendors])->extends('layouts.admin')->section('content');
    }
}
