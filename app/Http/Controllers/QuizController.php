<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function getAll()
    {
        return response()->json(Quiz::all());
    }

    public function getOne($id)
    {
        $quiz = Quiz::findOrFail($id);
        return response()->json($quiz);
    }

    public function createQuiz(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'description' => 'nullable|string',
            'option_1' => 'required|string',
            'option_2' => 'required|string',
            'option_3' => 'required|string',
            'option_4' => 'required|string',
            'option_5' => 'nullable|string',
            'correct_option' => 'required|integer|between:1,5',
            'cource_id' => 'required|integer|exists:cources,id',
        ]);

        $quiz = Quiz::create($validated);

        return response()->json($quiz, 201);
    }

    public function updateQuiz(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $validated = $request->validate([
            'question' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'option_1' => 'sometimes|required|string',
            'option_2' => 'sometimes|required|string',
            'option_3' => 'sometimes|required|string',
            'option_4' => 'sometimes|required|string',
            'option_5' => 'nullable|string',
            'correct_option' => 'sometimes|required|integer|between:1,5',
        ]);

        $quiz->update($validated);

        return response()->json($quiz);
    }

    public function deleteQuiz($id)
    {
        $quiz = Quiz::findOrFail($id);
        $quiz->delete();

        return response()->json(['message' => 'Quiz deleted']);
    }

 public function getQuizByCource($id)
{
    $quizzes = Quiz::where('cource_id', $id)->get();
    return response()->json(['quizzes' => $quizzes]);
}

}
