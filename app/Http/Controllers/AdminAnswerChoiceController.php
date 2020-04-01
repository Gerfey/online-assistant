<?php


namespace App\Http\Controllers;


use App\Services\Answer\Database\Models\Answer;
use App\Services\Answer\Database\Models\AnswerChoice;
use cijic\phpMorphy\Morphy;
use Illuminate\Http\Request;


class AdminAnswerChoiceController extends Controller
{
    protected $code = 'answerChoice';
    protected $name = 'Действия';
    protected $morphy;
    private $lang = 'ru';
    protected $indexRoute = '/admin/answerChoice';

    public function __construct()
    {
        $this->morphy = new Morphy($this->lang);
    }


    public function index()
    {
        $data = AnswerChoice::all()->toArray();
        foreach ($data as $key => $item) {
            $data[$key]['keywords'] = implode(
                ', ',
                $item['keywords']['words']
            );
        }
        $table = [
            'columns' => !empty($data[0]) ? array_keys($data[0]) : [],
            'data' => $data
        ];

        return view(
            'admin.index',
            [
                'table' => $table,
                'model_code' => $this->code
            ]
        );
    }

    public function create()
    {
        return view('admin.forms.answerChoice', ['answers' => Answer::all()]);
    }

    public function store(Request $request)
    {
        $keywords = ['words' => []];
        foreach ($request->get('keywords') as $keyword) {
            if (!empty($keyword)) {
                $keyword = mb_strtoupper($keyword);
                if ($lemma = $this->morphy->lemmatize($keyword)) {
                    $keyword = $lemma[0];
                }
                $keywords['words'][] = $keyword;
            }
        }

        $answerChoice = new AnswerChoice([
            'title' => $request->get('title'),
            'answer_id' => $request->get('answer_id'),
            'keywords' => $keywords
        ]);
        $answerChoice->save();
        return redirect($this->indexRoute)->with('success', 'Действие сохранено!');
    }


    public function edit(int $id)
    {
        $answerChoice = AnswerChoice::find($id);
        $answerChoice->keywords = $answerChoice->keywords['words'];
        return view('admin.forms.answerChoice', ['answerChoice' => $answerChoice, 'answers' => Answer::all(), 'edit' => true]);
    }

    public function update(Request $request, $id)
    {
        $answerChoice = AnswerChoice::find($id);
        $answerChoice->title = $request->get('title');
        $answerChoice->answer_id = $request->get('answer_id');
        $answerChoice->keywords = $this->prepareKeywords($request->get('keywords'));
        $answerChoice->save();
        return redirect($this->indexRoute)->with('success', 'Действие обновлено!');
    }

    public function destroy(int $id)
    {
        $answerChoice = AnswerChoice::find($id);
        $answerChoice->delete();
        return redirect($this->indexRoute)->with('success', 'Действие удалено!');
    }

    protected function prepareKeywords($keywords)
    {
        $out = ['words' => []];
        foreach ($keywords as $keyword) {
            if (!empty($keyword)) {
                $keyword = mb_strtoupper($keyword);
                if ($lemma = $this->morphy->lemmatize($keyword)) {
                    $keyword = $lemma[0];
                }
                $out['words'][] = $keyword;
            }
        }

        return $out;
    }

}
