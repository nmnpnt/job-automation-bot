<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resume;
use App\Models\ResumeSection;
use Barryvdh\DomPDF\Facade\Pdf;

class ResumeBuilder extends Component
{
    public $resume;
    public $sections = [];

    // Form inputs for new section
    public $newSectionType = 'EXPERIENCE';
    public $newSectionTitle = '';
    public $newSectionContent = []; // Array to hold structured data
    public $newSectionOrder = 1;

    public function mount(Resume $resume)
    {
        // Must belong to user
        if ($resume->user_id !== auth()->id()) {
            abort(403);
        }
        
        $this->resume = $resume;
        $this->loadSections();
    }

    public function loadSections()
    {
        $this->sections = $this->resume->sections()->orderBy('order_index')->get();
    }

    public function addSection()
    {
        $this->validate([
            'newSectionType' => 'required|string',
            'newSectionTitle' => 'required|string',
        ]);

        $this->resume->sections()->create([
            'type' => $this->newSectionType,
            'title' => $this->newSectionTitle,
            'content' => $this->newSectionContent, // Storing structured data directly
            'order_index' => $this->newSectionOrder,
        ]);

        $this->newSectionTitle = '';
        $this->newSectionContent = [];
        $this->newSectionOrder++;
        
        $this->loadSections();
        $this->dispatch('notify', ['message' => 'Section added successfully!', 'type' => 'success']);
    }

    public function deleteSection($id)
    {
        $section = ResumeSection::find($id);
        if ($section && $section->resume_id === $this->resume->id) {
            $section->delete();
            $this->loadSections();
            $this->dispatch('notify', ['message' => 'Section deleted!', 'type' => 'success']);
        }
    }

    public function exportPdf()
    {
        $pdf = Pdf::loadView('pdf.resume', ['resume' => $this->resume, 'sections' => $this->sections]);
        
        // Use download to ensure correct headers are sent
        $filename = ($this->resume->name ?: 'Resume') . '.pdf';
        
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $filename, ['Content-Type' => 'application/pdf']);
    }

    public function render()
    {
        return view('livewire.resume-builder')->layout('layouts.app');
    }
}
