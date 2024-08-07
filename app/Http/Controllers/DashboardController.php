<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\ClientTrackList;
use App\Models\Configuration;
use App\Models\Message;
use App\Models\QrCodes;
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
        $qr = QrCodes::query()->select()->where('id', 1)->first();
        $qrUralsk = QrCodes::query()->select()->where('id', 2)->first();
        $qrPetropavlovsk = QrCodes::query()->select()->where('id', 3)->first();
        $qrAtyrau = QrCodes::query()->select()->where('id', 4)->first();
        $qrSemey = QrCodes::query()->select()->where('id', 5)->first();
        $qrTaraz = QrCodes::query()->select()->where('id', 6)->first();
        $qrKizilorga = QrCodes::query()->select()->where('id', 7)->first();
        $qrKostanay = QrCodes::query()->select()->where('id', 8)->first();
        $qrKaraganda = QrCodes::query()->select()->where('id', 9)->first();
        $qrTurkestan = QrCodes::query()->select()->where('id', 11)->first();
        $qrOskemen = QrCodes::query()->select()->where('id', 12)->first();
        $qrPavlodar = QrCodes::query()->select()->where('id', 13)->first();
        $qrAlmaty = QrCodes::query()->select()->where('id', 10)->first();
        $qrRidder = QrCodes::query()->select()->where('id', 14)->first();
        $qrAktau = QrCodes::query()->select()->where('id', 12)->first();
        $qrEkibastuz = QrCodes::query()->select()->where('id', 15)->first();
        $count = 0;
        $messages = Message::all();
        $cities = City::query()->select('title')->get();

        if ($user->is_active === 1 && $user->type === null) {
            $tracks = ClientTrackList::query()
                ->leftJoin('track_lists', 'client_track_lists.track_code', '=', 'track_lists.track_code')
                ->select('client_track_lists.track_code', 'client_track_lists.detail', 'client_track_lists.created_at', 'client_track_lists.id',
                    'track_lists.to_china', 'track_lists.to_almaty', 'track_lists.to_client', 'track_lists.to_city',
                    'track_lists.city', 'track_lists.to_client_city', 'track_lists.client_accept', 'track_lists.status')
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
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Алматы', 'qr' => $qr]);
            }elseif ($user->type === 'kokshetauin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Кокшетау')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Кокшетау', 'qr' => $qr]);
            }elseif ($user->type === 'astanain') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Астане')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Астане', 'qr' => $qr]);
            }elseif ($user->type === 'shimkentin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Шымкенте')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Шымкенте', 'qr' => $qr]);
            }elseif ($user->type === 'aksuin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Аксу')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Аксу', 'qr' => $qr]);
            }elseif ($user->type === 'aktobein') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Актобе')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Актобе', 'qr' => $qr]);
            }elseif ($user->type === 'taldikorganin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Талдыкоргане')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Талдыкоргане', 'qr' => $qr]);
            }elseif ($user->type === 'uralskin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Уральске')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Уральске', 'qr' => $qrUralsk]);
            }elseif ($user->type === 'petropavlovskin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Петропавловске')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Петропавловске', 'qr' => $qrPetropavlovsk]);
            }elseif ($user->type === 'atyrauin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Атырау')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Атырау', 'qr' => $qrAtyrau]);
            }elseif ($user->type === 'semeyin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Семее')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Семее', 'qr' => $qrSemey]);
            }elseif ($user->type === 'tarazin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Таразе')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Таразе', 'qr' => $qrTaraz]);
            }elseif ($user->type === 'kizilorgain') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Кызылорде')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Кызылорде', 'qr' => $qrKizilorga]);
            }elseif ($user->type === 'kostanayin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Костанае')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Костанае', 'qr' => $qrKostanay]);
            }elseif ($user->type === 'karagandain') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Караганде')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Караганде', 'qr' => $qrKaraganda]);
            }elseif ($user->type === 'turkestanin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Балхаше')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Балхаше', 'qr' => $qrTurkestan]);
            }elseif ($user->type === 'oskemenin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Өскемене')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Өскемене', 'qr' => $qrOskemen]);
            }elseif ($user->type === 'pavlodarin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Павлодаре')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Павлодаре', 'qr' => $qrPavlodar]);
            }elseif ($user->type === 'almatyfin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Алматы')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Алматы', 'qr' => $qrAlmaty]);
            }elseif ($user->type === 'ridderin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Риддере')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Риддере', 'qr' => $qrRidder]);
            }elseif ($user->type === 'aktauin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Актау')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Актау', 'qr' => $qrAktau]);
            }elseif ($user->type === 'ekibastuzin') {
                $count = TrackList::query()->whereDate('to_city', Carbon::today())->where('status', 'Получено на складе в Экибастузе')->count();
                return view('almaty', ['count' => $count, 'config' => $config, 'cityin' => 'Экибастуз', 'qr' => $qrEkibastuz]);
            } elseif ($user->type === 'almatyout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Алматы', 'qr' => $qr]);
            } elseif ($user->type === 'kokshetauout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Кокшетау', 'qr' => $qr]);
            } elseif ($user->type === 'shimkentout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Шымкенте', 'qr' => $qr]);
            } elseif ($user->type === 'astanaout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Астане', 'qr' => $qr]);
            } elseif ($user->type === 'aksuout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Аксу', 'qr' => $qr]);
            } elseif ($user->type === 'aktobeout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Актобе', 'qr' => $qr]);
            } elseif ($user->type === 'taldikorganout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Талдыкоргане', 'qr' => $qr]);
            } elseif ($user->type === 'uralskout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Уральске', 'qr' => $qrUralsk]);
            } elseif ($user->type === 'petropavlovskout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Петропавловске', 'qr' => $qrPetropavlovsk]);
            } elseif ($user->type === 'atyrauout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Атырау', 'qr' => $qrAtyrau]);
            } elseif ($user->type === 'semeyout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Семее', 'qr' => $qrSemey]);
            } elseif ($user->type === 'tarazout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Таразе', 'qr' => $qrTaraz]);
            } elseif ($user->type === 'kizilordaout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Кызалорде', 'qr' => $qrKizilorga]);
            } elseif ($user->type === 'kostanayout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Костанае', 'qr' => $qrKostanay]);
            } elseif ($user->type === 'karagandaout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Караганде', 'qr' => $qrKaraganda]);
            } elseif ($user->type === 'turkestanout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Балхаше', 'qr' => $qrTurkestan]);
            } elseif ($user->type === 'oskemenout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Өскемене', 'qr' => $qrOskemen]);
            } elseif ($user->type === 'pavlodarout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Павлодаре', 'qr' => $qrPavlodar]);
            }elseif ($user->type === 'almatyfout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Алматы', 'qr' => $qrAlmaty]);
            }elseif ($user->type === 'ridderout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Риддере', 'qr' => $qrRidder]);
            }elseif ($user->type === 'aktauout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Актау', 'qr' => $qrAktau]);
            }elseif ($user->type === 'ekibastuzout') {
                $count = TrackList::query()->whereDate('to_client_city', Carbon::today())->count();
                return view('almatyout', ['count' => $count, 'config' => $config, 'cities' => $cities, 'cityin' => 'Экибастуз', 'qr' => $qrEkibastuz]);
            } elseif ($user->type === 'othercity') {
                $count = TrackList::query()->whereDate('to_client', Carbon::today())->count();
                return view('othercity')->with(compact('count', 'config', 'cities', 'qr'));
            } elseif ($user->type === 'admin' || $user->type === 'moderator') {
                $search_phrase = '';
                if ($user->city){
                    $users = User::query()->select('id', 'name', 'surname', 'type', 'login', 'city', 'is_active', 'block', 'password', 'created_at')->where('type', null)->where('city', $user->city)->where('is_active', false)->get();
                }else{
                    $users = User::query()->select('id', 'name', 'surname', 'type', 'login', 'city', 'is_active', 'block', 'password', 'created_at')->where('type', null)->where('city', 'Алматы')->where('is_active', false)->get();
                }

                return view('admin')->with(compact('users', 'messages', 'search_phrase', 'config'));
            }
        }

        $moderatorPhone = User::query()->select('whatsapp')->where('type', 'moderator')->where('city', $user->city)->first();

        if ($moderatorPhone){
            $phone = $moderatorPhone->whatsapp;
        }else{
            $phone = $config->whats_app;
        }

        return view('register-me')->with(compact('phone'));
    }


    public function archive ()
    {
            $tracks = ClientTrackList::query()
                ->leftJoin('track_lists', 'client_track_lists.track_code', '=', 'track_lists.track_code')
                ->select( 'client_track_lists.track_code', 'client_track_lists.detail', 'client_track_lists.created_at','client_track_lists.id',
                    'track_lists.to_china','track_lists.to_almaty','track_lists.to_client','track_lists.to_city','track_lists.city','track_lists.to_client_city','track_lists.client_accept','track_lists.status')
                ->where('client_track_lists.user_id', Auth::user()->id)
                ->where('client_track_lists.status', '=', 'archive')
                ->get();
        $config = Configuration::query()->select('address', 'title_text', 'address_two', 'whats_app')->first();
            $count = count($tracks);
            return view('dashboard')->with(compact('tracks', 'count', 'config'));
    }



}
