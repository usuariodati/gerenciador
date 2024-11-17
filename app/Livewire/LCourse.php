<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Course;
use App\Models\Plataform;
use Livewire\Component;
use Livewire\WithPagination;

class LCourse extends Component
{
    use WithPagination;

    public $course_id;
    public $name, $total_modules, $total_classes, $done_modules, $done_classes;
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
        $plataforms = Plataform::all();
        $categories = Category::all();
        return view('livewire.l-course', compact(
            'courses',
            'plataforms',
            'categories',
        ));
    }
    
    public function clearFields() {
        $this->course_id = null;
        $this->name = '';
        $this->total_modules = '';
        $this->total_classes = '';
        $this->done_modules = '';
        $this->done_classes = '';
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
            'total_modules' => 'required',
            'total_classes' => 'required',
            'done_modules' => 'required',
            'done_classes' => 'required',
            'plataform_id' => 'required',
        ], [
            'name.required' => 'Campo obrigatório',
            'total_modules.required' => 'Campo obrigatório',
            'total_classes.required' => 'Campo obrigatório',
            'done_modules.required' => 'Campo obrigatório',
            'done_classes.required' => 'Campo obrigatório',
            'plataform_id.required' => 'Campo obrigatório',
        ]);

        $course = Course::updateOrCreate(['id' => $this->course_id], [
            'name' => $this->name,
            'total_modules' => $this->total_modules,
            'total_classes' => $this->total_classes,
            'done_modules' => $this->done_modules,
            'done_classes' => $this->done_classes,
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
        $this->total_modules = $course->total_modules;
        $this->total_classes = $course->total_classes;
        $this->done_modules = $course->done_modules;
        $this->done_classes = $course->done_classes;

        $course->categories()->pluck('id')->toArray();

        $this->open = true;
    }

    public function delete($id) {
        $course = Course::findOrFail($id);
        $course->delete();

        session()->flash('Course removed!');
    }
}
