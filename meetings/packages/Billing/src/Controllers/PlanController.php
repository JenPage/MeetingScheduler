<?php
namespace Billing\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;
use App\Company;
use Billing\PlanInterface;
use App\Role;
use Billing\MessagePlan;
use Billing\UserPlan;
use Billing\EventPlan;
use Billing\BasicPlan;
use Billing\Models\Plan;
use Billing\Models\Subscription;
use Illuminate\Support\Facades\DB;


class PlanController extends \App\Http\Controllers\Controller
{

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('billing.plans');
    }

    /**
     * @param Request $request
     * @param Plan $model
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function signup(Request $request, Plan $model,  User $users, Company $company, Subscription $subscription)
    {
        if(Auth::guest())
        {
            return view('welcome');

        }else{
            $user = Auth::user();
            $compid = Auth::user()->company->id;
            $subscription = $subscription->where('company_id', '=', $compid)->get();

           // dd($subscription);

            $user = [
                'first_name' => $user->first_name,
                'lastname' => $user->last_name,
                'company' => $user->company->name,

                'signup_options' => [
                    'message_options' =>[
                        $message_options = $model->where('type', '=', 'messages')->get()->toArray()
                    ],
                    'users_options' =>
                        [
                            $user_options = $model->where('type', '=', 'users')->get()->toArray()
                        ],
                    'event_options' =>
                        [
                            $event_options = $model->where('type', '=', 'events')->get()->toArray()
                        ]
                ]
            ];

            if(count($subscription) > 1)
            {
                if($subscription->owner == Auth::user()->id)
                {
                    $user['plan'] = 'Paying Member';
                    $user['subscriptions'] = $subscription;
                }

                return view('billing.signupform', compact('user'));
            }else{
                $user['subscriptions'] = '';
                $user['plan'] = 'Free Member';
                return view('billing.signupform', compact('user'));
            }
        }
    }

    /**
     * @param Request $request
     * @param Plan $model
     * @return string
     */
    public function save(Request $request,  Plan $model, Subscription $subscription, User $user)
    {
        $message_opts = $request->message_options;
        $user_opts = $request->users_options;
        $event_opts = $request->event_options;

        $user_plans = (new EventPlan($event_opts, new UserPlan($user_opts, new MessagePlan($message_opts, new BasicPlan()))))->getPlan($opts=null, $model);
        $cost = array_sum([$user_plans['events']['cost'], $user_plans['messages']['cost'], $user_plans['users']['cost']]);

        $user_plan = [
            'message_type' => $user_plans['messages']['id'],
            'event_type' => $user_plans['events']['id'],
            'user_type' => $user_plans['users']['id'],
            'owner' => Auth::user()->id,
            'status' => 'live',
            'payment_amount' => $cost
        ];
        $confirmation = [
            'message_type' => [
                'type' => $user_plans['messages']['type'],
                'description' =>  $user_plans['messages']['description']
            ],
            'event_type' => [
                'type' => $user_plans['events']['type'],
                'description' =>$user_plans['events']['description']
            ],
            'user_type' => [
                'type'=>$user_plans['users']['type'],
                'description' => $user_plans['users']['description']
            ]
        ];
        $current_plan = $subscription->where('owner', '=', Auth::user()->id)->first();
        if($current_plan){
            $current_plan->update($user_plan);
            $currentuser = $user->where('id', '=', Auth::user()->id)->first();

            $owner = Role::where('name', '=', 'owner')->first();
            $manager = Role::where('name', '=', 'manager')->first();
            $member = Role::where('name', '=', 'member')->first();
            $currentuser->roles()->detach();
            $currentuser->roles()->save($owner);
            $currentuser->roles()->save($manager);
            $currentuser->roles()->save($member);

        }else{
            $subscription->create($user_plan);
            $currentuser = $user->where('id', '=', Auth::user()->id)->first();
            $owner = Role::where('name', '=', 'owner')->first();
            $manager = Role::where('name', '=', 'manager')->first();
            $member = Role::where('name', '=', 'member')->first();
            $currentuser->roles()->detach();
            $currentuser->roles()->save($owner);
            $currentuser->roles()->save($manager);
            $currentuser->roles()->save($member);
        }

        return view('billing.confirm', compact('confirmation', 'user'));
    }
}

