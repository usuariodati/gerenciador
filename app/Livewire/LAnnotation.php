<?php

namespace App\Livewire;

use App\Models\Annotation;
use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class LAnnotation extends Component
{
    use WithPagination;

    public $annotation_id;
    public $module, $title, $content;
    public $course_id;
    public $courseQuery = '';
    public $open = false;

    public function search() {
        $this->resetPage();
    }

    public function render()
    {
        $annotations = Annotation::with('courses')
            ->when($this->courseQuery, function($query) {
                $query->whereHas('courses', function($courseQuery) {
                    $courseQuery->where('module', 'like', '%'.$this->courseQuery.'%');
                });
            })
            ->orderBy('id', 'asc')->paginate(5, ['*'], 'AnnotationPage');
        $courses = Course::all();
        return view('livewire.l-annotation', compact(
            'annotations',
            'courses'
        ));
    }

    public function clearFields() {
        $this->annotation_id = null;
        $this->module = '';
        $this->title = '';
        $this->content = '';
        $this->course_id;
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
            'module' => 'required',
            'title' => 'required',
            'content' => 'required',
            'course_id' => 'required',
        ], [
            'module.required' => 'Campo obrigatório',
            'title.required' => 'Campo obrigatório',
            'content.required' => 'Campo obrigatório',
            'course_id.required' => 'Campo obrigatório',
        ]);

        $course = Course::updateOrCreate(['id' => $this->annotation_id], [
            'module' => $this->module,
            'title' => $this->title,
            'content' => $this->content,
            'course_id' => $this->course_id,
        ]);


        session()->flash('success', $this->annotation_id ? 'Annotation updated' : 'Annotation cretad');
        $this->close();
    }

    public function edit($id) {
        $course = Course::findOrFail($id);

        $this->annotation_id = $course->id;
        $this->module = $course->module;
        $this->title = $course->title;
        $this->content = $course->content;
        $this->course_id = $course->course_id;

        $this->open = true;
    }

    public function delete($id) {
        $course = Course::findOrFail($id);
        $course->delete();

        session()->flash('Course removed!');
    }
}
