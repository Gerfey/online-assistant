<?php


namespace App\Http\Controllers;


use App\Services\Answer\Database\Models\Answer;
use App\Services\Answer\Database\Models\AnswerChoice;
use cijic\phpMorphy\Morphy;
use Illuminate\Http\Request;


class AdminAnswerController extends Controller
{
    protected $code = 'answer';
    protected $name = 'Ответы';
    protected $morphy;
    private $lang = 'ru';
    protected $indexRoute = '/admin/answer';

    public function __construct()
    {
        $this->morphy = new Morphy($this->lang);
    }


    public function index()
    {
        $data = Answer::all()->toArray();
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
        return view('admin.forms.answer');
    }

    public function store(Request $request)
    {
        $answer = new Answer([
            'answer' => $request->get('answer'),
            'keywords' => $this->prepareKeywords($request->get('keywords'))
        ]);
        $answer->save();
        return redirect($this->indexRoute)->with('success', 'Ответ сохранен!');
    }


    public function edit(int $id)
    {
        $answer = Answer::find($id);
        $answer->keywords = $answer->keywords['words'];
        return view('admin.forms.answer', ['answer' => $answer, 'edit' => true]);
    }

    public function update(Request $request, $id)
    {
        $answer = Answer::find($id);
        $answer->answer =   $request->get('answer');
        $answer->keywords = $this->prepareKeywords($request->get('keywords'));
        $answer->save();
        return redirect($this->indexRoute)->with('success', 'Ответ обновлен!');
    }

    public function destroy(int $id)
    {
        $answer = Answer::find($id);
        $answer->delete();
        return redirect($this->indexRoute)->with('success', 'Ответ удален!');
    }

    protected function prepareKeywords($keywords) {
        $out = ['words'=>[]];
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
