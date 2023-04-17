<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\ClientTrackList;
use App\Models\Configuration;
use App\Models\Message;
use App\Models\TrackList;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index ()
    {
        $user = Auth::user();
        $config = Configuration::query()->select('address', 'title_text', 'address_two', 'whats_app')->first();
        $count = 0;
        $messages = Message::all();
        $cities = City::query()->select('title')->get();

        if ($user->is_active === 1 && $user->type === null) {
            $tracks = ClientTrackList::query()
                ->leftJoin('track_lists', 'client_track_lists.track_code', '=', 'track_lists.track_code')
                ->select('client_track_lists.track_code', 'client_track_lists.detail', 'client_track_lists.created_at',
                    'track_lists.to_china', 'track_lists.to_almaty','client_track_lists.id', 'track_lists.to_client', 'track_lists.to_city', 'track_lists.city', 'track_lists.to_client_city', 'track_lists.client_accept', 'track_lists.status')
                ->where('client_track_lists.user_id', $user->id)
                ->where('client_track_lists.status', null)
                ->orderByDesc('client_track_lists.id')
                ->get();
            $count = count($tracks);

            return view('dashboard')->with(compact('tracks', 'count', 'messages', 'config'));
        } elseif ($user->is_active === 1) {

            if ($user->type === 'stock') {
                $count = TrackList::query()->whereDate('created_at', Carbon::today())->count();
                return view('stock')->with(compact('count', 'config'));
            } elseif ($user->type === 'almatyin') {
                $count = TrackList::query()->whereDate('to_almaty', Carbon::today())->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Алматы']);
            }elseif ($user->type === 'kokshetauin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Кокшетау')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Кокшетау']);
            }elseif ($user->type === 'astanain') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Астане')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Астане']);
            }elseif ($user->type === 'shimkentin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Шымкенте')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Шымкенте']);
            }elseif ($user->type === 'zheskazganin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Жезказгане')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Жезказгане']);
            }elseif ($user->type === 'aktobein') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Актобе')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Актобе']);
            }elseif ($user->type === 'taldikorganin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Талдыкоргане')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Талдыкоргане']);
            } elseif ($user->type === 'almatyout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Алматы']);
            } elseif ($user->type === 'kokshetauout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Кокшетау']);
            } elseif ($user->type === 'shimkentout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Шымкенте']);
            } elseif ($user->type === 'astanaout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Астане']);
            } elseif ($user->type === 'zheskazganout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Жезказгане']);
            } elseif ($user->type === 'aktobeout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Актобе']);
            } elseif ($user->type === 'taldikorganout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Талдыкоргане']);
            } elseif ($user->type === 'othercity') {
                $count = TrackList::query()->whereDate('to_client', Carbon::today())->count();
                return view('othercity')->with(compact('count', 'config', 'cities'));
            } elseif ($user->type === 'admin') {
                $search_phrase = '';
                $users = User::query()->select('id', 'name', 'surname', 'type', 'login', 'city', 'is_active', 'block', 'password', 'created_at')->where('type', null)->where('is_active', false)->get();
                return view('admin')->with(compact('users', 'messages', 'search_phrase', 'config'));
            }
        }

        return view('register-me')->with(compact('config'));
    }


    public function archive ()
    {
            $tracks = ClientTrackList::query()
                ->leftJoin('track_lists', 'client_track_lists.track_code', '=', 'track_lists.track_code')
                ->select( 'client_track_lists.track_code', 'client_track_lists.detail', 'client_track_lists.created_at',
                    'track_lists.to_china','track_lists.to_almaty','track_lists.to_client','track_lists.to_city','track_lists.city','track_lists.to_client_city','track_lists.client_accept','track_lists.status')
                ->where('client_track_lists.user_id', Auth::user()->id)
                ->where('client_track_lists.status', '=', 'archive')
                ->get();
        $config = Configuration::query()->select('address', 'title_text', 'address_two', 'whats_app')->first();
            $count = count($tracks);
            return view('dashboard')->with(compact('tracks', 'count', 'config'));
    }



}
