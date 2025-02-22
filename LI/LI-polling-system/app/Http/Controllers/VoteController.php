namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    public function store(Request $request, Option $option)
    {
        $user = auth()->user();

        // Проверяем, голосовал ли пользователь уже
        if ($user->votes()->where('option_id', $option->id)->exists()) {
            return response()->json(['message' => 'You have already voted for this poll.'], 400);
        }

        $vote = $user->votes()->create(['option_id' => $option->id]);
        $option->increment('votes');

        return response()->json(['message' => 'Your vote has been recorded.'], 201);
    }
}
