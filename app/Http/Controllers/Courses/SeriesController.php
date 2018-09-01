<?php
/**
 * Created by IntelliJ IDEA.
 * User: EDZ
 * Date: 2018/08/20
 * Time: 下午 05:37
 */

namespace App\Http\Controllers\Courses;
use App\Repositories\Courses\SeriesRepositories;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    protected $request;
    private $seriesRepositories;

    public function __construct(SeriesRepositories $seriesRepositories,Request $request)
    {
        $this->seriesRepositories = $seriesRepositories;
        $this->request = $request;
    }

    public function seriesList(Request $request)
    {
        $data =array(
            'serieslist' => $this->seriesRepositories->getSeriesList($request->get("page"),$request->get("key")),
            'pageNow'=> !trim($request->get("page"))?1:$request->get("page"),
            'pageNumber'=>$this->seriesRepositories->getSeriesPage(),
            'listNumber'=>$this->seriesRepositories->getSeriesNumber(),
            'key'=>$this->request->get("key"),
        );
        return view("admin.courses.series-list",$data);
    }

    public function edit(Request $request)//编辑页面函数
    {
        $data =array(
            'series' => $this->seriesRepositories->getSeriesById($request->get('id')),
            'id'=>$this->request->get('id')
        );
        return view("admin.courses.series-edit",$data);
    }

    public function add(){
        return view("admin.courses.series-add");
    }

    public function seriesEdit()
    {//ajax编辑
        $id = $this->request->post('id');
        $series_name = $this->request->post('series_name');

        if (!trim($series_name)){
            show(0,"请填写分类名称");
        }
        $data = array(
            'series_name' => $series_name,
        );
        $res = $this->seriesRepositories->setSeriesById($id, $data);
        if ($res) {
            show(1,"修改成功");
        } else {
            show(0,"修改失败");
        }
    }

    public function seriesDel(Request $request)
    {
        $res = $this->seriesRepositories->delSeriesById($request->get('id'));
        if ($res) {
            return response()->json(['status' => 1, 'msg' => '删除成功']);
        } else {
            return response()->json(['status' => 1, 'msg' => '删除条目成功但文件未能完全删除，肯能文件已经不存在或者文件夹没有权限']);
        }
    }

    public function seriesAdd(Request $request){

        $series_name = $this->request->post('series_name');
        if (!trim($series_name)){
            show(0,"请填写分类名称");
        }
        $data = array(
            'series_name' => $series_name,
            'add_time'=>time(),
        );
        $res = $this->seriesRepositories->addSeries($data);
        if ($res) {
            show(1,"添加成功");
        } else {
            show(0,"添加成功");
        }
    }
}
