<?php
namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\Contact;

class Footer extends Component
{
    public $contact;
    public function __construct()
    {
        $this->email = Contact::first(); 
    }

    public function render()
    {
        return view('components.footer');
    }
}
