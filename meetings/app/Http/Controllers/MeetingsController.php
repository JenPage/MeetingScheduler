<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Meetings\Meetings;
use Messages\Models\Messages as MessageModel;
use Illuminate\Http\Request;
use App\User;
use App\Company;
use App\Meeting;
use App\MeetingUser;
use App\Events\UserMeetingInvite;


class MeetingsController extends Controller{
    public $request;

    protected $messagemodel;

    protected $user;

    public function __construct(Request $request, MessageModel $messagemodel, User $user, Company $company, Meeting $meetings, MeetingUser $meetingUser)
    {
        $this->request = $request;
        $this->messagemodel = $messagemodel;
        $this->user = $user;
        $this->company = $company;
        $this->meetings = $meetings;
        $this->meetingUser = $meetingUser;
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
     * @return mixed
     */
    public function create_meeting()
    {
        if(!Auth::user())
        {
            return redirect('/home');
        }
        $user = Auth::user();
        $meeting = [
            'type' => $this->request->input('type'),
            'owner' => Auth::user()->id,
            'date_from' => $this->request->input('from'),
            'date_to' => $this->request->input('to'),
            'placeid' => $this->request->input('placeid'),
            'description' => $this->request->input('description'),
            'location' => $this->request->input('address'),

        ];

        $newmeeting = Meeting::create($meeting);
        var_dump($newmeeting->id);

        $meetinguser = [
          'meeting_id' => $newmeeting->id,
            'user_id' => Auth::user()->id,
            'response' => 'created'
        ];

        return MeetingUser::create($meetinguser);
    }

    /**
     * @return $user_meetings
     */
    public function get_meetings()
    {
        if(!Auth::user())
        {
            return redirect('/home');
        }
        $user = Auth::user();

        $user_meetings = ['meetings' => $this->meetings->where('owner', '=', $user->id)->get(),
                          'invites' => $this->get_invites()];

        //event(new UserMeetingInvite($user_meetings));
        return $user_meetings;
    }

    public function eventResponse()
    {
        if(!Auth::user())
        {
            return redirect('/home');
        }
        $user = Auth::user();

        $meeting = $this->meetingUser->find($this->request->meeting_id);

        $meeting->update(['response'=> $this->request->rsvp]);

        return $this->get_meetings();

    }


    /**
     * @return array($events)
     */
    public function get_invites()
    {
        if(!Auth::user())
        {
            return redirect('/home');
        }
        $user = Auth::user();

        $user_invites =  $this->meetingUser->where('user_id', '=', $user->id)->with('meetings')->get();

        $filtered = $user_invites->filter(function ($value, $key) {
            if($value->response !== 'created')
            {
                return $value->response;
            }
        });

        $events = [];
        foreach($filtered as $inv)
        {

            $events[] = [
                 'description' => $inv->meetings->description,
                'response' => $inv->response,
                'date_from' => $inv->meetings->date_from,
                'date_to' => $inv->meetings->date_to,
                'location' => $inv->meetings->location,
                'placeid' => $inv->meetings->placeid,
                'id' => $inv->id,
                'meeting_id' => $inv->meetings->id

            ];
        }

         return array($events);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update_meeting()
    {
        if(!Auth::user())
        {
            return redirect('/home');
        }

        $meeting = $this->meetings->where('id', '=', $this->request->input('meeting')['id'])->update($this->request->input('meeting'));

        return $meeting;
    }


    /**
     * @param MeetingUser $meetingUser
     * @param Meeting $meetings
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View|string
     */
    public function edit_meeting(MeetingUser $meetingUser, Meeting $meetings)
    {
        if(!Auth::user())
        {
            return redirect('/home');
        }
        $user = Auth::user();

        if ($this->request->wantsJson()) {

            $meeting = $meetings->where('id', '=', $this->request->input('meeting_id'))->get();

            $meet = $meetings->where('id', '=', $this->request->input('meeting_id'))->first();

            if($meet->owner == Auth::user()->id)
            {
                return json_encode(['meeting' => $meeting]);
            }else{
                return 'unauthorized';
            }

        }else{
            return view('meetings.edit', compact('user', 'meeting'));
        }
    }


    /**
     * @param MeetingUser $meetingUser
     * @param Meeting $meetings
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|string
     */
    public function delete_meeting(MeetingUser $meetingUser, Meeting $meetings)
    {
        if(!Auth::user())
        {
            return redirect('/home');
        }

        $meet = $meetings->where('id', '=', $this->request->input('meeting_id'))->first();

        if($meet->owner == Auth::user()->id)
        {
            $meetingUser->where('meeting_id', '=', $this->request->input('meeting_id'))->delete();

            $meetings->where('id', '=', $this->request->input('meeting_id'))->delete();

        }else{
            return 'unauthorized';
        }

    }

    /**
     * @param MeetingUser $meetingUser
     * @return string
     */
    public function meeting_invite(MeetingUser $meetingUser)
    {
        $invited = $meetingUser->where('meeting_id', '=', $this->request->input('meeting_id'))->get();

        $filtered = $invited->filter(function ($value, $key) {
            return $value['user_id'] != Auth::user()->id;
        });

        $invited_users = [];
        foreach($filtered as $inv)
        {
           $invited_users[] = ['user' => $this->user->where('id', '=', $inv->user_id)->get()];
        }

        $invite = [
            'contacts' => $this->get_contacts(),
            'invitees' => array($invited_users),
            'meeting' => $this->meetings->where('id', '=', $this->request->input('meeting_id'))->get()
        ];

        return json_encode($invite);
    }

    /**
     * @return mixed
     */
    public function invite_contact()
    {

        $user = $this->user->where('id','=', $this->request->input('user_id'))->get();

        $meeting_invite = [
            'meeting_id' => $this->request->input('meeting_id'),
            'user_id' => $this->request->input('user_id'),
            'response' => 'invited',
            'user' => $user,
        ];

        MeetingUser::create($meeting_invite);

        event(new UserMeetingInvite($meeting_invite));

        return $user;

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

    public function event_page(Meeting $meetings)
    {
        if(!Auth::user())
        {
            return redirect('/home');
        }
        $user = Auth::user();

        if ($this->request->wantsJson()) {


            $meeting_users = $this->meetingUser->where('meeting_id', '=', $this->request->id)->get();

            $meeting = $this->meetings->where('id', '=', $meeting_users[0]->meeting_id)->get();

            $event_data = [

                'users' => $meeting_users,
                'meeting' => $meeting,
            ];
            return $event_data;

        }else{
            return view('meetings.page', compact('user'));
        }
    }

}
