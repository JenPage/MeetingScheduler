<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Messages\Messages;
use Messages\Models\Messages as MessageModel;
use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Events\UserSentMessage;
use Illuminate\Support\Facades\DB;


class MessageController extends Controller{

    public $request;

    protected $messagemodel;

    protected $user;

    public function __construct(Request $request, MessageModel $messagemodel, User $user, Company $company)
    {

        $this->request = $request;
        $this->messagemodel = $messagemodel;
        $this->user = $user;
        $this->company = $company;

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function index()
    {
        if(!Auth::user())
        {
            return redirect('/home');
        }
        $user = Auth::user();

        return view('messages.broadcast', compact('user'));
    }

    /**
     * @param null $recipient
     * @param null $message
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|string
     */
    public function get_messages($recipient=null, $message=null)
    {

        if(!Auth::user())
        {
            return redirect('/home');
        }

        $user = Auth::user();

        if($this->last_chat())
        {
           $latest_chat =  $this->last_chat();
            $last_contact = $latest_chat['last_contact'];
            $last_convo = $latest_chat['last_convo'];
        }else{
            $latest_chat = '';
            $last_contact = '';
            $last_convo ='';
        }

        $threads = '';

        $contacts = $this->get_contacts();

        event(new UserSentMessage($user, $recipient, $message));

        if ($this->request->wantsJson()) {

            if($this->request->input('id'))
            {
                $messages = $this->get_convo($this->request->input('id'), Auth::user()->id);
                if($messages)
                {
                    return json_encode($messages['last_convo']);
                }
            }

            $messages = [
                'latest_chat' => $latest_chat,
                'last_contact' => $last_contact,
                'last_convo' => $last_convo,
                'contacts' => $contacts
            ];
            if($messages)
            {
                return json_encode($messages);
            }

        }

        return view('messages.broadcast', compact('threads', 'user', 'contacts', 'last_contact', 'last_convo'));
    }


    /**
     * @return array
     */
    public function user_sent_messages()
    {
        $usermessages = $this->messagemodel;

        $new_array=array();
        foreach ($usermessages->where('sender', '=', Auth::user()->id)->get() as $usermessage) {
            $new_array[] = [
                'type' => $usermessage['type'],
                'subject' => $usermessage['subject'],
                'body' => $usermessage['body'],
                'status' => $usermessage['created'],
                'recipient_user' => $usermessage['recipient_user'],
                'sender' => $usermessage['sender'],
                'created_at' => $usermessage['created_at']
            ];
        }

        return array($new_array);
    }


    /**
     * @return array
     */
    public function user_recieved_messages()
    {
        $usermessages = $this->messagemodel;

        $new_array=array();
        foreach ($usermessages->where('recipient_user', '=', Auth::user()->id)->get() as $usermessage) {
            $new_array[] = [
                'type' => $usermessage['type'],
                'subject' => $usermessage['subject'],
                'body' => $usermessage['body'],
                'status' => $usermessage['created'],
                'recipient_user' => $usermessage['recipient_user'],
                'sender' => $usermessage['sender'],
                'created_at' => $usermessage['created_at']
            ];
        }


        return array($new_array);
    }

    /**
     * @return array
     */
    public function user_all_messages()
    {
//        $request = $this->request;
//        $usermessage = $this->messagemodel;

        $sent = $this->user_sent_messages();

        $recieved = $this->user_recieved_messages();

        $messages = [
          'sent' => $sent,
          'recieved' => $recieved
        ];

        $allmessages = collect($messages);

        $messagethreads = $allmessages->groupBy('recipient_user');

        $threads = $messagethreads;
        return $threads->toArray();
    }

    /**
     *
     */
    public function create_message()
    {
        $request = $this->request;
        $user = $this->user;
        if($request->input('to'))
        {
            $recipient = $user->where('email', '=', $request->input('to'))->first();
        }else{
            $recipient = $user->where('id', '=', $request->input('recipient'))->first();
        }
        $message = Messages::factory($request->input('type'));
        $message->create_message(
            $request->input('type'),
            $request->input('subject'),
            $request->input('body'),
            $request->input('status'),
            $recipient->company_id,
            $recipient->id,
            Auth::user()->id
        );
        $sendmessage = [
            'sender'=> Auth::user()->id,
            'subject'=>  $request->input('subject'),
            'body' => $request->input('body')
        ];
        if($request->input('status')=='send')
        {
            $this->get_messages($recipient->id, $sendmessage);
        }
    }

    /**
     * @return array
     */
    public function get_contacts()
    {
        $compid = Auth::user()->company_id;

        $company_contacts = $this->user->where('company_id', '=', $compid)->get();

        $filtered =  $company_contacts->filter(function ($value, $key) {
           return $value['id'] != Auth::user()->id;
        });

        $contacts = [
            'company_contacts' => $filtered
        ];

        return $contacts;
    }

    /**
     * @param $sender
     * @param $recipient
     * @return array
     */
    public function get_convo($sender, $recipient)
    {
        $usermessages = DB::table('messages')
            ->where([
            ['sender', '=', $sender],
            ['recipient_user', '=', $recipient]
            ])
            ->orWhere([
                ['sender', '=', $recipient],
                ['recipient_user', '=', $sender]
            ])
            ->orderBy('id', 'asc')
            ->get();

        $last_convo = collect($usermessages);


        $last_convo->map(function ($item, $key) {

            $item->from = $this->user->where('id', $item->sender)->first()->first_name;

            return $item;

        });

        if($last_convo[0]->sender == Auth::user()->id)
        {
            $user = $this->user->where('id', $last_convo[0]->recipient_user)->first();
            $last_contact = [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email
            ];
        }else{
            $user = $this->user->where('id', $last_convo[0]->sender)->first();
            $last_contact = [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email

            ];
        }

        $conversation = [
            'last_contact' => $last_contact,
            'last_convo' => $last_convo
        ];
        return $conversation;
    }

    /**
     * @return array|bool
     */
    public function last_chat()
    {
        $usermessages = $this->messagemodel;

        $recieved = $usermessages->where('recipient_user', '=', Auth::user()->id)->orderBy('id', 'desc')->first();

        $sent = $usermessages->where('sender', '=', Auth::user()->id)->orderBy('id', 'desc')->first();

        if($recieved && $sent)
        {
            if($recieved->id > $sent->id)
            {
                return $this->get_convo($recieved->sender, $recieved->recipient_user);

            }else{
                return $this->get_convo($sent->sender, $sent->recipient_user);
            }
        }elseif($recieved)
        {
            return $this->get_convo($recieved->sender, $recieved->recipient_user);
        }elseif($sent)
        {
            return $this->get_convo($sent->sender, $sent->recipient_user);
        }else{
            return false;
        }
    }

    public function create_broadcast()
    {
        return $this->request->broadcastmessage;
    }


}