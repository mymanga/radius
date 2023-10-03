<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Client;
use App\Models\Lead;
use App\Models\Package;
use App\Models\Payment;
use App\Models\Service;

class Searchbox extends Component
{
     public $showresult = false;
     public $search = "";
     public $records;
     public $packages;
     public $leads;
     public $services;
     public $routers;
     public $payments;
     public $empDetails;

     // Fetch records
     public function searchResult(){

         if(!empty($this->search)){

             $this->records = Client::orderby('firstname','asc')
                       ->select('*')
                       ->where('firstname','like','%'.$this->search.'%')
                       ->orWhere('lastname','like','%'.$this->search.'%')
                       ->orWhere('username','like','%'.$this->search.'%')
                       ->orWhere('email','like','%'.$this->search.'%')
                       ->limit(5)
                       ->get();
            
            $this->packages = Package::orderby('id','asc')
                       ->select('*')
                       ->where('name','like','%'.$this->search.'%')
                       ->limit(5)
                       ->get();

            $this->leads = Lead::orderby('firstname','asc')
                       ->select('*')
                       ->where('firstname','like','%'.$this->search.'%')
                       ->orWhere('lastname','like','%'.$this->search.'%')
                       ->orWhere('email','like','%'.$this->search.'%')
                       ->limit(5)
                       ->get();
                       
            $this->services = Service::orderby('id','asc')
                       ->select('*')
                       ->where('username','like','%'.$this->search.'%')
                       ->limit(5)
                       ->get();
            
            $this->payments = Payment::orderby('id','asc')
                       ->select('*')
                       ->where('transaction_id','like','%'.$this->search.'%')
                       ->limit(5)
                       ->get();

             $this->showresult = true;
         }else{
             $this->showresult = false;
         }
     }

     // Fetch record by ID
    //  public function fetchEmployeeDetail($id = 0){

    //      $record = Client::select('*')
    //                  ->where('id',$id)
    //                  ->first();

    //      $this->search = $record->name;
    //      $this->empDetails = $record;
    //      $this->showresult = false;
    //  }

     public function render(){ 
         return view('livewire.searchbox');
     }
}
