<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class LCourse extends Component
{
    use WithPagination;

    public $course_id;
    public $name;
    public $plataform_id;
    public $selectedCategories = [];
    public $query = '';
    public $open = false;

    public function search() {
        $this->resetPage();
    }

    public function render()
    {
        $courses = Course::where('name', 'like', '%'.$this->query.'%')
            ->orderBy('id', 'asc')->paginate(5, ['*'], 'CoursePage');
        $categories = Category::all();
        return view('livewire.l-course', compact(
            'courses',
            'categories',
        ));
    }
    
    public function clearFields() {
        $this->course_id = null;
        $this->name = '';
        $this->plataform_id;
        $this->selectedCategories = [];
    }

    public function create() {
        $this->clearFields();
        $this->open = true;
    }

    public function close() {
        $this->open = false;
        $this->clearFields();
    }

    public function store() {
        $this->validate([
            'name' => 'required',
            'plataform_id' => 'required',
        ], [
            'name.required' => 'Campo obrigatório',
            'plataform_id.required' => 'Campo obrigatório',
        ]);

        $course = Course::updateOrCreate(['id' => $this->course_id], [
            'name' => $this->name,
            'plataform_id' => $this->plataform_id,
        ]);

        $course->categories()->sync($this->selectedCategories);

        session()->flash('success', $this->course_id ? 'Course updated' : 'Course cretad');
        $this->close();
    }

    public function edit($id) {
        $course = Course::findOrFail($id);

        $this->course_id = $course->id;
        $this->name = $course->name;

        $course->categories()->pluck('id')->toArray();

        $this->open = true;
    }

    public function delete($id) {
        $course = Course::findOrFail($id);
        $course->delete();

        session()->flash('Course removed!');
    }
}
