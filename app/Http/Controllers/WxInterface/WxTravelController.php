<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/28
 * Time: 下午 06:38
 */

namespace App\Http\Controllers\WxInterface;

use App\Repositories\UserRepositories;
use App\Http\Controllers\Controller;
use App\Service\WxchatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis; //引入redis

class WxTravelController extends Controller
{
    private $travelRepository;
    private $userRepositories;
    private $request;

    public function __construct(
        Request $request,
        TravelRepository $travelRepository,
        UserRepositories $userRepositories,
        WxchatService $wxchatService
    )
    {
        $this->travelRepository = $travelRepository;
        $this->userRepositories = $userRepositories;
        $this->request = $request;
    }

    public function selectTravelByKey(){
        $token = $this->request->post('token');
    }
}
