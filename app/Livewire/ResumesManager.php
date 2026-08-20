<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Resume;

class ResumesManager extends Component
{
    public $newResumeTitle = '';

    public function createResume()
    {
        $this->validate([
            'newResumeTitle' => 'required|string|max:255',
        ]);

        $resume = auth()->user()->resumes()->create([
            'name' => $this->newResumeTitle,
            'is_default' => auth()->user()->resumes()->count() === 0
        ]);

        $this->newResumeTitle = '';
        
        return redirect()->route('resumes.builder', ['resume' => $resume->id]);
    }

    public function deleteResume($id)
    {
        $resume = auth()->user()->resumes()->findOrFail($id);
        $resume->delete();
    }

    public function render()
    {
        return view('livewire.resumes-manager', [
            'resumes' => auth()->user()->resumes()->latest()->get(),
            'profile' => \App\Models\Profile::where('user_id', auth()->id())->first(),
        ])->layout('layouts.app');
    }
}
