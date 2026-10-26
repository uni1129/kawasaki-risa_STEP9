namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    // お問い合わせ画面を表示するメソッド
    public function index()
    {
        return view('contact'); 
    }

    public function send(Request $request)
    {
        // 送信処理など
    }
}