namespace App\Http\Controllers;

use App\Models\Poll;
use Illuminate\Http\Request;

class PollController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except(['index', 'show']);
    }

    public function index(Request $request)
    {
        $query = Poll::with('options');

        // Фильтрация по статусу
        if ($request->has('active')) {
            $query->where('is_active', $request->input('active'));
        }

        // Поиск по вопросу
        if ($request->has('search')) {
            $query->where('question', 'like', '%' . $request->input('search') . '%');
        }

        return response()->json($query->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
        ]);

        $poll = auth()->user()->polls()->create(['question' => $validated['question']]);

        foreach ($validated['options'] as $optionText) {
            $poll->options()->create(['text' => $optionText]);
        }

        return response()->json($poll->load('options'), 201);
    }

    public function show(Poll $poll)
    {
        return response()->json($poll->load('options'));
    }

    public function update(Request $request, Poll $poll)
    {
        $this->authorize('update', $poll);

        $validated = $request->validate([
            'is_active' => 'sometimes|boolean',
        ]);

        $poll->update($validated);
        return response()->json($poll);
    }

    public function destroy(Poll $poll)
    {
        $this->authorize('delete', $poll);

        $poll->delete();
        return response()->json(null, 204);
    }
}
