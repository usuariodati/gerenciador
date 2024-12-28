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
        $annotations = Annotation::with('course')
            ->when($this->courseQuery, function($query) {
                $query->whereHas('course', function($courseQuery) {
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

        Annotation::updateOrCreate(['id' => $this->annotation_id], [
            'module' => $this->module,
            'title' => $this->title,
            'content' => $this->content,
            'course_id' => $this->course_id,
        ]);


        session()->flash('success', $this->annotation_id ? 'Annotation updated' : 'Annotation cretad');
        $this->close();
    }

    public function edit($id) {
        $annotation = Annotation::findOrFail($id);

        $this->annotation_id = $annotation->id;
        $this->module = $annotation->module;
        $this->title = $annotation->title;
        $this->content = $annotation->content;
        $this->course_id = $annotation->course_id;

        $this->open = true;
    }

    public function delete($id) {
        $annotation_id = Annotation::findOrFail($id);
        $annotation_id->delete();

        session()->flash('Course removed!');
    }
}
