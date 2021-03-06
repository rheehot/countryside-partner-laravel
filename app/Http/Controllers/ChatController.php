<?php

namespace App\Http\Controllers;

use App\Exceptions\MeteoException;
use App\Http\Requests\StoreChatRequest;
use App\Models\ChatConversation;
use App\Models\ChatList;
use App\Models\Mentee;
use App\Models\Mentor;
use App\Services\ChatService;
use Illuminate\Http\Request;

/**
 * Class ChatController
 * @package App\Http\Controllers
 */
class ChatController extends Controller
{
    /**
     * @var ChatService|null
     */
    private $chatService = null;

    /**
     * ChatController constructor.
     * @param ChatService $chatService
     */
    public function __construct(ChatService $chatService)
    {
        $this->chatService = $chatService;
    }

    /**
     * @param StoreChatRequest $request
     * @return mixed
     * @throws MeteoException
     */
    protected function store(StoreChatRequest $request)
    {
        $data = $request->all();
        $data['homi'] = 0;
        if ($data['user_type'] === "MENTOR") {
            $userInfo = Mentor::find($data['id']);
            if ($userInfo) {
                $data['homi'] = $userInfo->homi;
            }
        } else {
            $userInfo = Mentee::find($data['id']);
            if ($userInfo) {
                $data['homi'] = $userInfo->homi;
            }
        }

        if ($data['homi'] < 1) {
            throw new MeteoException(3);
        }

        $message_id = $this->chatService->sendMessage($data);

        return $this->show($message_id);
    }
    /**
     * @param $message_id
     * @return mixed
     */
    protected function show($message_id)
    {
        return ChatConversation::find($message_id);
    }

    /**
     * @param $chat_lists_id
     * @return mixed
     */
    protected function messagelists($chat_lists_id)
    {
        $conversations = ChatConversation::where('chat_lists_id', $chat_lists_id)->orderBy('created_at', 'DESC')->orderBy('id', 'DESC')->paginate(15);

        return $conversations;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    protected function chatLists(Request $request)
    {
        $data = $request->all();
        $user = $data['user_type']."_".$data['id'];
        return $this->chatService->chatLists($user);
    }
}
